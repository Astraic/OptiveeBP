#pragma once
#include <Arduino.h>
#include <lmic.h>
#include <hal/hal.h>
#include <SPI.h>

#define BUFFERSIZE 25
#define ALIVETIME 600000
#define ENTITYPRODUCTION    0xC   //1100
#define ENTITYREGISTRATION  0x8   //1000
#define ENTITYFOOD          0x4   //0100
// #define ENTITYANIMAL     0x0   //0000

extern const unsigned TX_INTERVAL;
extern const lmic_pinmap lmic_pins;
extern String sAliveString;

extern const u1_t PROGMEM APPEUI[8];// = {0xE5, 0x09, 0x01, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getArtEui (u1_t* buf);

extern const u1_t PROGMEM DEVEUI[8];// = {0xBB, 0x04, 0x1b, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getDevEui (u1_t* buf);

extern const u1_t PROGMEM APPKEY[16];// = {0x92, 0xFD, 0x50, 0xE0, 0xF0, 0x28, 0x11, 0x43, 0xB6, 0x1C, 0x62, 0x57, 0x3A, 0x6B, 0x7C, 0x35};
void os_getDevKey (u1_t* buf);

extern char mydata[];
extern osjob_t sendjob;
extern bool lWaitingResponse;

class StringShift
{
private:
    String sBuffer[BUFFERSIZE];
    int nPointer = 0;

    void shiftOut();

public:

    StringShift()
    {
        clear();
    };

    void append(String sInput);
    String get(int nGetPoint);
    String getAndRemoveFirst();
    void clear();
};

extern StringShift oOutPutBufferData;// = StringShift();

void onEvent (ev_t ev);
void do_send(osjob_t* j);
void sendEntityProduction(unsigned int nUID[], int nWeight);
void sendEntityFood(unsigned int nUID[], int nWeight);
void sendEntityRegistration(unsigned int nUID[], int nWeight, int nTemp);