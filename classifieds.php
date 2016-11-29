<?php
ob_start();
session_start();
if( !isset($_SESSION['user'])){
    header("Location: index.php");
}

//define("SERVER", "lochnagar.abertay.ac.uk");
//define("USER", "sql1602312");
//define("PASS", "ymC78stBq2m3");
//define("DATABASE", "sql1602312");


define("SERVER", "mysql.hostinger.co.uk");
define("USER", "u180486004_root");
define("PASS", "x7442nbb");
define("DATABASE", "u180486004_cls");




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
        exit;
    }

    while ($row = $result->fetch_assoc()) {       
        echo "<div class= \"card\" >";
        echo "<img src=".$row['imagePath']."></img>";
        echo "<p class = \"card-text\">".$row['info']."</p>";
        echo "<form method=\"POST\" action=\"classifieds.php\" autocomplete=\"off\" enctype=\"multipart/form-data\">";
        echo "<input type=\"hidden\" name=\"cid\" value=".$row['classifiedID'].">";
        echo "<input type=\"hidden\" name=\"price\" value=".$row['price'].">";
        echo "<p><strong>".$row['price']."</strong></p><button class=\"btn btn-sm btn-primary\" name=\"buy-btn\" type=\"submit\">Buy</button>";
        echo "</form>";
        echo "</div>";
    }

    $db->close();
     


}

function logout(){

    session_unset();
    session_destroy();
    session_write_close();
    $_SESSION = array();
    header("Location: index.php");
}

function getNewItem(){
    //echo "";
}

if (isset($_POST['btn-logout'])){

    logout();
}

if(isset($_POST['cls-btn'])){

    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );

    }

    $user = $_SESSION['user'];

    $query = "SELECT customerID FROM loginData WHERE loginID='$user'";
    $result = $db->query($query);

    $row = $result->fetch_assoc();
    $cid = uniqid();
    $uid = $row['customerID'];

    $email = $_POST['email'];
    $info = $_POST['info'];
    $days = (int)$_POST['days'];
    $price = $_POST['cost'];



    $name = $_FILES["imageFile"]["name"];
    //$size = $_FILES['file']['size']
    //$type = $_FILES['file']['type']

    $tmp_name = $_FILES['imageFile']['tmp_name'];
    $error = $_FILES['imageFile']['error'];
    $location = 'upload/';
    $target_file = $location.$name;

    if (isset ($name)) {     
        if (!empty($name)) {
            if  (move_uploaded_file($tmp_name, $location.$name)){
            $errorMSG = 'Uploaded'; 
            $days += 10;

        }

        } else {
                $target_file = 'upload/default.png';
                $errorMSG = 'please choose a file';

        }
    }

    date_default_timezone_set('GMT');
    $curdate = date('l jS \of F Y h:i:s A');

    $query = "INSERT INTO classifieds(classifiedID,userID,info,imagePath,uploadDate,price) VALUES('$cid', '$uid', '$info', '$target_file', '$curdate', '$price')";


    $result = $db->query($query);

    if (!$result){
        $errorMSG = "Error inserting into database";

    }

    $clasprice = $days * 1.0;
    $query = "UPDATE loginData SET money = money-'$clasprice' WHERE customerID='$uid'";
    $result = $db->query($query);
    if (!$result){
        $errorMSG = "Error inserting into database";

    }

    $db->close();
    unset($row['customerID']);
    unset($_POST['email']);
    unset($_POST['price']);
    unset($_POST['days']);
    unset($_POST['info']);
    unset($_POST['cls-btn']);
}

if (isset($_POST['buy-btn'])){


    $cid = $_POST['cid'];
    $price = $_POST['price'];

    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }

    $user = $_SESSION['user'];
    $query = "SELECT customerID FROM loginData WHERE loginID='$user'";
    $result = $db->query($query);
    if($result){
        $errorMSG= "Success";
    }else{
        $errorMSG = "Failure";
    }
    $row = $result->fetch_assoc();
    $uid = $row['customerID'];

    $query = "UPDATE loginData SET money = money-'$price' WHERE customerID='$uid'";
    $result = $db->query($query);
    if($result){
        $errorMSG= "Success";
    }else{
        $errorMSG = "Failure";
    }

    $query = "SELECT userID FROM classifieds WHERE classifiedID='$cid'";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $sellerid = $row['userID'];

    $query = "UPDATE loginData SET money = money+'$price' WHERE customerID='$sellerid'";
    $result = $db->query($query);
    if($result){
        $errorMSG= "Success";
    }else{
        $errorMSG = "Failure";
    }

    $query = "DELETE FROM classifieds WHERE classifiedID='$cid'";
    $result = $db->query($query);
    if($result){
        $errorMSG= "Success";
    }else{
        $errorMSG = "Failure";
    }

    

    

    unset($_POST['buy-btn']);

}

