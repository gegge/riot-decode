@REM put the dargon install folder here
cd D:\9_Perso\LOL\Dargon
d:
start "Dargon Manager" "Dargon Manager.exe"

@REM wait
ping -w 10 123.123.123.123

@REM output path
dargon dump D:\9_Perso\LOL\GlobalDumped *

