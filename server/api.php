<?php

$mysql_s = "92.127.158.65";    #MySQL server
$mysql_u = "dc319_greeghouse";    #MySQL user
$mysql_p = 'n4z8YKCHZ82W';    #MySQL password
$mysql_d = "dc319_greeghouse";    #MySQL database
try {
	$db = new PDO('mysql:host='.$mysql_s.';dbname='.$mysql_d, $mysql_u, $mysql_p, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	exit($e->getMessage());
}



if ($_REQUEST['key'] == '30bJpP0R29epB7kofxF5WszPtP1fRJxWbVEf89bDXOFJpEJRMdvTN6ouqXOtg2bb' && isset($_REQUEST['type']) && isset($_REQUEST['data'])) {
	$db->query("INSERT INTO `logs`(`logtype`, `date`, `data`) VALUES (" . $db->quote($_REQUEST['type']) . ", " . $db->quote(time()) . ",". $db->quote($_REQUEST['data']) . ")");
	echo "SENDED";
} else {
	echo "ERROR";
}

?>
