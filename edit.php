<?php
session_start();
//if not logged in
if(!$_SESSION["loggedinuser"])
{
    //redirect to login page
    header("Location: index.php");
}

//gret the id from query string sent from clients.php
$clientID = $_GET['id'];

//connect tp database
include("includes/connection.php");

//connect to functions
include("includes/functions.php");

//start a query
$query = "SELECT * FROM clients WHERE id='$clientID'";

//store the query
$result = mysqli_query($conn,$query);

$clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
$alertMessage="";
$clientNameError=$clientEmailError="";
$clientname=$clientemail="";

//check if result is returned
if( mysqli_num_rows($result) > 0 )
{
    //we have data
    //set some variables
    while( $row=mysqli_fetch_assoc($result) )
    {
        $clientName     =      $row["name"];
        $clientEmail    =      $row["email"];
        $clientPhone    =     $row["phone"];
        $clientAddress  =     $row["address"];
        $clientCompany  =     $row["company"];
        $clientNotes    =     $row["notes"];
    }
}
else
{
    $alertMessage = "<div class='alert alert-warning'>Nothing to see here!<a href=clients.php>Head Back</a></div>";
}

//if update button was pressed
if(isset($_POST["update"]))
{
    //set variables
    //basically we will overwrite the data stored in database
    if($_POST["clientName"])
    {
        $clientname = validateFormData($_POST["clientName"]);
    }
    else
    {
        $clientNameError = "This feild can't be empty";
    }
    if($_POST["clientEmail"])
    {
        $clientemail = validateFormData($_POST["clientEmail"]);
    }
    else
    {
        $clientEmailError = "This feild can't be empty";
    }
    
    $clientPhone = validateFormData($_POST["clientPhone"]);
    $clientAddress = validateFormData($_POST["clientAddress"]);
    $clientCompany = validateFormData($_POST["clientCompany"]);
    $clientNotes = validateFormData($_POST["clientNotes"]);
    
    //if none of starred box is empty
    if($clientname && $clientemail){
    
        //start a new query and result
        $query = "UPDATE clients 
                   SET name='$clientname',
                   email='$clientemail',
                   phone='$clientPhone',
                   address='$clientAddress',
                   company='$clientCompany',
                   notes='$clientNotes'
                   WHERE id='$clientID'";

        $result=mysqli_query( $conn, $query );

        //check if there is result i.e above statement gives true
        if( $result )
        {
            //redirect to client page with query string
            header("Location: clients.php?alert=updatesuccess");
        }
        else
        {
            echo "Error updating records".mysqli_error($conn);
        }
    }

}

//if delete button is pressed
if(isset($_POST["delete"]))
{
    $alertMessage = "<div class='alert alert-danger'>
                        <p class='lead'>Are you sure want to delete this client data?</p>
                        
                        <form style='margin-left:400px;' action='". htmlspecialchars($_SERVER["PHP_SELF"]) ."?id=$clientID' method='post'>
                            <button type='submit' class='btn btn-danger btn-sm' name='confirm-delete'>Yes,sure</button>
                            <a type='button' class='btn btn-dafault btn-sm' data-dismiss='alert'>Ooops,No</a>
                        </form>
                    </div>";
}

//if confirm-delete button was pressed
if(isset($_POST["confirm-delete"]))
{
    //start a new query and result
    $query = "DELETE FROM clients WHERE id='$clientID'";
    $result = mysqli_query( $conn, $query);
    
    //check if result is true
    if( $result )
    {
        //return to client.php with query string(deleted)
        header("Location: clients.php?alert=deleted");
    }
    else
    {
        echo "Error deleting the client data".mysqli_error($conn);
    }
}

//close the connection
mysqli_close($conn);

include("includes/header.php");

?>


<div class="container">
    <?php echo $alertMessage; ?>
    <h1>Add Client</h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $clientID; ?>" method="post" class="row">
        
        <div class="form-group col-sm-6">
        <small class="text-danger"> <?php echo $clientNameError; ?></small>
        <label for="client-name">Name *</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName; ?>">
        </div>
        
        <div class="form-group col-sm-6">
        <small class="text-danger"> <?php echo $clientEmailError; ?></small>
        <label for="client-email">Email *</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail; ?>">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone; ?>">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-add">Address</label>
        <input type="text" class="form-control input-lg" id="client-add" name="clientAddress" value="<?php echo $clientAddress; ?>">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany; ?>">
        </div>
        
        <div class="form-group col-sm-6">    
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $clientNotes; ?></textarea>
        </div>

        <div class="col-sm-12">
            <hr>
            <a style="float:right;"href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button style="float:right; margin-right:5px;"type="submit" class="btn btn-lg btn-success pull-right" name="update">Update</button> 
            <button style="float:left;"type="submit" class="btn btn-lg btn-danger pull-right" name="delete">Delete</button> 
        </div>
        
    </form>
</div>

<?php
include("includes/footer.php");
?>
