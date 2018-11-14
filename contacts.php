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

    if(isset($_GET['findContacts']) && $_GET['findContacts'] == "true") {
        $contacts -> findContacts();
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
            $data = json_decode(file_get_contents("php://input"),true);
            $sourceId = $data['sourceId'];
            $destinationId = $data['destinationId'];
            $cId = $data['cId'];

            $sql = "select count(cId) as total from contacts where cSourceId = '$sourceId' and cDestinationId = '$destinationId'";
            $res = mysqli_query($this->link, $sql) or die("Error in Authenticating Contact Count!!".$sql);
            $row = mysqli_fetch_assoc($res);
            $total = $row['total'];
            if($total ==  1)   {
                //Add contact to your list
                $sql = "delete from contacts where cSourceId='$sourceId' and cDestinationId='$destinationId' and cId='$cId'";
                $res = mysqli_query($this->link,$sql) or die("Error in adding Contact query.".$sql);
                $res = mysqli_affected_rows($this->link);
                if($res)    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "Contact has been removed successfully.";
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "Error in removing user from contacts. Please try again!";
                }
            }
            else    {
                //Contact already Exists!!
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "User not exist in your contacts!";
            }

            header("Content-type: Application/json");
            echo json_encode($result);
        }

        function listContacts() {
            $sourceId = $_GET['sourceId'];
            $sql = "select * from contacts right join users on contacts.cDestinationId = users.uId where cSourceId='$sourceId'";
            $res = mysqli_query($this->link,$sql) or die("Error in Getting Contacts list!".$sql);
            $total = mysqli_num_rows($res);
            if($total == 0) {
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "User not exist in your contacts!";
            }
            else    {
                $result = array();
                $result['result'] = "Success";
                $result['message'] = "Contacts are in Contacts objects!";
                $result['contacts'] = array();
                $i = 0;
                while($row = mysqli_fetch_assoc($res))  {
                    $result['contacts'][$i] = array();
                    $result['contacts'][$i]['sourceId'] = $row['cSourceId'];
                    $result['contacts'][$i]['destinationId'] = $row['cDestinationId'];
                    $result['contacts'][$i]['cName'] = $row['uFirstName']." ".$row['uLastName'];
                    $result['contacts'][$i]['cEmail'] = $row['uEmail'];
                    $result['contacts'][$i]['cMobile'] = $row['uMobile'];
                    $i++;
                }
            }
            header("Content-type: Application/json");
            echo json_encode($result);
        }

        function findContacts()  {
            $sourceId = $_GET['sourceId'];
            $q = mysqli_real_escape_string($this->link,$_GET['q']);

            if($q != NULL || !empty($q) || $q == " ")   {
                $sql = "select * from users where uFirstName LIKE '$q%' or uLastName LIKE '$q%' or uEmail LIKE '$q%'";
                $res = mysqli_query($this->link,$sql) or die("Error in Finding Contacts list!".$sql);
                $total = mysqli_num_rows($res);
                if($total == 0) {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "Couldn't find user!";
                }
                else    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "Contacts are in Contacts objects!";
                    $result['contacts'] = array();
                    $i = 0;
                    while($row = mysqli_fetch_assoc($res))  {
                        $result['contacts'][$i] = array();
                        $result['contacts'][$i]['uId'] = $row['uId'];
                        $result['contacts'][$i]['cName'] = $row['uFirstName']." ".$row['uLastName'];
                        $result['contacts'][$i]['cEmail'] = $row['uEmail'];
                        $result['contacts'][$i]['cMobile'] = $row['uMobile'];
                        $i++;
                    }
                }
                header("Content-type: Application/json");
                echo json_encode($result);
            }
        }
    }
?>