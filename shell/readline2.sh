#!/bin/bash
i=0
OUTPUT=$2
MYSQL_USER=needforping2
MYSQL_USER_PASSWORD=needforping2

function output_to_mysql() {
#    echo { "\"The server is "\":"\"$THESERVER"\" ,"\"TIME"\":"\"$DATETIME"\" , "\"LOSS"\":"\"$LOSS"\" , "\"min"\":"\"$min"\" , "\"avg"\":"\"$avg"\" , "\"max"\":"\"$max"\"}
	MYSQL_COMMAND="INSERT INTO needforping2.pingresult (id, server_name, DATETIME, loss_percent, rtt_min, rtt_avg, rtt_max) VALUES (NULL, \"$THESERVER\", \"$DATETIME\", \"$LOSS\", \"$min\", \"$avg\", \"$max\");"
	mysql -u$MYSQL_USER -p$MYSQL_USER_PASSWORD -e "$MYSQL_COMMAND"
}

while read line
do
	i=`expr $i + 1`
	keytext=`echo $line|awk '{print $5}'`

	if [ `echo $keytext|grep CST` ] ;then
		DATETIME=`echo "$line" |awk '{print $3" "$4}'`
#		MON=`echo "$line" |awk '{print $2}'`
#		DAY=`echo "$line" |awk '{print $3}'`
#		TIME=`echo "$line" |awk '{print $4}'`
		continue
	fi

	if [ `echo $keytext|grep SERVER` ] ;then
		THESERVER=`echo "$line" |awk '{print $4}'`
	fi

	if [ `echo $keytext|grep received` ] ;then
		LOSS=`echo "$line" |awk '{print $6}'`
		continue
	fi

	if [ `echo $keytext|grep ms` ] ;then
		RTT=`echo "$line" |awk '{print $4}'`
		min=`echo "$RTT" |awk  'BEGIN{FS="/"} {print $1}'`
		avg=`echo "$RTT" |awk  'BEGIN{FS="/"} {print $2}'`
		max=`echo "$RTT" |awk  'BEGIN{FS="/"} {print $3}'`
		mdev=`echo "$RTT" |awk  'BEGIN{FS="/"} {print $4}'`
		#echo { "\"TIME"\":"\"${MON}_${DAY}_${TIME}"\" , "\"LOSS"\":"\"$LOSS"\" , "\"min"\":"\"$min"\" , "\"avg"\":"\"$avg"\" , "\"max"\":"\"$max"\" } >> $OUTPUT
		output_to_mysql
	fi

done < $1
