<?php
Namespace FlexiVote;
class Vote
{
    public $vote_type;
    public $vote_id;
	public function getVoteOptions($id_type,$id)
	{
	}
    function __construct()
    {
    }

    /**
     * Save a vote without any restrictions
     * @param int $flexivote_id is the
     * @param int $vote_answer
     */
    public static function Cast($flexivote_id,$vote_answer)
    {
        if(!is_int($flexivote_id) || !is_int($vote_answer)) return;
        global $wpdb;
        $current_user_id = get_current_user_id();
        if($current_user_id == 0)
        {
            $user_id = 'NULL';
        }
        else
        {
            $user_id = "'$current_user_id'";
        }

        $sql = "
        INSERT INTO
        " . Database::getVotesTableName() . "
        (
            'flexivote_id',
            'ip',
            'user_id',
            'vote'
        )
        VALUES
        (
            '$flexivote_id',
            INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "'),
            $user_id,
            $vote_answer
        )";
        $wpdb->query($sql);
    }
}