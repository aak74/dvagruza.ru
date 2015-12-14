var city = {
	path: "",
	parentId: false,
	terminals: false,

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
			str += "<option "
				+ "data-id='" + city.terminals[i].ID + "'"
				+ "data-name='" + city.terminals[i].NAME + "'"
				+ ">" 
				+ city.terminals[i].COMPANY_NAME + " - " 
				+ city.terminals[i].NAME 
				+ "</option>";
		};
		$("#terminals-in-city").html(str);
	},

	_getTerminals: function (e) {
		console.log("_getTerminals", e);
	    $.post(city.path + "/getTerminals.php", {"id" : e.target.dataset.id})
	        .done(function(response) {
	            console.log("getTerminals.php done", response);
	            city.terminals = JSON.parse(response);
	            city.showTerminals();
	        })
	        .fail(function() {
	            console.log("getTerminals.php fail");
	        });

	},

	_getCityFromAll: function () {
		var $terminal = $("#terminals-in-city option:selected");
		var $city = $("#cities-main option:selected");
		console.log("_getCityFromAll", $city, $city.data(), $terminal, $terminal.data());
/*
	    $.post(city.path + "/getCityFromAll.php", {"id" : e.target.dataset.id})
	        .done(function(response) {
	            console.log("getCityFromAll.php done", response);
	            city.terminals = JSON.parse(response);
	            city.showTerminals();
	        })
	        .fail(function() {
	            console.log("getCityFromAll.php fail");
	        });
*/	        
	},

	_getCityByName: function (e) {
		console.log("_getTerminals", e);
		city.get
	}

}

$(document).ready(function() {
	city.path = $(".admin-cities").data("path");
	$("#cities-main").click(city._getTerminals);
	$("#add-city").click(city.add);
	$("#get-city-from-all").click(city._getCityFromAll);
	$("#remove-city").click(city.remove);
	$("#set-main-city").click(city.setMain);
});