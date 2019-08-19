<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['site']) && $_SESSION['site']=="media_planning" && $_SESSION['usertype']=="staff") {

}else{
    header("location:../index.php");
}
?>
