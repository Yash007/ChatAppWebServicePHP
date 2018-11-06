<?php
    include("config.php");

    class Connection	{
        var $link;
        function dbConnect()	{
            $this->link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,DB_PORT);
            
            if($this->link)	{
                return $this->link;
            }
            else	{
                die("COULD NOT CONNECT TO DATABASE");
            }
        }
    }
?>