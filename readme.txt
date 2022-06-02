Author: Charles Chatham 
Purpose: This is a technical demo for LT. 
Date: May22
Use: This is a cli application which base functionality will recive user input which will corespond to an album ID.
     The application will then access a web recourse and retrive JSON information which whill be filtered by the user input. 
     Once the information is retrived, the application will print the picture ID and Title of the picture. 

There will be a few versions of this to explore a few different approaches based off of efficancy. 
Level 1: Simply use the user input to dynamicly construct a unique URL, parse returned information and display. 
    Level 1: MVP, note based off of the example, I infered we need a loop, thus the text is a little different 
    Level 1a: Make it look good. 
    Level 1b: Implement a dynamic cashe. 
    Level 1c: On launch retrive all of the information and querry localy. 
Level 2: Check for a JSON file on launch and either load that information or retrive the information from the web service. 
    Level 2a: Add the functionality for the user to update the file.
Level 3: Similar to Level 2, but use a database rather than a file.
    Level 3a: Allow the user to add/remove information localy. 
    Level 3b: When issuing the update command, do a comparison between what is local and what is on the web service and prompt user to keep or discard changes. 

