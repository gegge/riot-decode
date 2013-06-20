<?php
use riotDecode\raf\ExtractedRiotArchiveFileEntry;
// setup php environment
ini_set("memory_limit","512M");
set_time_limit(0);
spl_autoload_register();

$start_time = microtime(true);
// create game folder object
//$gameFolder = new \riotDecode\GameFolder('D:\\9_Perso\\jeux\\Riot\\League of Legends\\');
$gameFolder = 'D:\\9_Perso\\LOL\\GlobalDumped';

$p = null;
$dir = $gameFolder;

if (isset($_REQUEST["current"]))
{
	$p = $_REQUEST["current"];
	$dir = $gameFolder. DIRECTORY_SEPARATOR . $p;
}	

$indexed = array();
$count = 0;
function indexDir(&$count, &$indexed, $dir)
{
	if (is_dir($dir))
	{
		$cdir = scandir($dir);
		foreach ($cdir as $key => $value)
		{
			if (!in_array($value,array(".","..")))
			{
				indexDir($count, $indexed, $dir . DIRECTORY_SEPARATOR . $value);
			}
		}
	}
	else 
	{
		$gameFile = new ExtractedRiotArchiveFileEntry(null, $dir, 0, 0, null);
		$decodedFile = $gameFile->decode();
		
		if ($decodedFile instanceof \riotDecode\common\BaseFile)
		{
			if ($decodedFile->isIndexable())
			{
				echo "indexing : " . $dir . "<br>";
				$indexed[$dir] = $decodedFile->getValues();
				$count++;
			}
		}
	}
}

	
echo("ROOT :". $dir . "<br><br>");

indexDir($count, $indexed, $dir);

echo("INDEXING DONE<br><br>");

$file=fopen("riotDecode/_private/indexed",'w');
fwrite($file, serialize($indexed));
fclose($file);
?>

This index was builded in <?php echo(number_format(microtime(true) - $start_time, 2)); ?> seconds / <?php echo($count); ?> Files