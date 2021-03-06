<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: index.php");
 }

//$server = 'lochnagar.abertay.ac.uk';
//$uid = 'sql1602312';
//$mysqlpassword = 'ymC78stBq2m3';
//$database = 'sql1602312';

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

$db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        echo $errormsg;
    }

 $error = false;
 $name;
 $email;
 $nameError;
 $emailError;


 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name must contain alphabets and space.";
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM loginData WHERE userEmail='$email'";
   $result = $db->query($query);
   $count = $result->num_rows;
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   $customerID = uniqid('', $more_entropy);
   base_convert($customerID, 16, 36);
   $query = "INSERT INTO loginData(customerID,loginID,password,userEmail) VALUES('$customerID','$name','$password','$email')";
   $res = $db->query($query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/register.css" type="text/css" />
</head>

<body>

    <div class="container">

        <div id="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                <div class="col-md-12">

                    <div class="form-group">
                        <h2 class="">Sign Up.</h2>
                    </div>

                    <div class="form-group">
                        <hr />
                    </div>

                    <?php if ( isset($errMSG) ) { ?>
                        <div class="form-group">
                            <div class="alert alert- <?php echo ($errTyp=='success') ? 'success ' : $errTyp;?> ">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php } ?>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50">
                                </div>
                                <?php if ( isset($nameError) ) { ?>
                                <span class="text-danger"><?php echo $nameError; ?></span> 
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40">
                                </div>
                                <?php if ( isset($emailError) ) { ?>
                                <span class="text-danger"><?php echo $emailError; ?></span>
                                <?php } ?> 
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15">
                                </div>
                                <?php if ( isset($passError) ) { ?>
                                <span class="text-danger"><?php echo $passError; ?></span>
                                <?php } ?>  
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>

                            <div class="form-group">
                                <a href="index.php">Sign in Here...</a>
                            </div>

                </div>

            </form>
        </div>

    </div>

</body>

</html>

<?php ob_end_flush(); ?>
