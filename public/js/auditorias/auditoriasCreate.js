//alert(" create ")
var addAuditoriasForm = document.forms.addAuditoriasForm;
addAuditoriasForm.setAttribute("autocomplete", "off");
addAuditoriasForm.onsubmit = submitValidate.bind(addAuditoriasForm, "/auditoriasAjax/elementsUpdate", "add", viewResultAdd.bind(addAuditoriasForm), 0, 0);
for (var i = 0; i < addAuditoriasForm.elements.length; i++) {
    addAuditoriasForm.elements[i].setAttribute('errorValueFlaf', 0);
    if ((addAuditoriasForm.elements[i].type != 'reset') && (addAuditoriasForm.elements[i].type != 'submit')) {
        addAuditoriasForm.elements[i].onblur = onblurValidate;
        addAuditoriasForm.elements[i].onfocus = onfocusValidate;
        addAuditoriasForm.elements[i].oninput = oninputValidate;
    }
}
//----------------------------------------------------------------------------
function viewResultAdd(responseXMLDocument) {
//	alert("result add ");
    var flagResultDomElement = responseXMLDocument.getElementsByTagName('flagResult');
    if (flagResultDomElement && flagResultDomElement.length > 0) {
        if (flagResultDomElement[0].textContent == 0) {
            this.elements.reset.click();
        } else if (flagResultDomElement[0].textContent == 2) {
            var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
            if (nextElementDomElement && nextElementDomElement.length > 0) {
                var nextElement = JSON.parse(nextElementDomElement[0].textContent);
                for (var i = 0; i < this.elements.length; i++) {
                    if ((this.elements[i].type != 'reset') && (this.elements[i].type != 'submit')) {
                        this.elements[i].value = nextElement[this.elements[i].name];
                        oninputValidate.call(this.elements[i]);
                    }
                }
            }
        }
    }
    var resultAddTeacherDomElement = responseXMLDocument.getElementsByTagName('resultAddElement');
    if (resultAddTeacherDomElement && resultAddTeacherDomElement.length > 0) {
        resultAddTeacher = resultAddTeacherDomElement[0].textContent;
        modalInformWindow(resultAddTeacher)
    }
}




















