<?php
namespace com\ddocc\base\utility;


class Gadget
{		
	function calender($dtm,$name,$minyear,$maxyear)
	{
		$select = '';                              
		$dt = mktime(substr($dtm,11,2),substr($dtm,14,2),substr($dtm,17,2),	substr($dtm,5,2),substr($dtm,8,2),substr($dtm,0,4));
		$mon = array('','JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
		echo "<select name='calMonth_" . $name. "'>";
		for($i =1; $i < 13; $i++)
		{
			if ($i == date("n",$dt)) $select = "selected='selected'"; 
			echo "<option value='$i' $select>$mon[$i]</option>";
			$select = '';
		}
		echo "</select>";     
		echo "<select name='calDay_" . $name. "'>";
		for($i =1; $i < 32; $i++)
		{
			if ($i == date("j",$dt)) $select = "selected='selected'"; 
			echo "<option value='$i' $select>$i</option>";
			$select = '';
		}
		echo "</select>";      
		echo "<select name='calYear_" . $name. "'>";
		for($i = $maxyear; $i > $minyear; $i--)
		{
			if ($i == date("Y",$dt)) $select = "selected='selected'"; 
			echo "<option value='$i' $select>$i</option>";
			$select = '';
		}
		echo "</select>";     
	}
	
	function isValidEmail($email)
	{	
	    if(!preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/',$email)){
	        return false;
	    } else {
	        return true;
	    }
	}
	
	function generatePwd($cnt)
	{
		$n = "";
		$a = array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
		for($i = 0; $i <$cnt; $i++)
		{
			$n.= $a[rand(0, count($a)- 1)];
		}
		return $n;		
	}
	
	function prettyDate($dtm)
	{
		//yyyy-mm-dd hh:ii:ss
		$y = substr($dtm,0,4); 
		$m = substr($dtm,5,2);
		$d = substr($dtm,8,2);
		$h = substr($dtm,11,2);
		$i = substr($dtm,14,2);
		$s = substr($dtm,17,2);		
		$dt = mktime($h,$i,$s,$m,$d,$y);
		return date('F d, Y', $dt);
		//return $y;
	}
	
	function ToDate($y,$m,$d)
	{
		$dt = mktime(0,0,0,$m,$d,$y);
		return date("Y-m-d H:i:s",$dt);
	}

    function genKey($length) {
        if ($length > 0) {
            $rand_id = "";
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, 62);
                $rand_id .= Gizmo::GetChar($num);
            }
        }
        return $rand_id;
    }
}