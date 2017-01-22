var myReq = getXMLHttpRequest();
var responseXMLDocument;
var cacheAjaxQuery = new MyAjaxCache;
//-----------------------------------------------------------------------------------
//Конструктор для обьекта кеш запросов Ajax
function MyAjaxCache() {
    var cache = [];
    this.push = function (object) {
        cache.push(object);
    }
    this.shift = function () {
        if (cache.length != 0) {
            return cache.shift()
        } else {
            return false;
        }
    }
    this.length = function () {
        return cache.length;
    }
}
// ===== Ajax ===создание===обьекта====XMLHttpRequest===========
function getXMLHttpRequest()
{
    var req;
    if (window.ActiveXObject) {
        try {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            req = false;
        }
    } else {
        try {
            req = new XMLHttpRequest();
        } catch (e) {
            req = false;
        }
    }
    if (!req) {
        alert("Error - ошибка  1 создания обьекта XMLHttpRequest");
    } else {
        return req;
    }
}
;
// ---------------------------------------------------------------
//======функция====отпр.===ajax===POST===запроса================
function sendAjaxQuery() {
    if (!cacheAjaxQuery || cacheAjaxQuery.length() == 0)
        return false;
    if (myReq) {
        if (myReq.readyState == 4 || myReq.readyState == 0) {
            var cacheEntry = cacheAjaxQuery.shift();
            var theUrl = cacheEntry.url;
            var theParam = cacheEntry.param;
            myReq.open("POST", theUrl, true);
            myReq.onreadystatechange = getAjaxResponse;
            myReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            myReq.setRequestHeader("Content-length", theParam.length);
            myReq.setRequestHeader("Connection", "close");
            myReq.send(theParam);
        } else {
            setTimeout('sendAjaxQuery()', 1000);
        }
    } else {
        alert("Error - ошибка 2 создания обьекта XMLHttpRequest");
    }
    ;
}
;
//-------------------------------------------------------------
function setAjaxQuery(theUrl, theParam) {
    if (cacheAjaxQuery && cacheAjaxQuery.length() < 50) {
        cacheAjaxQuery.push({'url': theUrl, 'param': theParam});
        sendAjaxQuery();
    }
}
;
//--------------------------------------------------------------

//======функция====разбора===входящего==XMLDocument==============
//==варианты==принимаемых===корневых===тегов:====================
//==<response>==<error>==<underreporting>========================
//==var myReq = getXMLHttpRequest();==вставляем в начало скрипта
//==var responseXMLDocument;==обьявляем переменную через кот передаем XML документ на обработку
//Если отклик правильный то ф-я вызывает обработчик имя которого передано из сервера в теге <functionHandler>
//туда передаем корневой элемент XML - т.е. <response>
function getAjaxResponse() {

    if (myReq.readyState == 4) {
        if (myReq.status == 200) {
            var theXMLresponseDoc = myReq.responseXML;
            if (!theXMLresponseDoc || !theXMLresponseDoc.documentElement) {
                alert("Неверная структура документа XML .  " + myReq.responseText);
            } else {
//				alert(myReq.responseText);
                firstNodeName = theXMLresponseDoc.childNodes[0].tagName;
                switch (firstNodeName) {
                    case 'response':
                        var theRootXMLresponseTag = theXMLresponseDoc.childNodes[0];
                        var functionNameHandler = theXMLresponseDoc.getElementsByTagName('functionHandler')[0].textContent;
                        responseXMLDocument = theXMLresponseDoc;
                        var handlerXMLresponseName = functionNameHandler + "(responseXMLDocument)";
                        setTimeout(handlerXMLresponseName, 0);
                        break;
                    case 'underreporting':
//					var functionNameHandler = theXMLresponseDoc.getElementsByTagName('functionHandler')[0].textContent;
                        dispModalInformWindow(theXMLresponseDoc.childNodes[0].textContent);
                        break;
                    case 'error':
//					var functionNameHandler = theXMLresponseDoc.getElementsByTagName('functionHandler')[0].textContent;
                        dispModalErrorWindow(theXMLresponseDoc.childNodes[0].textContent);
                        break;
                }
            }
        }
    }
    sendAjaxQuery();
}
;
//====функция====вывода===модального==Error===окна================
function dispModalErrorWindow(stringError) {
    var modalErrorWindow = document.createElement('div');
    modalErrorWindow.innerHTML = "<h1>Sorry....Error...</h1><hr/><h2>" + stringError + "</h2>";
    document.body.insertBefore(modalErrorWindow, document.body.firstChild);
    modalErrorWindow.style.cssText = "width:800px;max-width: 100%;height: 800px;max-height: 100%;cursor:pointer;padding:10px;background:#F4A460;color:#800000;text-align:center;font: 1em/2em arial;border: 4px solid #A52A2A;position:fixed;z-index: 1000;top:50%;left:50%;transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;";
    modalErrorWindow.onclick = function () {
        document.body.removeChild(modalErrorWindow);
    }
    return true;
}
;
//----------------------------------------------------------------
//====функция====вывода===модального==Inform===окна================
function dispModalInformWindow(stringInform) {
    var modalInformWindow = document.createElement('div');
    modalInformWindow.innerHTML = "<h1>" + stringInform + "</h1>";
    document.body.insertBefore(modalInformWindow, document.body.firstChild);
    modalInformWindow.style.cssText = "width:600px;max-width: 100%;height: 600px;max-height: 100%;cursor:pointer;padding:10px;background:#7A96A1;color:#FFFFF0;text-align:center;font: 1em/2em arial;border: 4px double #1E0D69;position:fixed;z-index: 1000;top:50%;left:50%;transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;";
    modalInformWindow.onclick = function () {
        document.body.removeChild(modalInformWindow);
    }
    return true;
}
;
//----------------------------------------------------------------	
//--------------------------------------------------------------
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}//=============================================================================
