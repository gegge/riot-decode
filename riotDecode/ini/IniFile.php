<?php
namespace riotDecode\ini;

use riotDecode\common\BaseFile;
class IniFile extends BaseFile{

    public function __construct($file) {
        parent::__construct($file);
        $this->indexable = true;
    }

    public function &getValues($translateKeys = true) {
    	if ($this->values == null)
    	{
    		$content =$this->loadFileContent();
    		$this->values = parse_ini_string($content, true);
    		
    		if (count($this->values) == 0)
    			$this->values["content"]["all"] = str_replace("\r\n", "<br>", $content);
    		else 
    		{
    			$allEmpty = true;
    			foreach ($this->values as $key => $val)
    			{
    				if (count($val) > 0)
    				{
    					$allEmpty = false;
    					continue;
    				}
    			}
    			if ($allEmpty)
    			{
    				$this->values = array();
    				$this->values["content"]["all"] = str_replace("\r\n", "<br>", $content);
    			}
    		}
    		ksort($this->values);
    	}
        return $this->values;
    }
    
    public function showValue($value)
    {
    	return json_encode($value);
    }
}
?>