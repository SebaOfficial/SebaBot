# SebaBot

This Telegram bot lets users contact me (even if they are limited) and know more about me.


## Table of Contents

* Features
* Installation
* Database Structure
* License
* Credits


## Features

1. [/chat](https://github.com/SebaOfficial/SebaBot/blob/master/commands/chat.php):<br>
    This command lets you chat with me letting you deceide the reason you'd like to do it.<br>
    Be aware that you must have joined a channel before using that function.

2. [/bots](https://github.com/SebaOfficial/SebaBot/blob/master/commands/bots.php):<br>
    This command is intended to view the list of all the bots developed by me.

3. [/lang](https://github.com/SebaOfficial/SebaBot/blob/master/commands/lang.php):<br>
    Just a language switch


## Installation

Here's a guide to install TruthOrDareRobot locally

1. Install PHP and other packages<br>
`sudo apt update && sudo apt install php8.1 && sudo apt-get install -y php8.1-curl php8.1-mysql php8.1-cli && echo 'PHP installed.'`

2. Install MariaDB<br>
`sudo apt install mariadb-server && sudo mysql_secure_installation && echo 'MariaDB server installed.'`

3. Clone this repository<br>
`git clone https://github.com/SebaOfficial/SebaBot.git && cd SebaBot`

4. Edit the [utils.php](https://github.com/SebaOfficial/SebaBot/blob/master/utils.php) file with your credentials and informations

5. Run the [checkErrors.php](https://github.com/SebaOfficial/SebaBot/blob/master/checkErrors.php) file to check for any errors and to create all the required tables in the database<br>
`php checkErrors.php`

If everything is okay you should have your bot running correctly.<br>
Otherwise feel free to [contact me](https://racca.me#contact). 


## Database Structure

* Tables
    * Users<br>
    *Contains information about all the users:*<br>
        1. Telegram id (**id**);
        2. Last action in the bot (**action**);
        3. If they blocked the bot (**active**)
        4. Their preferred language (**lang**)
        5. If they have an ongoing chat (**is_chatting**)
        6. Some utils, used for some features (**util***)

    * Texts<br>
    *Contains all the texts the bot will use:*<br>
        1. The text id (**id**)
        2. The columns for the languages (**lang-code**)
        3. The type of a button, *optional* (**type**)
        4. The callback or url of a button, *optional* (**callback**)<br>

    * Bots<br>
    *Contains all the bots that are shown in the /bots section:*<br>
        1. The username of the bot (**username**)
        2. If the bot is online (**online**)
        3. if the bot is visible in the section (**visible**)

    * Supports<br>
    *Contains all the chats the users started:*<br>
        1. The id of the support (**id**)
        2. The user of the chat (**user**)
        3. The type of the chat (**type**)
        4. The date the user interacted (**date**)


## License
This project is open source and available under the [**MIT** License](https://github.com/SebaOfficial/SebaBott/blob/master/LICENSE).


## Credits
* This project is created by [@SebaOfficial](https://github.com/SebaOfficial) using the [Telegram APIs](https://core.telegram.org/bots/api)
    * [Contact Me](https://racca.me#contact)
* [Live demo of the bot](https://t.me/SebaBot)
* [Database used](https://mariadb.org/)