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
    //var_dump(date('H:i'));
}
catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}

function getTimeInterval($horaireBus, $heureActuelle){
	$startTime = new DateTime($horaireBus);
	$endTime = new DateTime($heureActuelle);
	$duration = $startTime->diff($endTime); //$duration is a DateInterval object

	if($startTime > $endTime) {
		return $duration;
	}else{
		return false;
	}

}
$url = "http://www.lapetitepause.fr/";
$content = file_get_contents($url);
$first_step = explode( 'class="daily-menu"' , $content ); // So you will get two array elements

$second_step = explode("</ul>" , $first_step[1] ); // "1" depends, if you have more elements with this id (theoretical)



?>

<html>
<head>
	<title>Le site du L1</title>
	<link rel="stylesheet" href="lib/bootstrap4/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Norican" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="lib/bootstrap4/js/bootstrap.min.js"></script>
</head>
<img id="image" src="imgs/L1.png" width="115" height="59"  style="z-index: 800" />

<img style="opacity: 0.8;" id="l1" src="imgs/L1_reversed.png" width="413" height="158"/>
<img style="opacity: 0.8;" id="l1run" src="imgs/run.gif" width="150" height="150"/>
<img style="opacity: 0.8;" id="l1run2" src="imgs/run2.gif" width="150" height="150"/>

	<body style="background-color:#212529;">
		<div class="centrer">
			<h1 style="font-family: Righteous">Le site du L1</h1>
		</div>
		<br>
		<div class="centrer">
			<h5 style="font-family: Righteous"><i>Le plus beau bus de Strasbourg</i></h5>
		</div>
	<div class="col">

	<div class="col-md-5" style="float : left; margin-top: 100px; position: relative; padding: 0 !important;">
		<div class="textblock col" style="position: absolute; z-index: 20; top: 21%; right: 4%; width: 86%">
			<?php echo $second_step[0]; ?>
			<span class="bonWeek" style="color: white;font-size: 50px;font-family: Norican;text-align: center;text-transform: capitalize; font-weight: bold;">Bon Week' !</span>
		</div>
		<img id="sandwich" src="imgs/sandwich.png" width="115" height="59"  style="z-index: 800; position: absolute;" />

		<div class="imageblock col" style="z-index: 10; width: 100%">
			<img  id="menuImg" src="imgs/menu.jpg" width="680" height="100%" style="position: relative; width:105%"/>
		</div>
	</div>
	<div class="col-md-7" style="float : right;  padding: 0 !important;">
		<table class="table table-dark text-center" style="margin-top:100px">
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
					?>
				</tr>
			</tbody>
		</table>

		<?php
		$params = [
			'CodeArret' => '522',
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
		?>
		<table class="table table-dark text-center table-layout:fixed" style="margin-top:50px">
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
					?>
				</tr>
			</tbody>
		</table>
	</div>
	</div>
<script>
	$(document).ready(function() {

		var keys = "";
		$(document).keydown(function (e) {
		    if(e.keyCode == 79){
		    	keys += "o";
		    }else if(e.keyCode == 70){
		    	keys += "f";
		    }else{
		    	keys = "";
		    }
		});

		$(document).keyup(function (e) {
    		oof();
		});

		function oof() {
		$('#out').html(keys);
			if(keys == "oof"){
	    		var roblox = "sounds/oof.mp3";
				new Audio(roblox).play();
	      		keys = "";
		    }else if(keys.length == 3){
		    	keys = "";
		    }
		}

		rotateSandwich();
		$("#image").css("z-index", "800");
		$(".daily-menu").hide();
		$("h2").hide();
		$("p").hide();
		$("ul").addClass("menu");
		$(".menu").addClass("list-group");

		$(".menu li").addClass("dayliMenu")
		$(".menu").css("height", "100%");
		$(".menu").css("width", "95%");
		$(".menu").css("list-style", "none");

		$('.menu li').text(function(_, txt) {
		    return txt.charAt(0).toUpperCase() + txt.slice(1).toLowerCase();
		});
		$(".menu li").addClass("list-group-item");
		$(".menu li").css("background-color", "transparent");
		$(".menu li").css("border", "0");
		$(".menu li").css("color","white");
		$(".menu li").css("font-size","18px");
		$(".menu li").css("font-family","Norican");
		$(".menu li").css("text-align", "center");
	    $(".menu li").each(function() {
	        var text = $(this).text();
	        var arr = text.split(":")
	        $(this).html("<span class='plat' style='font-size: 42px; font-weight: bold'>"+arr[0]+':' + "</span></br>" + arr[1]);
	    });
		$(".menu li").css("text-transform", "capitalize");
		$('body').hide().fadeIn(500);
	});


	$(document).mousemove(function(e){
	   $("#image").css({left:e.pageX, top:e.pageY});
	});
	var klaxon = "sounds/klaxon.wav";
	$('body').click(function() {
		new Audio(klaxon).play();
	});
	var marginleft = 0;
	function moveL1() {
		$('#l1').css({left:'-40%'});
        $('#l1').animate ({
            left: '+=150%',
        }, 5000, 'linear', function() {
            moveL1();
        });
	}
	function rotateSandwich() {
		$("#sandwich").animate({left:'92%'}, 600);
		$("#sandwich").animate({top:'95%'}, 600);
		$("#sandwich").animate({left:'0%', right:'105%'}, 600);
		$("#sandwich").animate({top:'0%', bottom:'100%'}, 600);
		setTimeout(rotateSandwich, 600);
	}
	function moveMan() {
		$('#l1run').css({left:'-50%'});
        $('#l1run').animate ({
            left: '+=150%',
        }, 5000, 'linear', function() {
            moveMan();
        });
	}
	function moveMan2() {
		$('#l1run2').css({left:'-15%'});
        $('#l1run2').animate ({
            left: '+=150%',
        }, 5000, 'linear', function() {
            moveMan2();
        });
	}
	$(document).ready(function(){
		moveL1();
		moveMan();
		moveMan2();
	});
</script>
</body>
</div>
</html>