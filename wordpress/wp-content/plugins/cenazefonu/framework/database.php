<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
class Database
{


    public function crate_houholder_table()
    {
        global $wpdb;
        
            $table = $wpdb->prefix.'cf_householder_info';
            $sql ="CREATE TABLE IF NOT EXISTS $table (
                    Id int(11) NOT NULL AUTO_INCREMENT,
                    householder_name VARCHAR(50) NOT NULL,
                    householder_lastname VARCHAR(50) NOT NULL,
                    householder_birthplace VARCHAR(50),
                    city VARCHAR(50),
                    householder_birthdate VARCHAR(10),
                    householder_age VARCHAR(10),
                    householder_gender ENUM('man','woman'),
                    email VARCHAR(50),
                    phone_number VARCHAR(50),
                    turkey_address TEXT,
                    street TEXT,
                    post_code INT(10),
                    form_price FLOAT(10),
                    member_name VARCHAR(50) NOT NULL,
                    member_age VARCHAR(50) NOT NULL,
                    member_lastname VARCHAR(50) NOT NULL,
                    member_gender ENUM('man','woman'),
                    member_birthdate VARCHAR(10),
                    member_intimacy VARCHAR(50),
                    status ENUM('approved','waiting','rejected'),
                    PRIMARY KEY(Id)
                )";
            // Create the table
            dbDelta( $sql );
    }

    public function add_new($data)
    {
        global $wpdb;
        $householder_birthdate = $data['householder_birthday'].'-'.$data['householder_birthmonth'].'-'.$data['householder_birthyear'];
        $data['householder_birthdate'] = $householder_birthdate;
        $data['householder_age'] = date('Y')-$data['householder_birthyear'];
        $data['member_age'] = date('Y')-$data['householder_birthyear'];
        unset($data['householder_birthday']);
        unset($data['householder_birthmonth']);
        unset($data['householder_birthyear']);

        $member_birthdate = $data['member_birthday'].'-'.$data['member_birthmonth'].'-'.$data['member_birthyear'];
        $data['member_birthdate'] = $member_birthdate;
        $data['status'] = 'waiting';
        unset($data['member_birthday']);
        unset($data['member_birthmonth']);
        unset($data['member_birthyear']);

        unset($data['isset_member']);
        unset($data['ism']);

        $table = $wpdb->prefix.'cf_householder_info';

        $insert = $wpdb->insert($table, $data);
        return $insert;
        
    }
    public function get_all($limit = 10)
    {
        global $wpdb;
        $per = intval($limit)-10;   
        $table = $wpdb->prefix.'cf_householder_info';
        
        $select = $wpdb->get_results("
                    SELECT *
                    FROM $table 
                    ORDER BY Id DESC LIMIT $per, $limit ");
        return $select;
    }

    public function total_registration()
    {
        global $wpdb;
        $table = $wpdb->prefix.'cf_householder_info';
        $select = $wpdb->get_row("
                    SELECT COUNT(Id) as total
                    FROM $table ");
        return $select;
    }

    

    public function approve($memberId)
    {   
        global $wpdb;
        $table = $wpdb->prefix.'cf_householder_info';
        $data =['status'=>'approved'];
        $where =  ['Id'=>$memberId];
        $update = $wpdb->update($table, $data, $where);
        return $update;
    }

    public function delete($memberId)
    {   
        global $wpdb;
        $table = $wpdb->prefix.'cf_householder_info';
        $where =  ['Id'=>$memberId];
        $delete = $wpdb->delete($table,  $where);
        return $delete;
    }

    public function reject($memberId)
    {
        global $wpdb;
        $table = $wpdb->prefix.'cf_householder_info';
        $data = ['status'=>'rejected'];
        $where = ['Id'=>$memberId];
        $update = $wpdb->update($table, $data, $where);
        return $update;
    }
    

}