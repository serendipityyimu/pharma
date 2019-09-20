//***********javascript.js**************
//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 04/11/2017
//Last modified: 09/11/2018

(function(global) {   // Immediately Invoked Function Expression (IIFE)
  var js = {
     //Return substitute of '{{propName}}' with propValue in given 'string'
    insertProperty: function (string, propName, propValue) {
      var propToReplace = "{{" + propName + "}}";
      string = string.replace(new RegExp(propToReplace, "g"), propValue);
      return string;
    }
    ,
    //Permet de charger des scripts javascript une fois la page html chargée
    loadScript: function (selector, script) {
      var targetElem = document.querySelector(selector);
      var DSLScript  = document.createElement("script");
      DSLScript.src  = script;
      DSLScript.type = "text/javascript";
      targetElem.appendChild(DSLScript);
      targetElem.removeChild(DSLScript);
    }
    // ,
    //Permets d'attribuer plusieurs attributs a un element
    // setAttributes: function (element, attributes) {
    //   for(var key in attributes) {
    //     element.setAttribute(key, attributes[key]);
    //   }
    // }
  };
  global.$js = js;
})(window);


// Sous total pour le regroupement de factures
function addValue() {
  var somme = 0;
  var sousTotalDisplay = $("#sous_total");
  var chkBx = $('[type="checkbox"]');
  for(let i = 0, length = chkBx.length; i < length; i++){
    if(chkBx[i].checked) somme += parseFloat(chkBx[i].value);
  }
  sousTotalDisplay.html(Number(somme).toFixed(2) + " €");
}


// Recupere l'objet SELECT ayant l'identifiant elementId et met la valeur par defaut 'etat'
function optionSelect(etat, elementId) {
  for (var i = 0; i < elementId.children('option').length; i++) {
    if (elementId.children('option').eq(i).val() ==  etat) {
      elementId.children('option').eq(i).prop('selected',true);
    }
  }
}


function listeSalaries(liste, elementId){
  var divList = document.getElementById(elementId);
  $.each(liste, function(index, value) {
    var item = document.createElement("a");
    $js.setAttributes(item, {"href": "#", "class": "list-group-item list-group-item-action","data-toggle": "list","id": value.SALESREP_ID});
   item.appendChild(document.createTextNode(value.SALESREP));
    divList.appendChild(item);
  });
}


function getXMLHttpRequest() {
  var xhr = null;
  if (window.XMLHttpRequest || window.ActiveXObject) {
    if (window.ActiveXObject) {
      try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch(e) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    else {
      xhr = new XMLHttpRequest();
    }
  }
  else {
    alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
    return null;
  }
  return xhr;
}
