<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'models/user.php';

$user = unserialize($_SESSION['user']);

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

    <title>Your Notes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <!-- Custom styles for this template -->
    <link href="bootstrap/signin.css" rel="stylesheet">
    <link href="bootstrap/loader.css" rel="stylesheet">
    <script src="bootstrap/autosize.js"></script>
</head>

<body>


<nav class="navbar navbar-default" id="nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
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
                <li class="active"><a href="browse_notes.php">Browse notes</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="">
                        <?php
                            echo $user->mail;
                        ?>
                        <span class="sr-only">(current)</span></a></li>
                <li><a href="">Log out</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>

<h1 style="text-align: center; padding-bottom: 50px;">Your notes</h1>
<div class="container" id="container">

    <?php

    $notes = Database::getUserNotes($user->id);
    $notesCount = count($notes);

    if (isset($_GET["id"]))
        $notes[$_GET["id"]]->saveNote();

    $notesIndex = 0;
    echo '<div class="row">';

    for ($column = 0; $notesIndex < $notesCount; $notesIndex++) {
        echo '<div class="col-sm-4">';
        for ($row = 0; $row * 3 + $column < $notesCount; $notesIndex++) {
            $note = $notes[$row * 3 + $column];

            echo '<form method="get" id="form' . $note->id . '" action="actions/update_note.php">';
            echo '<div class="panel ';

            switch ($note->importance) {
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
            echo '">';
            echo '<input type="hidden" name="noteid" value="' . $note->id . '">';
            echo '<div class="panel-heading"><input autocomplete="off" class="form-control input-lg panel-title title" type="text" name="title" placeholder="Title" value="';
            //Panel title
            echo $note->title;

            echo '"></div> <div class="panel-body"><textarea autocomplete="off" class="form-control input-lg panel-title" name="text"  style="background: none; height: auto;" type="text" placeholder="Your text">';
            //Panel content
            echo $note->text;

            echo '</textarea>';
            echo '<div style="padding-top: 5px;">';
            echo '<button class="btn btn-lg btn-primary" id="submit">Save</button>';
            echo '<label class="text-right datetime" style="width: calc(100% - 85px);text-align: right;">';
            echo $note->datetime;
            echo '</label>';
            echo '</div></div></form></div>';
            $row++;
        }
        $notesIndex--;
        $column++;
        echo '</div>';
    }
    echo '</div>';


    ?>

    <script>

        function SubForm (form){

            $.ajax({
                url:'actions/update_note.php',
                type:'post',
                data:$('#' + form.id).serialize(),
                    success:function(){
                        location.reload();
                }
            });
        }

        $('form').submit(function(e){
            e.preventDefault();
            this['submit'].innerHTML = '<div data-loader="circle"></div>';
            this['submit'].style = 'padding: 1.5px 16px;';
            SubForm(this);
        });

        function h(e) {
            $(e).height(e.scrollHeight - 20);
            //$(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight - 20);
        }
        $('textarea').each(function () {
            autosize(this);
        });
    </script>
</div> <!-- /container -->
</body>
</html>

