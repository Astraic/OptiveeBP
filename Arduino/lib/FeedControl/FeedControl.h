#ifndef FeedControl_h
#define FeedControl_h

#include <Arduino.h>

class FeedControl {

private:
    
    uint8_t *nfcTag = nullptr;

    byte feedType = 0;

    float allocatedAmount = 0;
    float distributedAmount = 0;
    float portionSize = 0;
    float previousRead = 0;

public:
    
    FeedControl();
    void setNFC(uint8_t* uid);
    uint8_t* getNFC();
    boolean compareNFC(uint8_t* uid);
    byte getFeedType();
    void fetchFeedingPattern(uint8_t* uid);
    boolean distributeFeed(float scale_units);
    void calculateDistributed(float scale_units);
    void closeTransaction(float scale_units);
    
};

#endif