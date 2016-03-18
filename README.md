# netflow
Decoding Netflow v5 packets 

Flow formats,Vendor,Supported versions,Supported traffic types
==============================================================

```
NetFlow, Cisco, 5,IPv4
```

## require 

Setup Netflow exporter with fprobe

```
apt-get install fprobe
```

config

```
#fprobe default configuration file

INTERFACE="ex:wlan0 or eth0"
FLOW_COLLECTOR="localhost:1234"

#fprobe can't distinguish IP packet from other (e.g. ARP)
OTHER_ARGS="-fip"
```

start fprobe

```
service fprobe start
```

install php packages

* ZeroMQ
* React/ZMQ
* PhalconPHP

ZeroMQ
=========
```
sudo pecl install zmq-beta
```

React/ZMQ
=========
```
composer require react/zmq
```
Phalcon
========

```
https://phalconphp.com/en/download
```

And Just clone the repo

```
git clone https://github.com/ch3k1/netflow
```

I will be storing the flows in a MySQL database

database default config

```
<?php

return new \Phalcon\Config(array(

    'database' => array(
        'adapter'    => 'Mysql',
        'host'       => 'localhost',
        'username'   => 'username',
        'password'   => 'password',
        'dbname'     => 'dbname',
    ),
    'application' => array(
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'libraryDir'     => __DIR__ . '/../../app/libraries/'
    )
));
```

Usage

```
php cli.php
```

