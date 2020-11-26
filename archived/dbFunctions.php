<?php
require("dbconfig.php");

function getUserData($id)
{
	$array - array();
	$q = mysql_query("SELECT * FROM 'users' WHERE 'id'=".$id);
	while($r = mysql_fetch_assoc($q))
	{
		$array['username'] = $r['username'];
	}	
	return $array;
}

function getId($username)
{
	$q = mysql_query("SELECT * FROM 'users' WHERE 'username'='".$username."'");
	while($r = mysql_fetch_assoc($q))
	{
		return $r ['id'];
	}	

}

?>