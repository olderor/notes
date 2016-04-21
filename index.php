<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <!-- Custom styles for this template -->
    <link href="bootstrap/index.css" rel="stylesheet">

    <script>
        if (document.addEventListener) {
            if ('onwheel' in document) {
                // IE9+, FF17+, Ch31+
                document.addEventListener("wheel", onWheel);
            } else if ('onmousewheel' in document) {
                // устаревший вариант события
                document.addEventListener("mousewheel", onWheel);
            } else {
                // Firefox < 17
                document.addEventListener("MozMousePixelScroll", onWheel);
            }
        } else { // IE8-
            document.attachEvent("onmousewheel", onWheel);
        }

        function onWheel(e) {
            e = e || window.event;
            $('html, body').animate({scrollTop:$('#title').position().top}, 2000);
            e.preventDefault ? e.preventDefault() : (e.returnValue = false);
        }

    </script>
</head>

<body>

<div class="container">

    <h1 id="title">Notes</h1>
    <h2 id="description">The best way to store your notes</h2>
    
    <div id="login">
        <?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            echo '<div class="btn btn-lg btn-primary" style="width: calc(50% - 5px);" onclick="location.href = \'signin.php\';">Sign in</div>';
            echo '<div class="btn btn-lg btn-default" style="margin-left: 5px; width: calc(50% - 5px);" onclick="location.href = \'register.php\';">Register</div>';
        }
        else {
            echo '<div class="btn btn-lg btn-primary" onclick="location.href = \'browse_notes.php\';">Browse notes</div>';
        }
        ?>
    </div>
</div>


</body>
</html>
