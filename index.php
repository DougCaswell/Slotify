<?php 
include('includes/config.php');

//session_destroy();

if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
} else {
    header('Location: register.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slotify</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <div id='nowPlayingBarContainer'>
        <div id='nowPlayingBar'>
            <div id='nowPlayingLeft'>

            </div>

            <div id='nowPlayingCenter'>

                <div class='content playerControls'>

                    <div class='buttons'>
                        <button class='controlButton shuffle' title='Shuffle'>
                            <img src='assets/images/icons/shuffle.png' alt="Shuffle">
                        </button>
                        <button class='controlButton previous' title='Previous'>
                            <img src='assets/images/icons/previous.png' alt="Previous">
                        </button>
                        <button class='controlButton play' title='Play'>
                            <img src='assets/images/icons/play.png' alt="Play">
                        </button>
                        <button class='controlButton pause' title='Pause' style='display: none;'>
                            <img src='assets/images/icons/pause.png' alt="Pause">
                        </button>
                        <button class='controlButton next' title='Next'>
                            <img src='assets/images/icons/next.png' alt="Next">
                        </button>
                        <button class='controlButton repeat' title='Repeat'>
                            <img src='assets/images/icons/repeat.png' alt="Repeat">
                        </button>
                    </div>
                </div>
            </div>

            <div id='nowPlayingRight'>

            </div>
        </div>
    </div>

</body>

</html>