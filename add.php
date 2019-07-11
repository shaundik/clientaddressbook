<?php
session_start();

//if user is not logged in
if(!$_SESSION["loggedinuser"])
{
    //send them back to login page
    header("location: index.php");
}

//connect to database
include("includes/connection.php");

//connect to functions
include("includes/functions.php");

$clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
$clientNameError=$clientEmailError="";
if(isset($_POST["add"]))
{
    //check if input are empty
    //create variable with form data
    //wrap them with function.php
    if($_POST["clientName"])
    {
        $clientName = validateFormData($_POST["clientName"]);
    }
    else
    {
        $clientNameError = "please enter your Name";
    }
    if($_POST["clientEmail"])
    {
        $clientEmail = validateFormData($_POST["clientEmail"]);
    }
    else
    {
        $clientEmailError = "please enter your Email";
    }
    
    $clientPhone = validateFormData($_POST["clientPhone"]);
    $clientAddress = validateFormData($_POST["clientAddress"]);
    $clientCompany = validateFormData($_POST["clientCompany"]);
    $clientNotes = validateFormData($_POST["clientNotes"]);
    
    if($clientName && $clientEmail)
    {
        //start a query
        $query = "INSERT INTO clients(id,name,email,phone,address,company,notes,date_added)VALUES(NULL,'$clientName','$clientEmail','$clientPhone','$clientAddress','$clientCompany','$clientNotes',CURRENT_TIMESTAMP)";
        
        //store the query
        $result = mysqli_query($conn,$query);
        
        if($result)
        {
            //refresh the page with query string(alert=success)
            header("Location: clients.php?alert=success");
        }
        else
        {
            echo "ERROR".$query."<br>".mysqli_error($conn);
        }
    }
}

//close my sql coonection
mysqli_close($conn);


include("includes/header.php");
?>

<div class="container">
    <h1>Add Client</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row">
        <div class="form-group col-sm-6">
        <small class="text-danger"> <?php echo $clientNameError; ?></small>
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName">
        </div>
        
        <div class="form-group col-sm-6">
        <small class="text-danger"> <?php echo $clientEmailError; ?></small>
        <label for="client-email">Email *</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-add">Address</label>
        <input type="text" class="form-control input-lg" id="client-add" name="clientAddress">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"></textarea>
        </div>
        
        <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button style="float:right;"type="submit" class="btn btn-lg btn-success pull-right" name="add">Add client</button> 
        </div>
        
    </form>
</div>

<?php
include("includes/footer.php");
?>
