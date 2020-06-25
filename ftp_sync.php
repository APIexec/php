<?php

echo 'Sync<br>';

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
	
// set up basic connection
$conn_id = ftp_connect($ipAddress); //ipaddress or FQDN

//check to see if server is responding
if($conn_id){

// login with username and password
$login_result = ftp_login($conn_id, $userName, $passWord);

$remote_dir=''; //ftp root on File Server (specified in ftp server config)
$local_dir='c:/Apache24/htdocs/library/'; // local starting directory

// get the file list for /
function getFiles($conn_id, $remote_dir, $local_dir) {
$file_list = ftp_nlist($conn_id, $remote_dir);
foreach ($file_list as $file)
{
  //echo "<br>$file";
  $res = ftp_size($conn_id, $file);
	$local_file = $local_dir.$file;
	if ($res != -1) {
		//echo "<br>$file";
		if (file_exists($local_file)){
			echo $local_file.'<br>';
		} else {
			ftp_get($conn_id, $local_file, $file, FTP_BINARY);
		}
	} else {
		if (@!mkdir($local_file, 0777, true)) {
			
		}
		getFiles($conn_id, $file, $local_dir);
	}
}
}



getFiles($conn_id, $remote_dir, $local_dir);

//removeFiles($conn_id, $local_dir);

// close the connection
ftp_close($conn_id);



} else {
	echo 'FTP Server not responding';
}
?>