if (isset($_POST['charge'])){


    $topup = $_POST['valinc'];
    $user = $_SESSION['user'];

    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }


    $query = "UPDATE loginData SET money = money+'$topup' WHERE loginID='$user'";
    $result = $db->query($query);
    if($result){
        $errorMSG= "Success";
    }else{
        $errorMSG = "Failure";
    }




    $db->close();
    unset($_POST['charge']);
}

function curMuns(){

    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }
    $user = $_SESSION['user'];
    $query = "SELECT money FROM loginData WHERE loginID='$user'";
    $result = $db->query($query);

    $row = $result->fetch_assoc();
    $curmun = $row['money'];

    echo "     $$curmun";

    $db->close();
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

    <title>Classifieds</title>






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
                    title: 'Post an ad!',
                    width: 500
                });
                $('#opener').click(function() {
                    $('#dialog').dialog('open');
//                  return false;
                });

                $('#dialog2').dialog({
                    autoOpen: false,
                    title: 'Top up your account!',
                    width: 500
                });
                $('#sec-opener').click(function() {
                    $('#dialog2').dialog('open');
//                  return false;
                });


                $('#five-btn').click(function() {
                    var tmp = Number(document.getElementById('value').value);
                    tmp += 5;
                    document.getElementById('value').value = tmp;
                });
                $('#ten-btn').click(function() {
                    var tmp = Number(document.getElementById('value').value);
                    tmp += 10;
                    document.getElementById('value').value = tmp;
                });
                $('#hun-btn').click(function() {
                    var tmp = Number(document.getElementById('value').value);
                    tmp += 100;
                    document.getElementById('value').value = tmp;
                });
                $('#thou-btn').click(function() {
                    var tmp = Number(document.getElementById('value').value);
                    tmp += 1000;
                    document.getElementById('value').value = tmp;
                });


            });
      
  </script>

  <div id="dialog" title="Post an ad!">
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
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
  <div class="input-group">
  <span class="input-group-addon">$</span>
  <input type="text" class="form-control" name="cost"  aria-describedby="priceHelp">
  </div>
  <small id="priceHelp" class="form-text text-muted">Listed Price.</small>
  </br>
  <div class="form-group">
    <label for="exampleInputFile">Upload File.</label>
    <input type="file" name="imageFile" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">Upload an image of the item you want to sell, must be smaller than 2mb. (Images are an extra $10)</small>
  </div>
  
  <button type="submit" class="btn btn-primary btn-block" name="cls-btn" >Post</button>
</form>
</div>

<div id="dialog2" title="Top up your money!">
        <div class="form-check-inline">
            <button class="btn btn-success" id="five-btn">$5</button>
            <button class="btn btn-success" id="ten-btn" >$10</button>
            <button class="btn btn-warning" id="hun-btn" >$100</button>
            <button class="btn btn-danger"  id="thou-btn">$1000</button>
            </br>
        </div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input class="form-control" id="value" name="valinc" type="number" placeholder="Readonly input here…" readonly>
        </div>
        </br>
        <button type="submit" class="btn btn-primary btn-block" name="charge" >Charge</button>
    </form>
</div>
  
  

    <div class="navbar navbar-static-top navbar-dark bg-inverse">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><?php echo $_SESSION['user']; echo curMuns();?></a>
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <button class="btn btn-sm btn-primary" type="submit" name="btn-logout"><span class="glyphicon glyphicon-log-out"></span> Log out</button>
            </form>
        </div>
    </div>

    <section class="jumbotron text-xs-center">
        <div class="container">
            <h1 class="jumbotron-heading">Classifieds</h1>
            <p class="lead text-muted">Below you can find all currently active classified ads, if you would like to buy one simply click the buy button and the funds will be deducted from your account. Otherwise click the 'post a classified ad' button to post your own classified ad!</p>
            <p id="opener">
                <button class="btn btn-primary">Post a classified ad.</button>
            </p>
            <p id="sec-opener">
                <button class="btn btn-success">Top up cash.</button>
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

    <!--Bootsrap requires Tether to not spit errors-->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</body>

</html>
<?php ob_end_flush(); ?>