<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PPW2 System</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<style>

*{
    background-color: rgb(93, 120, 138);
    margin: 0;
    padding: 0;
    
}

body{
    display:flex;
    justify-content: center;
    align-items: center;
    font-family: 'PT Sans', sans-serif;
}

div.header{
    max-width:550px;
    margin:0 auto;
    padding-top: 10px;
    color:rgb(229, 226, 226);
    text-align: center;
}

input{
    width: 90%;
    padding: 10px;
    padding-bottom: 15px;
    margin-bottom: 10px;
    background-color: white;
}

button{
    max-width:550px;
    margin:0 auto;
    padding: 10px;
    padding-left: 10px;
    padding-right: 10px;
    text-align: center;
    background: white;
}

form, h2, h3{
    display: block;
    background: rgb(229, 226, 226);
    padding: 10px;
    margin: 3% auto;
    text-align: center;
}
.container{
    max-width: 550px;
    width: 100%;
}

div.login{
    background: rgb(229, 226, 226);
    display: block;
    margin : 0 auto;
}

div.error{
    background: rgb(229, 226, 226);
    display: block;
    margin-bottom: 20px;
    font-size: 20px;
}

input[type=checkbox]{
    font-size: 20px;
    margin-left: 16px;
    padding-left: 20px;
    text-align: center;
}

</style>
<body>
    <div class="container">
        <div class="header"><h1>Login System</h1></div>
        <form action = "NewPassword.php" method="POST">
            <h2>Login Page</h2>
            <h3>It Appears that your Password has Expired. Please Enter a New One.</h3>
            <div class = "login">
            <input type="password" name='NewPass' placeholder = "Password..." id="input">
            <input type="password" name='ReEnter' placeholder = "Verify Password..." id="reenter">
            <input type="checkbox" onclick="ShowPassword()">Show Password
            <br><br>
            <button type="submit" name= "new">Submit New Password</button>
            <button type="submit" name= "check">Check Strength </button>
            </div>
        </form>
    </div>
    
    <script>
        function ShowPassword(){
            var inputtext = document.getElementById("input");
            if (inputtext.type === "password") {
              inputtext.type = "text";
            } else {
              inputtext.type = "password";
            }
            var inputtext = document.getElementById("reenter");
            if (inputtext.type === "password") {
              inputtext.type = "text";
            } else {
              inputtext.type = "password";
            }
        }
    </script>   
</body>
</html>