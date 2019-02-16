#include "PiTools.h"

std::string PiTools::ConvertIntToStr(int number)
{
	std::ostringstream numberStringStream;
	numberStringStream << number;
	return numberStringStream.str();
}

int PiTools::ConvertStrToInt(std::string str)
{
	std::stringstream ss(str);
	int number;
	ss >> number;
	return number;
}

std::vector<std::string> PiTools::Explode(std::string delimiter, std::string str)
{
	std::vector<std::string> stringArray;
	int stringLength = str.length();

	int delimiterLength = delimiter.length();
	if (delimiterLength == 0)
	{
		return stringArray;
	}

	int startIndex = 0;
	int endIndex = 0;

	while (endIndex < stringLength)
	{
		int entryLength = 0;
		while (endIndex + entryLength < stringLength && entryLength < delimiterLength && str[endIndex + entryLength] == delimiter[entryLength])
		{
			entryLength++;
		}

		if (entryLength == delimiterLength)
		{
			stringArray.push_back(str.substr(startIndex, endIndex - startIndex));
			endIndex += delimiterLength;
			startIndex = endIndex;
		}
		else
		{
			endIndex++;
		}
	}

	stringArray.push_back(str.substr(startIndex, endIndex - startIndex));
	return stringArray;
}
