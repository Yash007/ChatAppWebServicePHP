<?php
    //AI tool that will find keywords occurence from the message and sets it's priority.


    class AI    {
        var $priority;
        var $keywords;
        var $listKeyWords;
        function __construct($keywords)  {
            $this -> $keywords = $keywords;
            $this -> $priority = 0; 
            $this -> $listKeyWords = array('bank','password','account details','account number','a/c number','a/c no',
                                            'pass','username','swift bank code','correspondent bank','usa account',
                                        'holder address','information account','fund transfers','bank charges','bank details',
                                        'banking information','pin','pin number','access code','atm','atm card','atm number',
                                        'cvc2 number','cvv','cvc2','sin','sin number','card number','card details','id card',
                                        'id number');

        }

        function findKeyword()  {
            //Keyword stored already in variable. $this->$keywords;
            
        }
        
        function getPriority()  {
            //return priority
        }
    }

?>