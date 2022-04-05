<?php 
	setcookie("username", " ",time() - 3600, "/");
	setcookie("userid", " ",time() - 3600, "/");
	setcookie("email", " ",time() - 3600, "/");
	setcookie("mobile", " ",time() - 3600, "/");
	setcookie("profilepic", " ", time() + (86400 * 30), "/");
	header('Location: ../index.php');
?>