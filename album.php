<?php 
include('includes/header.php'); 

if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();
?>

<div class='entityInfo'>
    <div class="leftSection">
        <img src="<?php echo $album->getAlbumArtwork(); ?>" alt="Album Artwork">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p>By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>

    </div>
</div>
{console.log('inside html')}
<div class='trackListContainer'>
    <ul class='trackList'>

    <?php

    $songIdArray = $album->getSongIds();

    $i = 1;

    foreach($songIdArray as $songId) {

        $albumSong = new Song($con, $songId);
        $albumArtist = $albumSong->getArtist();

        echo "<li class='trackListRow'>
                <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png' alt='play' onClick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                    <span class='trackNumber'>$i</span>
                </div>

                <div class='trackInfo'>
                    <span class='trackName'>" . $albumSong->getTitle() . "</span>
                    <span class='artistName'>" . $albumArtist->getName() . "</span>
                </div>

                <div class='trackOptions'>
                    <img class='optionsButton' src='assets/images/icons/more.png' alt='More'>
                </div>

                <div class='trackDuration'>
                    <span class='duration'>" . $albumSong->getDuration() . "</span>
                </div>

            </li>";

        $i++;

    }
    
    ?>

    <script>
        let tempSongIds = '<?php echo json_encode($songIdArray); ?>';
        tempPlaylist = JSON.parse(tempSongIds);
    </script>

    </ul>
</div>

<?php include('includes/footer.php'); ?>