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
        $select = $this->DB->get_results("
                    SELECT * FROM wp_posts 
                    LEFT JOIN wp_wc_product_meta_lookup ON wp_posts.ID = wp_wc_product_meta_lookup.product_id
                    WHERE wp_posts.post_type = 'product'
                    ");
        return $select;
    }

}