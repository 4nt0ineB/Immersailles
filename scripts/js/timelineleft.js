var linkClicked;

function unClickLink(){
	if (typeof linkClicked != "undefined"){
		linkClicked.style.fontWeight = "normal";
	}
}


document.getElementById('rdc').onclick = function() {
	unClickLink();
  document.getElementById('rdc').style.fontWeight = "bold";
  linkClicked = document.getElementById('rdc');
  changeMapLayer(1);
  return false; // empecher de scroll to the TOP.
};

document.getElementById('etage1').onclick = function() {
	unClickLink();
  document.getElementById('etage1').style.fontWeight = "bold";
  linkClicked = document.getElementById('etage1');
  changeMapLayer(2);
  return false; // empecher de scroll to the TOP.
};