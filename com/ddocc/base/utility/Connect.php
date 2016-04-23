<?php
namespace com\ddocc\base\utility;

Class Connect
{	
    private $link;
    private $res;		
    private $DBHost = DBHOST;
    private $DBUser = DBUSER;
    private $DBPassword = DBPWD;
    private $DBName = DBNAME;
    private $params;   
        
    public $sql;
    public $num_rows;
    public $Persist = false;
    function __construct()
    {
        try
        {
            $l = "mysql:host=".$this->DBHost.";dbname=".$this->DBName;
            $this->link = new \PDO($l,$this->DBUser,$this->DBPassword);
        }
        catch (\PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
            new ErrorLog($e);
        }
    }

    function SetSQL($sql)
    {
        $sql = str_replace("__DB__",DBPREFIX,$sql);
        $this->sql = $sql;
        $this->params = array();
    }
        
    function AddParam($key, $val)
    {
        $this->params[$key] = $val;
    }
        
    function Select()
    { 
        $this->num_rows = -1;
        try
        {
            $this->res = $this->link->prepare($this->sql);          
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            } 
            else
            {
                $this->res->execute();
            }
            $rows = $this->res->fetchAll();

            $this->num_rows = count($rows);
        }
        catch (\PDOException $e)
        {
            new ErrorLog($e);
        }
        $this->Close();
        return $rows;
    }

    function Select2()
    { 
        dd($this);
        $this->num_rows = -1;
        try
        {
            $this->res = $this->link->prepare($this->sql);          
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            } 
            else
            {
                $this->res->execute();
            }
            $rows = $this->res->fetchAll();

            $this->num_rows = count($rows);
        }
        catch (\PDOException $e)
        {
            new ErrorLog($e);
        }
        $this->Close();
        return $rows;
    }
    function SelectObject()
    {
        $this->num_rows = -1;
        try
        {
            $this->res = $this->link->prepare($this->sql);
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            }
            else
            {
                $this->res->execute();
            }
        }
        catch (\PDOException $e)
        {
            new ErrorLog($e);
        }
        $arr = array();
        while($row = $this->res->fetchObject()){
            $arr[] = $row;
        }
        $this->num_rows = count($arr);
        $this->Close();
        return $arr;
    }

    function SelectScalar()
    {
        $this->num_rows = -1;
        try
        {
            $this->res = $this->link->prepare($this->sql);
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            }
            else
            {
                $this->res->execute();
            }
        }
        catch (\PDOException $e)
        {
            new ErrorLog($e);
        }
        $row = $this->res->fetch();
        $v = $row[0];
        $this->Close();
        return $v;
    }
	
    function Update()
    {
        $cnt = -1;
        try
        {
            $this->res = $this->link->prepare($this->sql);          
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            } 
            else
            {
                $this->res->execute(); 
            }
            $cnt = $this->res->rowCount();
        }
        catch (\PDOException $e)
        {
            new ErrorLog($e);
        }
        $this->Close();
        return $cnt;
    }
    
    function Delete()
    {
        return $this->Update();
    }
    
    function Insert()
    {
        $cnt = -1; 
        try
        {        
            $this->res = $this->link->prepare($this->sql);          
            if ($this->params && count($this->params) > 0) {
                $this->res->execute($this->params);
            } 
            else
            {
                $this->res->execute();
            }            
            $cnt = $this->link->lastInsertId();
        }
        catch (\PDOException $e)
        {
            echo $this->sql;
            new ErrorLog($e);
        }
        $this->Close();
        return $cnt;
    }
	 
	
    function Close()
    {
        if($this->Persist) 
        {    
            return;
        }
        $this->link = null;        
        $this->res = null; 
    }
        
    function CloseAll()
    {
        $this->link = null;        
        $this->res = null; 
    }
}