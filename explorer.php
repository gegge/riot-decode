<html>
	<head>
		<script src="google-code-prettify/run_prettify.js"></script>
	</head>
	<body onload="prettyPrint();">
<?php
use riotDecode\raf\ExtractedRiotArchiveFileEntry;
// setup php environment
set_time_limit(0);
spl_autoload_register();

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

echo("ROOT :". $dir . "<br><br>");

if (is_dir($dir))
{
	$cdir = scandir($dir);
	foreach ($cdir as $key => $value)
	{
		$cur = $value;
		
		if (isset($_REQUEST["current"]))
			$cur = $p. DIRECTORY_SEPARATOR . $cur;
		
		if (!in_array($value,array(".","..")))
		{
			if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
			{
				echo "<a href='explorer.php?current=". urlencode($cur)."'>DIR:".$value."</a><br>";
			}
			else
			{
				echo "<a href='explorer.php?current=". urlencode($cur)."'>FIL:".$value."</a><br>";
			}
		}
	}
}
else 
{
	$gameFile = new ExtractedRiotArchiveFileEntry(null, $dir, 0, 0, null);
	$decodedFile = $gameFile->decode();

	echo $decodedFile;
}
	

?>
	</body>
</html>