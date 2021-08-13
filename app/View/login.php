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
                <h1>Login</h1>
            </header>
            <main>
                <form method="post" action="<?php echo URI_PUBLIC; ?>login">
                    <?php echo $csrf->generateToken(); ?>
                    <fieldset>
                        <legend>Enter your login credentials</legend>
                        <?php include('required_icon.svg'); ?>
                        <?php include('error.php'); ?>
                        <div class="input-group">
                            <label for="username">Username <span class="sr-only">(required)</span><svg class="icon" focusable="false">
                                    <use xlink:href="#required"></use>
                                </svg></label>
                            <input id="username" type="text" name="username" value="<?php echo $username; ?>">
                        </div>
                        <div class="input-group">
                            <label for="password">Password <span class="sr-only">(required)</span><svg class="icon" focusable="false">
                                    <use xlink:href="#required"></use>
                                </svg></label>
                            <input id="password" type="password" name="password" value="<?php echo $password; ?>">
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn">Login</button>
                        <p>Not a member? <a href="register">Sign up</a></p>
                    </fieldset>
                </form>
            </main>
        </div>
    </div>
</body>

</html>