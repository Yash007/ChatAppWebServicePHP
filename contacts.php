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
            $data = json_decode(file_get_contents("php://input"),true);
            $sourceId = $data['sourceId'];
            $destinationId = $data['destinationId'];

            $sql = "select count(cId) as total from contacts where cSourceId = '$sourceId' and cDestinationId = '$destinationId'";
            $res = mysqli_query($this->link, $sql) or die("Error in Authenticating Contact Count!!".$sql);
            $row = mysqli_fetch_assoc($res);
            $total = $row['total'];
            if($total ==  0)   {
                //Add contact to your list
                $sql = "insert into contacts (cSourceId, cDestinationId) values ('$sourceId','$destinationId')";
                $res = mysqli_query($this->link,$sql) or die("Error in adding Contact query.".$sql);
                $res = mysqli_affected_rows($this->link);
                if($res)    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "Contact has been saved successfully.";
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "Error in adding user in contacts. Please try again!";
                }
            }
            else    {
                //Contact already Exists!!
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "User already in your contact list!";
            }

            header("Content-type: Application/json");
            echo json_encode($result);
        }

        function removeContact()    {

        }

        function listContacts() {

        }

        function findContact()  {

        }
        

    }
?>