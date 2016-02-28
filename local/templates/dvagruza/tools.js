var akop = {
	// _callback: null, // проверить на нужность
	// var messageTimeout = 3000;
  debug: {
      isOn: true,
      log: function() {
          if (this.isOn && window.console)
              console.log.apply(window.console, arguments);
      },
      warn: function() {
          if (this.isOn && window.console)
              console.warn.apply(window.console, arguments);
      },
      dir: function() {
          if (this.isOn && window.console)
              console.dir.apply(window.console, arguments);
      },
      stop: function() {
          if (this.isOn)
              debugger;
      }
  },

  
  _showCover: function () {
    var coverDiv = document.createElement("div");
    coverDiv.id = "cover-div";
    document.body.appendChild(coverDiv);
  },

  _hideCover: function() {
    if (document.getElementById("cover-div")) {
      document.body.removeChild(document.getElementById("cover-div"));
    }
  },
  
  showConfirm: function (textMessage, callback_yes) {
    // akop.debug.dir("showConfirm", textMessage, callback_yes);
    var i=0;
    $(".confirm p")
      .text(textMessage);
      
    
    $("#confirm-yes")
      .off()
      .on("click", function(){
        $(".confirm").css("display", "none");
        // akop.debug.dir("showConfirm", callback_yes, i);
        i++;
        callback_yes.call();
      });
    $("#confirm-no")
      .off()
      .on("click", function(){
        $(".confirm").css("display", "none");
      });
      
    $(".confirm").css("display", "block");
  },
  
  
  showPrompt: function (text, callback) {
    
    /* Переопределяем onsubmit */
    $("#ajax-form")
      .submit(function(e){
        e.preventDefault();
        var value = document.getElementById("prompt-input").value;
        if (value == "") return false; // игнорировать пустой submit

        callback(value);
        akop.hideAjaxPage();
        return false;
      });

    akop.showForm(
      '<input name="text" type="text" id="prompt-input" value="' + text + '">', 
      callback,
      "prompt-input"
    );
  },

  showForm: function (text, callback, elFocus) {
    // akop._callback = callback;
    elFocus = elFocus || "ajax-form-cancel";
    // akop.debug.log("showForm", text, elFocus);
    akop._showCover();
    $(".container-ajax-page")
      .css("display", "block")
      .find(".body-page")
      .html(text);

    /* Переопределяем onsubmit */
    // akop.debug.dir("showForm", $("#ajax-form"));
    $("#ajax-form")
      .off()
      .on("submit", function(e){
        e.preventDefault();
        akop.hideAjaxPage();
        callback();
        // return false;
      });
      
    if (document.getElementById(elFocus)) { 
      document.getElementById(elFocus).focus(); 
    }
  },
  
  showAjaxPage: function (url, callback) {
    // d3.event.preventDefault();
    
    $.get(url, function(response, error) {
      // akop.debug.log("showAjaxPage", response, error);
      // akop._hideCover();
      if (error == null) {

          
        akop.showForm(response, callback, "ajax-form-cancel");
        
      } else {
        akop.showMessage("Ошибка загрузки", 2000);
      }
      
    });
  },
  
  hideAjaxPage: function() {
  
    akop._hideCover();
    $("#container-ajax-page")
      .css("display", "none");
  },
  
  /**
  * Показываем всплывающее сообщение
  */
  showMessage: function (message, messageTimeout) {
    // akop.debug.dir("showMessage", $(".container-ajax"));
    var $container = $(".container-ajax")
    if ($container.length) {
      $container.html(message);
    } else {
      $('<div class="container-ajax">' + message + '</div>')
        .appendTo("body");
    }
      
    /* Скрываем всплывающее сообщение после таймаута*/
    if (messageTimeout != undefined) {
      setTimeout(
        function () {$(".container-ajax").remove()},
        messageTimeout
      );
    }
  },
  /**
  * Показываем всплывающее сообщение, в котором можно совершить действие и закрыть панель
  */
  // showAlert: function (message, linkUrl, linkDesc, alertClass) {
  showAlert: function (message, callbackFunction, linkDesc, alertClass) {
    if (alertClass == undefined) alertClass = "success";
    var $containerAlert = $(akop.containerAlertSelector).html(
      "<div class=\"alert alert-" + alertClass + "\">"
      + message + "&nbsp;"
      + "<a href=\"#\" class=\"alert-link\">" + linkDesc + "</a>"
      // + "<a href=\"" + linkUrl + "\" class=\"alert-link\">" + linkDesc + "</a>"
      + "<button type=\"button\" class=\"close\" aria-hidden=\"true\">&times;</button>"
      + "</div>"
    );

    /* Обработчик на закрытие алерта */
    $containerAlert.find(".close").on("click", function(e) {
      e.preventDefault();
      $(akop.containerAlertSelector).html("");
    });

    /* обраотчик клика по линку */
    $containerAlert.find(".alert-link").on("click", function(e) {
      e.preventDefault();
      callbackFunction.call();
    });
		
	}

}

$(document).ready(function () {
  /** Обработка ссылок, которые должны открываться во всплывающем окне  */
  $(".ajax-page")
    .on("click", akop.showAjaxPage);

  if (typeof calc != "undefined") calc.onload();
	// if (typeof map != "undefined") map.onload();
});

