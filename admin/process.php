<?php
if(isset($_POST['submit'])) {
	include_once("../includes/dbconnect.php");
	$link = mysqli_connect(HNAME,USER,PWD,DBNAME);
	$username = mysqli_real_escape_string($link,$_POST['username']);
	$password = md5($_POST['password']);
	$query = "select * from tbl_user where username='$username' and password='$password'";
	$result = mysqli_query($link,$query);
	$userdata=mysqli_fetch_assoc($result);
	$rec= mysqli_num_rows($result);
	if($rec==1 && $userdata['usertype']=='admin') {
		session_start();
		$_SESSION['username']=$username;
		$_SESSION['usertype']=$userdata['usertype'];
		$_SESSION['site']="media_planning";
		header("location:index.php");
	}
	else{
		header("location:index.php?msg=username or password invalid");
	}
}else{
	header("location:index.php");
}
?>