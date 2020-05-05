<?#!/usr/bin/php5
# www.lsauer.com, 2012 lo sauer
# desc: kill a process on Linux, MacOS, Windows without a process-control library
#      in the php setup or environment
$kill = function($pid){ return stripos(php_uname('s'), 'win')>-1 
                        ? exec("taskkill /F /PID $pid") : exec("kill -9 $pid");
};
//e.g.
echo $kill(19008);
//> "Successfully terminated...."
array_map($kill, [19008,23012,1802,930]);

//killall: without using array_map and a boolean return value
$killall = function($pids){ $os=stripos(php_uname('s'), 'win')>-1; 
                           ($_=implode($os?' /PID ':' ',$pids)) or ($_=$pids);
                           return preg_match('/success|close/', 
                           $os ? exec("taskkill /F /PID $_") : exec("kill -9 $_"));
};
if( $killall([19008,23012,1802,930]) and $killall(19280)){
  echo "successfully killed all processes"
}
