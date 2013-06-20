<?php
namespace riotDecode\tga;

use riotDecode\common\BaseFile;

class TgaFile extends BaseFile {
	
	const CONVERT_PATH = null;
	//const CONVERT_PATH = "\"C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe\"";
	
	public function __construct($file) {
		parent::__construct($file);
	}

	public function &getValues($translateKeys = true) {
	
    	if ($this->values == null)
    	{
    		if (self::CONVERT_PATH!=null)
    		{
    			$pinfo = pathinfo($this->file->getPath());
    			 
	    		$tmpFile = fopen(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.tga', "w+");
	    		fwrite($tmpFile, $this->loadFileContent());
	    		fclose($tmpFile);
	    			    			    		
	    		$command = self::CONVERT_PATH . " riotdecode/tga/_private/tmp.tga riotdecode/tga/_private/".$pinfo['filename'].".jpg";;
	    		$result = `$command`;
	    		
	    		$this->values["content"]["tga"]="riotDecode/tga/_private/".$pinfo['filename'].".jpg";
	    		
	    		while (!file_exists($this->values["content"]["tga"])){}
	    		
	    		unlink(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.tga');
    		}
    		else 
    		{
    			$this->values["content"]["tga"] = str_replace("\r\n", "<br>", file_get_contents("./riotDecode/tga/_private/README.txt"));
    		}
    		
    		ksort($this->values);
    	}
        return $this->values;
    }
    
    public function showValue($value)
    {
    	return ((self::CONVERT_PATH!=null)?'<img src="' . $value . '" border="0">':$value);
    }
}
?>