<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'models/user.php';
require 'models/NoteCollection.php';

$user = unserialize($_SESSION['user']);
$offset = 0;

if (!isset($user, $user->id))
    ErrorHandler::newError(0, "Please, sign in before browsing notes.", "signin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Restoring</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>


    <!-- Custom styles for this template -->
    <link href="bootstrap/signin.css" rel="stylesheet">
    <link href="bootstrap/loader.css" rel="stylesheet">
    <script src="bootstrap/autosize.js"></script>
</head>
<body>
<input type="hidden" id="offset" value="0">
<input type="hidden" id="count" value="9">
<nav class="navbar navbar-default" id="nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" style="font-size: 30px;">Notes</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse_notes.php">Browse notes</a></li>
                <li><a href="contacts.php">Contacts</a></li>
                <li class="active"><a href="restore_browse_notes.php">Restore</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="">
                        <?php
                        echo $user->mail;
                        ?>
                        <span class="sr-only">(current)</span></a></li>
                <li><a href="signin.php" onclick="
                $.ajax({
                    url: 'actions/logout.php',
                    cache: false,
                    success: function(html){
                    }
                    });
                    ">Log out</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
<a id="scrollup" href="#top">&uarr;</a>
<h1 style="text-align: center; padding-bottom: 50px; line-height: 1.5;">Your deleted notes
    <br><a href="restore_calendar.php">Search in calendar</a>
</h1>
<div class="container" id="container">

    <div class="row">
        <div class="col-sm-4" id="col-sm-4-1">
            <input type="hidden" name="height" value="0">
        </div>
        <div class="col-sm-4" id="col-sm-4-2">
            <input type="hidden" name="height" value="0">
        </div>
        <div class="col-sm-4" id="col-sm-4-3">
            <input type="hidden" name="height" value="0">
        </div>
    </div>


    <script>var deleted = true;</script>
    <script src="showing_notes.js"></script>
    <script src="browse_notes.js"></script>

</div> <!-- /container -->
</body>
</html>

