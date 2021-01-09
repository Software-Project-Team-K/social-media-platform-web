<?php
require '../classes.php';
include '../../includes/classes/Group.php';
$connect =new connection ;
$con = $connect->conn; 

$limit=50; //num of posts to be loaded
$user_id= $_REQUEST['userloggedin'];
$group_id= $_REQUEST['group_id'];

$group_obj = new Group($con, $user_id,$group_id);	
$group_obj->loadgrouppost($_REQUEST, $limit);

?>