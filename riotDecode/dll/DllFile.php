<?php
namespace riotDecode\dll;

use riotDecode\common\BaseFile;

class DllFile extends BaseFile {
	
	const VS_DRIVE = null;
	//const VS_DRIVE = "C:";
	const VS_PATH = null;
 	//const VS_PATH = "\"C:\\Program Files (x86)\\Microsoft Visual Studio 11.0\"";
	
	
    protected $file;
    protected $values;

	public function __construct($file) {
		parent::__construct($file);
		$this->indexable = true;
	}

public function &getValues($translateKeys = true) {
	
    	if ($this->values == null)
    	{
    		if (self::VS_PATH!=null && self::VS_DRIVE!=null)
    		{
    			$pinfo = pathinfo($this->file->getPath());
    			 
    			
    			// NEED TO ADD A COPY BUT DLL CAN BE HEAVY
	    		//$tmpFile = fopen(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.dll', "w+");
	    		//fwrite($tmpFile, $this->file->getContent());
	    		//fclose($tmpFile);
	    			    			    		
	    		$command = "riotDecode\\dll\_private\\vslaunchdb ".self::VS_DRIVE." ". self::VS_PATH . " \"".$this->file->getPath()."\"";
	    		$result1 = `$command`;
	    		
	    		$command = "riotDecode\\dll\_private\\vslaunchlnk ".self::VS_DRIVE." ". self::VS_PATH . " \"".$this->file->getPath()."\"";
	    		$result2 = `$command`;
	    		 
	    		
	    		$this->values["content"]["dumpbin /exports"]= str_replace("\n", "<br>", $result1);
	    		$this->values["content"]["link /dump /exports"]=str_replace("\n", "<br>", $result2);

    		}
    		else 
    		{
    			$this->values["content"]["config"] = str_replace("\r\n", "<br>", file_get_contents("./riotDecode/dll/_private/README.txt"));
    		}
    		
    		ksort($this->values);
    	}
        return $this->values;
    }

	public function showValue($value)
    {
    	return $value;
    }
	
}
?>