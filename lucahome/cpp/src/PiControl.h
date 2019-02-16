#include <wiringPi.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <iostream>
#include <math.h>
/* below is necessary due to https://github.com/platenspeler/LamPI-2.0/blob/master/transmitters/livolo/livolo.h */
#include <errno.h>
#include <time.h>
#include <netdb.h>
#include <sys/types.h>
#include <netinet/in.h>
#include <sys/socket.h>
#include <arpa/inet.h>

#define WIRELESS_TRUE 136
#define WIRELESS_FALSE 142

#define CODE_LENGTH 6
#define CODE_ONE '1'
#define CODE_ZERO '0'

#define PULSE_LENGTH_MS 300
#define PULSE_REPEAT 5

#define PULSE_SHORT 110 // 110 works quite OK
#define PULSE_LONG 300  // 300 works quite OK
#define PULSE_START 520 // 520 works quite OK

#ifndef PI_CONTROL_H
#define PI_CONTROL_H

class PiControl
{
  private:
	static bool sendEther(int, int[]);
	static void printCode(int[]);

	/* from https://github.com/platenspeler/LamPI-2.0/blob/master/transmitters/livolo/livolo.h */
	static void selectPulse(unsigned char, int, bool);
	static void sendPulse(unsigned char, int);

  public:
	static bool Send433Mhz(int, std::string, int);
	static bool WriteGpio(int, int);

	/* from https://github.com/platenspeler/LamPI-2.0/blob/master/transmitters/livolo/livolo.h */
	static bool SendButton(unsigned int, unsigned char, int, bool);
};

#endif
