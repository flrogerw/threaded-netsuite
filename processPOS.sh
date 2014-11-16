#!/bin/bash


# Boca

/usr/local/share/threaded-netsuite/LivePos.php  -l 27449 -d yesterday -t receipts

sleep 61

# Culver City

/usr/local/share/threaded-netsuite/LivePos.php  -l 27644 -d yesterday -t receipts



/usr/local/share/threaded-netsuite/LivePos.php -t orders
