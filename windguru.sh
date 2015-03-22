#!/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games
now=$(date)
tgpath=$1
LOGFILE="windguru.log"
cd ${tgpath}
casperjs windguru.js
php windguru.php prod >> ${tgpath}/logs/${LOGFILE}
#sleep 10
#echo "safe_quit" | ${tgpath}/bin/telegram-cli -k ${tgpath}/server.pub
#${tgpath}/bin/telegram-cli -k ${tgpath}/server.pub -W \n<<EOF
#msg $to $subject
#safe_quit
#EOF
echo "Finished" >> ${tgpath}/logs/${LOGFILE}