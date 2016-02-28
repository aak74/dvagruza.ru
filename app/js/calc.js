var calc = {
	cityFrom: false,
	cityTo: false,
	weight: false,
	volume: false,
	companies: [],

	/* Ищет компании, через которые можно осуществить перевозку. После нахождения для каждой компании запускается отдельный поиск */
	search: function() {
		$(".result").html("");
		// $(".result-table").html("");
		calc.cityFrom = $("#input-from").data("id");
		calc.cityTo = $("#input-to").data("id");
		calc.weight = $("#input-weight").val();
		calc.volume = $("#input-volume").val();
		// console.log('calc.search', calc.cityFrom, calc.cityTo);
		// calc.clearLog();
		var str = "<h2>Расчет перевозки</h2>" + "<br />"
			+ "Из: " + $("#input-from").val() + "<br />"
			+ "В: " + $("#input-to").val() + "<br />"
			+ "Вес: " + calc.weight + "<br />"
			+ "Объем: " + calc.volume + "<br />"
			+ "<a href='//dvagruza.ru/?"
			+ "from=" + calc.cityFrom
			+ "&to=" + calc.cityTo
			+ "&weight=" + calc.weight
			+ "&volume=" + calc.volume
			+ "'>URL для быстрого расчета</a>" + "<br />";

		str += '<table class="table table-hover"><tr><th>Компания</th><th>Цена</th><th>Срок</th></tr></table>';
		$(".result-table .container").html(str);

		$("html,body").animate({scrollTop: $(".result-table").offset().top}, 1000);

	    $.post("/ajax/getCompsInCities.php", {
	    	"from": calc.cityFrom, 
	    	"to": calc.cityTo,
	    	"weight": calc.weight,
	    	"volume": calc.volume,
	    })
	        .done(function(response) {
		        // $(".log").html(response).show();
		        var data = JSON.parse(response);
	          	// console.log("compsInCities data", data);
	          	// Для каждой из компаний запускаем отдельный расчет
		        for (var i = 0; i < data.comps.length; i++) {

		        	calc.calc(data.comps[i], data.query_id);
		        }
	      	})
	        .fail(function() {
	        	console.log("getCompsInCities.php fail");
	        });
	}, 

	/* Отправляем запрос на расчет по отдельной компании */
	calc: function(companyId, queryId) {
		// console.log('calc.calc', calc.cityFrom, calc.cityTo);

		// calc.replaceCompanyPanel(companyId, "<h3>" + calc.getCompanyAnchor(companyId) + "</h3><p>Отправлен запрос на расчет</p>");
		calc.add2Table( {"companyId": companyId} );
		
	    $.post("/app/ajax/calc.php", {
	    		"from": calc.cityFrom, 
	    		"to": calc.cityTo, 
	    		"companyId": companyId,
	    		"weight": calc.weight,
	    		"volume": calc.volume,
	    		"queryId": queryId
	    	})
	        .done(function(response) {
		        // $(".log").append("<p>" + response + "</p>").show();
		        if ( response !== "" ) {
			        var data = JSON.parse(response);
			        var str = "<h3>" + calc.getCompanyAnchor(companyId) + "</h3>"
			        	+ "<p class='price'>Стоимость, руб.: " + data.result.price + "</p>"
			        	+ "<p class='time'>Срок доставки, дней: " + data.result.time + "</p>";
					// calc.replaceCompanyPanel(data.result.companyId, str);
					calc.add2Table( data.result );
					calc.add2Log( str + "<br/>" );
			        // console.log("data", data, companyId);

		        }
		        // $(".log").append("<p>" + response + "</p>").show();
	          	// console.log("calc", response);
	      	})
	        .fail(function() {
	        	console.log("calc.php fail");
	        });
	}, 


	/* Подставляет данные по грузам и запускает поиск вариантов */
	searchVariant: function() {
		var data = $(this).data();
		$("#input-weight").val(data.weight);
		$("#input-volume").val(data.volume);
		calc.search();
		
	},

	// Возвращает тег "a" для компании
	getCompanyAnchor: function(companyId) {
        return "<a href='//"  + calc.companies[companyId].site + "' target='_blank'>" + calc.companies[companyId].name + "</a>";
	},

	// Замена панельки 
	replaceCompanyPanel: function(companyId, msg) {
		// console.log("replaceCompanyPanel", companyId, msg);
		var clName = "comp" + companyId;
		var $company = $(".result div." + clName);
		// console.log("replaceCompanyPanel", $company);
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
	add2Table: function (data) {
		// $(".log").append("<p>" + msg + "</p>");
		console.log("add2Table", data, data.from );
		var str = "<tr id='comp" + data.companyId + "'>";
		str +=	"<td>" + calc.companies[data.companyId].name + "</td>";
		if (data.from === undefined) {
			str +=	"<td colspan='2'>Запрос отправлен</td>";
		} else {
			str += "<td>" + data.price + "</td>"
				+ "<td>" + data.time + "</td>";
		}
		str += "</tr>";
		
		if (data.from !== undefined) {
			$(".result-table table tr#comp" + data.companyId).remove();
		}
		$(".result-table table").append(str);

	},

	// Добавляет запись в лог
	add2Log: function (msg) {
		// $(".log").append("<p>" + msg + "</p>");
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
	$(".search-variant").on("click", calc.searchVariant);
	$("#switch").on("click", calc.switch);
	$(".from-to .form-control").on("keyup", calc.showCities);
	$("ul.cities").on("click", calc.setCity);
	calc.init();
});

