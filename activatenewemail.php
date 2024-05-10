<?php
    session_start();
    include("connection.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Handy Notes</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="styling.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Original+Surfer&display=swap" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm">
                <h1>Activation Page</h1>
                <?php
                    if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){
                        echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit;
                    }
                    $email = $_GET['email'];
                    $newemail = $_GET['newemail'];
                    $key = $_GET['key'];
                    $email = mysqli_real_escape_string($link, $email);
                    $newemail = mysqli_real_escape_string($link, $newemail);
                    $key = mysqli_real_escape_string($link, $key);
                    $sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
                    $result = mysqli_query($link, $sql);
                    if(mysqli_affected_rows($link) == 1){
                        session_destroy();
                        setcookie("rememeberme", "", time()-3600);
                        echo '<div class="alert alert-success">Your email has been updated.</div>';
                        echo '<a href="index.php" type="button" class="btn-lg btn-success">Log in<a/>';
                    }else{
                        echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
                        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
                    }
                ?>
            </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>