<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Post.php");

$limit=50; //num of posts to be loaded

$posts=new Post($con,$_REQUEST['userloggedin']);
//$post= new Post($con,$userloggedin);
$posts->loadporfilepost($_REQUEST, $limit);

?>