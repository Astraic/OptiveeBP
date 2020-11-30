#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
PN532_I2C pn532i2c(Wire);
PN532 nfc(pn532i2c);
long timeout = 0;
long starttime = 0;


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
}


void loop(void) {
  //Use a timeout to make sure the card is only scaned once per second to prevent double reads
  timeout = millis() - starttime;
  if(timeout > 1000) {
      uint8_t uid[] = { 0, 0, 0, 0};
      bool success = scanForNFC(uid);
      if(success){
          nfc.PrintHex(uid, 4);
      }
  }
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
    Serial.println("Ooops ... read failed: Is there a card present?");
  }
  return success;
}
