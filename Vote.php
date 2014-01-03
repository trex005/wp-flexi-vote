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

    public static function CastUnique($flexivote_id,$vote_answer)
    {
        $current_user = get_current_user_id();
        $unique_settings = Settings::getFlexiVoteSetting($flexivote_id,'anonymous_unique');
        if($current_user != 0)
        {
            $unique_settings = Settings::getFlexiVoteSetting($flexivote_id,'logged_in_unique');
        }
        $unique_array = explode(",",$unique_settings);
        $or_wheres = array();
        foreach($unique_array as $this_setting)
        {
            $this_setting_parts = explode(':',$this_setting);
            switch(strtolower($this_setting_parts[0]))
            {
                case 'user':
                    $or_wheres[] = " user_id = $current_user ";
                    break;
                case 'ip':
                    $or_wheres[] = " ip = INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "') ";
                    break;
                case 'hours':
                    if(!isset($this_setting_parts[1]) || !is_int($this_setting_parts[1]))break;
                    $or_wheres = ""
                    break;
            }
        }
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