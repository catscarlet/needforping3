#!/bin/sh

needforping3_DIR=/var/www/needforping3

TMP_DIR=/$needforping3_DIR/shell/pingresult
SERVER_LIST=/$needforping3_DIR/shell/server_list.txt




while read line
    do
        $needforping3_DIR/shell/goping3.sh $line &
    done < $SERVER_LIST
