<?php

//get database class
require FRAMEWORK."database.php";
require FRAMEWORK."MailSender.php";
class Core
{
    public $database;
    public $gender;
    public $gender_lookup;
    public $intimacy_lookup;
    public $MailSender;

    public function __construct()
    {
        //create tables
        $this->database = new Database();
        $this->database->crate_houholder_table();
        $this->database->crate_member_table();

        //mail sender
        $this->mail_sender = new MailSender();

        add_action('admin_menu', [$this, 'add_link2admin_menu']);

        $this->gender = ['woman','man'];
        $this->gender_lookup =['man'=> "Erkek", 'woman'=> "Kadın" ];
        $this->intimacy_lookup = [
            'esi'=>'Eşi',
            'cocugu'=>'Çocuğu'
        ];

        $this->intimacy = [
        'hanimi',
        'kizi',
        'annesi',
        'gelini',
        'kardesi',
        'torunu',
        'Kayin_validesi',
        'baldizi',
        'yegeni',
        'diger_akrabasi'];
            
       

    }


    public function add_link2admin_menu()
    {
        add_menu_page( _('Caneze Fonu'),
         _('Caneze Fonu'), 
         'manage_options', 'cenaze-fonu',[$this,'main_template'] );
    }

    /**
     * Creates ajax requests
     */
    public function ajax_requests()
    {
     
        //Custom actions
        add_action( 'wp_ajax_form_control_handler', [$this,'form_control_handler'] );
        add_action( 'wp_ajax_nopriv_form_control_handler', [$this ,'form_control_handler'] );
        
        add_action('wp_ajax_get_price', [$this, 'get_price']);
        add_action('wp_ajax_nopriv_get_price',[$this, 'get_price']);

        add_action('wp_ajax_add_new_registration', [$this, 'add_new_registration']);
        add_action('wp_ajax_nopriv_add_new_registration',[$this, 'add_new_registration']);

        add_action('wp_ajax_approve_member_registration', [$this, 'approve_member_registration']);
        add_action('wp_ajax_nopriv_approve_member_registration',[$this, 'approve_member_registration']);

        add_action('wp_ajax_reject_member_registration', [$this, 'reject_member_registration']);
        add_action('wp_ajax_nopriv_reject_member_registration',[$this, 'reject_member_registration']);

        add_action('wp_ajax_delete_member_registration', [$this, 'delete_member_registration']);
        add_action('wp_ajax_nopriv_delete_member_registration',[$this, 'delete_member_registration']);

        
        add_action('wp_ajax_main_template_load_more', [$this, 'main_template_load_more']);
        add_action('wp_ajax_nopriv_main_template_load_more',[$this, 'main_template_load_more']);

        
    }

    public function approve_member_registration()
    {
        //is admin logged in?
        if(is_user_logged_in())
        {
            $update = $this->database->approve($_POST['data']['memberId']);   
            if($update)
            {
                
                //Get informations
                $householder = $this->database->get_houserholder_byId($_POST['data']['memberId']);
                
                //Send approvement mail
                $user_name = $householder->householder_name.' '.$householder->householder_lastname;
                $mail_content = $this->mail_sender->get_approvement_template($user_name);
                $to_mail = $householder->email;
                $mail = $this->mail_sender->send(
                    ['mail'=>$to_mail,'user_name'=>$user_name],
                    $mail_content,'Cenaze Fonu için Kayıt Onay İşlemi');
                
                echo json_encode(['type'=>'success', 'message'=>'Onaylandı']);

                wp_die();
            }
            else{
                echo json_encode(['type'=>'danger', 'message'=>'Hata oluştu']);
                wp_die();
            }
        }
        
        wp_die();
    }

    public function delete_member_registration()
    {
        //is admin logged in?
        if(is_user_logged_in())
        {
            $delete = $this->database->delete($_POST['data']['memberId']);   
            if($delete)
            {
                //delete all members
                $members = $this->database->get_members_by_houserholderId($_POST['data']['memberId']);
                foreach($members as $member)
                {
                    $this->database->delete_family_members($member->Id);
                }
                echo json_encode(['type'=>'success', 'message'=>'Silindi']);

                wp_die();
            }
            else{
                echo json_encode(['type'=>'danger', 'message'=>'Hata oluştu']);
                wp_die();
            }
        }
        
        wp_die();
    }

