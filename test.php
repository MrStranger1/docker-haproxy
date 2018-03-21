<?php
#echo shell_exec("sudo -su www-data  ls /var/www/html/haproxy").'<br>';
#exec("./add.sh", $output);
#var_dump($output)


#exec('sudo -u www-data ./add.sh'); exit;
#system('sudo -u www-data /etc/init.d/haproxy stop'); exit;
#print exec('add.sh'); exit;
echo exec('sudo /etc/init.d/haproxy reload');

?>
