<?php
    include("codebase/Connection.php");
    $chat = new Chat();
    
    if(isset($_GET['sendChat']) && $_GET['sendChat'] == "true") {
        $chat -> sendChat();
    }

    if(isset($_GET['receiveChat']) && $_GET['receiveChat'] == "true")   {
        $chat -> receiveChat();
    }

    if(isset($_GET['findTotalMessage']) && $_GET['findTotalMessage'])   {
        $chat -> findTotalMessage();
    }

    if(isset($_GET['encryptMessage']) && $_GET['encryptMessage'] == "true") {
        $chat -> encryptMessage();
    }

    if(isset($_GET['decryptMessage']) && $_GET['decryptMessage'] == "true")   {
        $chat -> decryptMessage();
    }

    if(isset($_GET['loadChat']) && $_GET['loadChat'])   {
        $chat -> loadChat();
    }


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