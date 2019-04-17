<?php

//$host="localhost"; //host name
//$username = "springv1_var";    //mySQL username
//$password = "ILoveTxWildife2017!";    //mySQL password
//$db_name ="springv1_Tx_Wildlife_Coffee_Co";      //database name

// made need to add port and socket
//Connect to server and select database

mysql_connect("localhost","springv1_var","ILoveTxWildife2017") or die("Cannot connect to server for some reason and I have entered strings instead");

//select database

mysql_select_db("springv1_Tx_Wildlife_Coffee_Co") or die("Cannot connect to database");

?>
