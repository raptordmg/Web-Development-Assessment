var styleLocation = "css/";

var styleId = "AccessibilityID";

/*
    Loads the selected stylesheet
 */
function loadStyle(pageStyle) {
    var fileName;

    //creates a link element in the page the javascript is being used on
    var fileRef = document.createElement("link");

    //creates an id for the style sheet
    var styleLink = document.getElementById(styleId);

    //if a page style isn't set sets the default stylesheet
    if (!pageStyle) {
        pageStyle = "style";
    }

    //sets the variable to the location of the selected stylesheet
    fileName = styleLocation+pageStyle+".css";

    //Sets attributes to the element from fileRef variable
    fileRef.setAttribute("rel", "stylesheet");
    fileRef.setAttribute("type", "text/css");
    fileRef.setAttribute("href", fileName);
    fileRef.setAttribute("id", styleId);

    //if styleLink is not set, adds the fileRef element to the head
    if (!styleLink) {
        document.getElementsByTagName("head")[0].appendChild(fileRef);
    }
    //if styleLink is set, replaces the previous fileRef with the styleLink
    else {
        styleLink.parentNode.replaceChild(fileRef, styleLink);
    }
}
