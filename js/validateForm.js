function validateForm(){
	"use strict"

	var uNameRegex = /^[A-Za-z]*$/;
	var form = document.forms["signInForm"];
	var userName = form["userName"].value.trim();

	if (!uNameRegex.test(userName)) {
		alert("A username must only contain latin alphabet characters");
		form["userName"].focus();
		return false;
	}

	if (userName.length < 3 || userName.length > 30) {
		alert("A valid username must be between 3 and 30 characters");
		form["userName"].focus();
		return false;
	}
	return true;
}