    public function reject_member_registration()
    {
        //is admin logged in?
        if(is_user_logged_in())
        {
            $update = $this->database->reject($_POST['data']['memberId']);   
            
            if($update)
            {
                echo json_encode(['type'=>'success', 'message'=>'Reddedildi']);
                wp_die();
            }
            else{
                echo json_encode(['type'=>'danger', 'message'=>'Hata oluştu']);
                wp_die();
            }
        }
        
        wp_die();
    }
    /**
     * Adds new registration that comes from frontend form
     */
    public function add_new_registration()
    {
        $form_control = $this->form_control_handler(true);

        //Save it to the database
        if($form_control['type'] != 'success')
        {
            echo json_encode($form_control);
            wp_die();    
        }

        //if everything went to well!
        if($form_control['type']== 'success')
        {
            //Save it to the database
            $householderId = $this->database->add_new($_POST['data']['formData']);
            
            if(is_array($_POST['data']['memberData']) && count($_POST['data']['memberData']) > 0)
            {
                $members = $_POST['data']['memberData'];
                foreach($members as $member)
                {
                    $insert_member = $this->database->add_new_member($member, $householderId);
                }
            }

            
            $error = [];
            if($householderId)
            {
               
                //send email
                $user_name = $_POST['data']['formData']['householder_name'].' '.$_POST['data']['formData']['householder_lastname'];
                $mail_content = $this->mail_sender->get_registration_template($user_name);
                $to_mail = $_POST['data']['formData']['email'];
                $mail = $this->mail_sender->send(
                    ['mail'=>$to_mail,'user_name'=>$user_name],
                    $mail_content,'Cenaze Fonu için Kayıt İşlemi');
                
                $error = ['type'=>'success','message'=>'Kaydınızı tamamlandı. Sizinle yakın zamanda iletişime geçeceğiz.'];
            }
            else{
                $error = ['type'=>'danger','message'=>'Bir hata oluştu. Kayıt yapılmadı.'];
            }

            echo json_encode($error);
            wp_die();
        }
        
    }

    public function get_price()
    {   
        $data = $_POST['data'];
        $members = $data['members']; 
        $total_price = $this->cacl_price($data['householder_birthyear']);

        if($data['householder_birthyear'] == '' || $data['householder_birthyear'] == 0)
        {
            echo json_encode(['type'=>'danger','message'=>'Aile reisi bilgilerini doldurun']);
            wp_die( );
        }

        //if there is a members
        else if( is_array($members) && count($members) > 0)
        {
            foreach($members as $member)
            {
                $total_price = $total_price + $this->cacl_price($member['member_birthyear']);  
            }
        }

        //Yıllık aidat 65;
        $total_price  = $total_price+65;

        echo json_encode( ['type'=>'success','new_price'=>$total_price] );
        wp_die();
    }

