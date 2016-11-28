<?php
ob_start();
session_start();
//if( !isset($_SESSION['user'])){
    //header("Location: index.php");
//}

define("SERVER", "127.0.0.1");
define("USER", "root");
define("PASS", "");
define("DATABASE", "test");


function updateItems(){
    $db = new mysqli(SERVER, USER, PASS, DATABASE);
    $test = "Hello World";

    echo "\"<div class='card'><p class='card-text'>". $test . " </p> </div>\"";
    
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

                dataDiv = document.getElementById('dataDiv');
				var tempElement = document.createElement('div');
                tempElement.innerHTML =  <?php updateItems();?> ;

                dataDiv.appendChild(tempElement.firstChild);

    }
document.addEventListener("DOMContentLoaded", function()  // This is the function the browser first runs when it's loaded.
{
	refresh() // Then runs the refresh function for the first time.
	//var int=self.setInterval(function(){refresh()},10000); // Set the refresh() function to run every 10 seconds. [1 second would be 1000, and 1/10th of a second would be 100 etc.
});

</script>

<body>

  <script>
  $( function() {
    $( "#dialog" ).dialog({
    autoOpen: false
  });
  } );
  </script>

  <div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
  <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50">
                                </div>
                            </div>
</div>

    <div class="navbar-collapse collapse inverse" id="navbar-header">
        <div class="container-fluid">
            <div class="about">
                <h4>About</h4>
                <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
            </div>
        </div>
    </div>
    <div class="navbar navbar-static-top navbar-dark bg-inverse">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"></button>
            <a href="#" class="navbar-brand">Navigation</a>
        </div>
    </div>

    <section class="jumbotron text-xs-center">
        <div class="container">
            <h1 class="jumbotron-heading">Album example</h1>
            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
            <p>
                <a href="#" class="btn btn-primary">Main call to action</a>
                <a href="#" class="btn btn-secondary">Secondary action</a>
            </p>
        </div>
    </section>

    <div class="album text-muted">
        <div class="container">

            <div class="row" id="dataDiv">

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