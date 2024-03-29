<?php
include 'functions.php';
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
<img id="kebab" class="kebab" src="imgs/kebab.png" style="z-index: 900; position: absolute; display: none; width: 100px; height: 100px" />

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
			<img  id="menuImg" src="imgs/menu.jpg" width="680" height="100%" style="z-index: 800; position: relative; width: 105%"/>
		</div>
	</div>
	<div class="col-md-7" style="float : right;  padding: 0 !important;">
		<table class="table table-dark text-center" style="margin-top:100px" id="table_tanneries">
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
		<table class="table table-dark text-center table-layout:fixed" style="margin-top:50px" id="table_quartierDesQuinzes">
		</table>
	</div>
	</div>

<div id="win" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     	<img src="imgs/win.gif">
    </div>
  </div>
</div>

<div id="eric" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     	<img src="imgs/ericzer.jpg">
    </div>
  </div>
</div>


<script>
	$(document).ready(function() {

		spawnKebab();
		getTanneries();
		getQuartierDesQuinzes();

		function spawnKebab(){	
			setTimeout(function(){
				console.log("spawn kebab");
				let windowWidth = $(document).width();
				let windowHeight = $(document).height();
				let randWidth = Math.floor((Math.random()*windowWidth));
				let randHeight = Math.floor((Math.random()*windowHeight));      
				$('.kebab').css('left', randWidth);
				$('.kebab').css('top', randHeight);
				$('.kebab').css('display', 'block');
				setTimeout(function(){
					console.log("remove kebab");
					$('.kebab').css('display', 'none');
				}, 2000);
			}, 2000);
		}

		$('.kebab').click(function(){
        	$('#eric').modal('show');
        	var yay = "sounds/yay.mp3";
			new Audio(yay).play();
        	setTimeout(function(){
				$('#eric').modal('hide')
			}, 2000);
    	});

		var speed = 600;
		rotateSandwich(speed);
		$("#sandwich").click(function() {
			$('#win').modal('show');
			setTimeout(function(){
			  $('#win').modal('hide')
			}, 2000);
			speed = speed - 100;
			rotateSandwich(speed);
		});

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

		$("#image").css("z-index", "800");
		$(".daily-menu").hide();
		$("h2").hide();
		$("p").hide();
		$("ul").addClass("menu");
		$(".menu").addClass("list-group");
		$(".menu li").addClass("dayliMenu");
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
	function rotateSandwich(speed) {
		$("#sandwich").animate({left:'92%'}, speed);
		$("#sandwich").animate({top:'95%'}, speed);
		$("#sandwich").animate({left:'0%', right:'105%'}, speed);
		$("#sandwich").animate({top:'0%', bottom:'100%'}, speed);
		setTimeout(rotateSandwich, speed);
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

	function getTanneries(){
			$.ajax({
		    url: "cts.php",
		    type: 'get',
		    dataType: 'html',
		    data: 'destination=' + 'rob',
		    success: function(data) {
		    	$('#table_tanneries').html(data);
		    	setTimeout(getTanneries, 2000);
		    },
		    error: function(xhr, status) {
		        //alert("Sorry, there was a problem!");
		    },
		});
	}

	function getQuartierDesQuinzes(){
			$.ajax({
		    url: "cts.php",
		    type: 'get',
		    dataType: 'html',
		    data: 'destination=' + 'lingo',
		    success: function(data) {
		    	$('#table_quartierDesQuinzes').html(data);
		    	setTimeout(getQuartierDesQuinzes, 2000);
		    },
		    error: function(xhr, status) {
		        //alert("Sorry, there was a problem!");
		    },
		});
	}
</script>
</body>
</div>
</html>