<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Connect;
Class SiteTab
{
    var $tab_id;
    var $tab_ent;
    var $tab_text;
    var $var1;
    var $var2;
    var $var3;
    var $var4;
    var $var5;


    function Load()
    {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $this->tab_id);
        $cn->AddParam(':tab_ent', $this->tab_ent);

        $ds = $cn->Select();
        $this->tab_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
    {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $this->tab_id);
        $cn->AddParam(':tab_ent', $this->tab_ent);

        $ds = $cn->Select();
        $this->tab_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->tab_id = $dr['tab_id'];
        $this->tab_ent = $dr['tab_ent'];
        $this->tab_text = $dr['tab_text'];
        $this->var1 = $dr['var1'];
        $this->var2 = $dr['var2'];
        $this->var3 = $dr['var3'];
        $this->var4 = $dr['var4'];
        $this->var5 = $dr['var5'];
    }

    function Insert()
    {
        $sql = "INSERT INTO __DB__text (tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5)  VALUES ( :tab_id, :tab_ent, :tab_text, :var1, :var2, :var3, :var4, :var5) ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_text', $this->tab_text);
        $cn->AddParam(':var1', $this->var1);
        $cn->AddParam(':var2', $this->var2);
        $cn->AddParam(':var3', $this->var3);
        $cn->AddParam(':var4', $this->var4);
        $cn->AddParam(':var5', $this->var5);
        $cn->AddParam(':tab_id', $this->tab_id);
        $cn->AddParam(':tab_ent', $this->tab_ent);

        $this->tab_id = $cn->Insert();
        return $this->tab_id;
    }

    function Update()
    {
        $sql = "UPDATE __DB__text SET tab_text = :tab_text, var1 = :var1, var2 = :var2, var3 = :var3, var4 = :var4, var5 = :var5 WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_text', $this->tab_text);
        $cn->AddParam(':var1', $this->var1);
        $cn->AddParam(':var2', $this->var2);
        $cn->AddParam(':var3', $this->var3);
        $cn->AddParam(':var4', $this->var4);
        $cn->AddParam(':var5', $this->var5);
        $cn->AddParam(':tab_id', $this->tab_id);
        $cn->AddParam(':tab_ent', $this->tab_ent);

        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM __DB__text WHERE tab_id = :tab_id and tab_ent = :tab_ent";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':tab_id', $this->tab_id);
        $cn->AddParam(':tab_ent', $this->tab_ent);

        return $cn->Delete();
    }

    function GetList($sort = 2)
    {
        $sql = "SELECT tab_id, tab_ent, tab_text, var1, var2, var3, var4, var5 "
                . "FROM __DB__text WHERE tab_id = :tab_id order by ".$sort;        
        $cn = new Connect();
        $cn->SetSQL($sql);  	
        $cn->AddParam('tab_id', $this->tab_id);
        return $cn->Select();
    }
    
    
}
