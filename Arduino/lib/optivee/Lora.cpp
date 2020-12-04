#include<Lora.hpp>
StringShift oOutPutBufferData = StringShift();

const unsigned TX_INTERVAL = 60;

// Pin mapping
const lmic_pinmap lmic_pins = {
 .nss = 10,
 .rxtx = LMIC_UNUSED_PIN,
 .rst = 9,
 .dio = {2, 6, 7},
};

const u1_t PROGMEM APPEUI[8] = {0xE5, 0x09, 0x01, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getArtEui (u1_t* buf) { memcpy_P(buf, APPEUI, 8);}

// This should also be in little endian format, see above.
const u1_t PROGMEM DEVEUI[8] = {0xF9, 0x04, 0x1B, 0x00, 0x00, 0xAC, 0x59, 0x00};
void os_getDevEui (u1_t* buf) { memcpy_P(buf, DEVEUI, 8);}

// This key should be in big endi=-=- n format (or, since it is not really a
// number but a block of memory, endianness does not really apply). In
// practice, a key taken from ttnctl can be copied as-is.
// The key shown here is the semtech default key.
const u1_t PROGMEM APPKEY[16] = {0xdc, 0xb4, 0x29, 0x8e, 0x68, 0x21, 0xe6, 0xfc, 0x09, 0x53, 0x81, 0x57, 0xf4, 0x7c, 0x4d, 0x31};
void os_getDevKey (u1_t* buf) {  memcpy_P(buf, APPKEY, 16);}

String sAliveString = "0000000000000000";
char mydata[] = "                         ";
osjob_t sendjob;
bool lWaitingResponse = false;

// code SensorString+asingmenttoken+value;
//      3 chars + 1 char + 8 chars;
//      tmp=21      ;wgt=100.1    ;
//
//
// static char mydata[] = "                         ";
// static osjob_t sendjob;
// bool lWaitingResponse = false;



void StringShift::shiftOut()
{
    for(int i = 0; i < (nPointer-1); i++)
        sBuffer[i] = sBuffer[i++];
}

void StringShift::append(String sInput)
{
    if(nPointer >= (BUFFERSIZE-1))
        shiftOut();
    
    sBuffer[nPointer] = sInput;

    if(nPointer < (BUFFERSIZE-1))
        nPointer++;
}

String StringShift::get(int nGetPoint)
{
    return sBuffer[nGetPoint];
}

String StringShift::getAndRemoveFirst()
{
    String sReturn = sBuffer[0];

    shiftOut();

    if(nPointer > 0)
        nPointer--;

    return sReturn;
}

void StringShift::clear()
{
    for(int i = 0; i < 25; i++)
        sBuffer[i] = "";

    nPointer = 0;
}



void onEvent (ev_t ev) {
    Serial.print(os_getTime());
    Serial.print(": ");
    switch(ev) {
        case EV_SCAN_TIMEOUT:
            Serial.println(F("EV_SCAN_TIMEOUT"));
            break;
        case EV_BEACON_FOUND:
            Serial.println(F("EV_BEACON_FOUND"));
            break;
        case EV_BEACON_MISSED:
            Serial.println(F("EV_BEACON_MISSED"));
            break;
        case EV_BEACON_TRACKED:
            Serial.println(F("EV_BEACON_TRACKED"));
            break;
        case EV_JOINING:
            Serial.println(F("EV_JOINING"));
            break;
        case EV_JOINED:
            Serial.println(F("EV_JOINED"));

            // Disable link check validation (automatically enabled
            // during join, but not supported by TTN at this time).
            LMIC_setLinkCheckMode(0);
            break;
        case EV_RFU1:
            Serial.println(F("EV_RFU1"));
            break;
        case EV_JOIN_FAILED:
            Serial.println(F("EV_JOIN_FAILED"));
            break;
        case EV_REJOIN_FAILED:
            Serial.println(F("EV_REJOIN_FAILED"));
            break;
            break;
        case EV_TXCOMPLETE:
            Serial.println(F("EV_TXCOMPLETE (includes waiting for RX windows)"));

            if (LMIC.txrxFlags & TXRX_ACK)
              Serial.println(F("Received ack"));
            if (LMIC.dataLen) {
              Serial.println(F("Received "));
              Serial.println(LMIC.dataLen);
              Serial.println(F(" bytes of payload"));
            }
            lWaitingResponse = false;
            // Schedule next transmission
            // os_setTimedCallback(&sendjob, os_getTime()+sec2osticks(TX_INTERVAL), do_send);
            break;
        case EV_LOST_TSYNC:
            Serial.println(F("EV_LOST_TSYNC"));
            break;
        case EV_RESET:
            Serial.println(F("EV_RESET"));
            break;
        case EV_RXCOMPLETE:
            // data received in ping slot
            Serial.println(F("EV_RXCOMPLETE"));
            break;
        case EV_LINK_DEAD:
            Serial.println(F("EV_LINK_DEAD"));
            break;
        case EV_LINK_ALIVE:
            Serial.println(F("EV_LINK_ALIVE"));
            break;
         default:
            Serial.println(F("Unknown event"));
            break;
    }
}

void do_send(osjob_t* j)
{
    // Check if there is not a current TX/RX job running
    if (LMIC.opmode & OP_TXRXPEND) {
        Serial.println(F("OP_TXRXPEND, not sending"));
    } 
    else if(!lWaitingResponse)
    {
        // Prepare upstream data transmission at the next possible time.
        String sOutputBuffer = oOutPutBufferData.getAndRemoveFirst();
        if(sOutputBuffer == "")
            sAliveString.toCharArray(mydata, 25);
        else
            sOutputBuffer.toCharArray(mydata, 25);
         

        LMIC_setTxData2(1, ((xref2u1_t)mydata), sizeof(mydata)-1, 0);
        for(int i = 0; i < 25; i++)
            Serial.print(mydata[i]);
        Serial.println();
        Serial.println(sOutputBuffer);
        Serial.println(F("Packet queued"));
        lWaitingResponse = true;
    }
}

String UIDTOSTRING(uint8_t UIDID[])
{
    String sReturn = "";
    for(int i = 0; i < 4; i++)
    {
        if(UIDID[i] < 0x10)
            sReturn += "0" + String(UIDID[i], HEX);
        else
            sReturn += String(UIDID[i], HEX);
    }
    return sReturn;
}


void sendEntityProduction(uint8_t nUID[], int nWeight)
{
    oOutPutBufferData.append(String(ENTITYPRODUCTION, HEX) + UIDTOSTRING(nUID) + String(nWeight, HEX));
    do_send(&sendjob);
}

void sendEntityFood(uint8_t nUID[], int nWeight)
{
    oOutPutBufferData.append(String(ENTITYREGISTRATION, HEX) + UIDTOSTRING(nUID) + String(nWeight, HEX));
    do_send(&sendjob);
}

void sendEntityRegistration(uint8_t nUID[], int nWeight, int nTemp)
{
    oOutPutBufferData.append(String(ENTITYFOOD, HEX) + UIDTOSTRING(nUID) + String(nWeight, HEX) + String(nTemp, HEX));
    do_send(&sendjob);
}


bool btnState(bool nState)
{
    static bool nPreviousState = false;
    if(nState != nPreviousState)
    {
        Serial.println(nState);
        nPreviousState = nState;
    }

    return nPreviousState;
}