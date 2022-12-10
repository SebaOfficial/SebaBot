<?php

/*
Fill this file with all required informations
*/

const token = "YOUR_TOKEN_HERE"; // The token that botfather gave you

$owner = 123; // Your telegram id
$log = 123; // The log channel, the bot must be admin, set this to false to stop logging
$chat_group = 123; // The private group where the requests from the "chat" section will come, set it to '$owner' to send them to private chat

$db_host = "localhost"; // The host of your database
$db_username = "root"; // The username of your database
$db_password = ""; // The password for the username
$db_name = ""; // The database that will contain all the tables

$main_language = "en"; // Set this with your language, you can delete this once you executed the checkErrors.php file

$commandHandlers = [ // What defines a command
    "/",
    ".",
];

$github_username = "SebaOfficial"; // Your github username
$github_link = "https://github.com/$github_username";


?>