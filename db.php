<?php
	class dbOperation{
     
		 function __construct($var){
			 $con=mysql_connect("localhost","root","") or die("Error in connection");
			 mysql_select_db("db_SOCIALNETWORK",$con)or die("Error in database");	
		 }
		 function executeQuery($query){
			 if($con==null){
				$con=mysql_connect("localhost","root","") or die("Error in connection");
				mysql_select_db("db_SOCIALNETWORK",$con)or die("Error in database");
			 }
			mysql_query($query,$con);
		}
		function getResult($query){
			if($con==null){
				$con=mysql_connect("localhost","root","") or die("Error in connection");
				mysql_select_db("db_SOCIALNETWORK",$con)or die("Error in database");
			 }
			return mysql_query($query,$con);
		}
		function closeConnection(){
			//mysql_close($con);
		}
	
	 }
?>