    /**
     * Make some validation control form control
     */
    public function form_control_handler($return_array) {
        $data = $_POST['data']['formData'];
        $memberData = $_POST['data']['memberData'];
        $error = [];
       
        //is empty?
        if(trim($data['householder_name']) =='' ||
            trim($data['householder_lastname']) == '' ||
            trim($data['householder_birthplace']) == '' ||
            trim($data['householder_birthday']) == '' ||
            trim($data['householder_birthmonth']) == '' ||
            trim($data['householder_birthyear']) == '' ||
            trim($data['householder_gender']) == '' ||
            trim($data['email']) == '' ||
            trim($data['phone_number']) == '' ||
            trim($data['street']) == '' ||
            trim($data['post_code']) == '' ||
            trim($data['city'] )== '')
        {
            $error = ['type'=>'danger','message'=>'Gerekli alanları doldurun'];
        }

        //if there is a family member
        // else if($data['isset_member'] == 'yes' && 
        // (trim($data['member_name']) == '' ||
        // trim($data['member_lastname']) == '' ||
        // trim($data['member_birthday']) == '' ||
        // trim($data['member_birthmonth']) == '' ||
        // trim($data['member_birthyear']) == '' ||
        // trim($data['member_gender']) == '' ||
        // trim($data['member_intimacy']) == '')
        // ){
        //     $error = ['type'=>'danger','message'=>'Aile ferdi için gerekli alanları doldurun'];
        // }

        else if(!is_email($data['email']))
        {
            $error = ['type'=>'danger','message'=>'Geçerli bir e-mail adresi girin.'];
        }
        else if($data['householder_birthday'] == 0 || 
                $data['householder_birthmonth'] == 0 || 
                $data['householder_birthyear'] == 0)
        {
            $error = ['type'=>'danger','message'=>'Doğum tarihi geçerli değil']; 
        }
        //is it a member?
        else if($data['isset_member'] == 'yes' && ($data['member_birthday'] == 0 || 
                $data['member_birthmonth'] == 0 || 
                $data['member_birthyear']== 0 ))
        {
            $error = ['type'=>'danger','message'=>'Doğum tarihi geçerli değil']; 
        }
         else if( ! in_array( $data['householder_gender'], $this->gender ) ){
            $error = ['type'=>'danger','message'=>'Cinsiyet geçerli değil'];
        }
        else if(!is_numeric($data['post_code'])){
            $error = ['type'=>'danger','message'=>'Geçerli posta kodu girin'];
        }

        else if( $data['isset_member'] == 'yes' && (! in_array( $data['member_gender'], $this->gender ) )){
            $error = ['type'=>'danger','message'=>'Cinsiyet geçerli değil'];
        }
        else if( $data['isset_member'] == 'yes' &&  (!in_array($data['member_intimacy'], $this->intimacy))){
            $error = ['type'=>'danger','message'=>'Yakınlık derecesi geçerli değil.'];
        }
        else{

            //calculate price
            $total_price = $this->cacl_price($data['householder_birthyear']);
            if(is_array($memberData) && count($memberData) > 0)
            {
                foreach($memberData as $member)
                $total_price = $total_price + $this->cacl_price($member['member_birthyear']);
            }
            
            //yıllık aiddat 65 €
            $total_price = $total_price + 65;

            //ages
            $ages = [
                'householder_age'=>(date('Y') - $data['householder_birthyear']),
                'member_age'=>(date('Y')-$data['member_birthyear'])
            ];
            
            $lookups = [
                'householder_gender'=>$this->gender_lookup[$data['householder_gender']],
                'member_gender'=>$this->gender_lookup[$data['member_gender']],
                'member_intimacy'=>$this->intimacy_lookup[$data['member_intimacy']],
            ];
            
            $error = ['type'=>'success','message'=>'Şimdi bilgileri kontrol edip kaydı onaylamalısınız.','total_price' => $total_price, 'ages'=>$ages,'lookups'=>$lookups];
        }
        

        // Do something with the data
        if($return_array)
        {
            return $error;
        }
        echo json_encode($error);
        wp_die();

        
    }

    public function cacl_price($year)
    {
        
        //-- 0-19 / 30 € | 
        //-- 20-29 / 50 € | 
        //-- 30-39 / 75 € | 
        //--40-44 / 100 € | 
        //-- 45-49 / 130 € | 
        //--50-54 / 175 € |5
        // 5-59 / 275 € |6
        // 0-64 / 475 € |6
        // 5-69 / 850 € |7
        // 0-74 / 1000€ |7
        // 5-79 1500€ | 
        // 80 ve üzeri 2250€
        
        $total_price = 0;
        $age = date('Y')-$year;
        if($age <=19){
            $total_price = '30';
        }
        if($age >= 20 && $age <=29 ){
            $total_price = '50';
        }
        if($age >= 30 && $age <= 39 ){
            $total_price = '75';
        }
        if($age >= 40 && $age <= 44 ){
            $total_price = '100';
        }
        if($age >= 45 && $age <= 49 ){
            $total_price = '130';
        }
        if($age >= 50 && $age <= 54 ){
            $total_price = '175';
        }
        if($age >= 54 && $age <= 59 ){
            $total_price = '275';
        }
        if($age >= 60 && $age <= 64 ){
            $total_price = '475';
        }
        if($age >= 65 && $age <= 69 ){
            $total_price = '850';
        }
        if($age >= 70 && $age <= 74 ){
            $total_price = '1000';
        }
        if($age >= 75 && $age <= 79 ){
            $total_price = '1500';
        }
        if($age >= 80){
            $total_price = '2250';
        }
        

        return $total_price;
    }

    public function main_template_load_more()
    {

        $this->member_list_table();
        wp_die();   
    }

