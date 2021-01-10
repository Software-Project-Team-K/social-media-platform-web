<?php
//declaring variables to prevent errors
$fname="";//first name
$lname="";//last name 
$email="";//email 
$email2="";//email2 
$password="";//password 
$password2="";//password2 
$date="";//signed up date
$error_array=array();//to recieve any error messages 
 //get the result and start handling the form post means get the data entered
if(isset($_POST['register_button']) )
{
    //first name
$fname=strip_tags($_POST['reg_fname']);//remove any html tags 
$fname=str_replace(' ','',$fname);//replace any spce in the name with no space
$fname=ucfirst(strtolower($fname));// only the first letter will be uppercase
$_SESSION['reg_fname']=$fname; //store the value
//last name
 $lname=strip_tags($_POST['reg_lname']);//remove any html tags 
 $lname=str_replace(' ','',$lname);//replace any spce in the name with no space
 $lname=ucfirst(strtolower($lname));// only the first letter will be uppercase
 $_SESSION['reg_lname']=$lname; //store the value
  //email
$email=strip_tags($_POST['reg_email']);//remove any html tags 
$email=str_replace(' ','',$email);//replace any spce in the name with no space
$email=ucfirst(strtolower($email));// only the first letter will be uppercase
$_SESSION['reg_email']=$email; //store the value
 //email2
 $email2=strip_tags($_POST['reg_email2']); //remove any html tags 
 $email2=str_replace(' ','',$email2);//replace any spce in the name with no space
 $email2=ucfirst(strtolower($email2));// only the first letter will be uppercase
 $_SESSION['reg_email2']=$email2; //store the value
//password

$password=strip_tags($_POST['reg_password']);//remove any html tags 

//password2
$password2=strip_tags($_POST['reg_password2']);//remove any html tags 

//date
$date=date("Y-m-d");//the current date
//checcking the same email or not and if they are the same what should be done
if($email==$email2){
  //check the right format of the email
  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email=filter_var($email, FILTER_VALIDATE_EMAIL);

  }
  else{
    array_push($error_array,"invalid format<br>") ;
  }
  //check if the email already exists
$e_value="SELECT email FROM users WHERE email='$email'";
if($e_check=mysqli_query($con,$e_value))
{
  //count the no of the same email
  $num_rows= mysqli_num_rows($e_check);
if($num_rows>0)
{
  array_push($error_array,"Email already in use<br>");
}
}
else {
  array_push($error_array,"failed to get values<br>"). $e_value;
}

}
//if emails don't match
else{
  array_push($error_array,"emails don't match<br>") ;
}

if ($password==$password2)
{//check the password length
  if(strlen($password)<5 ||strlen($password)>30 )
  {
    array_push($error_array,"your password should be between 5 and 30<br>");
  }
  //check the password format
  $p=preg_match('/[^A-Za-z0-9]/',$password);
  if($p)
  {
    array_push($error_array,"your password can only conatains english characters or numbers<br>");
  }

}
else{
  array_push($error_array,"passwords don't match <br>") ;
}
//check the validation of the first name 
if(strlen($fname)>25 ||strlen($fname)<2 )
{
  array_push($error_array,"your first name must be between 2 and 25 <br>");
}
//check the validation of the last name 
if(strlen($lname)>25 ||strlen($lname)<2 )
{
  array_push($error_array,"your last name must be between 2 and 25 <br>");
}
if (empty($error_array))
{
  $password =md5($password); //encrypt before sending to database
 // generate username
 $username= strtolower($fname."_".$lname);
 $check_username=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
 $i=0;
 //if username exists add 1
 while(mysqli_num_rows($check_username)!=0)
 {
   $i++; //increment username by 1
   $username=$username ."_". $i ;
   $check_username=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");

 }
//profile pic
//rand pic
$rand=rand(1,2);
if($rand=1)
{
  $profile_pic ="assets/images/profile picture/default/head_carrot.png";
}
else if($rand=2)
{
  $profile_pic ="assets/images/profile picture/default/head_belize_hole.png";
}
 //insert into the database direct
$sql = "INSERT INTO users VALUES('','$fname','$lname','$username','$email','$password','$date','$profile_pic','0','0','no',',')";
$quer=mysqli_query($con,$sql);
array_push($error_array,"<span style='color:#000000;' > you are all set up, hurry up and log in</span><br>");
// remove the information 
$_SESSION['reg_fname']="";
$_SESSION['reg_lname']="";
$_SESSION['reg_email']="";
$_SESSION['reg_email2']="";


}



} // end of isset 
?>