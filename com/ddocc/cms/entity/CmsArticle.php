<?php
namespace com\ddocc\cms\entity;
use com\ddocc\base\utility\Connect;

class CmsArticle
{
    var $article_id;
    var $article_name;
    var $article_content;
    var $article_type_id;
    var $article_tags;
    var $last_updated;

    
    function Load()
    {
        $sql = "SELECT article_id, article_name, article_content, article_type_id, article_tags, last_updated FROM ez_articles WHERE article_id = :article_id";        
        $cn = new Connect();
        $cn->SetSQL($sql);  
	$cn->AddParam(':article_id', $this->article_id); 
      
        $ds = $cn->Select(); 
        $this->article_id = 0;        
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function LoadByName()
    {
        $sql = "SELECT article_id, article_name, article_content, article_type_id, article_tags, last_updated
        FROM ez_articles WHERE article_name = :article_name";
        $cn = new Connect();
        $cn->SetSQL($sql);
        $cn->AddParam(':article_name', $this->article_name);

        $ds = $cn->Select();
        $this->article_id = 0;
        if($cn->num_rows > 0)
        {
            $this->Set($ds[0]);
        }
    }

    function Set($dr)
    {
        $this->article_id = $dr['article_id'];
        $this->article_name = $dr['article_name'];
        $this->article_content = $dr['article_content'];
        $this->article_type_id = $dr['article_type_id'];
        $this->article_tags = $dr['article_tags'];
        $this->last_updated = $dr['last_updated'];              
    }

    function Insert()
    { 
        $sql = "INSERT INTO ez_articles (article_name, article_content, article_type_id, article_tags, last_updated)  VALUES ( :article_name, :article_content, :article_type_id, :article_tags, :last_updated) "; 
        $cn = new Connect();
        $cn->SetSQL($sql); 
	$cn->AddParam(':article_name', $this->article_name); 
$cn->AddParam(':article_content', $this->article_content); 
$cn->AddParam(':article_type_id', $this->article_type_id); 
$cn->AddParam(':article_tags', $this->article_tags); 
$cn->AddParam(':last_updated', $this->last_updated);
       
        $this->article_id = $cn->Insert();     
		return $this->article_id;
    }

    function Update()
    {
        $sql = "UPDATE ez_articles SET article_name = :article_name, article_content = :article_content, article_type_id = :article_type_id, article_tags = :article_tags, last_updated = :last_updated WHERE article_id = :article_id"; 
        $cn = new Connect();
        $cn->SetSQL($sql);  
	$cn->AddParam(':article_name', $this->article_name); 
$cn->AddParam(':article_content', $this->article_content); 
$cn->AddParam(':article_type_id', $this->article_type_id); 
$cn->AddParam(':article_tags', $this->article_tags); 
$cn->AddParam(':last_updated', $this->last_updated); 
$cn->AddParam(':article_id', $this->article_id); 
        
        return $cn->Update();
    }

    function Delete()
    {
        $sql = "DELETE FROM ez_articles WHERE article_id = :article_id"; 
        $cn = new Connect();
        $cn->SetSQL($sql);
	$cn->AddParam(':article_id', $this->article_id); 
         
        return $cn->Delete();
    }      
}
