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
</head>
<body>
    <div id='inputContainer'>
        <form id='loginForm' action="register.php" method='POST'>
            <h2>Login to your account</h2>
            <p>
                <label for="loginUsername">Username</label>
                <input id='loginUsername' name='loginUsername' type="text" placeholder='e.g. bartSimpson' required>
            </p>
            <p>
                <label for="loginPassword">Password</label>
                <input id='loginPassword' name='loginPassword' type="password" placeholder='Your Password' required>
            </p>

            <button type='submit' name='loginButton'>LOG IN</button>
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
        </form>
    </div>
</body>
</html>