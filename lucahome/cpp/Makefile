SOURCE = ./PiServer.cpp ./PiTools.cpp ./PiControl.cpp -lwiringPi -lpthread
APP = ./bin/lucahome
CC = g++ -std=c++11

all: $(APP)

$(APP): $(SOURCE)
	chmod -R 755 *
	$(CC) $(SOURCE) -o $(APP)

clean:
	rm -fv ./bin/*
	update-rc.d -f lucahome remove
	rm -fv /etc/init.d/lucahome/
	rm -fv /bin/lucahome

install:
	cp ./bin/lucahome /bin/lucahome
	cp ./init/lucahome /etc/init.d
	update-rc.d lucahome defaults