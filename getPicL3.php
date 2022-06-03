<?php 

    //Author: Charles Chatham
    //Purpose: Code Sample 
    //Revision: L1/MVP
    //Date 6/22
    //Function: This program is intended to be executed at the command line. e.g. PHP getPicXX.php. 
    //The usuer will then be prompted for an album ID or enter a command. 
    //The user will then be have information displayed about the album and propted again. 

    //Revision Note: For this revision we're tasked with making it 'look good'. So why don't we always make sure when we're displaying our information we make sure 
    //the user can see it w/o having to scroll w/in command prompt. 


    //execute a command prompt command to set the console to 120x60. Note this will also clear the screen, so we know we can display cleanly. 
    if(strpos(strtoupper(php_uname()), "INDOWS")){
        exec('mode 120,60');
    }else{
        exec('stty rows 60 cols 120');
    }

    //Loop to allow for multiple request
    $userInput = -1;

    while($userInput != 'q'){
        $userInput = readline("Enter Album ID, u to update data or q to quit: ");
        echo("\n");

        if($userInput != 'q' && $userInput != 'u'){
            $albumInfo = getdata($userInput);
            if(!$albumInfo){
                echo("Album does not exist!\n");
                continue;
            }
            $currRow = 0;
            $lastR = 0;
            foreach($albumInfo as $thisPic){
                if($thisPic["albumId"] == $userInput){
                    echo("[" . $thisPic["id"] . "] " . $thisPic["title"] . "\n");
                    $currRow++;
                    
                }
                
                //improvment, could do a count on this so it doesn't do that extra promt. Would that be more efficent? 
                if($currRow % 25 == 0 && $lastR != $currRow){
                   
                    $userInput2 = -1;
                    $lastR = $currRow;  
                    while($userInput2 != 'm' && $userInput2 != 'a'){
                        $userInput2 = readline("m to display more, or a to retun to album input: ");
                        echo("\n");
                    }
                    
                    if($userInput2 == 'a'){
                        break;
                    }
                    
                }
            }
        }

        if($userInput == 'u'){
            $albumInfo = getdata("U");
        }
    }

    function getData($albumID){

        $host = 'localhost';
        $db   = 'LTDemo';
        $user = 'LTDemo';
        $pass = 'password';
        $charset = 'utf8mb4';

        $dsn = "mysql:server=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo;

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        $sqlQuery = 'SELECT * FROM ltdemo.albumInfo where albumID = ' . $albumID;

        $dbData = $pdo->query($sqlQuery);
        
        return($dbData);
    }
?>