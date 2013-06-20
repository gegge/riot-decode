<?php
namespace riotDecode\common;

abstract class BaseFile implements \ArrayAccess {
	protected $indexable = false;
    protected $file;
    protected $values;

	public function __construct($file) {
		$this->file = $file;
	}
	
	public function isIndexable()
	{
		return $this->indexable;
	}
	
	public function loadFileContent()
	{
		return (method_exists($this->file,"getContent")) ? $this->file->getContent() : (@file_get_contents($this->file) or die('COULD NOT LOAD FILE CONTENT: ' . $this->file));
	}
	
	public abstract function &getValues($translateKeys = true);

	public abstract function showValue($value);
	
	
	public function __tostring() {
        $result = '<table border="0" cellspacing="0" cellpadding="3" style="font-size:11px;font-family:arial;sans-serif;width:100%">'
                .   '<thead>'
                .     '<tr>'
                .       '<td colspan="2" style="background-color:#c7e1f3;font-weight:bold;-moz-border-radius: 6px 6px 0 0;-webkit-border-radius: 6px 6px 0 0;border-radius: 6px 6px 0 0;border-bottom:1px solid #ffffff;text-align:center">' . $this->file->getPath() . '</td>'
                .     '</tr>'
                .   '</thead>'
                .   '<tbody>';

        $catValues = $this->getValues();
        ksort($catValues);
        foreach($catValues as $groupName => $values) {
            $result .= '<tr>';
            $result .=   '<td colspan="2" style="background-color:#d1ecff;font-weight:bold;border-bottom:1px solid #ffffff;text-align:center">' . $groupName . '</td>';
            $result .= '</tr>';

            ksort($values);
            foreach($values as $key => $value) {
                $result .= '<tr><td style="background-color:#edf6fd;border-bottom:1px solid #ffffff;white-space:nowrap;padding-right:40px">' . $key . '</td><td style="background-color:#f7f7f7;border-bottom:1px solid #ffffff;font-style:italic;width:100%">' . $this->showValue($value) . '</td></tr>';
            }
        }

        $result .=   '</tbody>'
                 . '</table>';

        return $result;
    }
    
    public function offsetExists($offset) {
    	return key_exists($offset, $this->getValues());
    }
    
    public function offsetGet($offset) {
    	return $this->getValues()[$offset];
    }
    
    public function offsetSet($offset, $value) {
    	$this->getValues()[$offset] = $value;
    }
    
    public function offsetUnset($offset) {
    	unset($this->getValues()[$offset]);
    }
}
?>