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
$repl = $gameFolder."\\";
$search = null;
if (isset($_REQUEST["search"]))
	$search = $_REQUEST["search"];



?>

<html>
	<body>
	<form name="srch" id="srch">
		<input type="text" name="search"/>
		<input type="submit" value="SEARCH"/>
	</form>
	<br>
<?php

if ($search!=null)
{
	$foundOne = false;
	$indexed = unserialize( file_get_contents( "riotDecode/_private/indexed" ) );
	
	foreach($indexed as $file => $subarray)
	{
		$match = false;
				
		foreach($subarray as $groupname => $proparray)
		{
			foreach($proparray as $prop => $value)
			{
				
				if (is_array($prop))
					$prop = join(",", $prop);
				if (is_array($value))
					$value = join(",", $value);
				
				if (stristr($prop, $search) !== FALSE ||  stristr($value, $search) !== FALSE)
				{
					$prm = str_replace($repl, "", $file);
					echo '<a href="explorer.php?current='.$prm.'" target="_blank">'.$file.'</a><br>';
					$match = true;
					$foundOne = true;
					break;
				}
			}
			
			if ($match)
				break;
		}
	}
}
?>	
	<br>
	This search was done in <?php echo(number_format(microtime(true) - $start_time, 2)); ?> seconds
	</body>
</html>

