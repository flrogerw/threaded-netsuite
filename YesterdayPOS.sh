#!/bin/bash


###  Picks up Late Night Orders

# Culver City
/usr/local/share/threaded-netsuite/LivePos.php  -l 27644 -d yesterday -t receipts

sleep 61

#Oakridge
/usr/local/share/threaded-netsuite/LivePos.php  -l 27889 -d yesterday -t receipts

sleep 61

#Valley Fair
/usr/local/share/threaded-netsuite/LivePos.php  -l 27890 -d yesterday -t receipts

sleep 61

#Santa Anita
/usr/local/share/threaded-netsuite/LivePos.php  -l 27645 -d yesterday -t receipts

sleep 61

#Bay Area
/usr/local/share/threaded-netsuite/LivePos.php  -l 28033 -d yesterday -t receipts


sleep 61

#Roseville
/usr/local/share/threaded-netsuite/LivePos.php  -l 28034 -d yesterday -t receipts


/usr/local/share/threaded-netsuite/LivePos.php -t orders
