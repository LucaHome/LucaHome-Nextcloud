#include <string>
#include <sstream>

namespace patch
{
template <typename T>
std::string to_string(const T &n)
{
	std::ostringstream stm;
	stm << n;
	return stm.str();
}
} // namespace patch

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
#include <syslog.h>

#include "PiConstants.h"
#include "PiControl.h"
#include "PiTools.h"

#define PORT 2302
#define BUFLEN 128

#define MESSAGE_DELIMITER ":"
#define MESSAGE_ARRAY_LENGTH 4

#define MESSAGE_TYPE_INDEX 0
#define MESSAGE_PIN_INDEX 1
#define MESSAGE_WIRELESS_SOCKET_CODE_INDEX 2
#define MESSAGE_WIRELESS_SOCKET_STATE_INDEX 3

#define WIRELESS_SOCKET_IDENTIFIER "WSO"

using namespace std;

string handleMessage(string message)
{
	vector<string> data = PiTools::Explode(MESSAGE_DELIMITER, message);

	if (data.size() != MESSAGE_ARRAY_LENGTH)
	{
		return MESSAGE_ERROR_INVALID_LENGTH;
	}

	string type = data[MESSAGE_TYPE_INDEX];
	string pinString = data[MESSAGE_PIN_INDEX];
	string wirelessSocketCode = data[MESSAGE_WIRELESS_SOCKET_CODE_INDEX];
	string wirelessSocketStateString = data[MESSAGE_WIRELESS_SOCKET_STATE_INDEX];

	if (type == "")
	{
		return MESSAGE_ERROR_EMPTY_TYPE;
	}
	if (pinString == "")
	{
		return MESSAGE_ERROR_EMPTY_PIN;
	}
	if (wirelessSocketCode == "")
	{
		return MESSAGE_ERROR_EMPTY_CODE;
	}
	if (wirelessSocketStateString == "")
	{
		return MESSAGE_ERROR_EMPTY_STATE;
	}

	if (type == WIRELESS_SOCKET_IDENTIFIER)
	{
		int pin = PiTools::ConvertStrToInt(pinString);
		int wirelessSocketState = PiTools::ConvertStrToInt(wirelessSocketStateString);

		if (!PiControl::Send433Mhz(pin, wirelessSocketCode, wirelessSocketState))
		{
			return MESSAGE_ERROR_SENDING_STATE;
		}

		return MESSAGE_SUCCESS;
	}
	else
	{
		return MESSAGE_ERROR_INVALID_TYPE;
	}
}

void *server(void *arg)
{
	syslog(LOG_INFO, "PiServer started!");

	int socketResult, connection, answer, clientLength;
	struct sockaddr_in clientAddress, serverAddress;
	char message[BUFLEN];

	socketResult = socket(AF_INET, SOCK_DGRAM, 0);
	if (socketResult < 0)
	{
		syslog(LOG_CRIT, "Cant't open socket");
	}

	serverAddress.sin_family = AF_INET;
	serverAddress.sin_addr.s_addr = htonl(INADDR_ANY);
	serverAddress.sin_port = htons(PORT);

	connection = bind(socketResult, (struct sockaddr *)&serverAddress, sizeof(serverAddress));
	if (connection < 0)
	{
		syslog(LOG_CRIT, "Can't bind socket to port %d", PORT);
		exit(1);
	}

	syslog(LOG_INFO, "Server listen on port %u", PORT);

	while (1)
	{
		memset(message, 0x0, BUFLEN);
		clientLength = sizeof(clientAddress);

		answer = recvfrom(socketResult, message, BUFLEN, 0, (struct sockaddr *)&clientAddress, (socklen_t *)&clientLength);

		if (answer < 0)
		{
			syslog(LOG_ERR, "Can't receive data");
			continue;
		}
		else
		{
			syslog(LOG_INFO, "Received: %s", message);
			string response = handleMessage(message);
			int sendResult = sendto(socketResult, response.c_str(), strlen(response.c_str()), 0, (struct sockaddr *)&clientAddress, clientLength);
			if (sendResult < 0)
			{
				syslog(LOG_ERR, "Can't send data");
			}
		}
	}

	close(socketResult);
	syslog(LOG_INFO, "Exiting PiServer");
	pthread_exit(NULL);
}

int main(void)
{
	openlog("lucahome", LOG_PID | LOG_CONS, LOG_USER);
	syslog(LOG_INFO, "Starting LucaHome-PiServer -> Main");

	pthread_t serverThread;
	pthread_create(&serverThread, NULL, server, NULL);
	pthread_join(serverThread, NULL);

	closelog();
}