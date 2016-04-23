<?php
namespace com\ddocc\base\utility;
Class Audit 
{
    var $Refid;
    var $Doneby;
    var $Activity;
    var $Act;
    var $Sessionid;
    var $Ip;
    var $Dateadded;
    
    function Audit($type,$rem,$affected = 0)
    {
        $this->Activity = $type;
        $this->Act = $rem;
        if(isset($_SESSION["authid"]))
            $this->Doneby = $_SESSION["authid"];
        else
            $this->Doneby = 0;
        $this->SessionID = session_id();
        $this->Dateadded = date('Y-m-d H:i:s');
        $this->Ip = $_SERVER["REMOTE_ADDR"];
        $t = new AsyncAudit($this);
        $t->run();
    }
    
    function Load()
    {
        $sql = "SELECT refid, doneby, activity, act, sessionid, ip, dateadded FROM tbl_audit WHERE refid = :refid";        
        $cn = new Connect();
        $cn->SetSQL($sql);  
	$cn->AddParam('refid', $this->Refid);       
        $ds = $cn->Select(); 
        $this->Refid = 0;        
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->Refid = $dr['refid'];
        $this->Doneby = $dr['doneby'];
        $this->Activity = $dr['activity'];
        $this->Act = $dr['act'];
        $this->Sessionid = $dr['sessionid'];
        $this->Ip = $dr['ip'];
        $this->Dateadded = $dr['dateadded'];              
    }

    function Delete()
    {
        $sql = "DELETE tbl_audit WHERE refid = :refid"; 
        $cn = new Connect();
        $cn->SetSQL($sql);
	$cn->AddParam('refid', $this->Refid);          
        return $cn->Delete();
    }      
}

class AsyncAudit extends Thread {
    public $item;
    public function __construct($item) {
        $this->item = $item;
    }
    public function run() {

        $sql = "INSERT INTO tbl_audit (doneby, activity, act, sessionid, ip, dateadded)  "
            . "VALUES ( :doneby, :activity, :act, :sessionid, :ip, :dateadded) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam('doneby', $item->Doneby);
        $cn->AddParam('activity', $item->Activity);
        $cn->AddParam('act', $item->Act);
        $cn->AddParam('sessionid', $item->Sessionid);
        $cn->AddParam('ip', $item->Ip);
        $cn->AddParam('dateadded', $item->Dateadded);
        $cn->Update();
    }
}