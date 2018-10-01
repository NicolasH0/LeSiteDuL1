<?php
date_default_timezone_set('Europe/Paris');
$currentTime = date('H:i:s');
$id = '1550';
$password = 'ert864f';
$wsdl = 'http://opendata.cts-strasbourg.fr/webservice_v4/Service.asmx?wsdl';
$namespace = 'http://www.cts-strasbourg.fr/';
$client = new SoapClient($wsdl,array('trace' => 1));
$creditentials = array(
'ID' => $id,
'MDP' => $password
);
$header = new SOAPHeader($namespace,'CredentialHeader',$creditentials,false);
$client->__setSoapHeaders($header);
// CODES ARRET : Quartier des quinzes : 522, Tanneries : 624
$params = [
	'CodeArret' => '624',
	'Mode' => 0,
	'Heure' => date('H:i'),
	'NbHoraires' => 5
];
try {
    $response = $client->rechercheProchainesArriveesWeb($params);
}
catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}
function getTimeInterval($horaireBus, $heureActuelle){
	$startTime = new DateTime($horaireBus);
	$endTime = new DateTime($heureActuelle);
	$duration = $startTime->diff($endTime);

	if($startTime > $endTime) {
		return $duration;
	}else{
		return false;
	}
}
$url = "http://www.lapetitepause.fr/";
$content = file_get_contents($url);
$first_step = explode( 'class="daily-menu"' , $content );
$second_step = explode("</ul>" , $first_step[1] );

?>