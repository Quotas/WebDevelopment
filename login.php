<?php

$server = 'lochnagar.abertay.ac.uk';
$uid = 'sql1602312';
$mysqlpassword = 'ymC78stBq2m3';
$database = 'sql1602312';
$options = [
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];

$errormsg = "";
$username = $_POST['username'];
$password = $_POST['password'];


function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

function register($username, $password){

    $customerid = uniqid();
    $_salthashedpassword = password_hash($password, PASSWORD_DEFAULT, $options);

    $db = @new mysqli($server, $uid, $mysqlpassword, $database);
    if ($db->connect_errno) 
    {
        echo 'Error: Could not connect to database.  Please try again later.';
        echo $db->connect_errno;
        exit;
    }

    $query = "INSERT into loginData (customerID, loginID, password)" . "VALUES('$customerid', '$username', '$_salthashedpassword' )";
    $result = $db->query($query);
  
    if (!$result){
        echo 'There was a problem entering the data into the database, please try again later.';
   
    }
    else{
        echo  $db->affected_rows.' customer inserted into database.';

    }
    $db->close();


}

function verify($username, $password){
    
    
    $db = new mysqli($server, $uid, $mysqlpassword, $database);
    if ($db->connect_errno) 
    {
        $errormsg = "CONNECT_ERROR";
        debug_to_console( $db->connect_errno );
        return $errormsg;
    }

    $query = "SELECT password FROM loginDATA WHERE username=" . $username;
    $result = $db->query($query);

      
    if (!$result){
        
        $errormsg = 'LOGIN_ERROR';
        return $errormsg;
    }

    $hash = $result->fetch_assoc();


    if (!password_verify($password, $hash)){
        $errormsg =  'LOGIN_ERROR';
        return $errormsg;
    }
    else{
        $errormsg = "LOGIN_OKAY";
        return $errormsg;

    }

    $db->close();


}

$loginresult = verify($username, $password);

switch($loginresult){
    case "CONNECT_ERROR":
        header("Location: index.php?errormsg=CouldNotConnect");
        break;
    case "LOGIN_ERROR":
        header("Location: index.php?errormsg=LoginError");
        break;
    case "LOGIN_OKAY":
        //navigate to our start page after sucessful login
        break;


}

?>
