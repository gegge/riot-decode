<?php
namespace riotDecode\unknown;

use riotDecode\common\BaseFile;
class UnknownFile extends BaseFile {
    protected $ext;
	public function __construct($file, $extension) {
		parent::__construct($file);
		$this->ext = $extension;
	}
	
	public function &getValues($translateKeys = true) {
		if ($this->values == null)
		{
			$this->values["content"]["unknow"] = "File type not supported (". $this->ext.")";
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