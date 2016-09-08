<?php

namespace com\ddocc\base\utility;

class Texter {

    //put your code here
    var $mobile;
    var $message;
    var $account;
    var $isOK;
    var $bank_id;
    var $refid;
    var $sms_resp;
    var $sms_status;

    public function Log($r) {
        //now im inserting into dataabse
        $sql = "insert into net_sms (bank_id, account_number, refid, sms_resp, sms_status, date_added) "
                . "values (:bank_id, :account, :refid, :sms_resp, :sms_status, :date_added)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(":bank_id", $this->bank_id);
        $cn->AddParam(":account", $this->account);
        $cn->AddParam(":refid", $this->refid);
        $cn->AddParam(":sms_resp", $this->sms_resp);
        $cn->AddParam(":sms_status", $this->sms_status);
        $cn->AddParam(":date_added", Gizmo::Now());
    }

    public function Send() {
        $username = 'curiocityng';
        $password = 'deeWhy53';
        $senderId = 'Cashnetafri';
        $destination = $this->mobile234();
        $longSms = '1';
        $message = $this->messageForm();

        $data = array('UN' => $username,
            'p' => $password,
            'SA' => $senderId,
            'DA' => $destination,
            'L' => $longSms,
            'M' => $message);

        $url = 'http://98.102.204.231/smsapi/Send.aspx?';

        if (!$this->isOK) {
            $this->sms_status = 0;
        }
        $r = array();
        try {
            $this->PostRequest($url, $data);
            if (isset($r[1])) {
                $this->sms_resp = $r[1];
                $this->sms_status = 1;
            }
        } catch (\Exception $e) {
            
        }
        $this->sms_status = 2;
    }

    public function Send2() {
        $username = 'dayo';
        $password = 'riz@001';
        $senderId = 'NetBank';
        $destination = $this->mobile234();
        //$longSms = '1';
        $message = $this->messageForm();

        $data = array('username' => $username,
            'password' => $password,
            'sender' => $senderId,
            'recipient' => $destination,
            'message' => $message);

        $url = 'http://www.mytxtporta.com/API/api.php?';

        if (!$this->isOK) {
            return;
        }

        new ErrorLog(json_encode($data));
        $r = $this->PostRequest($url, $data);
        new ErrorLog(json_encode($r));
    }

    public function mobile234() {
        $this->mobile = trim($this->mobile, '+');
        $mb = '%%' . $this->mobile;

        if (substr($mb, 0, 5) === "%%234") {
            $this->isOK = TRUE;
            return $this->mobile;
        }

        if (substr($mb, 0, 3) === "%%0") {
            $mb = str_replace('%%0', '', $mb);
            $this->isOK = TRUE;
            return '234' . $mb;
        }

        $this->isOK = FALSE;
    }

    public function messageForm() {
        $this->message = str_replace(' ', '+', $this->message);
        return $this->message;
    }

    function PostRequest($url, $_data) {

        // convert variables array to string:
        $data = array();
        while (list($n, $v) = each($_data)) {
            $data[] = "$n=$v";
        }
        $data = implode('&', $data);
        // format --> test1=a&test2=b etc.
        // parse the given URL
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
            die('Only HTTP request are supported !');
        }

        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];

        // open a socket connection on port 80
        $fp = fsockopen($host, 80);

        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($data) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);

        $result = '';
        while (!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }

        // close the socket connection:
        fclose($fp);

        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);

        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        // return as array:
        return array($header, $content);
    }

}
