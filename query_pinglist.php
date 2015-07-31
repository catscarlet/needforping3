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
      <input type="radio" name="selected_server" value='.$this->server_name.'>'.$this->alias_name.'
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

/* 查询数据库 */
mysql_select_db(constant('DB_NAME'), $con) or die(mysql_error());
$sql = 'select * from '.constant('DB_TABLE').' where state = "normal" order by id';
$result = mysql_query($sql) or die('Query failed: '.mysql_error().' Actual query: '.$sql);

/* html输出form */
echo '<form name="server_selecter" class="formcss" action="query_db.php" method="get">';

while ($row = mysql_fetch_array($result)) {
    $serverarray[$row['id']] = new ServerList($row['id'], $row['server_name'], $row['alias_name'], $row['description'], $row['state']);
    $serverarray[$row['id']]->echoCheckbox();
}

echo '<input type="button" name="submit" value="提交查询" onclick="getquery('.'\'198.35.46.1\''.')">


</form>';

















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
