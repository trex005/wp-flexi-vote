<?php
Namespace FlexiVote;
class Database
{
    /**
     * Used for both initial creation and updating of structure for "Votes" table
     */
    public static function createVotesTable()
    {
        global $wpdb;

        //Create votes table
        $sql = "
        CREATE TABLE " . self::getVotesTableName() . "
        (
          vote_id INT NOT NULL AUTO_INCREMENT,
          flexivote_id INT,
          user_id INT,
          voted_on DATETIME,
          ip INT UNSIGNED,
          vote INT NOT NULL,
          PRIMARY KEY  (vote_id)
        )
        ";
        \dbDelta( $sql );

        //mysql does not support using NOW() as a default value for datetime, so we'll use a trigger to accomplish this
        $sql = "
        DROP TRIGGER
        IF EXISTS
        " . self::getVotesTableName() . "_OnInsert";

        $wpdb->query($sql);

        $sql = "
        CREATE TRIGGER
        " . self::getVotesTableName() . "_OnInsert
        BEFORE INSERT
        ON " . self::getVotesTableName() . "
        FOR EACH ROW
        SET
        NEW.voted_on = IFNULL(NEW.voted_on, NOW());";
        $wpdb->query($sql);
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