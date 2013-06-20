@REM put the dargon install folder here
cd D:\9_Perso\LOL\Dargon
d:
start "Dargon Manager" "Dargon Manager.exe"

@REM wait
ping -w 10 123.123.123.123

@REM 200 is the max version update if needed
for /L %%i in (20,1,200) DO (

@REM output path
dargon dump D:\9_Perso\LOL\Dumped\0.0.%%i 0.0.%%i
)
