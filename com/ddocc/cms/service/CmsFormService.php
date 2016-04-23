<?php

namespace com\ddocc\cms\service;

Class CmsFormService
{
    var $msg;
    function UpdatePostStatus($post_id, $sf)
    {
        $sql = "update ez_form_post set statusflag = :sf where post_id = :post_id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':sf', $sf);
        $cn->AddParam(':post_id', $post_id);
        return $cn->Update();
    }

    function GetFormItemsByForm($id)
    {
        $sql = "SELECT c.*,t.data_type_name FROM ez_form_columns c, ez_data_types t
            WHERE c.data_type_id = t.data_type_id and c.form_id = :id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':id', $id);
        return $cn->SelectObject();
    }

    function CreateFormView($form_id)
    {
        $cols = $this->GetFormItemsByForm($form_id);

        $sql = " CREATE OR REPLACE ALGORITHM=MERGE DEFINER=".DBUSER."@".DBHOST." SQL SECURITY DEFINER VIEW frm_".$form_id." AS
        SELECT  p.post_id,p.form_id,p.session_id,p.date_added,p.statusflag ";
        $n = 1;
        foreach ($cols as $col)
        {
            $sql .= " , d".$n.".column_data as " . $col->column_name . " ";
            $n++;
        }
        $sql .= " FROM ez_form_post p  ";
        $n = 1;
        foreach ($cols as $col)
        {
            $sql .= " LEFT JOIN ez_form_columns c".$n." ON  p.form_id = c".$n.".form_id ";
            $sql .= " AND c".$n.".form_id = ".$form_id." AND c".$n.".column_id = ".$col->column_id." ";
            $n++;
        }
        $n = 1;
        foreach ($cols as $col)
        {
            $sql .= " LEFT JOIN ez_form_data d".$n." ON  p.post_id = d".$n.".post_id  AND c".$n.".column_id = d".$n.".column_id ";
            $n++;
        }

        $sql .= "  WHERE p.form_id = ".$form_id."; ";
        //echo $sql;
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->Update();
    }

    function GetForms()
    {
        $sql = "SELECT * FROM ez_forms order by form_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    function GetDataTypes()
    {
        $sql = "SELECT * FROM ez_data_types order by data_type_name   ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        return $cn->SelectObject();
    }

    function TreatPost($arr)
    {
        if(!isset($arr["form_id"])) return;
        $form_id = $arr["form_id"];

        $frm = $this->getFormById($form_id);

        //vlaidate form
        $txta = '<script type="text/javascript" charset="utf-8">';
        $txtb = '</script>';
        $txt ='';
        $tx = '';
        $txf = '';
        $err = 0;
        $g = new Gadget();
        foreach($arr as $key => $val)
        {
            if(substr($key,0,4) == 'ctr_')
            {
                $txf .= '$("#' .$key.'").val("'.$val.'");';
                $col = substr($key,4);
                $col_id = $this->GetColumnByName($col,$form_id);
                $col = str_replace("_", " ", $col);
                $fi = new CmsFormItem();
                $fi->column_id = $col_id;
                $fi->Load();

                if($fi->column_null == 1 && $val == '')
                {
                    $tx .=  $col . ' cannot be empty.\n';
                    $err++;
                }
                if($fi->data_type_id == 6)  //check email
                {
                    if(! $g->isValidEmail($val))
                    {
                        $err++;
                        $tx .=  $col . ' is invalid.\n';

                    }
                }

                if($fi->data_type_id == 2)       //check number
                {
                    if (! is_numeric($val))
                    {
                        $err++;
                        $tx .=  $col . ' is not a number.\n';
                    }
                }

                //$this->SaveColumn($col_id,$val,$post_id);
            }
        }

        //lets validate a form too

        foreach ($_FILES as $key => $val)
        {
            if(substr($key,0,4) == 'ctr_')
            {
                //$txf .= '$("#' .$key.'").val("'.$val.'");';

                $col = substr($key,4);
                $col_id = $this->GetColumnByName($col,$form_id);
                $col = str_replace("_", " ", $col);
                $fi = new CmsFormItem();
                $fi->column_id = $col_id;
                $fi->Load();

                if($fi->column_null == 1 && $val['error'] == 4)
                {
                    $tx .=  $col . ' needs to be uploaded.\n';
                    $err++;
                }
            }
        }


        $this->msg = $tx;
        $txt =$txta . $txf;
        $txt .= "alert('$tx');";
        $txt .= $txtb;

        if($err > 0)
        {
            return $txt;
        }

        $ses = session_id();
        $sql = "insert into ez_form_post (form_id,session_id,date_added) values ($form_id,'$ses',now())";

        if(isset($arr["form_tok"]))
        {
            $_SESSION["token_".$form_id]  = $ses;
        }

        $cn = new Connect();
        $cn->SetSQL($sql);
        $post_id = $cn->Insert();

        foreach($arr as $key => $val)
        {
            if(substr($key,0,4) == 'ctr_')
            {
                //echo $key . ' => '. $val. ';'.substr($key,0,4).'<br />';
                $col = substr($key,4);
                $col_id = $this->GetColumnByName($col,$form_id);
                $this->SaveColumn($col_id,$val,$post_id);
            }
        }

        //if there  files

        foreach ($_FILES as $key => $val)
        {
            if(substr($key,0,4) == 'ctr_')
            {
                $col = substr($key,4);
                $col_id = $this->GetColumnByName($col,$form_id);
                //we need to save the file
                $temp = explode(".", $val["name"]);
                $extension = end($temp);
                $fname = $form_id. '_'  . $post_id  . '_'. $col_id .'.'. $extension;
                move_uploaded_file($val["tmp_name"],UPLOADPATH .  $fname);
                $this->SaveColumn($col_id,$fname,$post_id);
            }
        }


        $tx = 'Your form has been submitted successfully';
        $this->msg = $tx;
        $txt =$txta;
        $txt .= "alert('$tx');";
        $txt .= $txtb;
        return $txt;
    }

    function GetColumnByName($col_name,$form_id)
    {
        $sql = "SELECT column_id FROM ez_form_columns where form_id = :form_id and column_name = :col_name  ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_id', $form_id);
        $cn->AddParam(':col_name', $col_name);
        return $cn->SelectScalar();
    }

    function SaveColumn($col, $val,$post_id)
    {
        $val = addslashes($val);
        $sql = "insert into ez_form_data (column_id,column_data,post_id)
        values (:col,:val,:post_id)";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':col', $col);
        $cn->AddParam(':val', $val);
        $cn->AddParam(':post_id', $post_id);
        return $cn->Insert();
    }

    function SetNewColData($form_id, $column_id, $default_data)
    {
        $sql = "SELECT  *
                FROM  ez_form_post
                WHERE    form_id = :form_id ";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':form_id', $form_id);
        $rows = $cn->Select();

        foreach($rows as $row)
        {
            //echo "$form_id => $column_id => " .$row['post_id'] ." => $default_data" ;
            $this->SaveColumn($column_id, $default_data, $row['post_id']);
        }
    }
}