    public function main_template()
    {
        
        
    ?>
     <div class="loading">
        <div class="loading-body">
            <div class="spinner-border text-primary" role="status"></div>
            <span>{loading_message}</span>
        </div>
    </div> 

    <div style="display:none" class="toast-container position-fixed  top-10 end-0 p-3">
    <div id="liveToast" class=" toast" role="alert" aria-live="assertive" aria-atomic="true" style="display: flex; align-items: center; padding: 0 10px">
        <div style="width: 35px; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="white" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
            <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
        </svg>
        </div>
        <div style="font-size: 20px; color: #fff" class="toast-body">
        {message}
        </div>
    </div>
    </div>
        <input type="hidden" name="limit" value="10"/>
    <div style="max-width:1000px; padding-top: 5%; margin: auto">
        <nav style="border-radius: 5px"  data-bs-theme="dark" class=" navbar  navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                <svg STYLE="margin-right: 5px" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-database-fill" viewBox="0 0 16 16">
                    <path d="M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223Z"/>
                    <path d="M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                    <path d="M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                    <path d="M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                </svg>
                Cenaze Fonu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </buztton>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Tümü</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bekleyenler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Onaylananlar</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    

    <div class="container"  style="margin-top: 20px; padding: 0">
        <div id="content">
    
        <?php $this->member_list_table(); ?>
            
        </div>
    </div>
    </div>
    <?php
    }

    public function member_list_table()
    {

        if($_POST)
        {
            $limit = $_POST['data']['limit'];
            $all_records = $this->database->get_all($limit);
            if(count($all_records) <= 0)
            {
                return false;
                wp_die();
            }
        }
    else{
        $all_records = $this->database->get_all();
    }
        
        $data = $_POST ? $_POST['data'] : [];
    ?>
    <table  class="table  member-list-table " style="border: 1px solid #ddd;">
    
            <thead class="table-light">
                <tr style="font-weight: bold">
                    <td>#</td>
                    <td>Adı Soyadı</td>
                    <td>Yaş</td>
                    <td>Cinsiyet</td>
                    
                    <td>Ücret</td>
                    <td>E-mail</td>
                    <td>Durum</td>
                    <td>Ayarlar</td>
                </tr>           
            </thead>
                <?php if(count($all_records) > 0):?>
                <?php foreach($all_records as $member):
                    $family_members = $this->database->get_members_by_houserholderId($member->Id);
                    //print_r($family_members);
                    ?>
                
                <tr class="mem-info" data-member-id="<?php echo $member->Id?>">
                    
                    
                    <td class="member-td"><?php echo $member->Id; ?> </td>
                    <td class="member-td"><?php echo $member->householder_name;?> <?php echo $member->householder_lastname; ?> </td>
                    <td class="member-td"><?php echo $member->member_age?></td>
                    <td class="member-td"><?php echo $this->gender_lookup[$member->householder_gender];?></td>
                    <td class="member-td"><?php echo $member->form_price;?> €</td>
                    <td class="member-td"><a href="mailto:<?php echo $member->email?>"><?php echo $member->email?></a></td>
                    <td class="member-td">
                    <?php if($member->status == 'approved'):?>
                        
                        <span class=" badge bg-success">Onaylı</span>
                        <?php endif; ?>    
                    <?php if($member->status =='waiting'): ?>
                        <span class=" badge bg-warning">Bekliyor</span>
                        <?php endif; ?>
                    <?php if($member->status =='rejected'): ?>

                        <span class=" badge bg-danger">Reddedildi</span>
                    
                    <?php endif; ?>
                    </td>

                    <td>
                    
                    <div class="btn-group">
                        <span style="cursor:pointer" class=" badge text-bg-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                            </svg>
                        </span>
                        <ul class="dropdown-menu">
                            <li><span class="approve-registration dropdown-item " 
                            data-member-id="<?php echo $member->Id?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                            </svg>    
                            Onayla</span></li>
                            <li>
                                <span class="reject-registration dropdown-item"
                                data-member-id="<?php echo $member->Id?>"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                </svg>
                                Reddet</a>
                            </li>
                            <li><span class="delete-registration dropdown-item" href="#"
                            data-member-id="<?php echo $member->Id?>"
                            >
                                
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                            Sil</spa ></li>
                            
                        </ul>
                        </div>
                    </td>
                <?php $this->member_popup_information($member, $family_members); ?>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px 20px; color: #444">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#444" class="bi bi-database-exclamation" viewBox="0 0 16 16">
                    <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z"/>
                    <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5Zm0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Z"/>
                    </svg>
                        <p style=" padding-top: 20px;font-size: 16px; ">Ekli kayıt yok.</p></td>
                </tr>
            <?php endif; ?>
            <?php if(!$_POST): ?>
            <?php if(count($all_records) >= 10): ?>

            <tr>
                <td colspan="7">
                    <div style="padding:30px 0; display: flex; align-items:center; justify-content:center ">

                    <button class="load-more btn btn-primary">
                        Daha fazla yükle
            </button>
                    </div>
                </td>
            </tr>

            <?php endif;?>
            <?php endif;?>
            
            </table>
            
        
    <?php
    }

