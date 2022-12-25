<?php

define("MYSQLHOST","localhost");
define("MYSQLUSER","shixun_video");
define("MYSQLPASS","shixunvideo123");
define("MYDB","news_video");

function my_sql($sql){
      $con = mysql_connect(MYSQLHOST,MYSQLUSER,MYSQLPASS);
      if(!$con){
        die('erro:' . mysql_error());
      }
      mysql_select_db(MYDB,$con);
      mysql_set_charset('utf8', $con); 
      $result = mysql_query($sql);
      $ret = array();
      while($row = mysql_fetch_array($result))
      {
         array_push($ret, $row);
      }
      mysql_close($con);
      return $ret;
}

function my_insert($sql){
	  $con = mysql_connect(MYSQLHOST,MYSQLUSER,MYSQLPASS);
      if(!$con){
        die('erro:' . mysql_error());
      }
      mysql_select_db(MYDB,$con);
      mysql_set_charset('utf8', $con); 
      $result = mysql_query($sql);
	  return $result;
}

function my_delete($sql){
      $con = mysql_connect(MYSQLHOST,MYSQLUSER,MYSQLPASS);
      if(!$con){
        die('erro:' . mysql_error());
      }
      mysql_select_db(MYDB,$con);
      mysql_set_charset('utf8', $con); 
      $result = mysql_query($sql);
      return $result;
}

function my_update($sql){
      $con = mysql_connect(MYSQLHOST,MYSQLUSER,MYSQLPASS);
      if(!$con){
        die('erro:' . mysql_error());
      }
      mysql_select_db(MYDB,$con);
      mysql_set_charset('utf8', $con); 
      $result = mysql_query($sql);
      return $result;
}
