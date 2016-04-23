<?php
namespace com\ddocc\base\entity;
use com\ddocc\base\utility\Gizmo;
class EntityBase {
    var $verdict;
    function Rules() {
        $rules = array();
        return $rules;            
    }
    
    public function SetPost($post_array, $fields) {
        foreach ($fields as $name) {
            if (isset($post_array[$name])) {
                $this->{$name} = Gizmo::Clean($post_array[$name]);
            }
        }
        if(property_exists($this, 'last_updated')) {
            $this->last_updated = Gizmo::Now();            
        }        
        $rules = $this->Rules();
        $this->verdict = array();
        foreach($rules as $keys => $behaviours)
        {
            switch($keys)
            {
                case 'required':
                    $this->CheckRequired($behaviours);
                    break;  
                case 'length':
                    $this->CheckLength($behaviours);
                    break; 
                case 'numeric':
                    $this->CheckNumeric($behaviours);
                    break;  
                case 'email':
                    $this->CheckEmail($behaviours);
                    break;  
                case 'similar':
                    $this->CheckSimilar($behaviours);
                    break;                    
            }
        }
        if(count($this->verdict) > 0){
            return implode('<br />', $this->verdict);
        }
        return '';
    }
    
    private function CheckRequired($behaviours){
        foreach($behaviours as $key => $value){
            if($value == 'yes' && $this->{$key} == '')
            {
                $this->verdict[] = $this->labels[$key] . ' is required';
            }
        }
    }
    
    private function CheckLength($behaviours){
        foreach($behaviours as $key => $value){
            if(strlen($this->{$key}) > $value)
            {
                $this->verdict[] = $this->labels[$key] . ' has maximum length is '. $value;
            }
        }
    }    
    
    private function CheckNumeric($behaviours){
        foreach($behaviours as $key => $value){
            if($value == 'yes' && !is_numeric($this->{$key}))
            {
                $this->verdict[] = $this->labels[$key] . ' is not numeric ';
            }
        }
    }
    
    private function CheckEmail($behaviours){
        foreach($behaviours as $key => $value){
            if($value == 'yes' && !filter_var($this->{$key}, FILTER_VALIDATE_EMAIL))
            {
                $this->verdict[] = $this->labels[$key] . ' is not a valid email';
            }
        }
    }
    
    private function CheckSimilar($behaviours){
        foreach($behaviours as $key => $value){
            if($this->{$key} != $this->{$value})
            {
                $this->verdict[] = $this->labels[$key] . ' is not thesame as ' .$this->labels[$value];
            }
        }
    }
}
