<?php

/* The name of the database */
define('DB_NAME', 'needforping3');
/* MySQL database username */
define('DB_USER', 'needforping3');
/* MySQL database password */
define('DB_PASSWORD', '5umAQXVrLUsrqW5P');
/* MySQL database table */
define('DB_TABLE', 'pingresult');

$con = mysql_connect('localhost', constant('DB_USER'), constant('DB_PASSWORD'));
if (!$con) {
    die('Could not connect: '.mysql_error());
}
mysql_select_db(constant('DB_NAME'), $con);

 /* 查询范围 */
$query_range = 360;

$q_array = $_GET['q'];
    foreach ($q_array as $id => $q) {
        $query_output[$id] = query_db($q, $query_range);
    }
echo json_encode($query_output);

function query_db($q, $query_range)
{
    $sql = 'select * from '.constant('DB_TABLE')." where server_name = '".$q."' order by DATETIME DESC LIMIT $query_range";
    $result = mysql_query($sql);
    $i = min($query_range, mysql_num_rows($result));
    while ($row = mysql_fetch_array($result) and $i >= 0) {
        $i = $i - 1;
        $query_DATA['DATETIME'][$i] = $row['DATETIME'];
        $query_DATA['loss_percent'][$i] = 100 - substr($row['loss_percent'], 0, -1);
        $query_DATA['rtt_avg'][$i] = round($row['rtt_avg']);
    }

 /* 因为sql查询是DESC的，所以要根据键值重新排序，不然坐标轴的时间会变成降序 */
    ksort($query_DATA['DATETIME']);
    ksort($query_DATA['loss_percent']);
    ksort($query_DATA['rtt_avg']);

 /* 将查询的关键词与查询结果合并*/
    $query_data = array('server_name' => $q);
    $query_data = array_merge($query_data, $query_DATA);

    return $query_data;
}

mysql_close($con);
