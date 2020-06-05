/*
    Allows you to validate a username on the browser side
 */
function validateRegForm(formName) {
    "use strict"

    //Sets a variable containing the regex for the username
    var uNameRegex = /^[A-Za-z0-9]{0,29}$/;

    //Gets data from the form
    var form = document.forms[formName];

    //Gets the username from the form data
    var username = form["Username"].value.trim();

    //If username does not comply with the regex an alert will be displayed and the username of the form will be focused
    if (!uNameRegex.test(username)) {
        alert("A username must only contain alphanumeric characters");
        form["userName"].focus();
        return false;
    }

    return true;
}