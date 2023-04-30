<?php

require PLUGIN_DIR.'vendor/autoload.php';
class MailSender{

    private $api_key = "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";
    private $mail; 
    public function __construct()
    {
        $this->mail = new \SendGrid\Mail\Mail(); 
    }

    public function send($to, $content, $title)
    {
        $from = ['mail'=>'associationhamele@gmail.com',
        'user_name'=>'Hamele Yardım Derneği'];
        
        $this->mail->setFrom($from['mail'], $from['user_name']);
        $this->mail->setSubject($title);
        $this->mail->addTo($to['mail'], $to['user_name']);
        $this->mail->addContent("text/html", $content);
        $sendgrid = new \SendGrid($this->api_key);
        try {
           return $response = $sendgrid->send($this->mail);
        //    print $response->statusCode() . "\n";
        //    print_r($response->headers());
        //    print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    
    public function get_registration_template($user_name)
    {
        ob_start();
        require VIEWS.'mail-template/registration.php';
        $content = ob_get_clean();
        $content = str_replace('{{user_name}}',$user_name, $content);
        return $content;
    }

    public function get_approvement_template($user_name)
    {
        ob_start();
        require VIEWS.'mail-template/approvement.php';
        $content = ob_get_clean();
        $content = str_replace('{{user_name}}',$user_name, $content);
        return $content;
    }
}