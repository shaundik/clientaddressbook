<?php
session_start();
//if user is not logged in
$alertMessage="";
if(!$_SESSION["loggedinuser"])
{
    //send them back to login page
    header("location: index.php");
}

//connect to database
include("includes/connection.php");

//start a query
$query = "SELECT * FROM clients ORDER BY name ASC";

//storin query in to result
$result = mysqli_query($conn,$query);

//check for query string(alert=success)
if(isset($_GET["alert"]))
{
    if($_GET["alert"]=="success")
    {
        $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    New Client Added!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
    elseif($_GET["alert"]=="updatesuccess")
    {
        $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Client Data Updated!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }
    elseif($_GET["alert"]=="deleted")
    {
        $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Client Deleted!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
    }

}

//closing the connection
mysqli_close($conn);
include("includes/header.php");
?>
<div class="container">
<h1>Client Address Book</h1>

<?php echo $alertMessage; ?>    
    
<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>

    <?php

    if( mysqli_num_rows($result)>0 )
    {
        //we have the data
        //output the data
        while( $row = mysqli_fetch_assoc($result) )//fetching the data from associative array
        {
            echo "<tr>";
            
            echo "<td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["phone"]."</td><td>".$row["address"]."</td><td>".$row["company"]."</td><td>".$row["notes"]."</td>";
            
            //query string(id=".$row['id'].")-> used in editing(edit.php)
            echo "<td><a href='edit.php?id=".$row['id']."' type='button' class='btn btn-primary btn-sm>
            <span class='glyphicon glyphicon-edit'></span>Edit
            </a></td>";
            
            echo "</tr>";          
                
        }
    }
    else
    {
        echo "<div class='alert alert-warning'>You have no clients</div>"; 
    }
    ?>
    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-lg btn-success">Add Client</a></div></td>
    </tr>
    
</table>
</div>

<?php
include("includes/footer.php");
?>
