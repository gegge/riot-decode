<?php
namespace riotDecode\dds;

use riotDecode\common\BaseFile;

class DdsFile extends BaseFile {
	
	const READDXT_PATH = null;
	//const READDXT_PATH = "\"C:\\Program Files (x86)\\NVIDIA Corporation\\DDS Utilities\\readdxt.exe\"";
		
	const CONVERT_PATH = null;
	//const CONVERT_PATH = "\"C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe\"";
	
	public function __construct($file) {
		parent::__construct($file);
	}

	public function &getValues($translateKeys = true) {
	
    	if ($this->values == null)
    	{
    		if (self::READDXT_PATH!=null && self::CONVERT_PATH!=null)
    		{
    			$pinfo = pathinfo($this->file->getPath());
    			 
	    		$tmpFile = fopen(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.dds', "w+");
	    		fwrite($tmpFile, $this->loadFileContent());
	    		fclose($tmpFile);
	    		
	    		$command = self::READDXT_PATH . " riotdecode/dds/_private/tmp.dds";
	    		$result = `$command`;
	    			    		
	    		$command = self::CONVERT_PATH . " riotdecode/dds/_private/tmp00.tga riotdecode/dds/_private/".$pinfo['filename'].".jpg";;
	    		$result = `$command`;
	    		
	    		$this->values["content"]["dds"]="riotDecode/dds/_private/".$pinfo['filename'].".jpg";
	    		
	    		while (!file_exists($this->values["content"]["dds"])){}
	    		
	    		unlink(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.dds');
	    		unlink(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp00.tga');
    		}
    		else 
    		{
    			$this->values["content"]["dds"] = str_replace("\r\n", "<br>", file_get_contents("./riotDecode/dds/_private/README.txt"));
    		}
    		
    		ksort($this->values);
    	}
        return $this->values;
    }

    public function showValue($value)
    {
    	return ((self::READDXT_PATH!=null && self::CONVERT_PATH!=null)?'<img src="' . $value . '" border="0">':$value);
    }
    
}
?>