#ifndef Loadcell_h
#define Loadcell_h

#include <Arduino.h>
#include <HX711.h>
#include <EEPROM.h>

#define SLOPE_ADDRESS 0

class Loadcell : public HX711 {

private:
    
    float slope = 1;

public:
    
    Loadcell();
    void begin(byte dout, byte pd_sck, byte gain = 128);
    void calibrate(float calibration_weight , byte precision);
    
};

#endif