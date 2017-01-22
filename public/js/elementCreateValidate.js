//----------------------------------------------------------------------------
function submitValidate(theUrlData, paramAddUpdData, viewResultAddElementFunct, idData, arrLengthValueData, event) {
    var arrLengthValue = arrLengthValueData || {'name': 2, 'surname': 2, 'telephon': 5, 'skype': 2, 'email': 3, 'adress': 6, 'title': 2, 'birthday': 10, 'description': 2};
    var paramAddUpd = (paramAddUpdData) ? paramAddUpdData : 'add';
    var idTeach = +(idData) || 0;
    // var idTeach = (idData) ? +(idData) : 0 ;
    for (var i = 0; i < this.elements.length; i++) {
        var errValFlag = this.elements[i].getAttribute('errorValueFlaf');
        if (errValFlag != 0) {
            return false;
        }
    }
    var arrInputValue = {}
    for (var i = 0; i < this.elements.length; i++) {
        if ((this.elements[i].type != 'reset') && (this.elements[i].type != 'submit')) {
            var activeTagName = this.elements[i].name;
            var val = String(this.elements[i].value);
            if (!val || (val.length < arrLengthValue[activeTagName])) {
                break;
            }
            arrInputValue[activeTagName] = val;
        }
    }
    if (i == this.elements.length) {
        var theParam = "paramAddUpd=" + paramAddUpd + "&idElement=" + idTeach + "&arrInputValue=" + JSON.stringify(arrInputValue);
        ajaxPOST.setAjaxQuery(theUrlData, theParam, viewResultAddElementFunct, 'POST', 'xml');
    } else {
        modalInformWindow("не все поля заполнены");
    }
    return false;
}

//----------------------------------------------------------------------------
function onblurValidate(event, arrLengthValueData) {
    var arrLengthValue = arrLengthValueData || {'name': 2, 'surname': 2, 'telephon': 5, 'skype': 2, 'email': 3, 'adress': 6, 'title': 2, 'birthday': 10, 'description': 2};
    var activeTagName = this.name;
    var val = String(this.value);
    if ((val.length > 0) && (val.length < arrLengthValue[activeTagName]) && (this.getAttribute('errorValueFlaf') != 2)) {
        this.setAttribute('errorValueFlaf', 1);
        var before = document.createElement('::before');
        before.className = "errBefore";
        before.innerHTML = 'слишком короткое поле';
        this.parentElement.insertBefore(before, this);
    }
    ;
    return;
}
;
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
;
//----------------------------------------------------------------------------
function oninputValidate(event, arrRightSymbolData, arrStrErrorData) {
    var arrFunctionCharValid = {
        'name': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || ((a >= 1040) && (a <= 1103)) || (a == 32) || (a == 45) || (a == 46) || (a == 39) || (a == 44) || (a == 95)) ? true : false;
        },
        'surname': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || ((a >= 1040) && (a <= 1103)) || (a == 32) || (a == 45) || (a == 46) || (a == 39) || (a == 44) || (a == 95)) ? true : false;
        },
        'telephon': function (a) {
            return (((a >= 48) && (a <= 57)) || (a == 32) || (a == 45) || (a == 40) || (a == 41)) ? true : false;
        },
        'email': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || (a == 32) || (a == 45) || (a == 46) || (a == 64) || (a == 95)) ? true : false;
        },
        'skype': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || (a == 32) || (a == 45) || (a == 46) || (a == 64) || (a == 95)) ? true : false;
        },
        'adress': function (a) {
            return (((a >= 32) && (a <= 125)) || ((a >= 1040) && (a <= 1103))) ? true : false;
        },
        'birthday': function (a) {
            return (((a >= 48) && (a <= 57)) || (a == 32) || (a == 45)) ? true : false;
        },
        'title': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || ((a >= 1040) && (a <= 1103)) || (a == 32) || (a == 45) || (a == 46) || (a == 39) || (a == 44) || (a == 95)) ? true : false;
        },
        'description': function (a) {
            return (((a >= 48) && (a <= 57)) || ((a >= 65) && (a <= 90)) || ((a >= 97) && (a <= 122)) || ((a >= 1040) && (a <= 1103)) || (a == 32) || (a == 45) || (a == 46) || (a == 39) || (a == 44) || (a == 95)) ? true : false;
        }
    };
    var arrStrErrorIn = {
        'name': 'только a-z,A-Z,а-я,А-Я, пробел и \'',
        'surname': 'только a-z,A-Z,а-я,А-Я, пробел и \'',
        'telephon': 'только цифры 0-9,-,() и пробел...',
        'email': 'только a-z,A-Z,0-9,_,.,@',
        'skype': 'только a-z,A-Z,0-9,_,.,@',
        'adress': 'только a-z,A-Z,а-я,А-Я, пробел и \'',
        'birthday': 'только цифры 0-9,- и пробел...',
        'title': 'только a-z,A-Z,а-я,А-Я, пробел и \'',
        'description': 'только a-z,A-Z,а-я,А-Я, пробел и \''
    };
    var arrRightSymbol = arrRightSymbolData || arrFunctionCharValid;
    var arrStrError = arrStrErrorData || arrStrErrorIn;
    var activeTagName = this.name;
    var val = String(this.value);
    var elem = this.parentElement.getElementsByClassName("errBefore");
    for (var i = 0; i < elem.length; i++) {
        this.parentElement.removeChild(elem[i]);
    }
    this.setAttribute('errorValueFlaf', 0);
    for (var i = 0; i < val.length; i++) {
        if (!(arrRightSymbol[activeTagName](val.charCodeAt(i))))
            break;
    }
    if (i != val.length) {
        this.setAttribute('errorValueFlaf', 2);
        var before = document.createElement('::before');
        before.className = "errBefore";
        before.innerHTML = arrStrError[activeTagName];
        this.parentElement.insertBefore(before, this);
    }
    ;
    return;
}
;
//----------------------------------------------------------------------------