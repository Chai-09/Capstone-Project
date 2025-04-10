import './bootstrap';

var openForms = document.getElementById("openForms");
var formsModal = document.getElementById("formsModal");
var closebtn = document.getElementById("close");
var forExit = document.getElementById("forexit");

openForms.onclick = function(event) {
    event.preventDefault();
    formsModal.style.display = "block";
}

closebtn.onclick = function() {
    formsModal.style.display = "none";
}

