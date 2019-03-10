<?php 
$songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>
$(document).ready(function() {
    let newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    })

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
    });
    
    $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
            timeFromOffset(e, this);
        }
    });
    
    $(".playbackBar .progressBar").mouseup(function(e) {
         timeFromOffset(e, this);
    });

    $(".volumeBar .progressBar").mousedown(function() {
        mouseDown = true;
    });
    
    $(".volumeBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
            let percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        }
    });
    
    $(".volumeBar .progressBar").mouseup(function(e) {
        let percentage = e.offsetX / $(this).width();
        if(percentage >= 0 && percentage <= 1) {
            audioElement.audio.volume = percentage;
        }
    });

    $(document).mouseup(function() {
        mouseDown = false;
    })


});

function timeFromOffset(mouse, progressBar) {
    let percentage = mouse.offsetX / $(progressBar).width() * 100;
    let seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
}

function prevSong() {
    if(audioElement.audio.currentTime >= 3) {
        audioElement.setTime(0);
    } else if (currentIndex == 0) {
        currentIndex = currentPlaylist.length - 1;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    } else {
        currentIndex --;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
}

function nextSong() {
    if(repeat) {
        audioElement.setTime(0);
        playSong();
        return;
    }
    if(currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }

    let trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true)
}

function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName)
}

function setTrack(trackId, newPlaylist, play) {

    if(newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        shufflePlaylist = shuffleArray([...newPlaylist]);
    }

    if(shuffle) {
        currentIndex = shufflePlaylist.indexOf(trackId);

    } else {
        currentIndex = currentPlaylist.indexOf(trackId);
    }
    pauseSong();

    $.post("includes/handlers/ajax/getSongJSON.php", { songId: trackId }, function(data) {

        let track = JSON.parse(data);

        $(".trackName span").text(track.title);

        $.post("includes/handlers/ajax/getArtistJSON.php", { artistId: track.artist }, function(data) {
            let artist = JSON.parse(data);

            $(".artistName span").text(artist.name);
            
        });

        $.post("includes/handlers/ajax/getAlbumJSON.php", { albumId: track.album }, function(data) {
            let album = JSON.parse(data);

            $(".albumLink img").attr("src", album.artworkPath);

        });

        audioElement.setTrack(track);
        playSong();
    })

    if (play) {
        audioElement.play();
    }
}

function playSong() {

    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong() {
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName)
}

function setShuffle() {
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName)

    if(shuffle) {
        shufflePlaylist = shuffleArray([...shufflePlaylist]);
        currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
        currentIndex = currentlyPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
}

function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        let x = array[i];
        array[i] = array[j];
        array[j] = x;
    }
    return array;
}


</script>


<div id='nowPlayingBarContainer'>
    <div id='nowPlayingBar'>
        <div id='nowPlayingLeft'>
            <div class='content'>
                <span class='albumLink'>
                    <img src="" alt="Album" class='albumArtwork'>
                </span>

                <div class='trackInfo'>

                    <span class='trackName'>
                        <span></span>
                    </span>
                    <span class='artistName'>
                        <span></span>
                    </span>

                </div>

            </div>
        </div>

        <div id='nowPlayingCenter'>

            <div class='content playerControls'>

                <div class='buttons'>
                    <button class='controlButton shuffle' title='Shuffle' onClick="setShuffle()">
                        <img src='assets/images/icons/shuffle.png' alt="Shuffle">
                    </button>
                    <button class='controlButton previous' title='Previous' onClick="prevSong()">
                        <img src='assets/images/icons/previous.png' alt="Previous">
                    </button>
                    <button class='controlButton play' title='Play' onClick="playSong()">
                        <img src='assets/images/icons/play.png' alt="Play">
                    </button>
                    <button class='controlButton pause' title='Pause' style='display: none;' onClick="pauseSong()">
                        <img src='assets/images/icons/pause.png' alt="Pause">
                    </button>
                    <button class='controlButton next' title='Next' onClick="nextSong()">
                        <img src='assets/images/icons/next.png' alt="Next">
                    </button>
                    <button class='controlButton repeat' title='Repeat' onClick="setRepeat()">
                        <img src='assets/images/icons/repeat.png' alt="Repeat">
                    </button>
                </div>

                <div class='playbackBar'>

                    <span class='progressTime current'>0.00</span>
                    
                    <div class='progressBar'>

                        <div class='progressBarBG'>
                            <div class='progress'></div>
                        </div>
                    
                    </div>
                    <span class='progressTime remaining'>0.00</span>

                </div>

            </div>
        </div>

        <div id='nowPlayingRight'>
            <div class='volumeBar'>
                <button class='controlButton volume' title='Volume' onClick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class='progressBar'>

                    <div class='progressBarBG'>
                        <div class='progress'></div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>