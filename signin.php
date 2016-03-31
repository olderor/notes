<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sign in</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <!-- Custom styles for this template -->
    <link href="bootstrap/signin.css" rel="stylesheet">


</head>

<body>

<div class="container">

    <?php
        $request = null;
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
            $request = $_GET;
        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
            $request = $_POST;
        if ($request != null && $request['message'] != null)
            echo "<h2 class='error'>" . $request['message'] . "</h2>";
    ?>

    <form class="form-signin" method="get" action="actions/signin_user.php">
        <h2 class="form-signin-heading" style="text-align: center;">Sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="mail" class="form-control" placeholder="Email address"
            <?php
            if (isset($request, $request['mail']))
                echo "value='" . $request['mail'] . "' required>";
            else
                echo "autofocus required>";
            ?>


        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary" style="width: calc(50% - 5px);" type="submit">Sign in</button>
        <button class="btn btn-lg btn-default" type="button" style="margin-left: 5px; width: calc(50% - 5px);" onclick="location.href = 'register.php';";>Register</button>
    </form>

</div> <!-- /container -->
</body>
</html>
