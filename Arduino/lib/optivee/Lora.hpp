#pragma once
#include <Arduino.h>
#include <lmic.h>
#include <hal/hal.h>
#include <SPI.h>

#define BUFFERSIZE 25

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