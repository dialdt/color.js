<!doctype html>
<html>
<head>

	<title>Timely | Prompt World Time</title>
	
	<meta charset="utf-8" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	
	<!-- Moment.js for time formatting -->
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/color.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBsGmkjbbdhULLFHOKjEmHE0rfjiIaFZXE" type="text/javascript"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyBsGmkjbbdhULLFHOKjEmHE0rfjiIaFZXE"></script>

<style>

	html, body {
		
			padding:0;
			margin:0;
			height:100%;
		
		}
		
		.wrapper {
		
			background-color: #007bff;
			color: #fff;
			width:100%;
			height:100%;
			overflow:scroll;
			background-size:cover;
			background-position:center;
		
		}
			
			
	.lead {
		
			margin-top:150px;
			color:#FFF;
					
		}
		
		.lead h1 {
		
			font-size: 3em;
		
		}
		
		.search {
		
			margin-top: 20px;
		
		}
		
		#search-field-icon {
		
			position:relative;
			top:-1px;
		
		}
		
		.search-btn {
		
			margin-top: 25px;
		
		}
		
		.alert {
		
			display:none;
			text-align:center;
			font-size:0.8em;
		
		}
		
		#result {
			
			color: #fff;
			font-size: 5em;
			font-weight: bold;
			padding-bottom: 10px;
			
		}
		
		#full-result {
		
			color: #fff;
			font-size: 0.8em;
		
		}
		
</style>

</head>
<body>

	<div class="wrapper" id="wrapper">	
	
<div class="container">
		
			<div class="row lead">
			
				<div class="col-md-6 col-md-offset-3 text-center">
				
				<div id="result"></div>
						
					<form> 
					
						<div class="form-group search">
							
							<div class="input-group">
							
								<span class="input-group-addon">City</span>							
								<input id="adrValue" type="text" name="search" class="form-control" placeholder="Type in a city (e.g. 'London', 'Dublin', 'Cape Town')"  id="search-input" />
								
															
							</div>
							
							<button class="btn btn-primary btn-lg search-btn" type="submit" id="search-btn">Search</button>
													
												
						</div>
					
					</form>
					
					<div id="position"></div>
					<div class="alert alert-danger" id="result-fail">Could not find weather data for that city</div>
					<div class="alert alert-danger" id="noData">Please enter a city</div>
					
				</div>
	</div>
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
	  
<script>

	var geocoder = new google.maps.Geocoder();
	var adr = 'Seaford, UK';
	var latLng;
	var url = 'https://maps.googleapis.com/maps/api/timezone/json?location=';
	var key = 'AIzaSyBsGmkjbbdhULLFHOKjEmHE0rfjiIaFZXE';
	var currentTimeUTC = new Date();
	var hour;
	var hourOffset;
	var light;

	
	function getAddress(address) {
	
		geocoder.geocode({'address': address}, function(results, status) {
			
			if (status === 'OK') {
		
				latLng = results[0].geometry.location.lat() + "," + results[0].geometry.location.lng();
				url = 'https://maps.googleapis.com/maps/api/timezone/json?location=' + latLng + '&timestamp=1331161200&key=' + key + '';
			
				
				$.getJSON(url, function (data) {
				
					currentTimeSeconds = currentTimeUTC.getTime()/1000 + currentTimeUTC.getTimezoneOffset() + 60;
					var offsets = data.dstOffset * 1000 + data.rawOffset * 1000;
					var localTime = new Date(currentTimeSeconds * 1000 + offsets);

					hour = localTime.getHours();
					hourOffset = 100/24
					
					if(hour >= 0 && hour <= 12) {
					
						light = Math.round(hourOffset * hour);
					
					} else {
					
						light = 100 - Math.round(hourOffset * hour);
					
					}
					
					light = light + 15;
					
					var realTime = moment(localTime).format('HH:mm:ss');
					
					$("#result").html(realTime);
					
				let bgColor = new Color('211','100',light);
				$("#wrapper").css({backgroundColor: bgColor.getColor()});					
				
				});
				
				
        	} else {
        	
        		alert('Not successful');
        	
        	}
                
    	});
    
    }
    
    function initialize() {
    
    	var input = document.getElementById('adrValue');
    	var autocomplete = new google.maps.places.Autocomplete(input);
    
    }
    
	google.maps.event.addDomListener(window, 'load', initialize);
    
    
    $(document).ready(function() {
    
			$("#result-fail").hide();
			$("#noData").hide();
			var d = new Date();
			
			console.log($(window).height()/2);
			console.log($(".container").height()/2);
			console.log(($(window).height()/2) - ($(".container").height()/2));
			
			$(".container").css("margin-top", (($(window).height()/4) - ($(".container").height()/2)));
			
			$("#result").html(moment(d).format('HH:mm:ss'));
    
    		$("#search-btn").click(function(event) {
        		event.preventDefault();
        		
        		var address = $("#adrValue").val();
				
				getAddress(address);
    
    		});
    		
    	});
	

</script>

</body>