var phpjs = {
get_html_translation_table: function (table, quote_style) {

  var entities = {},
    hash_map = {},
    decimal;
  var constMappingTable = {},
    constMappingQuoteStyle = {};
  var useTable = {},
    useQuoteStyle = {};

  // Translate arguments
  constMappingTable[0] = 'HTML_SPECIALCHARS';
  constMappingTable[1] = 'HTML_ENTITIES';
  constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
  constMappingQuoteStyle[2] = 'ENT_COMPAT';
  constMappingQuoteStyle[3] = 'ENT_QUOTES';

  useTable = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
  useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() :
    'ENT_COMPAT';

  if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
    throw new Error('Table: ' + useTable + ' not supported');
    // return false;
  }

  entities['38'] = '&amp;';
  if (useTable === 'HTML_ENTITIES') {
    entities['160'] = '&nbsp;';
    entities['161'] = '&iexcl;';
    entities['162'] = '&cent;';
    entities['163'] = '&pound;';
    entities['164'] = '&curren;';
    entities['165'] = '&yen;';
    entities['166'] = '&brvbar;';
    entities['167'] = '&sect;';
    entities['168'] = '&uml;';
    entities['169'] = '&copy;';
    entities['170'] = '&ordf;';
    entities['171'] = '&laquo;';
    entities['172'] = '&not;';
    entities['173'] = '&shy;';
    entities['174'] = '&reg;';
    entities['175'] = '&macr;';
    entities['176'] = '&deg;';
    entities['177'] = '&plusmn;';
    entities['178'] = '&sup2;';
    entities['179'] = '&sup3;';
    entities['180'] = '&acute;';
    entities['181'] = '&micro;';
    entities['182'] = '&para;';
    entities['183'] = '&middot;';
    entities['184'] = '&cedil;';
    entities['185'] = '&sup1;';
    entities['186'] = '&ordm;';
    entities['187'] = '&raquo;';
    entities['188'] = '&frac14;';
    entities['189'] = '&frac12;';
    entities['190'] = '&frac34;';
    entities['191'] = '&iquest;';
    entities['192'] = '&Agrave;';
    entities['193'] = '&Aacute;';
    entities['194'] = '&Acirc;';
    entities['195'] = '&Atilde;';
    entities['196'] = '&Auml;';
    entities['197'] = '&Aring;';
    entities['198'] = '&AElig;';
    entities['199'] = '&Ccedil;';
    entities['200'] = '&Egrave;';
    entities['201'] = '&Eacute;';
    entities['202'] = '&Ecirc;';
    entities['203'] = '&Euml;';
    entities['204'] = '&Igrave;';
    entities['205'] = '&Iacute;';
    entities['206'] = '&Icirc;';
    entities['207'] = '&Iuml;';
    entities['208'] = '&ETH;';
    entities['209'] = '&Ntilde;';
    entities['210'] = '&Ograve;';
    entities['211'] = '&Oacute;';
    entities['212'] = '&Ocirc;';
    entities['213'] = '&Otilde;';
    entities['214'] = '&Ouml;';
    entities['215'] = '&times;';
    entities['216'] = '&Oslash;';
    entities['217'] = '&Ugrave;';
    entities['218'] = '&Uacute;';
    entities['219'] = '&Ucirc;';
    entities['220'] = '&Uuml;';
    entities['221'] = '&Yacute;';
    entities['222'] = '&THORN;';
    entities['223'] = '&szlig;';
    entities['224'] = '&agrave;';
    entities['225'] = '&aacute;';
    entities['226'] = '&acirc;';
    entities['227'] = '&atilde;';
    entities['228'] = '&auml;';
    entities['229'] = '&aring;';
    entities['230'] = '&aelig;';
    entities['231'] = '&ccedil;';
    entities['232'] = '&egrave;';
    entities['233'] = '&eacute;';
    entities['234'] = '&ecirc;';
    entities['235'] = '&euml;';
    entities['236'] = '&igrave;';
    entities['237'] = '&iacute;';
    entities['238'] = '&icirc;';
    entities['239'] = '&iuml;';
    entities['240'] = '&eth;';
    entities['241'] = '&ntilde;';
    entities['242'] = '&ograve;';
    entities['243'] = '&oacute;';
    entities['244'] = '&ocirc;';
    entities['245'] = '&otilde;';
    entities['246'] = '&ouml;';
    entities['247'] = '&divide;';
    entities['248'] = '&oslash;';
    entities['249'] = '&ugrave;';
    entities['250'] = '&uacute;';
    entities['251'] = '&ucirc;';
    entities['252'] = '&uuml;';
    entities['253'] = '&yacute;';
    entities['254'] = '&thorn;';
    entities['255'] = '&yuml;';
  }

  if (useQuoteStyle !== 'ENT_NOQUOTES') {
    entities['34'] = '&quot;';
  }
  if (useQuoteStyle === 'ENT_QUOTES') {
    entities['39'] = '&#39;';
  }
  entities['60'] = '&lt;';
  entities['62'] = '&gt;';

  // ascii decimals to real symbols
  for (decimal in entities) {
    if (entities.hasOwnProperty(decimal)) {
      hash_map[String.fromCharCode(decimal)] = entities[decimal];
    }
  }

  return hash_map;
},

html_entity_decode: function (string, quote_style) {
  var hash_map = {},
    symbol = '',
    tmp_str = '',
    entity = '';
  tmp_str = string.toString();

  if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
    return false;
  }

  delete(hash_map['&']);
  hash_map['&'] = '&amp;';

  for (symbol in hash_map) {
    entity = hash_map[symbol];
    tmp_str = tmp_str.split(entity)
      .join(symbol);
  }
  tmp_str = tmp_str.split('&#039;')
    .join("'");

  return tmp_str;
}

}