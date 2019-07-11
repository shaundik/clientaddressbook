<?php
session_start();
//did the user's browser send a cookie to session
if(isset($_COOKIE[ session_name() ]))
{
    setcookie(session_name(),'',time()-86400,'/');
}

//clear al session variable
session_unset();

//destroy the session
session_destroy();
    
include("includes/header.php");

?>
<div class="container">
<h1 style="color:red;">Logged Out</h1>
<p class="lead"> You have been logged out. See you next time.</p>
</div>
<br><br>
<?php
include("includes/footer.php");
?>