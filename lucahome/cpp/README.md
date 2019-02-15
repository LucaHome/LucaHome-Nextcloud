# C++-MiniServer

[![Platform](https://img.shields.io/badge/platform-Raspberry-blue.svg)](https://www.raspberrypi.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Donate: PayPal](https://img.shields.io/badge/paypal-donate-blue.svg)](https://www.paypal.me/GuepardoApps)

[![Build](https://img.shields.io/badge/build-WIP-yellow.svg)](./)
[![Version](https://img.shields.io/badge/version-v0.1.0-blue.svg)](https://github.com/LucaHome/LucaHome-RaspberryServer/tree/develop)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

[![C++](https://img.shields.io/badge/lang-C++-blue.svg)](https://isocpp.org/)

Part of the LucaHome-Nextcloud-Project

Small server running on a raspberry to control 433MHz sockets.

## Installation

### Required

#### WiringPi

If wiringpi is not installed, install this too:
Check this link: http://wiringpi.com/download-and-install/

```
git clone git://git.drogon.net/wiringPi
cd ~/wiringPi
git pull origin
./build
```

Check if the installation worked well:

```
gpio -v
gpio readall
```

### Finalize

Now you are ready to install LucaHome to your raspberry

- first download sourcecode and copy it to your raspberry (e.g. to your home directory (lucahome)
- you have to cd into the directory you copied the sourcecode to

```
sudo make clean
sudo make
sudo make install
sudo /etc/init.d/LucaHome start 
```

## License

This project is distributed under the MIT license. [See LICENSE](LICENSE.md) for details.