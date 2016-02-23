var city = {
	clearSearch: function () {
		$('#search-city-name').val("");
		city.searchCity();

	},

	searchCity: function () {
		var cityName = $('#search-city-name').val();
		if ( cityName === "" ) {
			$(".city").removeClass("hidden");
		} else {
			$(".city").addClass("hidden");
			$(".city[data-name-lower*='" + cityName + "']").removeClass("hidden");
		}
		// return $li.data("id");
	}
}



$(document).ready(function() {
	document.getElementById('search-city-name').focus()
	$('#search-city-name').keyup(city.searchCity);
	$('#clear-search').click(city.clearSearch);
});
