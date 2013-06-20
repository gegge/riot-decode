<?php
namespace riotDecode\raf;

use riotDecode\unknown\UnknownFile;
use riotDecode\txt\TxtFile;

class ExtractedRiotArchiveFileEntry {
    protected $riotArchiveFile;

	protected $path;

	protected $dataSize;

	protected $dataOffset;

	protected $pathHash;

	public function __construct($riotArchiveFile, $path, $dataSize, $dataOffset, $pathHash) {
		$this->riotArchiveFile = $riotArchiveFile;
		$this->path            = $path;
		$this->dataSize        = $dataSize;
		$this->dataOffset      = $dataOffset;
		$this->pathHash        = $pathHash;
	}

	public function getRiotArchiveFile() {
		return $this->riotArchiveFile;
	}

	public function getPath() {
		return $this->path;
	}

	public function getDataSize() {
		return $this->dataSize;
	}

	public function getDataOffset() {
		return $this->dataOffset;
	}

	public function getPathHash() {
		return $this->pathHash;
	}

	public function getContent() {
		return file_get_contents($this->path);
	}

	public function decode() {
		$pathInfo = \pathinfo($this->path);

		if(!isset($pathInfo['extension']) || $pathInfo['extension'] == '') {
			//throw new \Exception('can not auto decode files without file extensions');
			return new TxtFile($this);
		} else {
			$decoderClassName = '\\riotDecode\\' . $pathInfo['extension'] . '\\' . strtoupper($pathInfo['extension'][0]) . substr($pathInfo['extension'], 1) . 'File';
			
			try {
				if(class_exists($decoderClassName, true)) {
					return new $decoderClassName($this);
				} else {
					throw new \Exception("no decoder for " . $pathInfo['extension'] . " files found");
				}
			} catch(\Exception $exception) {
				//throw new \Exception("no decoder for " . $pathInfo['extension'] . " files found");
				return new UnknownFile($this, $pathInfo['extension']);
			}
		}
	}
}
?>