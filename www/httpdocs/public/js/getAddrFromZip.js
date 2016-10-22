	function getAddrFromZip(){
		var zip_code = $("input[name=zip_code]");
		var zip_code_value = (zip_code != null) ? zip_code.val() : 0;

		// http://maps.googleapis.com/maps/api/geocode/json?address=1000001
		$.getJSON('//maps.googleapis.com/maps/api/geocode/json?address=' + zip_code_value, function(data) {
			var results = data['results'][0];

			var pref = results['address_components'][3]['long_name'];
			var city = results['address_components'][2]['long_name'];
			var address = results['address_components'][1]['long_name'];

			$('input[name=prefecture]').val(pref);
			$('input[name=city]').val(city);
			$('input[name=address]').val(address);


			var latAndlng = results['geometry']['location'];
			var lat = latAndlng['lat'];
			var lng = latAndlng['lng'];

			var myCenter=new google.maps.LatLng(lat, lng);

			function initMap()
			{
				var mapProp = {
					center:myCenter,
					zoom:12,
					mapTypeId:google.maps.MapTypeId.ROADMAP
				};

				var map=new google.maps.Map(document.getElementById("map"),mapProp);

				var marker=new google.maps.Marker({
					position:myCenter,
				});

				marker.setMap(map);
			}

			// google.maps.event.addDomListener(window, 'load', initMap);
			initMap();
		});
	}
