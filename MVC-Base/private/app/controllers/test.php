<?php


class test extends Controller {

    function __construct() {
        parent::__construct();
    }

    function Index () {
        $this->view("template/header");
        $is_auth = isset($_SESSION["username"]);
        if($is_auth)
        {
            $this->view("test/user");
        }
        else{
            $this->view("test/nouser");
        }
        
        $this->view("template/footer");
    } 

    
    function signin()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $_POST_csrf = htmlentities($_POST["csrf"]);
            $_cook_csrf = htmlentities($_COOKIE["csrf"]);
            $csrf = $_SESSION["csrf"];
            if($csrf == $_POST_csrf && $csrf == $_cook_csrf)
            {
            $this ->model("usermodel");
            $u_name = $_POST["username"];
            $u_pass = $_POST["password"];
        }
        $auth = $this->usermodel->authorised();
        if($auth){
            header("location: /test/");
        }
    else{
             echo("not authentiacted");
         }
        }
    else{
        $csrf = htmlentities(random_int(10000, 10000000));
        //echo($csrf);
        $_SESSION['csrf'] = $csrf;
        setcookie("csrf", $csrf);
        $_COOKIE['csrf'] = $csrf;
        $this-> view("test/signin", array("csrf" =>$csrf));
    }
}

    function signout(){
        session_unset();
        $_SESSION["name"] = "";
         session_destroy();
         $_SESSION= array();
         //header("location: /test/");
    }
}
?>