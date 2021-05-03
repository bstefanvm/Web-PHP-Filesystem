<?php
require_once "../varpath.php";
$fUserEntry = strval(trim(htmlspecialchars($userEntry, ENT_QUOTES)));

$fileUserEntry = fopen($fUserEntry, "r");
while(!FEOF($fileUserEntry))  {
	$lineCheck = fgets($fileUserEntry);
	$checkUserEntry = explode("|", $lineCheck);
	foreach($checkUserEntry as $eUserEntry) {
		echo $eUserEntry . "<br>";
	}
}
fclose($fileUserEntry);

?>
