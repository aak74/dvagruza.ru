var calc = {
	cityFrom: false,
	cityTo: false,
	weight: false,
	volume: false,

	loadCities: function() {
		console.log('calc.loadCities');
	},

	/* Ищет возможные варианты */
	search: function() {
		calc.cityFrom = $("#input-from").data("id");
		calc.cityTo = $("#input-to").data("id");
		calc.weight = $("#input-weight").val();
		calc.volume = $("#input-volume").val();
		console.log('calc.search', calc.cityFrom, calc.cityTo);

	    $.post("/ajax/getCompsInCities.php", {"from": calc.cityFrom, "to": calc.cityTo})
	        .done(function(response) {
		        $(".log").html(response).show();
		        var compsInCities = JSON.parse(response);
	          	console.log("compsInCities", compsInCities);
	          	// Для каждой из компаний запускаем отдельный расчет
		        for (var i = 0; i < compsInCities.length; i++) {
		        	calc.calc(compsInCities[i]);
		        }
	      	})
	        .fail(function() {
	          console.log("getCompsInCities.php fail");
	        });
	}, 

	/* Отправляем запрос на расчет по компании */
	calc: function(company) {
		console.log('calc.calc', calc.cityFrom, calc.cityTo);

	    $.post("/ajax/calc.php", {
	    		"from": calc.cityFrom, 
	    		"to": calc.cityTo, 
	    		"company": company,
	    		"weight": calc.weight,
	    		"volume": calc.volume
	    	})
	        .done(function(response) {
		        // $(".log").append("<p>" + response + "</p>").show();
		        if ( response !== "" ) {
			        var data = JSON.parse(response);
			        console.log("data", data);

		        }
		        $(".log").append("<p>" + response + "</p>").show();
	          	console.log("calc", response);
	      	})
	        .fail(function() {
	          console.log("calc.php fail");
	        });
	}, 

	setCity: function (e) {
		console.log('calc.setCity', e, this, e.target.value);
		var $fg = $(this).closest(".form-group");
		$fg.find(".city").data("id", e.target.dataset.id).val(e.target.dataset.title);
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

};

$(document).ready(function() {
  $("#search").on("click", calc.search);
  $(".from-to .form-control").on("keyup", calc.showCities);
  $("ul.cities").on("click", calc.setCity);
});

