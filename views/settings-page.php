<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo view_path?>/settings-page.css">
    <title>Document</title>
</head>
<nav class="fade" id="nav-bar" class="clear-fix">
        <ul>
            <li><a href="/home">Home</a></li>
            <li id="log-out"> <a href="/logout"> Log Out </a></li>

        </ul>
    </nav>
    <div id="delete-project-container">
        <div id="delete-project-middle">

    <table id="project-table">
        <tr>
            <th>Name</th>
            <th>Phase</th>
            <th>Description</th>
</tr>

</table>
            <div id="question-box">
                        <h2>Are you sure you want to delete all these projects?</h2>
                        <div id="confirm-box">
                        <button id="confirm-button">Yes, I will delete all the projects</button>
                        <button id="reject-button">No, I don't want to delete all the projects</button>
                        </div>
            </div>
        </div>
    </div>
  
</div>
<body>
    <h3>Settings Page</h3>

    <p id="username">Username <?php echo $info["user"]["username"]?></p>
    <p id="password">Password Hash</H3> <?php echo $info["user"]["password"]?></p>
    <br>
    <p>This page will allow you to overview basic information of your profile and to perform some administrative actions on your account.
        also your password will <i>only</i> be in <b>hash</b> due to security assurances</p>
    </p>
    <br>

    <button id="delete-account">Delete account</button>
    <button id="delete-all-projects">Delete all projects</button>
    
    <script src="<?php echo view_path?>/settings-page.js"></script>
</body>
</html>