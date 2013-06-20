<?php
namespace riotDecode\raf;

class ExtractedRiotArchiveFile implements \IteratorAggregate, \Countable {
    protected $path;

	protected $magicNumber;

	protected $version;

	protected $managerIndex;

	protected $files = [];

	public function __construct($path) {
		$this->path = $path;
	}

	private function dirToArray($dir) {
	
		$result = array();
	
		$cdir = scandir($dir);
		foreach ($cdir as $key => $value)
		{
			if (!in_array($value,array(".","..")))
			{
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
				{
					$this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
				}
				else
				{
					$p = $dir . DIRECTORY_SEPARATOR . $value;
					$this->files[$p] = 
					new ExtractedRiotArchiveFileEntry($this, $p, 0, 0, 0);
				}
			}
		}
	
	}
	
	protected function parseFile() {
		if($this->magicNumber === null) {
			$this->dirToArray($this->path);
			$this->magicNumber = 1;
			
		}
	}

	public function __destruct() {
		if($this->magicNumber !== null) {
			//fclose($this->dataFileHandle);
		}
	}

	public function getPath() {
		return $this->path;
	}

	public function getMagicNumber() {
		$this->parseFile();

		return $this->magicNumber;
	}
	
	public function getVersion() {
		$this->parseFile();

		return $this->version;
	}

	public function getManagerIndex() {
		$this->parseFile();

		return $this->managerIndex;
	}

	public function getFiles($regex = null) {
		$this->parseFile();

		if($regex === null) {
			return $this->files;
		} else {

			$result = [];
			$regex = str_replace("/", "\\", $regex);
			foreach($this->files as $key => $value) {
				if(strpos($key,$regex) !== false) {
					$result[$key] = $value;
				}
			}

			return $result;
		}
	}

	public function getFile($filePath) {
		$this->parseFile();

		return $this->files[$filePath];
	}

	public function extract($targetDirectory) {
		$this->parseFile();

		$targetDirectory = preg_replace("![\\\\//]+$!", "", $targetDirectory);

		foreach($this as $riotArchiveFileEntry) {
			if(!file_exists($dirName = dirname($targetDirectory . DIRECTORY_SEPARATOR . $riotArchiveFileEntry->getPath()))) {
				mkdir($dirName, 0777, true) or die('COULD NOT CREATE DIRECTORY: ' . $dirName);
			}

			$file = @fopen($targetDirectory . DIRECTORY_SEPARATOR . $riotArchiveFileEntry->getPath(), 'w+') or die('COULD NOT CREATE FILE: ' . $targetDirectory . DIRECTORY_SEPARATOR . $riotArchiveFileEntry->getPath());
			fwrite($file, $riotArchiveFileEntry->getContent());
			fclose($file);
		}
	}

	public function getIterator() {
		$this->parseFile();

		return new \ArrayIterator($this->files);
	}

	public function count() {
		$this->parseFile();

		return sizeof($this->files);
	}
}
?>