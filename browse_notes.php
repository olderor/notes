<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registration</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <!-- Custom styles for this template -->
    <link href="bootstrap/signin.css" rel="stylesheet">


    <h1 style="text-align: center; padding-bottom: 50px;">Your notes</h1>
</head>

<body>

<div class="container">

    <?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require 'models/user.php';

    $user = unserialize($_SESSION['user']);

    if (!isset($user, $user->id))
        ErrorHandler::newError(0, "Please, sign in before browsing notes.", "signin.php");

    $notes = Database::getUserNotes($user->id);
    $notesCount = count($notes);

    $notesIndex = 0;
    echo '<div class="row">';

    for ($column = 0; $notesIndex < $notesCount; $notesIndex++) {
        echo '<div class="col-sm-4">';

        for ($row = 0; $row * 3 + $column < $notesCount; $notesIndex++) {
            echo '<div class="panel ';

            switch ($notes[$row * 3 + $column]->importance) {
                case 5:
                    echo 'panel-primary';
                    break;
                case 4:
                    echo 'panel-danger';
                    break;
                case 3:
                    echo 'panel-info';
                    break;
                case 2:
                    echo 'panel-success';
                    break;
                case 1:
                    echo 'panel-warning';
                    break;
                default:
                    echo 'panel-default';
                    break;
            }

            echo '"><div class="panel-heading"><h3 class="panel-title">';
            //Panel title
            echo $notes[$row * 3 + $column]->title;

            echo '</h3></div> <div class="panel-body">';
            //Panel content
            echo $notes[$row * 3 + $column]->text;

            echo '</div></div>';
            $row++;
        }
        $notesIndex--;
        $column++;
        echo '</div>';
    }
    echo '</div>';


    ?>



</div> <!-- /container -->
</body>
</html>

