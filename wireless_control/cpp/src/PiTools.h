#include <string>
#include <cstring>
#include <vector>
#include <iostream>
#include <fstream>
#include <sstream>
#include <ctime>
#include <algorithm>

#include <pthread.h>
#include <arpa/inet.h>
#include <netinet/in.h>
#include <stdio.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <unistd.h>

#ifndef PI_TOOLS_H
#define PI_TOOLS_H

class PiTools
{
  public:
	static std::string ConvertIntToStr(int);
	static int ConvertStrToInt(std::string);

	static std::vector<std::string> Explode(std::string, std::string);
};

#endif