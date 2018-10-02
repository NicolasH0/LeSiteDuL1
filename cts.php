<thead>
    <tr>
		<th scope="col"></th>
		<th scope="col">Arret</th>
		<th scope="col">Destination</th>
		<th scope="col">Horaire</th>
		<th scope="col">Arrive dans</th>
    </tr>
</thead>
<tbody>
<tr>

<?php
include 'functions.php';

if($_GET['destination'] == "rob"){

	foreach($response as $resp){
	foreach($resp->ListeArrivee as $bus){
		foreach($bus as $horaire){
			if($horaire->Destination == "L1 Robertsau Boecklin") {
				$duration = getTimeInterval($horaire->Horaire, $currentTime);
				echo '<tr>';
				echo '<td><img src="imgs/bus_v2.png" height="30" width="30"/></td>';
				echo '<td>Tanneries</td>';
				echo '<td  class="font-italic">'.$horaire->Destination.'</td>';
				echo '<td  class="font-italic">'.$horaire->Horaire.'</td>';
				if($duration != false && $duration->format("%H") != "00" && $duration->format("%I") != "00"){
					echo '<td  class="font-italic"><b>'.$duration->format("%H")."</b>h<b>".$duration->format("%I")."</b>min<b>".$duration->format("%S").'</b>s</td>';
				}else if($duration != false && $duration->format("%I") != "00"){
					echo '<td  class="font-italic"><b>'.$duration->format("%I")."</b>min<b>".$duration->format("%S").'</b>s</td>';
				}else if($duration != false){
					echo '<td  class="font-italic"><b>'.$duration->format("%S").'</b>s</td>';
				}
				else{
					echo '<td  class="font-italic"> Arrivé </td>';
				}
				echo '</tr>';
			}
		}
	}
}

}else if($_GET['destination'] == "lingo"){
	foreach($response as $resp){
		foreach($resp->ListeArrivee as $bus){
			foreach($bus as $horaire){
				if($horaire->Destination == "L1 Lingolsheim Alouettes") {
					$duration = getTimeInterval($horaire->Horaire, $currentTime);
					echo '<tr>';
					echo '<td><img src="imgs/bus_v2.png" height="30" width="30"/></td>';
					echo '<td>Quartier des Quinzes</td>';
					echo '<td  class="font-italic">'.$horaire->Destination.'</td>';
					echo '<td  class="font-italic">'.$horaire->Horaire.'</td>';
					if($duration != false && $duration->format("%H") != "00" && $duration->format("%I") != "00"){
						echo '<td  class="font-italic"><b>'.$duration->format("%H")."</b>h<b>".$duration->format("%I")."</b>min<b>".$duration->format("%S").'</b>s</td>';
					}else if($duration != false && $duration->format("%I") != "00"){
						echo '<td  class="font-italic"><b>'.$duration->format("%I")."</b>min<b>".$duration->format("%S").'</b>s</td>';
					}else if($duration != false){
						echo '<td  class="font-italic"><b>'.$duration->format("%S").'</b>s</td>';
					}
					else{
						echo '<td  class="font-italic"> Arrivé </td>';
					}
					echo '</tr>';
				}
			}
		}
	}
}

?>

</tr>
</tbody>