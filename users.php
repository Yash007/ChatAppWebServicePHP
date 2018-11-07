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
        $users -> updateUser($_GET['uId']);
    }
    
    class Users {
        var $link;
		var $conObj;
		
		function __construct()	{
			$this -> conObj = new Connection();
            $this -> link = $this -> conObj -> dbConnect();
        }

        function signUpUser()   {
            $data = json_decode(file_get_contents("php://input"),true);
            $uFirstName = $data['uFirstName'];
            $uLastName = $data['uLastName'];
            $uEmail = $data['uEmail'];
            $uPassword = $data['uPassword'];
            $uMobile = $data['uMobile'];
            $uPassword = sha1($uPassword);

            $sql = "select count(uId) as total from users where uEmail='$uEmail'";
            $res = mysqli_query($this->link,$sql) or die("Error in Count query");
            $row = mysqli_fetch_assoc($res);
            $total = $row['total'];
            
            $validate = true;
            if(empty($uFirstName) || $uFirstName == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Firstname required!!";
            }

            if(empty($uLastName) || $uLastName == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Lastname required!!";
            }

            if(empty($uEmail) || $uEmail == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Email required!!";
            }

            if(empty($uMobile) || $uMobile == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Mobile number required!!";
            }

            if(empty($uPassword) || $uPassword == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Password required!!";
            }

            if($validate == true && $total == 0) {
                $sql = "insert into users(uFirstName,uLastName,uEmail,uMobile,uHash) values('$uFirstName','$uLastName','$uEmail','$uMobile','$uPassword')";
                $res = mysqli_query($this->link,$sql) or die("Error in Signup User query");
                $res = mysqli_affected_rows($this->link);
    
                if($res)    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "User has been signed up.";
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "User has not been signed up.";
                }
            }
            else    {
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "User has already registered!!";
            }

            header("Content-type: Application/json");
            echo json_encode($result);
        }

        function loginUser()    {
            $data = json_decode(file_get_contents("php://input"),true);
            $uEmail = $data['uEmail'];
            $uPassword = $data['uPassword'];
            $validate = true;

            if(empty($uEmail) || $uEmail == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Email required!!";
            }

            if(empty($uPassword) || $uPassword == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Password required!!";
            }
            
            $uPassword = sha1($uPassword);
            if($validate == true)   {
                $sql = "select * from users where uEmail='$uEmail' and uHash='$uPassword'";
                $res = mysqli_query($this->link,$sql) or die("Error in users login Query");
                $row = mysqli_fetch_assoc($res);
                $total = mysqli_num_rows($res);

                if($total == 1) {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "User profile found";
                    $result['profile'] = array();
                    $result['profile']['uId'] = $row['uId'];
                    $result['profile']['uFirstName'] = $row['uFirstName'];
                    $result['profile']['uLastName'] = $row['uLastName'];
                    $result['profile']['uEmail'] = $row['uEmail'];
                    $result['profile']['uMobile'] = $row['uMobile'];
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "Invalid email or password";
                }
            }
            header("Content-type: Application/json");
            echo json_encode($result);
        }

        function updateUser($uId)   {
            $data = json_decode(file_get_contents("php://input"),true);
            $uFirstName = $data['uFirstName'];
            $uLastName = $data['uLastName'];
            $uEmail = $data['uEmail'];
            $uMobile = $data['uMobile'];
            
            $validate = true;
            if(empty($uFirstName) || $uFirstName == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Firstname required!!";
            }

            if(empty($uLastName) || $uLastName == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Lastname required!!";
            }

            if(empty($uEmail) || $uEmail == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Email required!!";
            }

            if(empty($uMobile) || $uMobile == " ")    {
                $validate = false;
                $result = array();
                $result['result'] = "Error";
                $result['message'] = "Mobile number required!!";
            }

            if($validate == true) {
                $sql = "update users set uFirstName='$uFirstName', uLastName='$uLastName', uEmail='$uEmail', uMobile='$uMobile' where uId='$uId'";
                $res = mysqli_query($this->link,$sql) or die("Error in Signup User query");
                $res = mysqli_affected_rows($this->link);
    
                if($res)    {
                    $result = array();
                    $result['result'] = "Success";
                    $result['message'] = "User has been updated";
                }
                else    {
                    $result = array();
                    $result['result'] = "Error";
                    $result['message'] = "User has not been updated.";
                }
            }

            header("Content-type: Application/json");
            echo json_encode($result);
        }

    }
?>