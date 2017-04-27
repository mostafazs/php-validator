<?php 
/**
* 
* PHP Form Validator
* 
* @author Mostafa Ziasistani <mostafas.dev@gmail.com>
* @license MIT
* @version 1.1.0
**/
namespace Mostafazs;

class Validator {
	
	var $valid = false;
	var $errors = array();
	var $request = array();
	
	function Validator($POST) {
		$this->request = $POST;
	}
	
	//check if a field or fields are filled in @TODO fuck we have error here 
	//ERROR: 100
	function filledIn($field = null) {
		if(is_array($field)) {
			foreach ($field as $key => $value){
				if(array_key_exists($value, $this->request) && $this->request[$value] != "") {
					$this->valid = true;
				} elseif($this->request[$value] === 0) {
					$this->valid=true;
				} else {
					$this->setError($value, 100);
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 100) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} elseif ($field == null){
			foreach ($this->request as $key => $value) {
				if(array_key_exists($value, $this->request) && $this->request[$value] != "") {
					return true;
				} elseif($this->request[$value] === 0) {
					return true;
				} else {
					$this->setError($value, 100);
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 100) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} else {
			if($field != "" || !empty($field) ) {
				return true;
			} else {
				$this->setError($field, 100);
				return false;
			}
		}
	}
	
	//length functions on a field takes <, >, =, <=, and >= as operators
	//ERROR: 101
	function length($field, $operator, $length) {
		switch($operator) {
			case "<":
				if(strlen(trim($field)) < $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
				break;
			case ">":
				if(strlen(trim($field)) > $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
				break;
			case "=":			
				if(strlen(trim($field)) == $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
				break;
			case "<=":
				if(strlen(trim($field)) <= $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
				break;
			case ">=":
				if(strlen(trim($field)) >= $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
				break;
			default:
				if(strlen(trim($field)) < $length) {
					return true;
				} else {
					$this->setError($field, 101);
					return false;
				}
		}
	}
	
	//check to see if valid email address
	//ERROR: 102
	function email($field){
		$address = trim($field);
		if (filter_var($address, FILTER_VALIDATE_EMAIL)){
			return true;
		}else{
			$this->setError($field, 102);
			return false;
		}
	}
	
	//check to see if two fields are equal
	//ERROR: 103
	function compare($field1, $field2, $caseSensitive = false) {
		if($caseSensitive) {
			if (strcmp($field1, $field2) == 0) {
				return true;
			} else {
				$this->setError($field1."|".$field2, 103);
				return false;
			}
		} else {
			var_dump(strcmp($field1, $field2));
			if ( strtolower($field1) == strtolower($field2) ) {
				return true;
			} else {
				$this->setError($field1."|".$field2, 103);
				return false;
			}
		}
	}
	
	//check to see if the length of a field is between two numbers
	//ERROR: 104
	function lengthBetween($field, $min, $max, $inclusive = false){
		if(!$inclusive){
			if(strlen(trim($field)) < $max && strlen(trim($field)) > $min) {
				return true;
			} else {
				$this->setError($field, 104);
				return false;
			}
		} else {
			if(strlen(trim($field)) <= $max && strlen(trim($field)) >= $min) {
				return true;
			} else {
				$this->setError($field, 104);
				return false;
			}			
		}
	}
	
	//check to see if there is punctuation
	//ERROR: 105
	function punctuation($field = null) {
		
	}
	
	//number value functions takes <, >, =, <=, and >= and === as operators
	//ERROR: 106
	function value($field, $operator, $length) {
		switch($operator) {
			case "<":
				if($field < $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			case ">":
				if($field > $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			case "=":			
				if($field == $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			case "<=":
				if($field <= $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			case ">=":
				if($field >= $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			case "===":
				if($field === $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
				break;
			default:
				if($field < $length) {
					return true;
				} else {
					$this->setError($field, 106);
					return false;
				}
		}		
	}
	
	//check if a number value is between $max and $min
	//ERROR: 107
	function valueBetween($field, $min, $max, $inclusive = false){
		if(!$inclusive){
			if($field < $max && $field > $min) {
				return true;
			} else {
				$this->setError($field, 107);
				return false;
			}
		} else {
			if($field <= $max && $field >= $min) {
				return true;
			} else {
				$this->setError($field, 107);
				return false;
			}			
		}
	}
	
	//check if a field contains only alphabetic characters
	//ERROR: 108
	function alpha($field = null) {
		if(is_array($field)) {
			foreach ($field as $key => $value){
				$strlen = strlen($this->request[$value]);
				if($strlen > 0) {
					if(!preg_match("/^[a-zA-Z]/", $this->request[$value])) {
						$this->setError($value, 108);
					} 
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 108) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} elseif ($field == null) {
			foreach ($this->request as $key => $value) {
				$strlen = strlen($value);
				if($strlen > 0) {
					if(!preg_match("/^[a-zA-Z]/", $value)) {
						$this->setError($key, 108);
					}
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 108) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} else {
			$strlen = strlen($field);
			if($strlen > 0) {
				if(preg_match("/^[a-zA-Z]/", $field)) {
					return true;
				} else {
					$this->setError($field, 108);
					return false;
				}
			}
		}
	}
	
	//check if a field contains only alphanumeric characters
	//ERROR: 109
	function alphaNumeric($field = null) {
		if(is_array($field)) {
			foreach ($field as $key => $value){
				$strlen = strlen($this->request[$value]);
				if($strlen > 0) {
					if(!preg_match("/^[a-zA-Z0-9]/", $this->request[$value])) {
						$this->setError($value, 109);
					} 
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 109) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} elseif ($field == null) {
			foreach ($this->request as $key => $value) {
				$strlen = strlen($value);
				if($strlen > 0) {
					if(!preg_match("/^[a-zA-Z0-9]/", $value)) {
						$this->setError($key, 109);
					}
				}
			}
			foreach ($this->errors as $key => $value){
				if($value == 109) {
					$this->valid = false;
				}
			}
			if($this->valid) {
				$this->resetValid();
				return true;
			} else {
				$this->resetValid();
				return false;
			}
		} else {
			//$strlen = strlen($this->request[$field]);
			$strlen = strlen($field);
			if($strlen > 0) {
				
				if( preg_match("/^[a-zA-Z0-9]/",$field) ) {
					return true;
				} else {
					$this->setError($field, 109);
					return false;
				}
			}
		}
	}
	
	//check if field is a date by specified format
	//acceptable separators are "/" "." "-" 
	//acceptable formats use "m" for month, "d" for day, "y" for year
	//eg: date("date", "mm.dd.yyyy") will match a field called "date" containing 01-12.01-31.nnnn where n is any real number
	//ERROR: 110
	function date($field, $format) {
		$month = false;
		$day = false;
		$year = false;
		$monthPos = null;
		$dayPos = null;
		$yearPos = null;
		$monthNum = null;
		$dayNum = null;
		$yearNum = null;
		$separator = null;
		$separatorCount = null;
		$fieldSeparatorCount = null;
		$formatArray = array();
		$dateArray = array();
		
		//determine the separator
		if(strstr($format, "-")) {
			$separator = "-";
			$this->valid = true;
		} elseif (strstr($format, ".")) {
			$separator = ".";
			$this->valid = true;
		} elseif (strstr($format, "/")) {
			$separator = "/";
			$this->valid = true;
		}	else {
			$this->valid = false;
		}
		
		if($this->valid){
			//determine the number of separators in $format and $field
			$separatorCount = substr_count($format, $separator);
			$fieldSeparatorCount = substr_count($this->request[$field], $separator);
			
			//if number of separators in $format and $field don't match return false
			if(!strstr($this->request[$field], $separator) || $fieldSeparatorCount != $separatorCount) {
				$this->valid = false;
				//echo "Her error";
			} else {
				$this->valid = true;
			}
		}
		
		if($this->valid) {
			//explode $format into $formatArray and get the index of the day, month, and year
			//then get the number of occurances of either m, d, or y
			$formatArray = explode($separator, $format);
			//var_dump($formatArray);
			for($i = 0; $i < sizeof($formatArray); $i++) {
				if(strstr($formatArray[$i], "m")) {
					$monthPos = $i;
					$monthNum = substr_count($formatArray[$i], "m");
				} elseif (strstr($formatArray[$i], "d")) {
					$dayPos = $i;
					$dayNum = substr_count($formatArray[$i], "d");					
				} elseif (strstr($formatArray[$i], "y")) {
					$yearPos = $i;
					//var_dump($yearPos);
					$yearNum = substr_count($formatArray[$i], "y");
					//var_dump($yearNum);
				} else {
					$this->valid = false;
				}
			}
			
			//set whether $format uses day, month, year
			if($monthNum) {
				$month = true;
			} else {
				$month = false;
			}
			if($dayNum) {
				$day = true;
			} else {
				$day = false;
			}
			if($yearNum) {
				$year = true;
			} else {
				$year = false;
			}
			
			//explode date field into $dateArray
			//check if the monthNum, dayNum, and yearNum match appropriately to the $dateArray
			$dateArray = explode($separator, $this->request[$field]);
			//var_dump($dateArray);
			if($month) {
				//@TODO having error @[SOLVED]
				if(!preg_match("^[0-9]{".$monthNum."}^", $dateArray[$monthPos]) || $dateArray[$monthPos] > 12) {
					$this->valid = false;
				}
			}
			if($day) {
				//@TODO having error @[SOLVED]
				if(!preg_match("^[0-9]{".$dayNum."}^", $dateArray[$dayPos]) || $dateArray[$dayPos] > 31) {
					$this->valid = false;
				}
			}
			if($year) {
				//@TODO having error @[SOLVED]
				//var_dump($dateArray[$yearPos]);
				if (!preg_match("^[0-9]{".$yearNum."}^", $dateArray[$yearPos])) {
					$this->valid = false;
				}
			}
		}
		
		if ($this->valid) {
			$this->resetValid();
			return true;
		} else {
			$this->resetValid();
			$this->setError($field, 110);
			return false;
		}
	}
	
	//Error 113
	function Url($field){
	if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$field)) {
		return true;
	}else{
		$this->setError($field, 113);
		return false;
	  }
	}
	
	//check ip address 
	//@since 1.1.0
	function Ip($field,$version){
		if($version == "4"){
			if(self::isValidV4($field)){
				$this->valid = true;
			}else{
				$this->valid = false;
			}
		}else if($version == "6"){
			if(self::isValidV6($field)){
				$this->valid = true;
			}else{
				$this->valid = false;
			}
		}else{
			return false;
		}
		if($this->valid){
			return true;
		}else{
			return false;
		}
		
	}
	
	//@since 1.1.0
	private function isValidV4($value)
    {
        if (!preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $value, $matches)) {
            return false;
        }
        for ($i = 1; $i <= 4; ++$i) {
            if ($matches[$i] > 255) {
                return false;
            }
        }
        return true;
    }
	
	//@since 1.1.0
	private function isValidV6($value)
    {
        if (!preg_match('/^[0-9a-fA-F]{0,4}(:[0-9a-fA-F]{0,4}){1,5}((:[0-9a-fA-F]{0,4}){1,2}|:([\d\.]+))$/', $value, $matches)) {
            return false;
        }
        // allow V4 addresses mapped to V6
        if (isset($matches[4]) && !$this->isValidV4($matches[4])) {
            return false;
        }
        // "::" is only allowed once per address
        if (($offset = strpos($value, '::')) !== false) {
            if (strpos($value, '::', $offset + 1) !== false) {
                return false;
            }
        }
        return true;
    }
	
	//set errors here
	function setError($field, $error) {
		if(!key_exists($field, $this->errors) || $this->errors[$field] !== $error && !is_array($this->errors[$field])) {
			$tmpArray = array($field => $error);
			$this->errors = array_merge_recursive($this->errors, $tmpArray);	
			return true;
		} elseif(is_array($this->errors[$field])) {
			foreach ($this->errors[$field] as $value) {
				if($value == $error) {
					$this->duplicate = true;
				} else {
					$this->duplicate = false;	
				}
			}
			if(!$this->duplicate){
				$tmpArray = array($field => $error);
				$this->errors = array_merge_recursive($this->errors, $tmpArray);					
			}
		} else {
			$this->duplicate = false;
		}
	}
	
	//get validation errors
	function getErrors() {
		return $this->errors;
	}
	
	//get the validator id
	function getId() {
		return $this->validatorId;
	}
	
	//resets $valid to false
	function resetValid() {
		$this->valid = false;
	}
}
?>