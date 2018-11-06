<?php
    include("codebase/Connection.php");
    $users = new Users();
    
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