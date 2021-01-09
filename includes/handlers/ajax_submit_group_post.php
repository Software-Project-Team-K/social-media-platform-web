<?php
include '../../assets/classes.php';
include '../../includes/classes/Group.php';

$connect =new connection ;
$con = $connect->conn;
session_start();
if(isset($_POST['post_body'])) {
	$group_id = $_POST['group_id'];
	$user_id  = $_SESSION['user']->get_id();
	$group_obj = new Group($con, $user_id,$group_id);	
	$group_obj->submitPost($_POST['post_body'])	;
}

?>