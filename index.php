 <?php
 ob_start();
 session_start();

 
    
//$server = 'lochnagar.abertay.ac.uk';
//$uid = 'sql1602312';
//$mysqlpassword = 'ymC78stBq2m3';
//$database = 'sql1602312';


$errormsg = "";
define("SERVER", "mysql.hostinger.co.uk");
define("USER", "u180486004_root");
define("PASS", "x7442nbb");
define("DATABASE", "u180486004_cls");




//define("SERVER", "lochnagar.abertay.ac.uk");
//define("USER", "sql1602312");
//define("PASS", "ymC78stBq2m3");
//define("DATABASE", "sql1602312");

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
function verify($username, $password){

    
    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }
    debug_to_console($username);
    $query = "SELECT loginID,password FROM loginData WHERE userEmail='$username'";
    $result = $db->query($query);
      
    if (!$result){
        
        $errormsg = 'LOGIN_ERROR';
        return $errormsg;
    }

    
    $row = $result->fetch_assoc();
    $hash = $row['password'];
    $hashpass = hash('sha256', $password);

    if ($hash != $hashpass){
        $errormsg =  'LOGIN_ERROR';
        return $errormsg;
    }
    else{
        $errormsg = "LOGIN_OKAY";
        $_SESSION['user'] = $row['loginID'];
        return $errormsg;

    }

    $db->close();


}


if(isset($_POST['btn-login']))
{


    $username = $_POST['username'];
    $password = $_POST['password'];



    $loginresult = verify($username, $password);

    switch($loginresult){
        case "CONNECT_ERROR":
            $errormsg = "CouldNotConnect";
            //header("Location: register.php");
            break;
        case "LOGIN_ERROR":
            $errormsg= "LoginError";

            //header("Location: register.php");
            break;
        case "LOGIN_OKAY":
            header("Location: classifieds.php");
            //navigate to our ebay page after successful login
            break;


    }
    unset($_POST['btn-login']);
}



?>
<!DOCTYPE html>
<html class="full" lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Web Development Blog </title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/the-big-picture.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-bottom">
        <div class="container-fluid">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <a class="navbar-brand" href="index.php">Home</a>
                    <li><a href="classifieds.php">Classifieds Demo</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog Posts <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Week 1</a></li>
                            <li class="disabled"><a href="#">Week 2</a></li>
                            <li class="disabled"><a href="#">Week 3</a></li>
                            <li class="disabled"><a href="#">Week 4</a></li>
                            <li class="disabled"><a href="#">Week 5</a></li>
                            <li class="disabled"><a href="#">Week 6</a></li>
                            <li class="disabled"><a href="#">Week 7</a></li>
                            <li class="disabled"><a href="#">Week 8</a></li>
                            <li class="disabled"><a href="#">Week 9</a></li>
                            <li class="disabled"><a href="#">Week 10</a></li>
                            <li class="disabled"><a href="#">Week 11</a></li>
                            <li class="disabled"><a href="#">Week 12</a></li>
                        </ul>
                    </li>
                </ul>
                <?php if (isset($_SESSION['user'])) { ?>
                    <ul class="nav navbar-nav navbar-right">
                    <p><?php echo $_SESSION['user']; ?></p>
                    </ul>
                
               <?php }?>
               <?php if (!isset($_SESSION['user'])) { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Login<span class="caret"></span></a>
                        <ul class="dropdown-menu">

                            <div class="container-fluid container-login">
                                <?php if (isset($_GET['errormsg']) && $_GET['errormsg'] == "CouldNotConnect") { ?>
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                                    <strong>Error!</strong> Error Connecting to the Database.
                                </div>
                                <?php } ?>
                                <?php if (isset($errorMsg) && $errorMsg == "LoginError") { ?>
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                                    <strong>Error!</strong> Invalid Username or Password.
                                </div>
                                <?php } ?>
                                <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <label for="inputEmail" class="sr-only">Email address</label>
                                    <input type="email" id="username" name="username" class="form-control" placeholder="Email address" required autofocus>
                                    <label for="inputPassword" class="sr-only">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Sign in</button>

                                </form>

                            </div>

                        </ul>
                        <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    </li>
                </ul>
                <?php } ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h1>Seamus Salt Blog and Portfolio</h1>
                <p>You will find on this site a demo of a classified ad website, and a link to 12 weeks of blog posts highlighting techniques used to create this website.</p>
                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!--Bootsrap requires Tether to not spit errors-->
    <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php ob_end_flush(); ?>