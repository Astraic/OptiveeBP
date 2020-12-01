#include <Arduino.h>
#include <LiquidCrystal_I2C.h>
#include <Servo.h>
#include <Loadcell.h>
#include <FeedControl.h>
#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
PN532_I2C pn532i2c(Wire);
PN532 nfc(pn532i2c);
LiquidCrystal_I2C lcd(0x27,16,2);
long timeout = 0;
long starttime = 0;

#define DOUT_PIN 2
#define SCK_PIN 3
#define SERVO_PIN 11
#define BTN_PIN 7

Loadcell scale;
Servo servo;
FeedControl fc;

void setupNFC(){
    nfc.begin();

    uint32_t versiondata = nfc.getFirmwareVersion();
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

void setup(void) {
    Serial.begin(9600);
    setupNFC();
    scale.begin(DOUT_PIN, SCK_PIN);
    pinMode(BTN_PIN, INPUT_PULLUP);
    servo.attach(SERVO_PIN);
    servo.write(0);
    lcd.init();
    lcd.backlight();
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

void loop(void) {
  //Use a timeout to make sure the card is only scaned once per second to prevent double reads
  timeout = millis() - starttime;
  if(timeout > 1000) {
      uint8_t uid[] = { 0, 0, 0, 0};
      bool success = scanForNFC(uid);
      if(succes) { // Controle of er op het moment een nfctag aanwezig is.
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
    } else if (!succes && fc.getNFC() != nullptr) {
    fc.closeTransaction(scale.get_units());
  }


  }

  if (digitalRead(BTN_PIN) == LOW) scale.calibrate(290, 10);
}

void printUIDtoLCD(uint8_t* uid){
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Koe: ");
  String uidString = "";
  for (int i = 0; i < 4; i++) {
      if (uid[i] < 0x10) {
          uidString += " 0";
      } else {a
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
