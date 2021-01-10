<?php
class User
{
    private $user;
    private $con;
    public function __construct($con,$user)
    {
        $this->con=$con;
        $user_query= mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user=mysqli_fetch_array($user_query);
    }
    //get username
    public function getusername()
    {
        return $this->user['username'];


    }
    //get number of posts
    public function getnumofposts()
    {
        $username=$this->user['username'];
        $query=mysqli_query($this->con,"SELECT no_post FROM users WHERE username='$username'");
        $row=mysqli_fetch_array($query);
        return $row['no_post'];

    }
    //get first and last name 
    public function getfirst_lastname()
    {
        $username=$this->user['username'];
        $query=mysqli_query($this->con,"SELECT first_name,last_name FROM users WHERE username='$username'");
        $row=mysqli_fetch_array($query);
        return $row['first_name']." ".$row['last_name'];
    }
    //get profile_pic
    public function getprofile_pic()
    {
        $username=$this->user['username'];
        $query=mysqli_query($this->con,"SELECT profile_pic FROM users WHERE username='$username'");
        $row=mysqli_fetch_array($query);
        return $row['profile_pic'];
    }
    public function isclosed()
    {
        $username=$this->user['username'];
        $query=mysqli_query($this->con,"SELECT user_closed FROM users WHERE username='$username'");
        $row=mysqli_fetch_array($query);
        if($row['user_closed']=='yes')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isfriend($usernametocheck)
    {
        $usernamecomma=",".$usernametocheck .",";
        if((strstr($this->user['friend_array'], $usernamecomma)) || $usernametocheck==$this->user['username']  )
        {
            return true;
        }
        else{
            return false;
        }



    }




}

?>