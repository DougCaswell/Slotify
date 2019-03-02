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

<?php include('includes/footer.php'); ?>