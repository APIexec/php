<?php

echo 'Prune<br>';

// set up basic connection
$conn_id = ftp_connect($ipAddress);




// login with username and password
$login_result = ftp_login($conn_id, $userName, $passWord);


$path2 = ''; //local relative directory
$path1 = ''; //remote relative directory

$objects_dest = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path2), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects_dest as $name_source => $object){
    
	$findme = '\.';
	$pos = strpos($name_source, $findme);
	if ($pos === false) {
	
		if (is_file($name_source)) {
		
		$name_dest = substr($name_source, 14);
		echo $name_dest.'<br>';
		
			if (file_exists($name_source)){
				echo $name_source.'<br>';
				$res = ftp_size($conn_id, $name_dest);

				if ($res != -1) {
					echo "size of $name_source is $res bytes<br>";
				} else {
					echo "couldn't get the size<br>";
					// Use unlink() function to delete a file  
					if (!unlink($name_source)) {  
						echo ("$name_source cannot be deleted due to an error");  
					}  
					else {  
						echo ("$name_source has been deleted");  
					} 
				}
				
			}
				
		}
	}

}
?>
