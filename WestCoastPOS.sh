#!/bin/bash


# Culver City
/usr/local/share/threaded-netsuite/LivePos.php  -l 27644 -d today -t receipts

sleep 61

#Oakridge
/usr/local/share/threaded-netsuite/LivePos.php  -l 27889 -d today -t receipts


/usr/local/share/threaded-netsuite/LivePos.php -t orders
