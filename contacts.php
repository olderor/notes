<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Contacts</title>
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
                <li class="active"><a href="contacts.php">Contacts</a></li>
                <li><a href="restore_browse_notes.php">Restore</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
<a id="scrollup" href="#top">&uarr;</a>
<div class="container">

    <h1 style="text-align: center; font-size: 1700%;">Notes</h1>
    <h1 style="text-align: center; padding-top: 100px; padding-bottom: 50px; line-height: 2;">
        Made by olderor (Yevchenko Bohdan)
        <br>
        <a href="http://vk.com/olderor" target="_blank">
            <img class="logo" id="vk_logo" src="img/vk_logo.png" alt="logo vk">
        </a>
        <a href="http://facebook.com/olderor" target="_blank">
            <img class="logo" id="fb_logo" src="img/fb_logo.png" alt="logo fb">
        </a>
        <a href="http://ua.linkedin.com/in/olderor" target="_blank">
            <img class="logo" id="linkedin_logo" src="img/linkedin_logo.png" alt="logo LinkedIn">
        </a>
        <a href="https://github.com/olderor" target="_blank">
            <img class="logo" id="github_logo" src="img/github_logo.png" alt="logo GitHub">
        </a>
        <br>
        <a href="mailto:yevchenko.bohdan@gmail.com">yevchenko.bohdan@gmail.com</a>
        <br>
    </h1>
</div>


</body>
</html>
