<?php
namespace riotDecode\gif;

use riotDecode\common\BaseFile;
class GifFile extends BaseFile {
	
	protected $ext = "gif";

	public function __construct($file, $ext = "gif") {
		parent::__construct($file);
		$this->ext = $ext;
	}

public function &getValues($translateKeys = true) {
	
    	if ($this->values == null)
    	{
    		$tmpFile = fopen(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', str_replace("gif", $this->ext, __NAMESPACE__))) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.'.$this->ext, "w+");
    		fwrite($tmpFile, $this->loadFileContent());
    		fclose($tmpFile);
    		
    		$this->values["content"][$this->ext]="riotDecode/".$this->ext."/_private/tmp.".$this->ext;
    		ksort($this->values);
    	}
        return $this->values;
    }
    
    public function showValue($value)
    {
    	return '<img src="' . $value . '" border="0">';
    }

	
}
?>