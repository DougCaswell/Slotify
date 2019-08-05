<div id='navBarContainer'>
    <nav class='navBar'>
        <span role="link" tabindex="0" onClick="openPage('index.php')" class='logo'>
            <img src="https://img.icons8.com/material/32/07d159/paper-windmill.png" alt="Logo"> <p>Slotify</p>
        </span>
        <div class="group">
            <div class='navItem'>
            <span role='link' tabindex='0' onClick="openPage('search.php')" class='navItemLink'>Search 
                <img src="assets/images/icons/search.png" alt="Search" class='icon'>
            </span>
            </div>
        </div>
        <div class="group">
        <div class='navItem'>
            <span role="link" tabindex="0" onClick="openPage('browse.php')"  class='navItemLink'>Browse</span>
        </div>
        <div class='navItem'>
            <span role="link" tabindex="0" onClick="openPage('yourMusic.php')"  class='navItemLink'>Your Music</span>
        </div>
        <div class='navItem'>
            <span role="link" tabindex="0" onClick="openPage('settings.php')"  class='navItemLink'><?php echo $userLoggedIn->getUsername(); ?></span>
        </div>
        </div>
    </nav>
</div>