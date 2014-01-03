<?php
Namespace FlexiVote;
class Database
{
    /**
     * Used for both initial creation and updating of structure for "Votes" table
     */
    public static function createVotesTable()
    {
        $sql = "
        CREATE TABLE " . self::getVotesTableName() . "
        (
          vote_id INT NOT NULL AUTO_INCREMENT,
          flexivote_id INT,
          user_id INT,
          ip INT UNSIGNED,
          vote INT NOT NULL,
          PRIMARY KEY  (vote_id)
        )
        ";
        \dbDelta( $sql );
    }

    /**
     * @return string name of "Votes" table
     */
    public static function getVotesTableName()
    {
        global $wpdb;
        return $wpdb->prefix . 'flexivotes_votes';
    }

    /**
     * Not quite sure if we'll need this for wordpress version, but keeping this here as a placeholder
     */
    function __construct()
    {
        //empty
    }
}