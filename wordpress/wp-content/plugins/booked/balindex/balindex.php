<?php

/**
 * @author Yusuf Caliskan
 * @email yusufocaliskan@gmail.com
 */
class Balindex{

    /**
     * Holds WPDB global variable
     */
    public $DB;

    public function __construct()
    {
        global $wpdb;
        $this->DB= $wpdb;
        
    }

    /**
     * Gets all the producst from the database
     */
    public function getAllProducts()
    {
        $select = $this->DB->get_results("SELECT * FROM wp_posts");
        return $select;
    }
}