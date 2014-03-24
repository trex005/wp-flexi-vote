<?php
/**
* Plugin Name: FlexiVote
* Plugin URI: https://github.com/trex005
* Description: Wordpress Plugin allowing for up/down, like or rate styles of voting geared to be flexible enough for any use.
* Version: 0.01
* Author: Tapy.com
* License: GPL2 or contact author
*/

//Call Settings to initialize
require_once("Settings.php");
require_once("Database.php");

$GLOBALS['FlexiVoteSettings'] = new \FlexiVote\Settings();