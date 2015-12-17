var calc = {
	cityFrom: false,
	cityTo: false,
	weight: false,
	volume: false,
	companies: [],

	/* Ищет компании, через которые можно осуществить перевозку. После нахождения для каздой компании запускается отдельный поиск */
	search: function() {
		$(".result").html("");
		calc.cityFrom = $("#input-from").data("id");
		calc.cityTo = $("#input-to").data("id");
		calc.weight = $("#input-weight").val();
		calc.volume = $("#input-volume").val();
		console.log('calc.search', calc.cityFrom, calc.cityTo);
		calc.clearLog();
		calc.add2Log( "<h3>Расчет перевозки</h3>" );
		calc.add2Log( "Из: " + $("#input-from").val() );
		calc.add2Log( "В: " + $("#input-to").val() );
		calc.add2Log( "Вес: " + calc.weight );
		calc.add2Log( "Объем: " + calc.volume );
		calc.add2Log( "<a href='//dvagruza.ru/?"
			+ "from=" + calc.cityFrom
			+ "&to=" + calc.cityTo
			+ "&weight=" + calc.weight
			+ "&volume=" + calc.volume
			+ "'>URL для быстрого расчета</a>");


	    $.post("/ajax/getCompsInCities.php", {"from": calc.cityFrom, "to": calc.cityTo})
	        .done(function(response) {
		        // $(".log").html(response).show();
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

	/* Отправляем запрос на расчет по отдельной компании */
	calc: function(companyId) {
		console.log('calc.calc', calc.cityFrom, calc.cityTo);

		calc.replaceCompanyPanel(companyId, "<h3>" + calc.getCompanyAnchor(companyId) + "</h3><p>Отправлен запрос на расчет</p>");
		
	    $.post("/ajax/calc.php", {
	    		"from": calc.cityFrom, 
	    		"to": calc.cityTo, 
	    		"companyId": companyId,
	    		"weight": calc.weight,
	    		"volume": calc.volume
	    	})
	        .done(function(response) {
		        // $(".log").append("<p>" + response + "</p>").show();
		        if ( response !== "" ) {
			        var data = JSON.parse(response);
			        var str = "<h3>" + calc.getCompanyAnchor(companyId) + "</h3>"
			        	+ "<p class='price'>Стоимость, руб.: " + data.result.price + "</p>"
			        	+ "<p class='time'>Срок доставки, дней: " + data.result.time + "</p>";
					calc.replaceCompanyPanel(data.result.companyId, str);
					calc.add2Log( str + "<br/>");
			        console.log("data", data, companyId);

		        }
		        // $(".log").append("<p>" + response + "</p>").show();
	          	console.log("calc", response);
	      	})
	        .fail(function() {
	        	console.log("calc.php fail");
	        });
	}, 

	// Возвращает тег "a" для компании
	getCompanyAnchor: function(companyId) {
        return "<a href='//"  + calc.companies[companyId].site + "' target='_blank'>" + calc.companies[companyId].name + "</a>";
	},

	// Замена панельки 
	replaceCompanyPanel: function(companyId, msg) {
		console.log("replaceCompanyPanel", companyId, msg);
		var clName = "comp" + companyId;
		var $company = $(".result div." + clName);
		console.log("replaceCompanyPanel", $company);
		if ( $company.length === 0 ) {
			var str = '<div class="' + clName + '" style="display: none;">' + msg + '</div>';
			$(".result").append(str);
			$(".result div." + clName).fadeIn(1000);
		} else {
			$company.html(msg);
			// $company.fadeOut().html(msg).fadeIn();
		}
		// $company.fadeOut(1000, function() {
		// 	$company.remove();
		// } );
		// $(".result div." + clName).fadeOut(2000).remove();
	}, 

	// Устанавливает город для текущего элемента
	setCity: function (e) {
		console.log('calc.setCity', e, this, e.target.value);
		var $fg = $(this).closest(".form-group");
		$fg.find(".city").data("id", e.target.dataset.id).val(e.target.dataset.name);
		$(".cities").removeClass("active");
		// $fg.find(".cities-wrapper").append($ul);
		
	},

	// Показывает список городов при наборе букв
	showCities: function (e) {
		console.log('calc.showCities', e, this, e.target.value);
		var cityName = e.target.value.toLowerCase();
		var $ul = $("ul.cities").addClass("active");
		$ul.find("li").removeClass("active");
		$ul.find("li[data-title*='" + cityName + "']").addClass("active");
		$(this).closest(".form-group").find(".cities-wrapper").append($ul);
	},

	// Поиск города по названию
	searchCityByName: function (cityName) {
		$li = $("ul.cities > li > span[data-name-lower*='" + cityName + "']");
		return $li.data("id");
	},

	// Поиск города по названию
	searchCityById: function (cityId) {
		$li = $("ul.cities > li > span[data-id='" + cityId + "']");
		return $li.data("name");
	},

	// Меняет местами город отправления и город отправки
	switch: function () {
		var $cityFrom = $("#input-from");
		var fromId = $cityFrom.data("id");
		var fromName = $cityFrom.val();
		var $cityTo = $("#input-to");
		$cityFrom.data( "id", $cityTo.data("id") );
		$cityFrom.val( $cityTo.val() );
		$cityTo.data( "id", fromId );
		$cityTo.val( fromName );
	},

	// Добавляет запись в лог
	add2Log: function (msg) {
		$(".log").append("<p>" + msg + "</p>");
	},
	
	// Очищает лог
	clearLog: function () {
		$(".log").html("");		
	},

	init: function () {
		// Подменяем ID по названию города
		var $cityFrom = $("#input-from");
		var $cityTo = $("#input-to");
		if ($cityFrom.val() === "") {
			$cityFrom.val( calc.searchCityById( $cityFrom.data("id") ) );
			$cityTo.val( calc.searchCityById( $cityTo.data("id") ) );
		} else {
			$cityFrom.data( "id", calc.searchCityByName( $cityFrom.val() ) );
			$cityTo.data( "id", calc.searchCityByName( $cityTo.val() ) );
		}

		// получаем данные о компаниях
		$(".companies li>a").each( function(i, d) {
			$d = $(d);
			console.log(".companies li", this, i, d, $d);
			calc.companies[$d.data("id")] = {
				"name": $d.data("name"),
				"site": $d.data("site")
			};
		}); 
	}



};

$(document).ready(function() {
	$("#search").on("click", calc.search);
	$("#switch").on("click", calc.switch);
	$(".from-to .form-control").on("keyup", calc.showCities);
	$("ul.cities").on("click", calc.setCity);
	calc.init();
});

