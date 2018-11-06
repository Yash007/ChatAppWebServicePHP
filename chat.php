<?php
    include("codebase/Connection.php");
    $chat = new Chat();
    
    class Chat {
        var $link;
		var $conObj;
		
		function __construct()	{
			$this -> conObj = new Connection();
            $this -> link = $this -> conObj -> dbConnect();
        }

        function sendChat() {

        }

        function receiveChat()  {

        }

        function findTotalMessage() {

        }

        function encryptMessage()   {

        }

        function decryptMessage()   {

        }

        function loadChat() {

        }
    
    }
?>