#include <Arduino.h>
#include <Servo.h>
#include <Loadcell.h>
#include <FeedControl.h>

#define DOUT_PIN 2
#define SCK_PIN 3
#define SERVO_PIN 11
#define BTN_PIN 7

Loadcell scale;
Servo servo;
FeedControl fc;

void setup() {
  scale.begin(DOUT_PIN, SCK_PIN);
  pinMode(BTN_PIN, INPUT_PULLUP);
  servo.attach(SERVO_PIN);
  servo.write(0);
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

void loop() {

  uint8_t uid[] = {0, 0, 0, 0};
  boolean succes = true;

  if(succes) { // Controle of er op het moment een nfctag aanwezig is.
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

  if (digitalRead(BTN_PIN) == LOW) scale.calibrate(290, 10);
}