    public function member_popup_information($member, $family_members){
    ?>
    <tr style="display: none" class="member-info-tr" data-member-info-id="<?php echo $member->Id?>">
                    <td colspan="7" style="position: relative">
                    <span class="close-member-info-popup">
                            X
                        </span>
                        <div class="information-pop row" style="padding: 40px">
                        
                        
                        <div class="col-12">
                        <div class="card" style="max-width: 100%">
                        <div class="last-info-item total_price" style="display: flex; flex-direction: column; align-items: center" >
                        <svg  style="margin-bottom: 5px" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span style="color: #333">Toplam Giriş Ücreti</span>
                        
                        <div class="display-6"><span class="form_price"><?php echo $member->form_price?></span> <small style="font-size: 25px;">€</small></div>
                        <input type="hidden" name="form_price" />
                        <small style="color: #888">+ yıllık aidat 65 €</small>
                    </div>
                    </div>
                        </div>
                        <div class="col-6">
                    <div class="card" >
                    <div class="tab-content-title">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        </i>    
                    Aile Reisi Bilgileri</div>

                    <div class="last-info-item">
                        <span>Adı / Soyadı</span>
                        <p><span class="householder_name"> </span> <span class="householder_lastname"><?php echo $member->householder_name?> <?php echo $member->householder_lastname?> </span> (<span class="householder_gender"><?php echo $this->gender_lookup[$member->householder_gender]?></span>) * <span class="badge bg-success text-white"><span style="color: white" class="  householder_age"><?php echo $member->householder_age?></span> yaşında</span></p>
                    </div>
                    <div class="last-info-item">
                        <span>Doğum Tarihi</span>
                        <p><span class="householder_birthday"><?php echo str_replace('-','/',$member->householder_birthdate)?></span>   - <span class="householder_birthplace"><?php echo $member->householder_birthplace?></span></p>
                    </div>
                </div>
                </div>
                <div class="col-6" >
                <div class="card"">
                    <div class="tab-content-title">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        </i>
                Aile Ferdi</div>

                    <?php if(count($family_members) > 0):?>
                        <div class="list-group member-list" style="margin: 10px">
                        <?php foreach($family_members as $f_member):?>
                            
                        <div  class="list-group-item list-group-item-action " aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo $f_member->member_name?> <?php echo $f_member->member_lastname?></h5>
                        
                        </div>
                        <p class="mb-1">
                            <?php echo str_replace('-','/',$f_member->member_birthdate);?>
                            <span class="member_intimacy2">
                                <?php echo $this->intimacy_lookup[$f_member->member_intimacy];?>
                            </span> - 
                            <span class="member_gender2">
                                <?php echo $this->gender_lookup[$f_member->member_gender];?>
                            </span>
                        </p>
                        <div>
                           
                        </div>
                        </div>
                        <?php endforeach; ?>
                    
                    </div>

                    <?php else:?>

                        <div class="last-info-item">
                        <p>Aile ferdi eklenmedi.</p>
                    </div>
                    <?php endif;?>
                </div>
                
                </div>
                <div class="col-12">
                    <div class="card" style="max-width: 100%">
                    <div class="tab-content-title">
                        <i><svg xmlns="http://www.w3.org/2000/svg" style="width: 28px !important" fill="currentColor" class="bi bi-house-add" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h4a.5.5 0 1 0 0-1h-4a.5.5 0 0 1-.5-.5V7.207l5-5 6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 1 0 1 0v-1h1a.5.5 0 1 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z"/>
                        </svg>    </i>
                        Adres Bilgileri</div>
                    

                    
                        <div class="last-info-item">
                            <span>E-mail</span>
                            <p><span class="email"><a href="mailto:<?php echo $member->email?>"><?php echo $member->email?></a></span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Telefon</span>
                            <p><span class="phone_number"><?php echo $member->phone_number?></span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Cadde </span>
                            <p><span class="street"><?php echo $member->street?></span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Şehir  / Posta Kodu</span>
                            <p><span class="city"><?php echo $member->city?></span> / <span class="post_code"><?php echo $member->post_code?></span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Türkiye Adresi</span>
                            <p><span class="turkey_address"><?php echo $member->turkey_address?></span></p>
                        </div>
                    </div>

                </div>
                </div>
                </div>
                    </td>
                </tr>
    <?php
    }
    
}