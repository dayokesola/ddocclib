<?php
namespace com\ddocc\base\utility;
use com\ddocc\base\utility\Connect;

class TreeView {
    public $queryArray;
    public $treeResult;
    public $prefix;
public $action;

    public function __construct($tableName, $idField, $titleField, $parentIdField,$prefix, $action = 0)
    {
        $this->prefix = $prefix;
        $this->action = $action;
        $sql = 'Select * From ' . $tableName . ' order by ' . $parentIdField . ', ' . $titleField;
        $cn = new Connect();
        $cn->SetSQL($sql);
        $ds = $cn->SelectObject();
        foreach ($ds as $dr)
        {
            $this->queryArray[$dr->$idField] = array(
                'id' => $dr->$idField,
                'title' => $dr->$titleField,
                'parent_id' => $dr->$parentIdField
            );
        }
    }

    public function generate_tree_list($array, $parent = 0)
    {
        $has_children = false;
        foreach($array as $key => $value)
        {
            if ($value['parent_id'] == $parent)
            {
                if ($has_children === false)
                {
                    $has_children = true;
                    $this->treeResult .= " <ul class='parent insRootClose'>"  ;
                }
                {$this->treeResult .= '<li><ins   onclick="expandNode(this.id);"' .
                    "id='$this->prefix" . $value['id'] . "'" . '>&nbsp;</ins>' . $value['title'];}
                $this->generate_tree_list($array, $key);
                $this->treeResult .= '</li>';
            }
        }
        if ($has_children === true) $this->treeResult .= '</ul>';
    }

    public function __destruct()
    {

    }
} 