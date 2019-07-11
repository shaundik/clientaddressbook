<?php
session_start();

$loginError="";
//if login form was submitted
if(isset($_POST["login"]))
{
    //connect with functions
    include("includes/functions.php");

    //create variables
    //wrap data with validate function
    $formEmail = validateFormData($_POST["email"]);
    $formPass  = validateFormData($_POST["password"]);
    
    //connect with database
    include("includes/connection.php");
    
    //create a query
    $query = "SELECT name, password FROM user WHERE email='$formEmail'";
    
    //store the result
    $result = mysqli_query($conn,$query);
    
    //verify if result is returned
    if( mysqli_num_rows($result) > 0 )
    {
        
        //store basic data in variables
        while( $row = mysqli_fetch_assoc($result) )
        {
            $user     = $row["name"];
            $hashPass = $row["password"];
        }
        
        //verify if password is correct
        if( password_verify($formPass,$hashPass) )
        {
            //correct login details
            //store data in session variables
            $_SESSION["loggedinuser"] = $user;
            
            //redirect it to clients.php
            header("location: clients.php");
        }
        else//hashed password doesnot match
        {
            $loginError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Incorrect Password,Please try again!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        }
    }
    else//there are no results in database
    {
        $loginError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    User does not exist!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
    
//close the connection
mysqli_close($conn);
}


//$password = password_hash("abc123",PASSWORD_DEFAULT);
//echo $password;
include("includes/header.php");
?>

<div class="container">
  <h1>Client Address Book</h1>
  <p class="lead">Log in to your account</p>

  <?php echo $loginError; ?>

  <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

      <div class="form-group" >
         <label for="login-email" class="sr-only">Email</label> 
         <input type="email" class="form-control" id="login-email" placeholder="email" name="email">
      </div>

      <div style="margin-left:5px;" class="form-group">
         <label for="login-password" class="sr-only">Password</label> 
         <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
      </div>              

      <button style="margin-left:5px;" type="submit" class="btn btn-primary" name="login">Login</button>

  </form>
  <br>

</div>

<?php
include("includes/footer.php");
?>
