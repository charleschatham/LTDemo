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
    $albumInfo = getdata();
    

    while($userInput != 'q'){
        $userInput = readline("Enter Album ID, u to update data or q to quit: ");
        echo("\n");

        if($userInput != 'q' && $userInput != 'u'){
 
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
            $albumInfo = getdata(1);
        }



    }

    function getData($doCurl = 0){
        
        $filename = "albumInfo.json";

        //note there's a default value of 0, so if we call this function w/o an argument it will perform the curl only if the file doesn't exit.
        //But we can also call this function w/ an argument of 1, thus forcing a curl. We'll use that for our update option.

        if (!file_exists($filename) || $doCurl) {
            //curle for data
            echo("Getting data from cURL.\n");
            $resourceURL = 'https://jsonplaceholder.typicode.com/photos';
            //define a cURL sesion
            $curl = curl_init();
            curl_setopt_array($curl, 
            [CURLOPT_RETURNTRANSFER => 1,       //tells cURL we want a return of a string, which we know will be JSON
            CURLOPT_URL => $resourceURL    ]    //sets url
            );

            //execute our cURL querry, and stor it in a variable
            $data = curl_exec($curl);

            try{
                unlink($filename);
            }catch(Exception $e){
                //nothing to see here
            }

            $newAlbumFile = fopen("$filename", "w");
            fwrite($newAlbumFile, $data);


        } else {
            //read data from file
            echo("Getting data from albumInfo.json\n");
            $data = file_get_contents($filename);
        }

        //decod the JSON string into an associative array
        return(json_decode($data, true));
    }
?>