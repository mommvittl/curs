//alert('create')
var addStudentsForm = document.forms.addStudentsForm;
addStudentsForm.setAttribute("autocomplete", "off");
addStudentsForm.onsubmit = submitValidate.bind(addStudentsForm, "/studentsAjax/elementAdd", "add", viewResultAddElement);
for (var i = 0; i < addStudentsForm.elements.length; i++) {
    addStudentsForm.elements[i].setAttribute('errorValueFlaf', 0);
    if ((addStudentsForm.elements[i].type != 'reset') && (addStudentsForm.elements[i].type != 'submit')) {
        addStudentsForm.elements[i].onblur = onblurValidate;
        addStudentsForm.elements[i].onfocus = onfocusValidate;
        if (addStudentsForm.elements[i].type != 'date') {
            addStudentsForm.elements[i].oninput = oninputValidate;
        }
    }
}
//----------------------------------------------------------------------------
function viewResultAddElement(responseXMLDocument) {
//	alert(myReq.responseText);
    var flagResultDomElement = responseXMLDocument.getElementsByTagName('flagResult');
    if (flagResultDomElement && flagResultDomElement.length > 0) {
        if (flagResultDomElement[0].textContent == 0) {
            document.forms.addStudentsForm.elements.reset.click();
        } else if (flagResultDomElement[0].textContent == 2) {
            var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
            if (nextElementDomElement && nextElementDomElement.length > 0) {
                var nextElement = JSON.parse(nextElementDomElement[0].textContent);
                for (var i = 0; i < addStudentsForm.elements.length; i++) {
                    if ((addStudentsForm.elements[i].type != 'reset') && (addStudentsForm.elements[i].type != 'submit')) {
                        addStudentsForm.elements[i].value = nextElement[addStudentsForm.elements[i].name];
                        oninputValidate.call(addStudentsForm.elements[i]);
                    }
                }
            }
        }
    }
    var resultAddTeacherDomElement = responseXMLDocument.getElementsByTagName('resultAddElement');
    if (resultAddTeacherDomElement && resultAddTeacherDomElement.length > 0) {
        resultAddTeacher = resultAddTeacherDomElement[0].textContent;
        modalInformWindow(resultAddTeacher);
    }
}

