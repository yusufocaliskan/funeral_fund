<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
class Database
{


    public function crate_houholder_table()
    {
        global $wpdb;
        
            $table_name =$wpdb->prefix.'cf_householder_info';
            $sql ="CREATE TABLE IF NOT EXISTS $table_name (
                    Id int(11) NOT NULL AUTO_INCREMENT,
                    fullname VARCHAR(50) NOT NULL,
                    last_name VARCHAR(50) NOT NULL,
                    birth_place VARCHAR(50),
                    country VARCHAR(50),
                    city VARCHAR(50),
                    birth_date DATE,
                    gender ENUM('man','woman'),
                    email VARCHAR(50),
                    phone VARCHAR(50),
                    turkey_address TEXT,
                    abroad_address TEXT,
                    abroad_city TEXT,
                    post_code INT(10),
                    PRIMARY KEY(Id)
                )";
            // Create the table
            dbDelta( $sql );
    }

    public function crate_family_member_table()
    {
        global $wpdb;
        
            $table_name =$wpdb->prefix.'cf_familymembers_info';
            $sql ="CREATE TABLE IF NOT EXISTS $table_name (
                    Id int(11) NOT NULL AUTO_INCREMENT,
                    fullname VARCHAR(50) NOT NULL,
                    last_name VARCHAR(50) NOT NULL,
                    birth_place VARCHAR(50),
                    country VARCHAR(50),
                    city VARCHAR(50),
                    birth_date DATE,
                    gender ENUM('man','woman'),
                    intimacy VARCHAR(50),
                    PRIMARY KEY(Id)
                )";
            // Create the table
            
            dbDelta( $sql );
    }
    
    public function get_all()
    {

    }

    public function get_by_id()
    {

    }
    
    public function update_by_id($data, $Id)
    {

    }

    public function delete_by_id($Id)
    {

    }


}