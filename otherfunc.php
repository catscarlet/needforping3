<?php

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
