var linkClicked;
var lastHovered;

function unClickLink(){
	if (typeof linkClicked != "undefined"){
    linkClicked.style.fontWeight = "normal";
    var styleElem = document.head.appendChild(document.createElement("style"));
    styleElem.innerHTML = "#core_"+lastHovered+":before {background-color: white;border:2px solid #C8AD7F;transition: background-color 0.5s ease;}";
	}
}

function hoverLeftButton(){
  var styleElem = document.head.appendChild(document.createElement("style"));
  styleElem.innerHTML = "#core_"+lastHovered+":before {background-color: #C8AD7F;border:2px solid white;transition: background-color 0.5s ease;}";
}

document.getElementById('rdc').onclick = function() {
	unClickLink();
  document.getElementById('rdc').style.fontWeight = "bold";
  linkClicked = document.getElementById('rdc');
  lastHovered = "rdc";
  
  hoverLeftButton();
  changeMapLayer(1);
  return false; // empecher de scroll to the TOP.
};

document.getElementById('etage1').onclick = function() {
  unClickLink();

  lastHovered = "etage1";
  document.getElementById('etage1').style.fontWeight = "bold";
  linkClicked = document.getElementById('etage1');

  hoverLeftButton();
  changeMapLayer(2);
  return false; // empecher de scroll to the TOP.
};