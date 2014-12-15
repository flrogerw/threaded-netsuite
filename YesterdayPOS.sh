#!/bin/bash


###  Picks up Late Night Orders

# Culver City
/usr/local/share/threaded-netsuite/LivePos.php  -l 27644 -d yesterday -t receipts

sleep 61

#Oakridge
/usr/local/share/threaded-netsuite/LivePos.php  -l 27889 -d yesterday -t receipts



/usr/local/share/threaded-netsuite/LivePos.php -t orders
