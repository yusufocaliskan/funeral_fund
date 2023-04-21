<?php

/**
 * Plugin Name: Cenaze Fonu
 * Author: Yusuf Çalışkan
 * Description: Online Kayıt ve Masraf Payı Ödemesi
 * Version: 1.0
 */

 define('PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ));
 define('PLUGIN_URL', trailingslashit( plugins_url('/', __FILE__) ));
 define('FRAMEWORK', PLUGIN_DIR.'/framework/');
 define('VIEWS', PLUGIN_DIR.'/views/');

//Loadin necessary scripts
add_action( 'admin_enqueue_scripts','load_scripts');
function load_scripts()
{
    //CSS
    wp_enqueue_style( 'master', PLUGIN_URL.'/public/css/master.css');
    wp_enqueue_style( 'bootsrapt', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css',[],['1.0.0.','all',['crossorigin' => 'anonymous','integrity'=>'sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ']]);
    
    //Javascripts
    wp_enqueue_script('app-script', PLUGIN_URL.'/public/js/app.js',[], false,true);
    wp_register_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js',[],'1.0.0.0');
    wp_enqueue_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js',[],['1.0.0.0','all',['integrity'=>'sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe','crossorigin'=>"anonymous"]]);
}

add_shortcode( 'cenaze_formu', 'cenaze_formu_shortcode' );
function cenaze_formu_shortcode()
{   
    wp_enqueue_script('app-script', PLUGIN_URL.'/public/js/app.js',[], false,true);
    wp_enqueue_style( 'master', PLUGIN_URL.'/public/css/master.css');
    wp_enqueue_style( 'bootsrapt', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css',[],['1.0.0.','all',['crossorigin' => 'anonymous','integrity'=>'sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ']]);
    ob_start();
    $content = file_get_contents(VIEWS.'registration_form.php');
    ob_end_flush();

    return $content;
}


//Start!
require_once FRAMEWORK.'core.php';
$core = new Core();