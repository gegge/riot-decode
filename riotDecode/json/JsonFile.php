<?php
namespace riotDecode\json;

use riotDecode\common\BaseFile;
use riotDecode\common\Formater;
class JsonFile extends BaseFile {
	public function __construct($file) {
		parent::__construct($file);
		$this->indexable = true;
	}
	
	public function &getValues($translateKeys = true) {
		if ($this->values == null)
		{
			$this->values["content"]["json"] = $this->loadFileContent();
			ksort($this->values);
		}
		return $this->values;
	}
	
	public function showValue($value)
	{
		return '<code class="prettyprint">'. Formater::json($value, true) . '</code>';
	}

}
?>