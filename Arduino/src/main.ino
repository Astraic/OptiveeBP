/*******************************************************************************
 * Copyright (c) 2015 Thomas Telkamp and Matthijs Kooijman
 *
 * Permission is hereby granted, free of charge, to anyone
 * obtaining a copy of this document and accompanying files,
 * to do whatever they want with them without any restriction,
 * including, but not limited to, copying, modification and redistribution.
 * NO WARRANTY OF ANY KIND IS PROVIDED.
 *
 * This example sends a valid LoRaWAN packet with payload "Hello,
 * world!", using frequency and encryption settings matching those of
 * the The Things Network.
 *
 * This uses OTAA (Over-the-air activation), where where a DevEUI and
 * application key is configured, which are used in an over-the-air
 * activation procedure where a DevAddr and session keys are
 * assigned/generated for use with all further communication.
 *
 * Note: LoRaWAN per sub-band duty-cycle limitation is enforced (1% in
 * g1, 0.1% in g2), but not the TTN fair usage policy (which is probably
 * violated by this sketch when left running for longer)!
 * To use this sketch, first register your application and device with
 * the things network, to set or generate an AppEUI, DevEUI and AppKey.
 * Multiple devices can use the same AppEUI, but each device has its own
 * DevEUI and AppKey.
 *
 * Do not forget to define the radio type correctly in config.h.
 *
 *******************************************************************************/
#include <Arduino.h>
#include <LiquidCrystal_I2C.h>
#include <Servo.h>
#include <Loadcell.h>
#include <FeedControl.h>
#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
#include <lmic.h>
#include <hal/hal.h>
#include <SPI.h>
#include <Lora.hpp>

#define DEBUG false
#define DOUT_PIN 4
#define SCK_PIN 5
#define SERVO_PIN 11

PN532_I2C pn532i2c(Wire);
PN532 nfc(pn532i2c);
LiquidCrystal_I2C lcd(0x27,16,2);
long timeout = 0;
long starttime = 0;
  
unsigned long nTimer = 0;
unsigned int uid[] = {24, 24, 24, 24};
unsigned long nDurationTimer = 0;

  
Loadcell scale;
Servo servo;
FeedControl fc;

void setupNFC(){
    nfc.begin();

    uint32_t versiondata = nfc.getFirmwareVersion();
    Serial.println("FIRMWARE");
    if (! versiondata) {
      Serial.print("Didn't find PN53x board");
      while (1); // halt
    }
    // Got ok data, print it out!
    Serial.print("Found chip PN5");
    Serial.println((versiondata>>24) & 0xFF, HEX);
    Serial.print("Firmware ver. ");
    Serial.print((versiondata>>16) & 0xFF, DEC);
    Serial.print('.');
    Serial.println((versiondata>>8) & 0xFF, DEC);

    // configure board to read RFID tags
    nfc.SAMConfig();

    Serial.println("Waiting for an ISO14443A Card ...");
}

void setup() {
    Serial.begin(9600);
    Serial.println("Starting...");
    setupNFC();
    scale.begin(DOUT_PIN, SCK_PIN);
    Serial.print("Kalibratiefactor: ");
    Serial.println(scale.get_scale());
    servo.attach(SERVO_PIN);
    servo.write(0);
    lcd.init();
    lcd.backlight();
  
    #ifdef VCC_ENABLE
    // For Pinoccio Scout boards
    pinMode(VCC_ENABLE, OUTPUT);
    digitalWrite(VCC_ENABLE, HIGH);
    delay(1000);
    #endif

    // LMIC init
    os_init();
    // Reset the MAC state. Session and pending data transfers will be discarded.
    LMIC_reset();

    // Start job (sending automatically starts OTAA too)
    nTimer = millis();
    nDurationTimer = millis() - ALIVETIME;
    do_send(&sendjob);
}

/*
 * Deze switch bepaald welke servo aangestuurd dient te worden. Indien er meerdere soorten voer
 * beschikbaar zijn in het systeem zal het systeem per voersoort een ander servo aansturen.
 * De hoek parameter wordt vergeleken met servo.read() om dubbele instructie tegen voorkomen.
 */
void servoSwitch(int hoek) {
  switch (fc.getFeedType()) {
    case 1:
      if (servo.read() != hoek) servo.write(hoek);
      break;
    case 2:
      if (servo.read() != hoek) servo.write(hoek); // Dit zou ik de praktijk een tweede servo zijn.
      break;
  }
}








void loop(void) 
{
    os_runloop_once();
    if((millis() - nTimer) > ALIVETIME)
    {
        do_send(&sendjob);
        // sendEntityRegistration(uid, 100, 21);       // Send data for registation enity
        nTimer = millis();
    }

  if(DEBUG)
      Serial.println(millis() - nDurationTimer);
  
  //Use a timeout to make sure the card is only scaned once per second to prevent double reads
  timeout = millis() - starttime;
  if(timeout > 1000) {
      uint8_t uid[] = { 0, 0, 0, 0};
      bool success = scanForNFC(uid);
      if(success) { // Controle of er op het moment een nfctag aanwezig is.
        printUIDtoLCD(uid);
        /*
        * Er is sprake van een nieuw tag indien de uitgelezen waarde ongelijk is aan nfcTag.
        * Indien dat het geval is wordt het nieuw ncf tag uitgelezen en opgeslagen.
        * Er wordt eenmalig een opvraag gedaan naar het voedingspatroon van het dier dat
        * overeenkomt met het waargenomen nfc tag en de load cell wordt getarreerd.
        */
      float currentValue = scale.get_units();
      if(fc.compareNFC(uid)) {
        if (fc.distributeFeed(currentValue)){
          servoSwitch(180);
        } else {
          servoSwitch(0);
        }
        fc.calculateDistributed(currentValue);
      } else {
        fc.fetchFeedingPattern(uid);
        scale.tare();
      }

    } else if (!success && fc.getNFC() != nullptr) {
      servoSwitch(0);
      sendEntityFood(uid, scale.get_units());
      fc.closeTransaction(scale.get_units());
    }
  }
}


void printUIDtoLCD(uint8_t* uid){
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Koe: ");
  String uidString = "";
  for (int i = 0; i < 4; i++) {
      if (uid[i] < 0x10) {
          uidString += " 0";
      } else {
          uidString += " ";
      }
      uidString += String(uid[i], HEX);
  }
  uidString.toUpperCase();
  lcd.setCursor(0,1);
  lcd.print(uidString);
}

bool scanForNFC(uint8_t* uid){
  uint8_t uidLength;
  bool success;
  //Check if there is a card available to read
  success = nfc.readPassiveTargetID(PN532_MIFARE_ISO14443A, uid, &uidLength);
  if (success) {
    // Assumtion that we always use mifare NFC so length is always 4
    // Display the uid of the card
    Serial.println("Found an ISO14443A card");
    Serial.print("  UID Value: ");
    nfc.PrintHex(uid, 4);
    Serial.println("");
    //set the timeout
    starttime = millis();
  }else{
    Serial.println("Oops... read failed: Is there a card present?");
  }
  return success;
}