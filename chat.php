<?php
    include("codebase/Connection.php");
    $chat = new Chat();
    
    if(isset($_GET['chatList']) && $_GET['chatList'] == "true") {
        $chat -> chatList();
    }

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
            date_default_timezone_set('US/Eastern');
        }

        function chatList() {
            
        }

        function sendChat() {
            $data = json_decode(file_get_contents("php://input"),true);
            $senderId = $data['senderId'];
            $receiverId = $data['receiverId'];
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $message = mysqli_real_escape_string($this->link,$data['message']);
            //$senLevel =  (AI code to find Sensitivity Level)
            $sensLevel = 0;

            if($message != NULL || $message != " " || !empty($message)) {
                $sql = "insert into messages (mSenderId, mReceiverId, mDate, mTime, mMessage, mSensitiveLevel) values ('$senderId','$receiverId','$date','$time','$message','$sensLevel')";
                $res = mysqli_query($this->link, $sql) or die("Error in sending Message Query".$sql);
                $res = mysqli_affected_rows($this->link);
                if($res)    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "Message send successfully";
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "Failed to send message! Please try again.";
                }
            }
            header("Content-type: Application/json");
            echo json_encode($result);
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
            $data = json_decode(file_get_contents("php://input"),true);
            $senderId = $data['senderId'];
            $receiverId = $data['receiverId'];

            $sql = "select * from messages where (mSenderId='$senderId' and mReceiverId = '$receiverId') or (mSenderId='$receiverId' and mReceiverId='$senderId') ORDER BY mDate ASC, mTime ASC";
            $res = mysqli_query($this->link, $sql) or die("Error in Load chat message Query".$sql);
            $total = mysqli_num_rows($res);
            if($total >= 1) {
                $i = 0;
                $result = array();
                $result['result'] = "Success";
                $result['message'] = "Chat are in chat object";
                $result['chat'] = array();
                while($row = mysqli_fetch_assoc($res))  {
                    $result['chat'][$i]['message'] = $row['mMessage'];
                    $result['chat'][$i]['date'] = $row['mDate'];
                    $result['chat'][$i]['time'] = $row['mTime'];
                    $result['chat'][$i]['sensLevel'] = $row['mSensitiveLevel'];
                    $i++;
                }
            }
            else    {
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Start chat now!!";
            }
            header("Content-type: Application/json");
            echo json_encode($result);
        }
    }
?>