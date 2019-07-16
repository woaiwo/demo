<?
require("init.php");

unset($_SESSION["userid"]);
unset($_SESSION["username"]);
unset($_SESSION["userphone"]);

// setcookie("userid","",time()-1);
// setcookie("username","",time()-1);
// setcookie("userphone","",time()-1);
header("location:user_login.php");
$db->close();
exit;
?>