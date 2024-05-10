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
                <h1>Reset Password</h1>
                <div class="resultmessage"></div>
                <?php
                    if(!isset($_GET['user_id']) || !isset($_GET['key'])){
                        echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit;
                    }
                    $user_id = $_GET['user_id'];
                    $key = $_GET['key'];
                    $time = time() - 86400;
                    $user_id = mysqli_real_escape_string($link, $user_id);
                    $key = mysqli_real_escape_string($link, $key);

                    $sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
                    $result = mysqli_query($link, $sql);
                    if(!$result){
                        echo '<div class="alert alert-danger">Error running the query!' . $sql . '</div>'; exit;
                    }
                    $count = mysqli_num_rows($result);
                    if($count !== 1){
                        echo '<div class="alert alert-danger">Please try again.</div>';
                        exit;
                    }
                    echo "
                    <form method=post id='passwordreset'>
                    <input type=hidden name=key value=$key>
                    <input type=hidden name=user_id value=$user_id>
                    <div class='form-group'>
                        <label for='password'>Enter your new Password:</label>
                        <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label for='password2'>Re-enter Password:</label>
                        <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
                    </div>
                    <input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>
                    </form>";
                ?>
            </div>
        </div>
      </div>
      <script>
            $("#passwordreset").submit(function(event){ 
                event.preventDefault();
                var datatopost = $(this).serializeArray();
                $.ajax({
                    url: "storeresetpassword.php",
                    type: "POST",
                    data: datatopost,
                    success: function(data){
                        $('#resultmessage').html(data);
                    },
                    error: function(){
                        $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
                    }
                });
            });
            </script>
      <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>