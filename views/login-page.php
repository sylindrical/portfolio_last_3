<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href= "<?php echo view_path ;?>/login-page.css">
    <title>Document</title>
</head>

<body>
    <div id="login-box">
    <h2>Login</h2>

    <form action="./submit" method="POST">
        <ul>
            <li><input type="text" name="username" placeholder="username"/></li>
            <li><input type="password" name="password" placeholder="password"/></li>
            <input type="checkbox" name="persist_login" id="persist_login" value="persist_login">
            <label for="persist_login">Persist login after close</label>
            <li><input type="submit" name="Submit" value="login"/></li>

        </ul>

        
        
    </form>
    <a href="/register">register page</a>
    </div>
</body>
</html>