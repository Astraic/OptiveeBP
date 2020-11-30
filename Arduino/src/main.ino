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
#include <lmic.h>
#include <hal/hal.h>
#include <SPI.h>
#include <Lora.hpp>

#define ALIVETIME 600000

const unsigned TX_INTERVAL = 60;

// Pin mapping
const lmic_pinmap lmic_pins = {
 .nss = 10,
 .rxtx = LMIC_UNUSED_PIN,
 .rst = 9,
 .dio = {2, 6, 7},
};

String sAliveString = "LIS";
static const u1_t PROGMEM APPEUI[8]= {0xE5, 0x09, 0x01, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getArtEui (u1_t* buf) { memcpy_P(buf, APPEUI, 8);}

// This should also be in little endian format, see above.
static const u1_t PROGMEM DEVEUI[8]= {0xBB, 0x04, 0x1b, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getDevEui (u1_t* buf) { memcpy_P(buf, DEVEUI, 8);}

// This key should be in big endi=-=- n format (or, since it is not really a
// number but a block of memory, endianness does not really apply). In
// practice, a key taken from ttnctl can be copied as-is.
// The key shown here is the semtech default key.
static const u1_t PROGMEM APPKEY[16] = {0x92, 0xFD, 0x50, 0xE0, 0xF0, 0x28, 0x11, 0x43, 0xB6, 0x1C, 0x62, 0x57, 0x3A, 0x6B, 0x7C, 0x35};
void os_getDevKey (u1_t* buf) {  memcpy_P(buf, APPKEY, 16);}

// code SensorString+asingmenttoken+value;
//      3 chars + 1 char + 8 chars;
//      tmp=21      ;wgt=100.1    ;
//
//


StringShift oOutPutBufferData = StringShift();

static char mydata[] = "                         ";
static osjob_t sendjob;

bool lWaitingResponse = false;
unsigned long nTimer = 0;

void setup() {
    Serial.begin(115200);
    Serial.println(F("Starting"));

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
    do_send(&sendjob);
}

void loop() 
{
    os_runloop_once();
    if((millis() - nTimer) > ALIVETIME)
    {
        do_send(&sendjob);
        nTimer = millis();
    }




}