//alert('create')
var addTeacherForm = document.forms.addTeacherForm;
addTeacherForm.setAttribute("autocomplete", "off");
addTeacherForm.onsubmit = submitValidate.bind(addTeacherForm, "/teacherAjax/teachersAdd");
for (var i = 0; i < addTeacherForm.elements.length; i++) {
    addTeacherForm.elements[i].setAttribute('errorValueFlaf', 0);
    if ((addTeacherForm.elements[i].type != 'reset') && (addTeacherForm.elements[i].type != 'submit')) {
        addTeacherForm.elements[i].onblur = onblurValidate;
        addTeacherForm.elements[i].onfocus = onfocusValidate;
        if (addTeacherForm.elements[i].type != 'date') {
            addTeacherForm.elements[i].oninput = oninputValidate;
        }
    }
}
//----------------------------------------------------------------------------
function viewResultAddElement(responseXMLDocument) {
//	alert(myReq.responseText);
    var flagResultDomElement = responseXMLDocument.getElementsByTagName('flagResult');
    if (flagResultDomElement && flagResultDomElement.length > 0) {
        if (flagResultDomElement[0].textContent == 0) {
            document.forms.addTeacherForm.elements.reset.click();
        } else if (flagResultDomElement[0].textContent == 2) {
            var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
            if (nextElementDomElement && nextElementDomElement.length > 0) {
                var nextElement = JSON.parse(nextElementDomElement[0].textContent);
                for (var i = 0; i < addTeacherForm.elements.length; i++) {
                    if ((addTeacherForm.elements[i].type != 'reset') && (addTeacherForm.elements[i].type != 'submit')) {
                        addTeacherForm.elements[i].value = nextElement[addTeacherForm.elements[i].name];
                        oninputValidate.call(addTeacherForm.elements[i]);
                    }
                }
            }
        }
    }
    var resultAddTeacherDomElement = responseXMLDocument.getElementsByTagName('resultAddTeacher');
    if (resultAddTeacherDomElement && resultAddTeacherDomElement.length > 0) {
        resultAddTeacher = resultAddTeacherDomElement[0].textContent;
        modalInformWindow(resultAddTeacher)
    }
}


















