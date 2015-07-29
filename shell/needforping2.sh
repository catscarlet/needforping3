#!/bin/sh

needforping2_DIR=/var/www/needforping2

TMP_DIR=/$needforping2_DIR/shell/pingresult
SERVER_LIST=/$needforping2_DIR/shell/server_list.txt




while read line
    do
        $needforping2_DIR/shell/goping2.sh $line &
    done < $SERVER_LIST
