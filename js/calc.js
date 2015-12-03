var calc = {
	loadCities: function() {
		console.log('calc.loadCities');
	},

	/* Ищет возможные варианты */
	search: function() {
		var cityFrom = $("#input-from").data("id");
		var cityTo = $("#input-to").data("id");
		console.log('calc.search', cityFrom, cityTo);

    $.post("/ajax/getCompsInCities.php", {"from": cityFrom, "to": cityTo})
        .done(function(response) {
	        $(".log").html(response).show();
	        compsInCities = JSON.parse(response);
          console.log("compsInCities", compsInCities);
      	})
        .fail(function() {
          console.log("getTCsInCities.php fail");
        });

	}, 

	setCity: function (e) {
		console.log('calc.setCity', e, this, e.target.value);
		var $fg = $(this).closest(".form-group");
		$fg.find(".city").data("id", e.target.dataset.id).val(e.target.innerHTML);
		$(".cities").removeClass("active");
		// $fg.find(".cities-wrapper").append($ul);
		
	},

	showCities: function (e) {
		console.log('calc.showCities', e, this, e.target.value);
		var cityName = e.target.value.toLowerCase();
		var $ul = $("ul.cities").addClass("active");
		$ul.find("li").removeClass("active");
		$ul.find("li[data-title*='" + cityName + "']").addClass("active");
		// var str = "";
		// $ul.find("li[data-title*='" + cityName + "']").each(function () {
		// 	console.log('calc.showCities find', this);
		// 	str += this;
		// 	// str += $(this).html();
		// });
		// $(this).closest(".form-group").find(".cities-wrapper >ul").html(str);
		// $(this).closest(".form-group").find(".cities-wrapper").append($ul.find("li.active"));
		$(this).closest(".form-group").find(".cities-wrapper").append($ul);
	}

}

$(document).ready(function() {
  $("#search").on("click", calc.search);
  $(".from-to .form-control").on("keyup", calc.showCities);
  $("ul.cities").on("click", calc.setCity);
});

