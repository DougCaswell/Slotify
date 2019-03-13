<?php 
include("includes/includedFiles.php");
?>

<h1 class='pageHeadingBig'>You Might Also Like</h1>

<div class='gridViewContainer'>

    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY rand() LIMIT 10;");

        while($row = mysqli_fetch_array($albumQuery)) {
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onClick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                        <img src='" . $row['artworkPath'] . "' alt='Album Artwork'>
                        <div class='gridViewInfo'>" 
                        . $row['title'] .
                        "</div>
                    </span>
                </div>";
        }
    ?>

</div>