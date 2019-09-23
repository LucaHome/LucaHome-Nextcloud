SOURCE = ./src/WirelessControl.cpp ./src/PiTools.cpp ./src/PiControl.cpp -lwiringPi -lpthread
APP = ./bin/wirelesscontrol
CC = g++ -std=c++11

all: $(APP)

$(APP): $(SOURCE)
	chmod -R 755 *
	$(CC) $(SOURCE) -o $(APP)

clean:
	rm -fv ./bin/*
	update-rc.d -f wirelesscontrol remove
	rm -fv /etc/init.d/wirelesscontrol/
	rm -fv /bin/wirelesscontrol

install:
	cp ./bin/wirelesscontrol /bin/wirelesscontrol
	cp ./init/wirelesscontrol /etc/init.d
	update-rc.d wirelesscontrol defaults