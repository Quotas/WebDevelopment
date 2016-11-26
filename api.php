<?php

$server = 'lochnagar.abertay.ac.uk';
$uid = 'sql1602312';
$password = 'ymC78stBq2m3';
$database = 'sql1602312';







function getCustomerDetails($cid) 
{

    $db = @new mysqli($server, $uid, $password, $database);
    if ($db->connect_errno) 
    {
        echo 'Error: Could not connect to database.  Please try again later.';
        echo $db->connect_errno;
        exit;
    }
    
	$searchquery = "SELECT * FROM customers WHERE customerID=".$cid;
	$searchresult = mysqli_query($db, $searchquery);
	
    if (!$searchresult){
		echo 'Something went wrong';


        
	}
    else{

        echo '%" . $searchresult . "% ';
    }
  


}
function createCustomer($cid, $data)
{

    $db = @new mysqli($server, $uid, $password, $database);
    if ($db->connect_errno) 
    {
        echo 'Error: Could not connect to database.  Please try again later.';
        echo $db->connect_errno;
    }

	$searchquery = "SELECT * FROM customers WHERE cusomterid LIKE '%" . $cid .  "%'";
	$searchresult = $db->query($searchquery);
	
    if (!$searchresult){
		echo 'Something went wrong';

        
	}

	$numresults = $searchresult->num_rows;

	if ($numresults > 0){
		echo 'This customer has already been registered.';
        
	}
    else
    {
        $query = "insert into customers (firstname, lastname, email) values ('" . $data ."')";

	    $result = $db->query($query);
        if ($result){
            echo  $db->affected_rows.' customer inserted into database.'; 
        } 
        else 
        {
	        echo "Something went wrong";
        }
        $db->close();
	}
	$db->close();


}
function updateCustomer($cid, $data)
{

    $db = @new mysqli($server, $uid, $password, $database);
    if ($db->connect_errno) 
    {
        echo 'Error: Could not connect to database.  Please try again later.';
        echo $db->connect_errno;
    }


}

function deleteCustomer($cid)
{
    $db = @new mysqli($server, $uid, $password, $database);
    
    if ($db->connect_errno) 
    {
        echo 'Error: Could not connect to database.  Please try again later.';
        echo $db->connect_errno;
        exit;
    }

    $searchquery = "SELECT * FROM customers WHERE cusomterid LIKE '%" . $cid .  "%'";
	$searchresult = $db->query($searchquery);
	
    if (!$searchresult){

		echo 'Something went wrong';

        echo ''.$searchresult;

        
	}

	$numresults = $searchresult->num_rows;

	if ($numresults <= 0){

		echo 'This customer does not exist';
        
	}
    else if($numresults > 0){

            $updatequery = "UPDATE customers SET (firstname, lastname, email) values ('" . $data ."') WHERE cusomterid LIKE '%" . $cid .  "%'";
	        $result = $db->query($updatequery);

            if (!$result){

                echo 'Something went wrong';

            }
            else{

                echo 'Cusomter updated successfully';

            }            

    }


}








getCustomerDetails(1001);









?>