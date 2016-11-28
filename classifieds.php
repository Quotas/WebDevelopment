<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])){
    header("Location: index.php");
}
$_SESSION['highestID'] = 0;

define("SERVER", "lochnagar.abertay.ac.uk");
define("USER", "sql1602312");
define("PASS", "ymC78stBq2m3");
define("DATABASE", "sql1602312");



function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}


function updateItems(){
    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }

    $query = "SELECT * FROM classifieds";
    //$result = $db->query($query);
    $result = $db->query($query);

    if ($result->num_rows == 0){
        echo "Nothing to return";
        exit;
    }

    while ($row = $result->fetch_assoc()) {       
        echo "<div class= \"card\">";
        echo "<img src=".$row['imagePath']."></img>";
        echo "<p class = \"card-text\">".$row['info']."</p>";
        echo "<a href=\"#\" class=\"btn btn-primary\">Buy</a>";
        echo "</div>";

        if($row['classifiedID'] > $highestID){
            $_SESSION['highestID'] = $row['classifiedID'];
        }
    }
     


}

function logout(){

    session_unset();
    session_destroy();
    session_write_close();
    $_SESSION = array();
    header("Location: index.php");
}

function getNewItem(){
    echo "";
}

if (isset($_POST['btn-logout'])){

    logout();
}

if(isset($_POST['cls-btn'])){

//add our new ad to our database and then refresh the page

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Album example for Bootstrap</title>






    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> 

    <!-- Custom styles for this template -->
    <link href="css/adds.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<script type="text/javascript">

    
    function refresh()
    {

                //dataDiv = document.getElementById('dataDiv');
				//var tempElement = document.createElement('div');
                //tempElement.innerHTML =  <?php getNewItem();?> ;

                //dataDiv.appendChild(tempElement.firstChild);

    }

    function test(){
        console.log("Test");
    }
document.addEventListener("DOMContentLoaded", function()  // This is the function the browser first runs when it's loaded.
{
	//refresh() // Then runs the refresh function for the first time.
	//var int=self.setInterval(function(){refresh()},10000); // Set the refresh() function to run every 10 seconds. [1 second would be 1000, and 1/10th of a second would be 100 etc.
});

</script>

<body>

  <script>
              $(document).ready(function() {

                $('#dialog').dialog({
                    autoOpen: false,
                    title: 'Post an ad!'
                });
                $('#opener').click(function() {
                    $('#dialog').dialog('open');
//                  return false;
                });
            });
  </script>

  <div id="dialog" title="Post an ad!">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
  <div class="form-group">
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">Contact Email</small>
  </div>
  <div class="form-group">
    <label for="exampleTextarea">Classified Information.</label>
    <textarea class="form-control" name="info" id="exampleTextarea" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="droplist">Select the number of days the ad will be active for (1$ per day).</label>
    <select class="selectpicker" id="droplist" name="days">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>50</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Upload File.</label>
    <input type="file" name="imageFile" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">Upload an image of the item you want to sell, must be smaller than 2mb.</small>
  </div>
  <button type="submit" class="btn btn-primary" name="cls-btn">Post</button>
</form>
  
  
  </div>


    <div class="navbar navbar-static-top navbar-dark bg-inverse">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><?php echo $_SESSION['user'];?></a>
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <button class="btn btn-sm btn-primary" type="submit" name="btn-logout"><span class="glyphicon glyphicon-log-out"></span> Log out</button>
            </form>
        </div>
    </div>

    <section class="jumbotron text-xs-center">
        <div class="container">
            <h1 class="jumbotron-heading">Classifieds</h1>
            <p class="lead text-muted">Below you can find all currently active classified ads, if you would like to buy one simply click the buy button and the funds will be deducted from your account.</p>
            <p id="opener">
                <button class="btn btn-primary">Post a classified ad.</button>
            </p>
        </div>
    </section>

    <div class="album text-muted">
        <div class="container">

            <div class="row" id="dataDiv">
            <?php updateItems(); ?>
            </div>

        </div>
    </div>

    <footer class="text-muted">
        <div class="container">
            <p class="float-xs-right">
                <a href="#">Back to top</a>
            </p>
            <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
            <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
        </div>
    </footer>

    <!--Bootsrap requires Tether to not spit errors-->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</body>

</html>