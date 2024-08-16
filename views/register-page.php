<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo view_path?>/register-page.css">
    <title>Document</title>
</head>
<body>
    

<div id="register-box">
    <h2>register</h2>

    <form action="/addAccount" method="POST" id="create-user">
        <ul>
            <label for="username">Enter Username</label>
            <li><input type="text" name="username" id="username" required></li>

            <label for="password">Enter Password</label>

            <li><input type="password" name="password" id="password" required></li>


            <label for="email">Enter Email</label>

            <li><input type="email" name="email" id="email" ></li>


            <li><input type="submit" name="SubmitBTN" id="Submit" value="submit"></li>
           

        </ul>
    </form>
    <p><a href="/login">Return to login-page</a></p>

        <div id="error">
            <h3>Error</h3>
            <p> there is an error with your email</p>
        </div>

    
</div>
<?php if (isset($_COOKIE) && count($_COOKIE) > 0)
            {
                if (isset($_COOKIE["incorrectPart"]))
                {
                    $info = json_decode($_COOKIE["incorrectPart"]);
                    if ($info->username && !$info->email)
                    {
                        ?>
                        <div id="server-error">
                        <p> Your username has been taken</p>
                        <p> Please try a different username</p>
                        </div>
                        <?php

                    }
                    elseif (!$info->username && $info->email)
                    {
                        ?>
                        <div id="server-error">
                        <p> Your email has been taken</p>
                        <p> Please try a different email</p>
                        </div>
                        <?php
                    }
                    elseif ($info->username && $info->email)
                    {
                        ?>
                        <div id="server-error">
                        <p> Both your username and email have already been taken</p>
                        <p> Please try a different combination of username and email</p>
                        </div>
                        <?php
                    }
                    unset($_COOKIE["incorrectPart"]);

                }

            }
                ?>
<script src="<?php echo view_path?>/register-page.js"></script>

</body>
</html>