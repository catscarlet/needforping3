<?php

/* The name of the database */
define('DB_NAME', 'needforping3');
/* MySQL database username */
define('DB_USER', 'needforping3');
/* MySQL database password */
define('DB_PASSWORD', '5umAQXVrLUsrqW5P');
/* MySQL database table */
define('DB_TABLE', 'pinglist');

/* Object define */
class ServerList
{
    public $id;
    public $server_name;
    public $alias_name;
    public $description;
    public $state;
    public function __construct($id, $server_name, $alias_name, $description, $state)
    {
        $this->id = $id;
        $this->server_name = $server_name;
        $this->alias_name = $alias_name;
        $this->description = $description;
        $this->state = $state;
    }

    public function echoMySelf()
    {
        return 'This is "'.$this->server_name.'"<br>';
    }

    public function echoCheckbox()
    {
      echo '
      <input type="checkbox" name="selecter" value='.$this->server_name.')">'.$this->alias_name.'
      <br>
      ';
    }


}
$serverarray = array();
//$serverlist = new ServerList();


//$q = $_GET['q'];
$con = mysql_connect('localhost', constant('DB_USER'), constant('DB_PASSWORD'));
if (!$con) {
    die('Could not connect: '.mysql_error());
}

/* 查询数据库，输出对象，而非数组 */
mysql_select_db(constant('DB_NAME'), $con) or die(mysql_error());
$sql = 'select * from '.constant('DB_TABLE').' where state = "normal" order by id';
//var_dump($sql);
$result = mysql_query($sql) or die('Query failed: '.mysql_error().' Actual query: '.$sql);
//var_dump($result);

while ($row = mysql_fetch_array($result)) {


$serverarray[$row['id']] = new ServerList($row['id'], $row['server_name'], $row['alias_name'], $row['description'], $row['state']);
//$serverarray = new ServerList(1,2,3,4,5);
//var_dump($row['id'], $row['server_name'], $row['alias_name'], $row['description'], $row['state']);;
//echo $serverarray[$row['id']]->echoMySelf();
$serverarray[$row['id']]->echoCheckbox();
}

/*

$i = min($query_range, mysql_num_rows($result));
while ($row = mysql_fetch_array($result) and $i >= 0) {
    $i = $i - 1;
    $query_DATA['DATETIME'][$i] = $row['DATETIME'];
    $query_DATA['loss_percent'][$i] = 100 - substr($row['loss_percent'], 0, -1);
    $query_DATA['rtt_avg'][$i] = round($row['rtt_avg']);
}

 // 因为sql查询是DESC的，所以要根据键值重新排序，不然坐标轴的时间会变成降序
ksort($query_DATA['DATETIME']);
ksort($query_DATA['loss_percent']);
ksort($query_DATA['rtt_avg']);

 // 将查询的关键词与查询结果合并，并输出json

$query_data = array('server_name' => $q);
$query_data = array_merge($query_data, $query_DATA);
echo json_encode($query_data);

mysql_close($con);

*/

function pingresult_clean($q)
{
    $sql = 'select COUNT(*) from '.constant('DB_TABLE')." where state = 'normal' and server_name =  '".$q."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

     /* 保留记录条数，以30条为一小时的话，1440为2天 */
    $retain_count = 1440;

    if ($row['COUNT(*)'] >= $retain_count) {
        $sql = 'select * from '.constant('DB_TABLE')." where server_name = '".$q."' order by DATETIME DESC LIMIT ".$retain_count;
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            $lastrow_DATETIME = $row['DATETIME'];
        }
        $sql = 'update '.constant('DB_TABLE')." set state = 'delete' where server_name = '".$q."' and DATETIME <= '".$lastrow_DATETIME."'";
        mysql_query($sql);

         //$sql="DELETE FROM ".constant('DB_TABLE')."  where server_name = '".$q."' and state = 'delete'";
        $sql = 'DELETE FROM '.constant('DB_TABLE')."  where state = 'delete'";

        mysql_query($sql);
    }
}
