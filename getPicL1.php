<?php 

    //Author: Charles Chatham
    //Purpose: Code Sample 
    //Revision: L1/MVP
    //Date 6/22
    //Function: This program is intended to be executed at the command line. e.g. PHP getPicXX.php. 
    //The usuer will then be prompted for an album ID or enter a command. 
    //The user will then be have information displayed about the album and propted again. 

    //Loop to allow for multiple request
    $userInput = -1;
    while($userInput != 'q'){
        $userInput = readline("\nEnter Album ID or q to quit: ");
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
            foreach($albumInfo as $thisPic){
                echo("[" . $thisPic["id"] . "] " . $thisPic["title"] . "\n");
            }
        }
    }
?>