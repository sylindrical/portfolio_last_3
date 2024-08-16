<?php
namespace Controller;

use Project_Table;
use User_Table;





class ProjController extends \Controller\BaseController
{
    // Dynamic pages



    public static function loginPage()
    {
        self::render("login-page.php");
    }

    public static function registerPage()
    {
        self::render("register-page.php");
    }
    public static function homePage($info)
    {
        if (isset($_COOKIE["INFO"]))
        {
            self::render("home-page.php", $_COOKIE["info"]);

        }
        else
        {
            self::render("home-page.php", $info);

        }
    }
    public static function maintenancePage()
    {
        self::render("maintenance-page.php");
    }
    public static function settingsPage($info = "")
    {
        self::render("settings-page.php", $info);
    }


    // API
    public static function resetSession()
    {
        if (isset($_SESSION))
        {
            session_unset();
            session_destroy();
        }
    }

    // If the user has their credentials, then they will automatically be referred to home-page

    public static function login()
    {
        $acc = self::comp_auth();
        if ($acc != null)
        {
            self::home();
        }
        else
        {
            self::loginPage();
        }
    }
    public static function home()
    {
        global $serve, $user_db;

        session_start();
        if (isset($_COOKIE["logged-in"]) && $_COOKIE["logged-in"] == true)
        {
    
            
                $user = self::comp_auth();
                if ($user != null)
                {
                    $arr = ["user"=>$user];
                    self::homePage($arr);
                    exit();
                }
        }
        self::loginPage();

    }

    public static function connect()
    {
        global $serve, $user_db;
        session_start();
        $username = $_POST["username"];
        $password = $_POST["password"];
        $persist = isset($_POST["persist_login"]) ? true : false;
        $user = self::auth_POST();
        if ($persist == false)
        {
            if ($user != null)
            {
                setcookie("logged-in", true, time()+60*60*24*1000,"/");
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("Location: home");
            }
            else
            {
                header("Location: /login");
            }
        }
        else
        {
            if ($user != null)
            {

                setcookie("logged-in", true, time()+60*60*24*1000,"/");
                setcookie("username", $username, time()+60*60*24*1000, "/");
                setcookie("password", $password, time()+60*60*24*1000, "/");


                header("Location: home");
            }
            else
            {
                header("Location: /login");
            } 
        }

    }

    public static function logOut()
    {
        session_start();
        session_unset();
        setcookie("username", "", 0, "/");
        setcookie("password", "", 0, "/");
        setcookie("logged-in", false,0, "/");

        // destroy the session
        self::loginPage();
    }

    public static function setting()
    {
        $user = self::comp_auth();
        $args = ["user"=>$user];
        if ($user != null)
        {
            self::settingsPage($args);
        }
    }


    // This checks against the user's session variables to see if they are registered and thus return the details

    public static function auth_POST()
    {
        global $user_db;

        $username = $password = "";
        if (isset($_POST["username"]))
        {
            $username = $_POST["username"];

        }
        if (isset($_POST["password"]))
        {
            $password = $_POST["password"];

        }
        $acc = $user_db->S_getAccount($username, $password);

        return $acc;   
    }
    public static function auth()
    {
        global $user_db;

        session_start();
        $username = $password = "";
        if (isset($_SESSION["username"]))
        {
            $username = $_SESSION["username"];

        }
        if (isset($_SESSION["password"]))
        {
            $password = $_SESSION["password"];

        }
        $acc = $user_db->S_getAccount($username, $password);

        return $acc;
    }

    public static function temp_auth()
    {
        global $user_db;


        $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null;
        $password = isset($_COOKIE["password"]) ? $_COOKIE["password"] : null;

        $acc = $user_db->S_getAccount($username, $password);
        return $acc;
        
    }

    public static function comp_auth()
    {
        if (self::auth() == null)
        {
            return self::temp_auth();
        }
        return self::auth();
    }
    public static function sendProjData()
    {
        
    }


    public static function sendData()
    {
        global $serve;


        $acc = self::comp_auth();
        if ($acc != null)
        {

            $data = [
    
            ];
            // $new = new User_Table();
            // $new->initialize($serve, "patients");
            // $info = $new->returnAllInformation();
            $new = new Project_Table;
            $new->initialize($serve, "projects");
            $info = $new->getProject($acc["uid"]);

            echo json_encode($info);

        }
     




    }

    // Adding

