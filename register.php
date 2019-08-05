<!DOCTYPE html>

<?php
    include('includes/config.php');
    include('includes/classes/Account.php');
    include('includes/classes/Constants.php');

    $account = new Account($con);

    include('includes/handlers/register-handler.php');
    include('includes/handlers/login-handler.php');

    function getInputValue($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Slotify</title>
    <link rel="stylesheet" href="assets/css/register.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <?php 
    
    if(isset($_POST['registerButton'])) {
        echo '<script>
            $(document).ready(function() {
                $("#loginForm").hide();
                $("#registerForm").show();
            });
            </script>';
    } else {
        echo '<script>
            $(document).ready(function() {
                $("#loginForm").show();
                $("#registerForm").hide();
            });
            </script>';
    }

    ?>

    <div id='background'>
        <div id=loginContainer>
            <div id='inputContainer'>
                <form id='loginForm' action="register.php" method='POST'>
                    <h2>Login to your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername">Username</label>
                        <input id='loginUsername' name='loginUsername' type="text" value="<?php getInputValue('loginUsername') ?>" placeholder='e.g. bartSimpson' required>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id='loginPassword' name='loginPassword' type="password" placeholder='Your Password' required>
                    </p>
        
                    <button type='submit' name='loginButton'>LOG IN</button>

                    <div class='hasAccountText'>
                        <span id='hideLogin'>Don't have an account yet?  Sign up here.</span>
                    </div>

                </form>
                <form id='registerForm' action="register.php" method='POST'>
                    <h2>Create your free account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="registerUsername">Username</label>
                        <input id='registerUsername' name='registerUsername' type="text" value="<?php getInputValue('registerUsername'); ?>" placeholder='e.g. bartSimpson' required>
                    </p>
        
                    <p>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <label for="firstName">First Name</label>
                        <input id='firstName' name='firstName' type="text" value="<?php getInputValue('firstName'); ?>" placeholder='e.g. Bart' required>
                    </p>
        
                    <p>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <label for="lastName">Last Name</label>
                        <input id='lastName' name='lastName' type="text" value="<?php getInputValue('lastName'); ?>" placeholder='e.g. Simpson' required>
                    </p>
        
                    <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for="email">Email</label>
                        <input id='email' name='email' type="email" value="<?php getInputValue('email'); ?>" placeholder='e.g. bart@gmail.com' required>
                    </p>
        
                    <p>
                        <label for="email2">Confirm Email</label>
                        <input id='email2' name='email2' type="text" value="<?php getInputValue('email2'); ?>" placeholder='e.g. bart@gmail.com' required>
                    </p>
        
                    <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                        <label for="registerPassword">Password</label>
                        <input id='registerPassword' name='registerPassword' type="password" placeholder='Your Password' required>
                    </p>
                    
                    <p>
                        <label for="registerPassword2">Confirm Password</label>
                        <input id='registerPassword2' name='registerPassword2' type="password" placeholder='Your Password' required>
                    </p>
        
                    <button type='submit' name='registerButton'>SIGN UP</button>

                    <div class='hasAccountText'>
                        <span id='hideRegister'>Already have an account?  Login here.</span>
                    </div>

                </form>
            </div>

            <div id='loginText'>
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you'll fall in love with</li>
                    <li>Create your own playlists</li>
                    <li>Follow artists to keep up to date</li>
                    <li>Icons used are from Icons8</li>
                    <li>Music is from BenSound </li>
                </ul>
            </div>

        </div>
    </div>
</body>
</html>