var city = {
	id: false,
	path: "",
	parentId: false,
	terminals: false,
	terminalId: false,

	add: function () {
		console.log("add");
		city.parentId = $("#cities-main option.active").data("id");
		if ( city.parentId ) {
			$children = $("#cities-children");
	  	var ids = [];
	    $("#cities-main option:selected").each(function () {
	    	$this = $(this);
	    	if ( !$this.hasClass("active") ) {
	    		$children.append(this);
	    		// console$this.data("id")
	    		ids.push( $this.data("id") );
	    	}
	    });
	    console.log("ids", ids);
	    $.post(city.path + "/addChildren.php", {"parent_id" : city.parentId, "ids": ids})
	        .done(function(response) {
	            console.log("addChildren.php done", response);
	        })
	        .fail(function() {
	            console.log("addChildren.php fail");
	        });
		} else {
      console.log("add no parent");
		}
	},
	
	remove: function () {
		console.log("remove");
	},
	
	setMain: function () {
		console.log("setMain");
    $("#cities-main option").removeClass("active");
    $("#cities-main option:selected :first").addClass("active");
    // $("#cities-main option:selected:nth-of-type(1)").addClass("active");
	},

	showTerminals: function () {
		console.log("showTerminals", city.terminals);
		var str = "";
		for (var i = 0; i < city.terminals.length; i++) {
			str += "<option"
				+ " data-id='" + city.terminals[i].ID + "'"
				+ " data-name='" + city.terminals[i].NAME + "'"
				+ ">" 
				+ city.terminals[i].COMPANY_NAME + " - " 
				+ city.terminals[i].NAME 
				+ "</option>";
		};
		console.log("city.id", city.id);
		if (city.id == 0) {
			$("#get-city-from-all").show();
		} else {
			$("#get-city-from-all").hide();
		}

		$("#terminals-in-city").html(str);
	},

	_getTerminals: function (e) {
		console.log("_getTerminals", e);
		city.id = e.target.dataset.id;
	    $.post(city.path + "/getTerminals.php", {"id" : city.id})
	        .done(function(response) {
	            console.log("getTerminals.php done", response);
	            city.terminals = ( ( response == "null")
	            	? []
	            	: JSON.parse(response)
            	);
	            city.showTerminals();
	        })
	        .fail(function() {
	            console.log("getTerminals.php fail");
	        });

	},

	_getCityFromAll: function () {
		var $terminal = $("#terminals-in-city option:selected");
		// var $city = $("#cities-main option:selected");
		// console.log("_getCityFromAll", $city, $city.data(), $terminal, $terminal.data());
		city.terminalId = $terminal.data("id");

	    $.post(city.path + "/getCityFromAll.php", {"name" : $terminal.data("name")})
	        .done(function(response) {
	            console.log("getCityFromAll.php done", response);
            	$("#log").html(response);
	            // var cities = $.makeArray( response );
	            // var cities = $.makeArray( JSON.parse(response) );
	            var cities = JSON.parse(response);
				console.log("cities", cities, cities.length);
	            if (cities.length > 0) {
	            	var str = "<ul>";
		            for (var i = 0; i < cities.length; i++) {
	            		str += "<li class='city-from-all'"
	            			+ " data-id='" + cities[i].ID
	            			+ "'>" + cities[i].UF_NAME_FULL + "</li>";
		            }
	            	str += "</ul>";
	            	$("#log").html(str);
	            	$("#log li.city-from-all").click(city.addCityFromAll);
	            }
	            // city.showTerminals();	

	        })
	        .fail(function() {
	            console.log("getCityFromAll.php fail");
	        });
	        
	},

	addCityFromAll: function (e) {
		console.log("addFromAll", e, e.target.dataset.id, city.terminalId);
		var cityId = e.target.dataset.id;

	    $.post(city.path + "/addCityFromAll.php", {"id": cityId, "terminal_id": city.terminalId})
	        .done(function(response) {
	   //          console.log("getCityFromAll.php done", response);
    //         	$("#log").html(response);
	   //          // var cities = $.makeArray( response );
	   //          // var cities = $.makeArray( JSON.parse(response) );
	   //          var cities = JSON.parse(response);
				// console.log("cities", cities, cities.length);
	   //          if (cities.length > 0) {
	   //          	var str = "<ul>";
		  //           for (var i = 0; i < cities.length; i++) {
	   //          		str += "<li class='city-from-all'"
	   //          			+ " data-id='" + cities[i].ID
	   //          			+ "'>" + cities[i].UF_NAME_FULL + "</li>";
		  //           }
	   //          	str += "</ul>";
	   //          	$("#log").html(str);
	   //          	$("#log li.city-from-all").click(city.addFromAll);
	   //          }
	   //          // city.showTerminals();	

	        })
	        .fail(function() {
	            console.log("getCityFromAll.php fail");
	        });

	},

	_getCityByName: function (e) {
		console.log("_getCityByName", e);
		// city.get
	}

};

$(document).ready(function() {
	city.path = $(".admin-cities").data("path");
	$("#cities-main").click(city._getTerminals);
	$("#add-city").click(city.add);
	$("#get-city-from-all").click(city._getCityFromAll);
	$("#remove-city").click(city.remove);
	$("#set-main-city").click(city.setMain);
});