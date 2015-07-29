#!/bin/sh
needforping2_DIR=/var/www/needforping2

TMP_DIR=/$needforping2_DIR/shell/pingresult
SERVER_LIST=/$needforping2_DIR/shell/server_list.txt
line=$1
OUTPUTTXT=$TMP_DIR/ping_$line.txt
OUTPUTTMP=$TMP_DIR/ping_$line.tmp
OUTPUTFORJS=$TMP_DIR/$line.json

  echo "" > $OUTPUTTXT
  THESERVER="The server is $1 SERVER"
  echo $THESERVER >> $OUTPUTTXT
  DATETIME="Pingtime is "`date "+%Y-%m-%d %H:%M:%S"`" CST"
  echo $DATETIME >> $OUTPUTTXT
  ping -c 100 $line |tail -n 3 >> $OUTPUTTXT

  $needforping2_DIR/shell/readline2.sh $OUTPUTTXT $OUTPUTTMP
