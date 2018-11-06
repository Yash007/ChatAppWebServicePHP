<?php
    include("codebase/Connection.php");
    $contacts = new Contacts();
    
    class Contacts {
        var $link;
		var $conObj;
		
		function __construct()	{
			$this -> conObj = new Connection();
            $this -> link = $this -> conObj -> dbConnect();
        }

        function addContact()  {

        }

        function removeContact()    {

        }

        function listContacts() {

        }

        function findContact()  {

        }
        

    }
?>