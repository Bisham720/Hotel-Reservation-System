<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['site']) && $_SESSION['site']=="media_planning" && $_SESSION['usertype']=="manager") {

}else{
    header("location:../index.php");
}
?>
