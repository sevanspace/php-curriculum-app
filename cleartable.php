<?php
$con = mysql_connect("SQL09.FREEMYSQL.NET","evanpractice","legodude232");
if (!$con)//"www.freesql.org","evantest","legodude232"
  {
  die('Could not connect: ' . mysql_error());
  }
  else
  {
  echo "Connected...<br>";
  }

// some code
mysql_select_db("evanstorage") or die(mysql_error());
echo "Connected to Database...<br>";

mysql_query("TRUNCATE TABLE lessons") or die(mysql_error());
echo "Table Cleared!";


?>