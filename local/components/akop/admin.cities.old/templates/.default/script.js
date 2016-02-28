var city = {
	path: "",
	parentId: false,

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

	_getChildren: function () {
		console.log("_getChildren");
	}

}

$(document).ready(function() {
	city.path = $(".admin-cities").data("path");
	$("#add-city").click(city.add);
	$("#remove-city").click(city.remove);
	$("#set-main-city").click(city.setMain);
});