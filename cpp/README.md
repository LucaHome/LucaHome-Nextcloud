# C++-MiniServer

[![Platform](https://img.shields.io/badge/platform-Raspberry-blue.svg)](https://www.raspberrypi.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Donate: PayPal](https://img.shields.io/badge/paypal-donate-blue.svg)](https://www.paypal.me/GuepardoApps)

[![Build](https://img.shields.io/badge/build-Successful-green.svg)](./)
[![Version](https://img.shields.io/badge/version-v1.1.1-blue.svg)](./)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

[![C++](https://img.shields.io/badge/lang-C++-blue.svg)](https://isocpp.org/)

Part of the WirelessControl-Project

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

Now you are ready to install WirelessControl to your raspberry

- first download sourcecode and copy it to your raspberry (e.g. to your home directory (wirelesscontrol)
- you have to cd into the directory you copied the sourcecode to

```
sudo make clean
sudo make
sudo make install
sudo /etc/init.d/wirelesscontrol start 
```

## License

This project is distributed under the MIT license. [See LICENSE](LICENSE.md) for details.

```
MIT License

Copyright (c) 2019 GuepardoApps (Jonas Schubert)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

```