    public static function addAccount()
    {
        global $user_db;
        $username = $_POST["username"];
        $password = $_POST["password"];

        $email = $_POST["email"];
        
        $info = "incorrectPart";
        if (isset($username) && isset($password) && isset($email))
        {
            if (self::checkEmail($email) && strlen($username) >=5 && strlen($password) >=5 )
            {
                $result = self::checkIfAccountExists($username, $email);

                if ($result["username"] == false && $result["email"] ==false)
                {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
               
                    if ($user_db->addAccount($username, $passwordHash, $email));
                    {
                        header("Location: /login");
                        exit();
                    }
                }
                else
                {
                    setcookie($info, json_encode($result), time()+60);
                    header("Location: /register");
                    exit();
                }

            }

        }
        header("Location: /register");
        exit();
    }

    public static function p_addAccount()
    {
        global $user_db;
        $username = $_POST["username"];
        $password = $_POST["password"];

        $email = $_POST["email"];
        
        $info = "incorrectPart";
        if (isset($username) && isset($password) && isset($email))
        {
            if (self::checkEmail($email) && strlen($username) >=5 && strlen($password) >=5 )
            {
                $result = self::checkIfAccountExists($username, $email);

                if ($result["username"] == false && $result["email"] ==false)
                {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
               
                    if ($user_db->addAccount($username, $passwordHash, $email));
                    {
                        $msg = ["Status"=>"OK"];

                        echo json_encode($msg);

                        exit();
                    }
                }
                else
                {
                    $msg = ["Status"=>"BAD", "errorMessage"=>"Account could not be made"];

                    echo json_encode($msg);
                }

            }

        }
        header("Location: /register");
    }

    public static function addProject()
    {
        session_start();
        global $user_db, $project_db;
        $acc = self::comp_auth();
        if ($acc)
        {

            // project details
            $user_id = $acc["uid"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $start_time = $_POST["start_time"];
            $end_time = $_POST["end_time"];
            $phase = $_POST["phase"];


            $res = $project_db->addProject($title, $start_time, $end_time, $phase, $description, $user_id);
            $project_db->refresh();
            if ($res != null)
            {
                $arr = ["user"=>$acc];
                self::homePage($arr);
            }
            else
            {
                $errContent = ["errorMessage"=>"Could not be entered into database; Check values"];
                $arr = ["user"=>$acc, "error"=>json_encode($errContent)];
                setcookie("INFO", json_encode($arr));
                self::homePage($arr);
            }
        }
    }
    public static function p_addProject()
    {
        session_start();
        global $user_db, $project_db;
        $acc = self::comp_auth();
        if ($acc)
        {

            // project details
            $user_id = $acc["uid"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $start_time = $_POST["start_date"];
            $end_time = $_POST["end_date"];
            $phase = $_POST["phase"];


            $res = $project_db->addProject($title, $start_time, $end_time, $phase, $description, $user_id);
            $project_db->refresh();
            if ($res != null)
            {
                $msg = ["Status"=>"OK"];

                echo json_encode($msg);
            }
            else
            {
                $errContent = ["errorMessage"=>"Project details does not pass integrity check; Please revise your values"];
                $msg = ["Status"=>"BAD", "user"=>$acc, "error"=>$errContent];


                echo json_encode($msg);
            }
        }
    }



    static function deleteProject()
    {
        global $project_db;
        $acc = self::comp_auth();
        if ($acc)
        {
            $id = $_POST["id"];

            $project_db->removeProject($id);
        }

    }

    static function deleteAccount()
    {
        global $user_db;
        $user = self::comp_auth();
        if ($user != null)
        {

            $user_db->directDelete($user["uid"]);
        }
        else
        {
            self::maintenancePage();
        }
    }
    
    static function checkEmail($em)
    {
        $regex = "/\w+@\w+/";
        if (preg_match($regex, $em))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // given params; it will try to check against the db and see
    // if there any conflicting accounts with any of the params

    static function checkIfAccountExists($username, $email)
    {
        global $user_db;

        $obj = $user_db->p_returnUserObjects();

        $retList = ["username" => false, "email" => false];

        foreach($obj as $key => $value)
        {
            if ($value["username"] == $username)
            {
                $retList["username"] = true;
            }

            if ($value["email"] == $email)
            {
                $retList["email"] = true;
            }
        }

        return $retList;

    }

    public static function modifyAccount()
    {
        global $user_db;
        $acc = self::comp_auth();
        if ($acc != null)
        {
            $username = isset($_POST["mod_username"]) ? $_POST["mod_username"] : "";
            $password = isset($_POST["mod_password"]) ? $_POST["mod_password"] : "";

            $user_db->modifyAccount($acc["uid"], $username, $password); 
        }
    }
}


?>