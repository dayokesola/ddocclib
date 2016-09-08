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

    public function Send() {
        if (ENV != 'dev') {
            return $this->sendMail();
        }

        new ErrorLog($this->Body);
        return TRUE;
    }

    public function AddTo($email) {
        $this->to = $email;
    }

    function sendMail() {
        require_once ("Mail.php");
        require_once ("Mail/mime.php");
        $host = MAILHOST; //replace this with your domain's SMTP address
        $port = MAILPORT;
        $headers['From'] = MAILUSER;
        $headers['To'] = $this->to;
        $headers['Subject'] = $this->Subject;
        $headers['Content-Type'] = 'text/html; charset=UTF-8';
        $headers['Content-Transfer-Encoding'] = '8bit';
        $mime = new \Mail_mime;
        $mime->setTXTBody('text');
        $mime->setHTMLBody($this->Body);
        $mimeparams = array();
        $mimeparams['text_encoding'] = '8bit';
        $mimeparams['text_charset'] = 'UTF-8';
        $mimeparams['html_charset'] = 'UTF-8';
        $mimeparams['head_charset'] = 'UTF-8';
        //$mimeparams['debug'] = 'True'; //Uncomment this if you want to view Debug information
        $body = $mime->get($mimeparams);
        $headers = $mime->headers($headers);
        $smtpinfo['host'] = $host;
        $smtpinfo['port'] = $port;
        $smtpinfo['auth'] = true;
        $smtpinfo['username'] = MAILUSER;
        $smtpinfo['password'] = MAILPWD;
        //$smtpinfo['debug'] = 'True'; //Uncomment this if you want to view Debug information
        $mail = & \Mail::factory('smtp', $smtpinfo);
        $mail->send($this->to, $headers, $body);
        if (\PEAR::isError($mail)) {
            return false;
        } else {
            return true;
        }
    }

    function sendMailold() {

        require_once ("Mail.php");

        $headers = array(
            'From' => MAILUSER,
            'To' => $this->to,
            'Subject' => $this->Subject
        );
        $smtp = \Mail::factory('smtp', array('host' => MAILHOST, 'auth' => true, 'username' => MAILUSER, 'password' => MAILPWD));
        $mail = $smtp->send($this->To, $headers, $this->Body);
        if (\PEAR::isError($mail)) {
            return false;
        } else {
            return true;
        }
    }

}
