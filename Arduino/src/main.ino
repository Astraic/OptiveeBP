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
      scanForNFC(uid);
      //Assumtion that we always use mifare NFC so length is always 4
      nfc.PrintHex(uid, 4);
      Serial.println("Final ID");
  }
}

void scanForNFC(uint8_t* uid){
  uint8_t success;
  uint8_t uidLength;

  //Check if there is a card available to read
  success = nfc.readPassiveTargetID(PN532_MIFARE_ISO14443A, uid, &uidLength);
  if (success) {
    // Display some basic information about the card
    Serial.println("Found an ISO14443A card");
    Serial.print("  UID Value: ");
    nfc.PrintHex(uid, uidLength);
    Serial.println("");

    // Now we need to try to authenticate it for read/write access
    // Try with the factory default KeyA: 0xFF 0xFF 0xFF 0xFF 0xFF 0xFF
    Serial.println("Trying to authenticate block 4 with default KEYA value");
    uint8_t keya[6] = { 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF };

    // Start with block 4 (the first block of sector 1) since sector 0
    // contains the manufacturer data and it's probably better just
    // to leave it alone unless you know what you're doing
    success = nfc.mifareclassic_AuthenticateBlock(uid, uidLength, 4, 0, keya);

    if (success){
      Serial.println("Sector 1 (Blocks 4..7) has been authenticated");
      uint8_t data[16];

      // If you want to write something to block 4 to test with, uncomment
      // the following line and this text should be read back in a minute
      // data = { 'a', 'd', 'a', 'f', 'r', 'u', 'i', 't', '.', 'c', 'o', 'm', 0, 0, 0, 0};
      // success = nfc.mifareclassic_WriteDataBlock (4, data);

      // Try to read the contents of block 4
      success = nfc.mifareclassic_ReadDataBlock(4, data);

      if (success){
        // Data seems to have been read ... spit it out
        Serial.println("Reading Block 4:");
        nfc.PrintHexChar(data, 16);
        Serial.println("");

        starttime = millis();

      }else{
        Serial.println("Ooops ... unable to read the requested block.  Try another key?");
      }
    }else{
      Serial.println("Ooops ... authentication failed: Try another key?");
    }
  }
}
