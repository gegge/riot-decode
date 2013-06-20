<?php
namespace riotDecode\luaobj;

use riotDecode\common\BaseFile;
class LuaobjFile extends BaseFile {
	

	public function __construct($file) {
		parent::__construct($file);
		$this->indexable = true;
	}

	public function &getValues($translateKeys = true) {
    	if ($this->values == null)
    	{
    		$tmpFile = fopen(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.luaobj', "w+");
    		fwrite($tmpFile, $this->loadFileContent());
    		fclose($tmpFile);
    		
    		$command = getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'luadec.exe "' . getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.luaobj' . '"';
    		$result = `$command`;
    		
    		$this->values["content"]["Decompiled"]=$result;
    		
    		
    		$command = getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'luadec.exe -dg -dis "' . getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.luaobj' . '"';
    		$result = `$command`;
    		
    		$this->values["content"]["Disassembled"]=$result;
    		
    		unlink(getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('\\', __NAMESPACE__)) . DIRECTORY_SEPARATOR . '_private' . DIRECTORY_SEPARATOR . 'tmp.luaobj');
    		
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