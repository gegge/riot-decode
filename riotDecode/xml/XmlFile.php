<?php
namespace riotDecode\xml;

use riotDecode\common\BaseFile;

class XmlFile extends BaseFile {

    public function __construct($file) {
        parent::__construct($file);
        $this->indexable = true;
    }

    public function &getValues($translateKeys = true) {
    	if ($this->values == null)
    	{
    		$this->values["content"]["xml"] = $this->loadFileContent();
    		ksort($this->values);
    	}
        return $this->values;
    }

    public function showValue($value)
    {
    	return '<textarea cols="100" rows="40" wrap="off">' . $value . '</textarea>';
    }
}
?>