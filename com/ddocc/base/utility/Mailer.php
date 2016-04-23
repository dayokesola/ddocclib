<?php
namespace com\ddocc\base\utility;

class Mailer {
    //put your code here
    var $Sender;
    var $Host;
    var $Email;
    var $To;
    var $Body;
    var $Subject;
    
    public function Send()
    {
        new ErrorLog($this->Body);
        return TRUE;
    }
    
    public function AddTo($email) {
        $this->to = $email;
    }

    function sendMail()
    {
        require_once "Mail.php";
        $headers = array ('From' => MAILUSER,  'To' => $this->to,  'Subject' => $this->Subject);
        $smtp = Mail::factory('smtp', array ('host' => MAILHOST, 'auth' => true, 'username' => MAILUSER, 'password' => MAILPWD));
        $mail = $smtp->send($this->To, $headers, $this->Body);
        if (PEAR::isError($mail))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}


