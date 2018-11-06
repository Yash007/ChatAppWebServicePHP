<?php
    include("codebase/Connection.php");
    $users = new Users();

    if(isset($_GET['signUp']) && $_GET['signUp'] == "true") {
        $users -> signUpUser();
    }

    if(isset($_GET['login']) && $_GET['login'] == "true")   {
        $users -> loginUser();
    }

    if(isset($_GET['updateUser']) && $_GET['updateUser'] == "true") {
        $users -> updateUser();
    }
    
    class Users {
        var $link;
		var $conObj;
		
		function __construct()	{
			$this -> conObj = new Connection();
            $this -> link = $this -> conObj -> dbConnect();
        }

        function signUpUser()   {
            
        }

        function loginUser()    {

        }

        function updateUser()   {

        }

    }
?>