<?php

namespace com\ddocc\base\entity;

use com\ddocc\base\utility\Gizmo;
use com\ddocc\base\utility\Session;

class EntityBase {

    var $verdict;
    var $statusflag;
    var $date_added;
    var $last_updated;

    function Rules() {
        $rules = array();
        return $rules;
    }

    public function castAs($newClass) {
        $obj = new $newClass;
        foreach (get_object_vars($this) as $key => $name) {
            $obj->$key = $name;
        }
        return $obj;
    }

    public function SetPost($post_array, $fields, $csrf = 1) {
        foreach ($fields as $name) {
            if (isset($post_array[$name])) {
                $this->{$name} = Gizmo::Clean($post_array[$name]);
            }
        }
        if (property_exists($this, 'last_updated')) {
            $this->last_updated = Gizmo::Now();
        }
        if (property_exists($this, 'created_at')) {
            $this->updated_at = Gizmo::Now();
        }
        $rules = $this->Rules();
        $this->verdict = array();
        foreach ($rules as $keys => $behaviours) {
            switch ($keys) {
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
                case 'fixed':
                    $this->CheckFixedLength($behaviours);
                    break;
                case 'date':
                    $this->CheckDate($behaviours);
                    break;
                case 'positive':
                    $this->CheckPositiveNumeric($behaviours);
                    break;
            }
        }
        if (count($this->verdict) > 0) {
            return implode('<br />', $this->verdict);
        }
        if ($csrf == 1) {
            if (Session::Get('token_' . $post_array['action']) != $post_array['token']) {
                return 'Invalid form data';
            }
        }
        return '';
    }

    private function CheckRequired($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($value == 'yes' && $this->{$key} == '') {
                $this->verdict[] = $this->labels[$key] . ' is required';
            }
        }
    }

    private function CheckLength($behaviours) {
        foreach ($behaviours as $key => $value) {
            if (strlen($this->{$key}) > $value) {
                $this->verdict[] = $this->labels[$key] . ' has maximum length of ' . $value;
            }
        }
    }

    private function CheckNumeric($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($value == 'yes' && !is_numeric($this->{$key})) {
                $this->verdict[] = $this->labels[$key] . ' is not numeric ';
            }
        }
    }
    
    private function CheckPositiveNumeric($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($value == 'yes' && (floatval($this->{$key}) <= floatval(0)) ) {
                $this->verdict[] = $this->labels[$key] . ' should be greater than Zero';
            }
        }
    }

    private function IsDate($test_date) {
        try {
            $test_arr = explode('-', $test_date);
            if(count($test_arr)< 3){
                return FALSE;
            }           
            if(!is_numeric($test_arr[1])){
                return false;
            }
            if(!is_numeric($test_arr[2])){
                return false;
            }
            if(!is_numeric($test_arr[0])){
                return false;
            }
            return checkdate($test_arr[1], $test_arr[2], $test_arr[0]);
        } catch (Exception $e) {
            
        }
        return false;
    }

    private function CheckDate($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($value == 'yes' && !$this->IsDate($this->{$key})) {
                $this->verdict[] = $this->labels[$key] . ' is not a valid date ';
            }
        }
    }

    private function CheckEmail($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($value == 'yes' && !filter_var($this->{$key}, FILTER_VALIDATE_EMAIL)) {
                $this->verdict[] = $this->labels[$key] . ' is not a valid email';
            }
        }
    }

    private function CheckSimilar($behaviours) {
        foreach ($behaviours as $key => $value) {
            if ($this->{$key} != $this->{$value}) {
                $this->verdict[] = $this->labels[$key] . ' is not thesame as ' . $this->labels[$value];
            }
        }
    }

    private function CheckFixedLength($behaviours) {
        foreach ($behaviours as $key => $value) {
            if (strlen($this->{$key}) != $value) {
                $this->verdict[] = $this->labels[$key] . ' must have character length ' . $value;
            }
        }
    }

}
