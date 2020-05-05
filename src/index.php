**Getting Correct Process ID:-  
<?php  
//Get Operating System  
$OperatingSystem = php_uname('s');  
if($OperatingSystem == "Windows NT") {  
//**Works only for PHP 4 and above. proc_get_status() does not return correct PID so  
//work around is used as shown below..  
$descriptorspec = array (  
0 => array("pipe", "r"),  
1 => array("pipe", "w"),  
);  
  
//proc_open — Execute a command  
//'start /b' runs command in the background  
if ( is_resource( $prog = proc_open("start /b " . $runPath, $descriptorspec, $pipes, $startDir, NULL) ) )  
{  
//Get Parent process Id  
$ppid = proc_get_status($prog);  
$pid=$ppid['pid'];  
}  
else  
{  
echo("Failed to execute!");  
exit();  
}  
$output = array_filter(explode(" ", shell_exec("wmic process get parentprocessid,processid | find \"$pid\"")));  
array_pop($output);  
  
//Process Id is  
$pid = end($output);  
}  
else if($OperatingSystem == "Linux") {  
  
//**Works only for PHP 4 and above. proc_get_status() does not return correct PID so  
//work around is used as shown below..  
$descriptorspec = array (  
0 => array("pipe", "r"),  
1 => array("pipe", "w"),  
);  
  
//proc_open — Execute a command  
//'nohup' command line-utility will allow you to run command/process or shell script that can continue running in the background  
if (is_resource($prog = proc_open("nohup " . $runPath, $descriptorspec, $pipes, $startDir, NULL) ) )  
{  
//Get Parent process Id   
$ppid = proc_get_status($prog);  
$pid=$ppid['pid'];  
  
//Process Id is  
$pid=$pid+1;  
  
}  
else  
{  
echo("Failed to execute!");  
exit();  
}  
}  
?>  
  
  
** To Kill Windows or Linux process:-  
  
<?PHP  
$OperatingSystem = php_uname('s');   
if($OperatingSystem == "Windows NT") {  
//'F' to Force kill a process  
exec("taskkill /pid $pid /F");  
}  
else if($OperatingSystem == "Linux") {  
exec("kill -9 $pid");  
}  
  
