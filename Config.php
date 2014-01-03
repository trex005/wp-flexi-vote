<?php
Namespace FlexiVote;
class Config
{
    //This is not a user configuration file, DO NOT TOUCH
    //This is not a user configuration file, DO NOT TOUCH
    //This is not a user configuration file, DO NOT TOUCH

    /**
     * Current version of FlexiVote
     * @var string
     */
    public static $FlexiVoteVersion = 0.001;

    /**
     * Initiates all variables and configuration functions needed to run FlexiVote
     */
    function __construct()
    {
        //register our custom post type
        \add_action('init', array(__CLASS__,'setCustomPostTypes'));

        //register plugin activation function
        \register_activation_hook(dirname(__FILE__).'/wp-flexi-vote.php', array(__CLASS__,'PluginActivation') );
    }

    /**
     * Runs only at time of activation
     */
    static function PluginActivation()
    {
        //Get the version from the last activation
        $old_version = \get_option('FlexiVoteVersion');
        //If this does not exist, run install script
        if($old_version === false)
        {
            self::PluginInstall();
        }
        //if last activation was old, run updates since last activation
        else if($old_version < self::$FlexiVoteVersion)
        {
            self::PluginUpdate($old_version);
        }
        //Save this version for future activations
        \add_option("FlexiVoteVersion", self::$FlexiVoteVersion);
    }

    static function PluginInstall()
    {
        Database::createVotesTable();
    }

    static function PluginUpdate($old_version)
    {
        if($old_version <= 0.001)
        {
            //This should never be possible as .001 was the first version!
            //This was put here as an example for future updates
        }
    }

    /**
     * Registers our custom post type with wordpress
     */
    static function setCustomPostTypes()
    {
        \register_post_type('flexivotes',
            array(
                'label' => 'FlexiVotes',
                'description' => 'FlexiVotes generated that are not tied to another specific post, page or other custom post type',
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'rewrite' => array('slug' => 'FlexiVotes', 'with_front' => true),
                'query_var' => true,
                'exclude_from_search' => true,
                'menu_position' => '5',
                'menu_icon' => \plugins_url( 'img/16/thumb_up.png' , __FILE__ ),
                'supports' => array('title'),
                'labels' => array (
                    'name' => 'FlexiVotes',
                    'singular_name' => 'FlexiVote',
                    'menu_name' => 'FlexiVotes',
                    'add_new' => 'Add FlexiVote',
                    'add_new_item' => 'Add New FlexiVote',
                    'edit' => 'Edit',
                    'edit_item' => 'Edit FlexiVote',
                    'new_item' => 'New FlexiVote',
                    'view' => 'View FlexiVote',
                    'view_item' => 'View FlexiVote',
                    'search_items' => 'Search FlexiVotes',
                    'not_found' => 'No FlexiVotes Found',
                    'not_found_in_trash' => 'No FlexiVotes Found in Trash',
                    'parent' => 'Parent FlexiVote',
                )
            )
        );
    }
}