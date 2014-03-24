<?php

Namespace FlexiVote;
class Settings
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
        $old_version = \get_option('FlexiVote_Version');
        
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
        \add_option("FlexiVote_Version", self::$FlexiVoteVersion);
    }

    /**
     * runs only the first time the plugin is activated (eg installed)
     */
    static function PluginInstall()
    {
        Database::createVotesTable();
    }

    /**
     * Runs every time the plugin is activated and it's current version is newer than the last activation (eg updated)
     * @param $old_version
     */
    static function PluginUpdate($old_version)
    {
        if($old_version <= 0.001)
        {
            //This should never be possible as .001 was the first version!
            //This was put here as an example for future updates
        }
    }
    /**
     * Gets the current value of a given setting.
     * Settings are checked in the following order
     *      passed in the shortcode args
     *      The post meta (flexivote or page included on)
     *      Sitewide defaults
     *      Plugin defaults
     * @param int $flexivote_id
     * @param string $setting_name
     * @param mixed $args
     * @return mixed Value of setting, or false if setting does not exist
     */
    public static function getFlexiVoteSetting($flexivote_id,$setting_name,$args=false)
    {
        //first check args
        if($args !== false && isset($args[$setting_name]))
        {
            return $args[$setting_name];
        }

        //second check post meta
        $meta_value = \get_post_meta($flexivote_id,'FlexiVote_Setting_' . $setting_name,true);
        if($meta_value != '')return $meta_value;

        //third check site defaults
        $default = \get_option('FlexiVote_Setting_' . $setting_name);
        if($default !== false)            return $default;

        //fourth check plugin defaults
        $default_settings = array(
            'setting_name'=>'value'
        );
        if(isset($default_settings[$setting_name]))return $default_settings[$setting_name];

        //if still nothing, throw exception.
        trigger_error("FlexiVote: Setting '$setting_name' could not be found",E_WARNING);
        return false;
    }
    /**
     * Sets a setting on a specific FlexiVote (or page which hosts a FlexiVote)
     * @param $flexivote_id
     * @param $setting_name
     * @param $setting_value
     */
    public static function setFlexiVoteSetting($flexivote_id,$setting_name,$setting_value)
    {
        \update_post_meta($flexivote_id,'FlexiVote_Setting_' . $setting_name,$setting_value);
    }
    /**
     * Sets the site default option for a given setting
     * @param $setting_name
     * @param $setting_value
     */
    public static function setDefaultSetting($setting_name,$setting_value)
    {
        \update_option('FlexiVote_Setting_' . $setting_name,$setting_value);
    }
    /**
     * Registers our custom post type with WordPress
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