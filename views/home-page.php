<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo view_path; ?>/home-page.css">
    <title>Home Page <?php echo $info["user"]["username"]?>></title>
</head>
<body>
    <template id="article-template">
    <style>
       @keyframes fade {
    from {
        transform: translate(0,-100%);

    }
    to {
        transform: translate(0, 0%);

    }
}

    #info-box
    {
        background-color: rgba(0,0,0,1);
        color:white;
        position:absolute;
        display:flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        height:100%;
        width:100%;
        transform: translate(0, -100%);

    }

    #article-content

    {
        display:block;
        position:relative;
        height:100%;
        overflow: hidden;
    }
      .fade
      {
        position:relative;

        overflow:hidden;

        animation: fade 0.5s;
        animation-fill-mode: forwards;
      }
    </style>
    <script>
    
    
    </script>
    <div id="article-content" class="article-content-area" style="overflow:hidden;">
        <div id="info-box">
            <span id="info-more">
                Need more info?
            </span>
    </div>
            <h2 id="title"><slot class="fade" name="title" id="title">Titles</slot> 
            </h2>
            <p ><slot name="description" > Description</slot></p>
            <p hidden id="pid">hello</p>
    </div>
   
    </template>
    <div>
        <template id="info-template">
            <style>
                .info-container
{
    display:flex;
    justify-content: center;
    align-items: center;
    position:fixed;
    width:100%;
    height:100vh;
    top:0;

}
#info
{
    background-color: wheat;
    border: 1px solid black;
    padding: 20px;
    border-radius:  5px;
}

                </style>
        <div class="info-container">
            <div id="info">

            <h3>Project Details</h3>
                    
                    <label>Title</label> <slot name="title">[Title]</slot>
                    <br>
                    <label>Description</label> <slot name="description">[Title]</slot>
                    <br>

                    <label>Start Date</label> <slot name="start_date">[Title]</slot>
                    <br>

                    <label>End Date</label> <slot name="end_date">[Title]</slot>
                    <br>

                    <label>Phase</label> <slot name="phase">[Title]</slot>
                </div>
    </div>
    </div>
    </template>

    <nav class="fade" id="nav-bar" class="clear-fix">
        <ul>
        <li><a href="/setting">Settings</a></li>

        <li id="log-out"> <a href="#"> Log Out </a></li>
        </ul>
    </nav>

    <h3>Logged In</h3>

    <p> Name : <?php  echo $info["user"]["username"]?></p>
    <p>Welcome user</p>
    <br>
    <br>
    <h2>Projects</h2>
    <input type="text" id="filter_text" placeholder="filter by description and title">

    <div id="projects-container">
        <div id="projects">

        </div>
    </div>
        <div id="command-bar">
            <div class="command-button" id="create-project">
                <h3>Create new project</h3>
            </div>
            <div class="command-button" id="delete-project">
                <h3>Delete project</h3>
            </div>
    </div>
    <?php
//   $err = json_decode($info["error"]);
//   $msg = $err->errorMessage;
//   if (isset($msg) && $msg != null)
//   {
//     echo "<script>var name = '$msg';</script>";
//     echo "<script>alert('$msg')</script>";
//   }

//   if (isset($_COOKIE["INFO"]))
//   {
//     unset($_COOKIE["INFO"]);
//     setcookie("INFO", "", time()-3600);

//   }
?>
<script src="<?php echo view_path?>/home-page.js"></script>
</body>
</html>
