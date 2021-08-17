<!DOCTYPE html>
<html lang="en">

<head>
    <title>User registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>form.css">
</head>

<body>
    <div class="wrapper">
        <div class="login-card">
            <?php include('debug.php'); ?>
            <header class="header">
                <h1>Forgot</h1>
            </header>
            <main>
                <form class="form" method="post" action="<?php echo URI_PUBLIC; ?>login">
                    <?php echo $csrf->generateToken(); ?>
                    <fieldset>
                        <legend>Enter your login credentials</legend>
                        <?php include('required_icon.svg'); ?>
                        <?php include('error.php'); ?>
                        <div class="input-group">
                            <label for="email">Email <span class="sr-only">(required)</span><svg class="icon" focusable="false">
                                    <use xlink:href="#required"></use>
                                </svg></label>
                            <input id="email" type="text" name="email" value="<?php echo $email; ?>">
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn">Login</button>
                        <p>Remember your password? <a href="login">Sign in</a></p>
                    </fieldset>
                </form>
            </main>
        </div>
    </div>
</body>

</html>