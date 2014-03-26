
<?php
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'Configure.php' );


$dbh = new PDO('mysql:host='.ACTIVA_DB_HOST.';dbname='.ACTIVA_DB_DATABASE, ACTIVA_DB_USER, ACTIVA_DB_PASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sth = $dbh->prepare( 'SELECT * FROM orders' );

$sth->execute();
var_dump($sth->fetch());

?>
