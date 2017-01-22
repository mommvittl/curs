//----------------------------------------------------------------------------
function submitValidate(theUrlData, paramAddUpdData, idData) {
    var paramAddUpd = (paramAddUpdData) ? paramAddUpdData : 'add';
    var idTeach = (idData) ? +(idData) : 0;
    for (var i = 0; i < addTeacherForm.elements.length; i++) {
        var errValFlag = addTeacherForm.elements[i].getAttribute('errorValueFlaf');
        if (errValFlag != 0) {
            return false;
        }
    }
    var arrInputValue = {}
    var arrLengthValue = {'name': 2, 'surname': 2, 'telephon': 5, 'skype': 2, 'email': 3, 'adress': 6, 'birthday': 10}
    for (var i = 0; i < addTeacherForm.elements.length; i++) {
        if ((addTeacherForm.elements[i].type != 'reset') && (addTeacherForm.elements[i].type != 'submit')) {
            var activeTagName = addTeacherForm.elements[i].name;
            var val = String(addTeacherForm.elements[i].value);
            if (!val || (val.length < arrLengthValue[activeTagName])) {
                break;
            }
            arrInputValue[activeTagName] = val;
        }
    }
    if (i == addTeacherForm.elements.length) {
        var theParam = "paramAddUpd=" + paramAddUpd + "&idElement=" + idTeach + "&arrInputValue=" + JSON.stringify(arrInputValue);
        ajaxPOST.setAjaxQuery(theUrlData, theParam, viewResultAddElement, 'POST', 'xml');
    } else {
        modalInformWindow("не все поля заполнены");
    }
    return false;
}

//----------------------------------------------------------------------------
function onblurValidate() {
    var activeTagName = this.name;
    var val = String(this.value);
    var arrLengthValue = {'name': 2, 'surname': 2, 'telephon': 5, 'skype': 2, 'email': 3, 'adress': 6, 'birthday': 10}
    if ((val.length > 0) && (val.length < arrLengthValue[activeTagName]) && (this.getAttribute('errorValueFlaf') != 2)) {
        this.setAttribute('errorValueFlaf', 1);
        var before = document.createElement('::before');
        before.className = "errBefore";
        before.innerHTML = 'слишком короткое поле';
        this.parentElement.insertBefore(before, this);
    }
    return;
}
//----------------------------------------------------------------------------
function onfocusValidate() {
    if (this.getAttribute('errorValueFlaf') == 1) {
        var elem = this.parentElement.getElementsByClassName("errBefore");
        for (var i = 0; i < elem.length; i++) {
            this.parentElement.removeChild(elem[i]);
        }
        this.setAttribute('errorValueFlaf', 0);
    }
    return;
}
//----------------------------------------------------------------------------
function oninputValidate() {
    var activeTagName = this.name;
    var val = String(this.value);
    var funValid = function (activeTagName) {
        switch (activeTagName) {
            case 'telephon':
                return function (a) {
                    return (((a >= 48) && (a <= 57)) || (a == 32) || (a == 45) || (a == 40) || (a == 41)) ? true : false;
                }
                break;
            case 'surname':
            case 'name':
                return function (a) {
                    return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || ((a >= 1040) && (a <= 1103)) || (a == 32) || (a == 45) || (a == 46) || (a == 39) || (a == 44) || (a == 95)) ? true : false;
                }
                break;
            case 'email':
            case 'skype':
                return function (a) {
                    return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || (a == 32) || (a == 45) || (a == 46) || (a == 64) || (a == 95)) ? true : false;
                    ;
                }
                break;
            case 'adress':
                return function (a) {
                    return true;
                }
                break;
            default:
                return function (a) {
                    return true;
                }
        }
    }
    var strError = {'telephon': 'только цифры 0-9,- и пробел...', 'skype': 'только a-z,A-Z,0-9,_,.,@', 'email': 'только a-z,A-Z,0-9,_,.,@',
        'name': 'только a-z,A-Z,а-я,А-Я, пробел и \'', 'surname': 'только a-z,A-Z,а-я,А-Я, пробел и \''}

    var elem = this.parentElement.getElementsByClassName("errBefore");
    for (var i = 0; i < elem.length; i++) {
        this.parentElement.removeChild(elem[i]);
    }
    this.setAttribute('errorValueFlaf', 0);

    for (var i = 0; i < val.length; i++) {
        if (!(funValid(activeTagName))(val.charCodeAt(i)))
            break;
    }
    if (i != val.length) {
        this.setAttribute('errorValueFlaf', 2);
        var before = document.createElement('::before');
        before.className = "errBefore";
        before.innerHTML = strError[activeTagName];
        this.parentElement.insertBefore(before, this);
    }
    return;
}
//----------------------------------------------------------------------------