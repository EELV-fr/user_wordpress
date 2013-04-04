<?php
$baseuri=$_SERVER['REQUEST_URI'];

$vars = explode('/',$baseuri);

if(sizeof($vars)>=4){
	$hash = $vars[4];
	$uid = $vars[3];
	$wp=new OC_user_wordpress();
	if(!$wp->log_with_hash($uid,$hash)){
		echo'ERROR 1';
		exit();
	}
}
else{
	echo'ERROR 0';
	exit();	
}
$baseuri=implode('/',array_slice($vars,0,5)).'/';
?>