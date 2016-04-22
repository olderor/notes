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

$noteCollection = new NoteCollection();
$noteCollection->userid = $user->id;
$noteCollection->getUserNotes();
$notes = $noteCollection->notes;
$notesCount = count($notes);

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
    <script src="browse_notes.js"></script>
    <script>function showNote(id, importance, title, text, datetime) {
            var col = getColumnWithMinHeight();

            var newNote = '<form onsubmit="onSubmitForm(this);" method="post" id="form' + id + '" action="actions/update_note.php">';
            newNote += '<div class="panel ';
            switch (importance) {
                case '5':
                    newNote += 'panel-primary';
                    break;
                case '4':
                    newNote += 'panel-danger';
                    break;
                case '3':
                    newNote += 'panel-info';
                    break;
                case '2':
                    newNote += 'panel-success';
                    break;
                case '1':
                    newNote += 'panel-warning';
                    break;
                default:
                    newNote += 'panel-default';
                    break;
            }
            newNote += '">';
            newNote += '<input type="hidden" name="noteid" value="' + id + '">';
            newNote += '<div class="panel-heading"><input onKeyUp="checkLengthTitle(this);" autocomplete="off" class="form-control input-lg panel-title title" type="text" name="title" placeholder="Title" value="';
            newNote += title + '">';
            newNote += '<button type="button" class="close" aria-label="Close" id="delete" onclick="deleteNote(this);"><span aria-hidden="true">&times;</span></button>';
            newNote += '<select class="form-control" name="importance" onchange="changeImportance(this);">'
            newNote += '<option value="5"' + (importance == '5' ? " selected" : "") + '>Emergency</option>'
            newNote += '<option value="4"' + (importance == '4' ? " selected" : "") + '>Highly important</option>'
            newNote += '<option value="3"' + (importance == '3' ? " selected" : "") + '>Important</option>'
            newNote += '<option value="2"' + (importance == '2' ? " selected" : "") + '>Regular</option>'
            newNote += '<option value="1"' + (importance == '1' ? " selected" : "") + '>Non-important</option>'
            newNote += '<option value="0"' + (importance == '0' ? " selected" : "") + '>Irrelevant</option>'
            newNote += '</select>';
            newNote += '</div> <div class="panel-body"><textarea onKeyUp="checkLengthTextarea(this);" autocomplete="off" class="form-control input-lg panel-title" name="text"  style="background: none; height: auto;" type="text" placeholder="Your text">';
            newNote += text + '</textarea>';
            newNote += '<div style="padding-top: 5px;">';
            newNote += '<button class="btn btn-lg btn-primary" id="submit">Save</button>';
            newNote += '<label class="text-right datetime" id="date" style="width: calc(100% - 85px);text-align: right;">';
            newNote += datetime;
            newNote += '</label>';
            newNote += '</div></div></form></div>';

            if (id < 0)
                col.innerHTML = newNote + col.innerHTML;
            else
                col.innerHTML = col.innerHTML + newNote;
            var length = text.length;
            if (length < 65)
                length = 65;

            for (var i = 0; i < col.childNodes.length; i++)
                if (col.childNodes[i].name == 'height') {
                    col.childNodes[i].value = +col.childNodes[i].value + length;
                    break;
                }

            $('textarea').each(function () {
                autosize(this);
            });

        }</script>
</head>

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
                <li class="active"><a href="browse_notes.php">Browse notes</a></li>
                <li><a href="#">Contact</a></li>
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

<h1 style="text-align: center; padding-bottom: 50px;">Your notes
    <button class="btn btn-lg btn-primary" id="submit" onclick="newNote();">+</button>
</h1>
<div class="container" id="container">


    <?php

    $noteCollection = new NoteCollection();
    $noteCollection->userid = $user->id;
    $noteCollection->getUserNotes();
    $notes = $noteCollection->notes;
    $notesCount = count($notes);

    if (isset($_GET["id"]))
        $noteCollection->notes[$_GET["id"]]->saveNote();

    $notesIndex = 0;
    echo '<input type="hidden" id="count" value="' . $notesCount . '">';
    echo '<div class="row">';

    for ($column = 0; $column < 3; $column++) {
        echo '<div class="col-sm-4" id="col-sm-4-' . ($column + 1) . '">';
        echo '<input type="hidden" name="height" value="0">';
        echo '</div>';
    }

    for ($notesIndex = 0; $notesIndex < $notesCount; $notesIndex++) {
        $note = $notes[$notesIndex];
        echo '<script>showNote("' . $note->id . '", "' . $note->importance . '", "' . $note->title . '", ' . json_encode($note->text) . ', "' . $note->datetime . '");</script>';
    }
    echo '</div>';


    ?>


    <script>

        function SubForm(form) {
            $.ajax({
                url: 'actions/update_note.php',
                type: 'post',
                data: $('#' + form.id).serialize(),
                success: function () {
                    form['submit'].innerHTML = "Save";
                    form['submit'].style = "";
                    var time = getCookie('time');
                    //console.log(time);
                    if (time != null && time != undefined)
                        form.childNodes[0].childNodes[3].childNodes[1].childNodes[1].innerHTML = time.replace('+', ' ');
                    if (form['noteid'].value < 0) {
                        var lastId = getCookie('lastId');
                        form['noteid'].value = lastId;
                        form.id = "form" + lastId;
                    }
                }
            });
        }

        function deleteNote(button) {
            button.form.style = "display: none;";
            $.ajax({
                url: 'actions/delete_note.php',
                type: 'post',
                data: $('#' + button.form.id).serialize(),
                success: function () {
                }
            });
        }

        function h(e) {
            $(e).height(e.scrollHeight - 20);
            //$(e).css({'height':'auto','overflow-y':'hidden'}).height(e.scrollHeight - 20);
        }

        function onSubmitForm(form) {
            event.preventDefault();
            form['submit'].innerHTML = '<div data-loader="circle"></div>';
            form['submit'].style = 'padding: 1.5px 16px;';
            SubForm(form);
        }

        $('textarea').each(function () {
            autosize(this);
        });

        function newNote() {
            //var col = getColumnWithMinHeight();
            var count = +document.getElementById('count').value + 1;
            document.getElementById('count').value = count;

            showNote(-count, 0, "", "", formatDate(new Date()));
        }
    </script>
</div> <!-- /container -->
</body>
</html>

