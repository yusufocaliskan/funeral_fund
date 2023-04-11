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
     * with its datails that stored on wp_wc_product_meta_lookup tabel
     */
    public function getAllProducts()
    {
        $select = $this->DB->get_results("
                    SELECT * FROM ".$this->DB->prefix."posts 
                    LEFT JOIN ".$this->DB->prefix."wc_product_meta_lookup 
                        ON wp_posts.ID = ".$this->DB->prefix."wc_product_meta_lookup.product_id
                        
                    WHERE ".$this->DB->prefix."posts.post_type = 'product'
                    ");
        return $select;
    }

    /**
     * Returns all the products that added to the timeslots
     */
    public function getTimeslotProducts($data = [])
    {
        $booked_default = get_option( 'booked_defaults' );
        
        //Removes the same values
        if(count($booked_default['productIds']) > 0)
        {
            return array_unique($booked_default['productIds']);
        }
        
    }
    

    
    

}