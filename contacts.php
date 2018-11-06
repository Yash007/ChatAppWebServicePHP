<?php
    include("codebase/Connection.php");
    $contacts = new Contacts();
    
    if(isset($_GET['addContact']) && $_GET['addContact'] == "true") {
        $contacts -> addContact();
    }

    if(isset($_GET['removeContact']) && $_GET['removeContact'] == "true")   {
        $contacts -> removeContact();
    }

    if(isset($_GET['listContacts']) && $_GET['listContacts'] == "true") {
        $contacts -> listContacts();
    }

    if(isset($_GET['findContact']) && $_GET['findContact'] == "true") {
        $contacts -> findContact();
    } 

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