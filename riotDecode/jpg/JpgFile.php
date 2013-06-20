<?php
namespace riotDecode\jpg;

class JpgFile extends \riotDecode\gif\GifFile {
	public function __construct($file) {
		parent::__construct($file,"jpg");
	}
}
?>