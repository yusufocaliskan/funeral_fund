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

    /**
     * Shorted days of weeek
     */
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
                        ON ".$this->DB->prefix."posts.ID = ".$this->DB->prefix."wc_product_meta_lookup.product_id
                        
                    WHERE ".$this->DB->prefix."posts.post_type = 'product'
                    ");
        return $select;
    }

    /**
     * Get Product by its name
     */
    public function getProductByTitle($title)
    {

        $select = $this->DB->get_row("
                    SELECT * FROM ".$this->DB->prefix."posts 
                    LEFT JOIN ".$this->DB->prefix."wc_product_meta_lookup 
                        ON ".$this->DB->prefix."posts.ID = ".$this->DB->prefix."wc_product_meta_lookup.product_id
                        
                    WHERE ".$this->DB->prefix."posts.post_type = 'product' AND ".$this->DB->prefix."posts.post_title = '$title'
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
        if($booked_default['productIds'])
        {
            return array_unique($booked_default['productIds']);
        }
        
    }

    public function getProductByTimeSlot($day = '')
    {
        $booked_default = get_option( 'booked_defaults' );
        
        //Removes the same values
        if($booked_default['productIds'])
        {
            return $booked_default[$this->shortDaynName($day).'-details'];
        }
        
    }

    public function shortDaynName($day)
    {
        return date('D', strtotime($day));
    }
    
    //Adds new product to the card!
    public function addToCart($productId, $quantity) {
        $cart = WC()->cart;
        $cartItemKey = $cart->add_to_cart($productId, $quantity);
    }

    public function searchByKey($pattern, $array) {
        $keys = array_keys($array);
        $matches = preg_grep($pattern, $keys);
        $result = array_intersect_key($array, array_flip($matches));
        return $result;
    }
    
    public function addSpecials($data)
    {   
        print_r($_POST);
        //Add Specialss
        $specialProducts = array_values($this->searchByKey('/^single-checkbox/',$data));
        foreach($specialProducts as $key)
        {
            foreach($key as $sProductId)
            {
                if($sProductId != '')
                {   
                    //if we have guest, we need to add every
                    //special product for eeach guest 
                    if($_POST['guest_no'])
                    {
                        $this->addToCart($sProductId, $_POST['guest_no']);
                    }
                    else{
                        $this->addToCart($sProductId, 1);
                    }
                    
                }
                
            }
        }
    }


}