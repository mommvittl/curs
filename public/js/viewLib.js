//В ф-ю передаем строку с именем(и если нужно параметрами) ф-ии куда переходить если ДА
function modalDeleteWindow(functNameForLocation, strDelete) {
    var modal = document.createElement('div');
    var str = (strDelete) ? strDelete : "Вы уверены, что хотите удалить этот элемент?";
    modal.innerHTML = "<h1>" + str + "</h1><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
    document.body.insertBefore(modal, document.body.firstChild);
    modal.style.cssText = "min-width:500px;max-width: 100%;min-height: 200px;max-height: 100%;cursor:pointer;padding:10px;background:#F4A460;color:#800000;text-align:center;font: 1em/2em arial;border: 4px double #1E0D69;position:fixed;z-index: 1000;top:50%;left:50%;transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;"
    var ok_but = document.getElementById('ok_but');
    var cancel_but = document.getElementById('cancel_but');
    ok_but.style.cssText = "border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
    cancel_but.style.cssText = "border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";
    cancel_but.onclick = function ()
    {
        document.body.removeChild(modal);
    };
    ok_but.onclick = function ()
    {
        document.body.removeChild(modal);
        functNameForLocation();
    };
}
;
//------------------------------------------------------------------------------------------
//В ф-ю передаем строку с именем(и если нужно параметрами) ф-ии куда переходить если ДА
function modalUpdateWindow(functNameForLocation) {
    var modal = document.createElement('div');
    modal.innerHTML = "<h1>Вы уверены, что хотите изменить элемент?</h1><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
    document.body.insertBefore(modal, document.body.firstChild);
    modal.style.cssText = "min-width:500px;max-width: 100%;min-height: 200px;max-height: 100%;cursor:pointer;padding:10px;background:#BDBDBD;color:#3B3C1D;text-align:center;font: 1em/2em arial;border: 4px double #1E0D69;position:fixed;z-index: 1000;top:50%;left:50%;transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;"
    var ok_but = document.getElementById('ok_but');
    var cancel_but = document.getElementById('cancel_but');
    ok_but.style.cssText = "border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
    cancel_but.style.cssText = "border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";

    cancel_but.onclick = function ()
    {
        document.body.removeChild(modal);
    };
    ok_but.onclick = function ()
    {
        document.body.removeChild(modal);
        setTimeout(functNameForLocation, 0);
    };
}
;
//=========================================================================================================
//ф-я вывода строки пейджера.Принимает:
// pagerObject - обьект Pager полеченный из соотв.Экземпляра класса pagerModel
//domElementForviewPager - элемент DOM в конец списка элементов которого рисует строку пейджера
//numPageData - номер текущей страницы
//functionGoNewPage - ф-я кот.вызывается по клику на пейджере и куда передается номер выбранной страницы.
function viewPager(pagerObject, domElementForviewPager, numPageData, functionGoNewPage) {
    var p = document.createElement('p');
    p.className = "stringPagePointer";
    domElementForviewPager.appendChild(p);
    for (nexPointer in pagerObject) {
        var span = document.createElement('span');
        if (pagerObject[nexPointer] == '-1') {
            span.textContent = '...';
            span.className = "noPagePinter";
        } else {
            span.textContent = pagerObject[nexPointer];
            span.setAttribute("page", pagerObject[nexPointer]);
            span.onclick = function () {
                functionGoNewPage(this.getAttribute('page'));
            };
            if (pagerObject[nexPointer] == numPageData) {
                span.className = "activePagePointer";
            } else {
                span.className = "passivePagePointer";
            }
        }
        p.appendChild(span);
    }
}
//-----------------------------------------------------------------------------------------------------------
//Ф-я вывода модального окна.Принимает необязательный DOM элемент - куда окно будет добавлено.
//По умолчанию рисует окно в BODY. Возвращает себя. 
function viewModalWindow(domElementForInsertWindow) {
    var domParentElement = domElementForInsertWindow || document.body;
    var closeButton = document.getElementById('closeButton');
    if (closeButton != null) {
        closeButton.onclick();
    }
    var modalWindow = document.createElement('div');
    modalWindow.style.cssText = " background: #FAEBD7; box-shadow: 3px 3px black; position:absolute;z-index: 10;top:50%;left: 50%;transform:translate(-50%, -50%); padding: 5px 10px; border: 4px double #8B4513; padding: 5px;";
    domParentElement.appendChild(modalWindow);
    modalWindow.innerHTML = "<p class='clearfix'><button type='button' id='closeButton' style='cursor:pointer;float:right;background:#FFA07A;'>close</button></p><hr>";
    var closeButton = document.getElementById('closeButton');
    closeButton.onclick = function () {
        modalWindow.parentNode.removeChild(modalWindow);
    }
    return modalWindow;
}
//--------------------------------------------------------------------------------------------------
//====функция====вывода===модального==Inform===окна================
function modalInformWindow(stringInform) {
    var modalInformWindow = document.createElement('div');
    modalInformWindow.innerHTML = "<h1>" + stringInform + "</h1>";
    document.body.insertBefore(modalInformWindow, document.body.firstChild);
    modalInformWindow.style.cssText = "min-width:600px;max-width: 100%;min-height: 400px;max-height: 100%;cursor:pointer;padding:10px;background:#7A96A1;color:#FFFFF0;text-align:center;font: 1em/2em arial;border: 4px double #1E0D69;position:fixed;z-index: 1000;top:50%;left:50%;transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;";
    modalInformWindow.onclick = function () {
        document.body.removeChild(modalInformWindow);

    }
}
;
//----------------------------------------------------------------	
//ф-я вывода таблицы элементов.Принимаает
//arrElementData - массив обьектов для вывода,
//domElementForInputTable - DOM  элемент для вставки таблицы
//arrTitleForTableData - ассоциативный массив управления выводом( какие поля обьекта выводим в таблице) [ поля обьекта : заголовок соотв.столбца]
//idTitleData - имя ключевого поля, значение которого помещаем в атрибут 'idElement' строки tr таблицы
// functOnclickData - ф-я которая вызывается по onclick на строке таблицы
function viewTableElements(arrElementData, domElementForInputTable, arrTitleForTableData, idTitleData, functOnclickData) {
    var table = document.createElement('table');
    table.className = "resultTable";
    domElementForInputTable.appendChild(table);
    var tr = document.createElement('tr');
    table.appendChild(tr);
    for (item in  arrTitleForTableData) {
        var th = document.createElement('th');
        th.textContent = arrTitleForTableData[item];
        tr.appendChild(th);
    }
    for (var i = 0; i < arrElementData.length; i++) {
        var tr = document.createElement('tr');
        tr.setAttribute('idElement', arrElementData[i][idTitleData]);
        tr.onclick = functOnclickData.bind(tr, [arrElementData[i][idTitleData]]);
        table.appendChild(tr);
        for (item in  arrTitleForTableData) {
            var td = document.createElement('td');
            td.textContent = arrElementData[i][item];
            tr.appendChild(td);
        }
    }
}
//==========================================================================================================================
//ф-я вывода таблицы персональных данных
function viewPersonalTableElements(arrElementData, domElementForInputTable, arrTitleForTableData) {
    var table = document.createElement('table');
    table.className = "personalTable";
    domElementForInputTable.appendChild(table);
    for (item in  arrTitleForTableData) {
        var tr = document.createElement('tr');
        table.appendChild(tr);
        var td = document.createElement('td');
        td.textContent = arrTitleForTableData[item];
        tr.appendChild(td);
        var td = document.createElement('td');
        td.textContent = arrElementData[item];
        tr.appendChild(td);
    }
}
//=================================================================================================
















