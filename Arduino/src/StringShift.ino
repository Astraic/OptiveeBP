// // #include <Arduino.h>

// #define BUFFERSIZE 25

// class StringShift
// {
// private:
//     String sBuffer[BUFFERSIZE];
//     int nPointer = 0;

//     void shiftOut()
//     {
//         for(int i = 0; i < (nPointer-1); i++)
//             sBuffer[i] = sBuffer[i++];
//     }



// public:

//     StringShift()
//     {
//         clear();
//     };


//     void append(String sInput)
//     {
//         if(nPointer >= (BUFFERSIZE-1))
//             shiftOut();
        
//         sBuffer[nPointer] = sInput;

//         if(nPointer < (BUFFERSIZE-1))
//             nPointer++;
//     }

//     String get(int nGetPoint)
//     {
//         return sBuffer[nGetPoint];
//     }

//     String getAndRemoveFist()
//     {
//         String sReturn = sBuffer[0];

//         shiftOut();

//         if(nPointer > 0)
//             nPointer--;

//         return sReturn;
//     }

//     void clear()
//     {
//         for(int i = 0; i < 25; i++)
//             sBuffer[i] = "";

//         nPointer = 0;
//     }
// };