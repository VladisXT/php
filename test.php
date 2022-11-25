<?php
$dbname='fortz';
$dbuser='tz';
$dbpass='test';
$output=exec("docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -a -q)", $ipaddr);
$name=exec("docker ps -a -q", $id);
foreach (array_combine($ipaddr, $id) as $ip => $number) {
	$db_connection = mysqli_connect("$ip","$dbuser","$dbpass") or die (mysqli_error($db_connection));
	mysqli_select_db($db_connection, $dbname) or die(mysqli_error($db_connection));
	$result = mysqli_query($db_connection, "SELECT firstnames.firstname, lastnames.lastname FROM firstnames INNER JOIN lastnames ON firstnames.id=lastnames.id ORDER BY RAND() LIMIT 1") or die('error');
	while ($row = mysqli_fetch_row($result)) {
		echo "$row[0] $row[1] from $number\n";

	}
	mysqli_close($db_connection);
}
?> 
