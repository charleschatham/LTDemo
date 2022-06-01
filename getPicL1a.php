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
        $userInput = readline("Enter Album ID or q to quit: ");
        echo("\n");

        //If we do not quit, querry API and display information
        if($userInput != 'q'){
            
            //define recourse URL
            $resourceURL = 'https://jsonplaceholder.typicode.com/photos?albumId=';

            //add the user input to the end of our url
            $thisQueryURL = $resourceURL .  $userInput;

            //define a cURL sesion
            $curl = curl_init();
            curl_setopt_array($curl, 
                [CURLOPT_RETURNTRANSFER => 1,       //tells cURL we want a return of a string, which we know will be JSON
                CURLOPT_URL => $thisQueryURL    ]    //sets url
            );

            //execute our cURL querry, and stor it in a variable
            $response = curl_exec($curl);

            //decod the JSON string into an associative array
            $albumInfo = json_decode($response, true);

            $currRow = 0;

            foreach($albumInfo as $thisPic){
                echo("[" . $thisPic["id"] . "] " . $thisPic["title"] . "\n");
                $currRow++;

                if($currRow % 25 == 0){
                    while($userInput != 'm' && $userInput != 'a'){
                        $userInput = readline("m to display more, or a to retun to album input: ");
                        echo("\n");
                    }
                    
                    if($userInput == 'a'){
                        break;
                    }
                }
            }
        }
    }
?>