let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;
// let userLoggedIn; seems to work better commented out
let timer;

$(document).click(function (click) {
    var target = $(click.target);
    if (!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function () {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function () {
    let select = $(this);
    let playlistId = $(select).val();
    let songId = $(select).prev(".songId").val();

    $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
        .done(function (error) {

            if (error != "") {
                alert(error);
                return;
            }

            hideOptionsMenu();
            $(select).val("");
        });

});

function openPage(url) {
    if (timer != null) {
        clearTimeout(timer);
    }
    if (url.indexOf("?") === -1) {
        url = url + "?";
    }
    let encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function formatTime(totalSeconds) {
    let time = Math.round(totalSeconds);
    let minutes = Math.floor(time / 60);
    let seconds = time - minutes * 60;

    let extraZero = (seconds < 10) ? "0" : "";

    return minutes + ':' + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    let progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    let volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function () {
        nextSong();
    });

    this.audio.addEventListener("canplay", function () {
        let duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function () {
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function () {
        updateVolumeProgressBar(this);
    });

    this.play = function () {
        this.audio.play()
    }

    this.setTrack = function (track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.pause = function () {
        this.audio.pause();
    }

    this.setTime = function (seconds) {
        this.audio.currentTime = seconds;
    }
}

function removeFromPlaylist(button, playlistId) {
    let songId = $(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId }).done(function (error) {

        if (error != "") {
            alert(error);
            return;
        }

        openPage("playlist.php?id=" + playlistId);
    });
}

function createPlaylist() {
    let popup = prompt("Please enter the name of your playlist");

    if (popup != null) {

        $.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn }).done(function (error) {

            if (error != "") {
                alert(error);
                return;
            }

            openPage("yourMusic.php");
        })

    }
}

function deletePlaylist(playlistId) {
    let prompt = confirm("Are you sure you want to delete this playlist?");

    if (prompt) {

        $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId }).done(function (error) {

            if (error != "") {
                alert(error);
                return;
            }

            openPage("yourMusic.php");
        })
    }
}

function showOptionsMenu(button) {
    let songId = $(button).prevAll(".songId").val();
    let menu = $(".optionsMenu");
    let menuWidth = menu.width();
    menu.find(".songId").val(songId);

    let scrollTop = $(window).scrollTop();
    let elementOffset = $(button).offset().top;

    let top = elementOffset - scrollTop;
    let left = $(button).position().left;

    menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}

function hideOptionsMenu() {
    let menu = $(".optionsMenu");
    if (menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function logout() {
    $.post("includes/handlers/ajax/logout.php", function () {
        location.reload();
    });
}

function updateEmail(emailClass) {
    let emailValue = $("." + emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
        .done(function (response) {
            $("." + emailClass).nextAll(".message").text(response);
        })
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    let oldPassword = $("." + oldPasswordClass).val();
    let newPassword1 = $("." + newPasswordClass1).val();
    let newPassword2 = $("." + newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php", { oldPassword, newPassword1, newPassword2, username: userLoggedIn })
        .done(function (response) {
            $("." + oldPasswordClass).nextAll(".message").text(response);
        })
}