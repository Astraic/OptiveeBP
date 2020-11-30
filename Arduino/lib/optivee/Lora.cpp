#include<Lora.hpp>

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