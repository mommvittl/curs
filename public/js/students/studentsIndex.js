// alert("student")
var page = 1;
var asideAjaxGroupsContent = document.getElementById('asideAjaxGroupsContent');
getElementtList(1);
if( idElementForPersonalPage ) { getPersonElement(idElementForPersonalPage); }
//====================================================================================
function getElementtList(pageData){
	var pageData = pageData || 1;
	var theUrl = "/studentsAjax/elementList";
	var theParam = "arrParam=" + JSON.stringify({"work":"1"}) + "&page=" + pageData;	
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewElementList,'POST','xml');
}
//====================================================================================
function viewElementList(responseXMLDocument){
	// alert(responseXMLDocument);
	var pageDomElement = responseXMLDocument.getElementsByTagName('page');
	var page = (pageDomElement && pageDomElement.length > 0) ? pageDomElement[0].textContent : 1;
	asideAjaxGroupsContent.innerHTML = "";
	var pageDomElement = responseXMLDocument.getElementsByTagName('pager');	
	if (pageDomElement && pageDomElement.length > 0){
		var pagerText = pageDomElement[0].textContent;
		var pager = JSON.parse(pagerText);
		viewPager(pager,asideAjaxGroupsContent,page,getElementtList);	
	}
	var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
	if (nextElementDomElement && nextElementDomElement.length > 0){
		var arrElement = [];
		var arrTitleForTable = { 'name':'имя','surname':'фамилия','telephon':'телефон','email':'email' }
		for (var i = 0; i < nextElementDomElement.length; i++){
			arrElement.push(JSON.parse(nextElementDomElement[i].textContent));	
		}
		viewTableElements(arrElement,asideAjaxGroupsContent,arrTitleForTable,'id',getPersonElement);	
	}
}
//====================================================================================================
function getPersonElement(idElementData){
	var idElement = idElementData || this.getAttribute('idElement');
	var theUrl = "/studentsAjax/elementPersonal";
	var theParam = "idElement=" + idElement;
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewPersonElement,'POST','xml');
}
//===================================================================================================
function viewPersonElement(responseXMLDocument){
//	alert(myReq.responseText);
	var personalData = document.getElementById('personalData');
	personalData.innerHTML = "";
	var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
	if (nextElementDomElement && nextElementDomElement.length > 0){
		var arrTitleForTable = { 'name':'имя','surname':'фамилия','birthday':'дата рождения','adress':'адрес','telephon':'телефон','email':'email','skype':'skype','status':'должность','statusAuthent':'статус доступа','nameAuthent':'nicName' }
		var nextElement = JSON.parse(nextElementDomElement[0].textContent);
		var p = document.createElement('p');
		p.className = "strMenuElements";
		var stringDelete = "Вы уверены, что хотите удалить <br><strong>" + nextElement.name + " " + nextElement.surname + "</strong><br> из списка студентов?";
		var f1 = deletePersonalElement.bind(p,nextElement.id);
		p.innerHTML = "<span><span id='delteacher'>удалить</span></span><span><span id='update'>редактировать</span></span><span><span id='temetable'>расписание</span></span>";
		personalData.appendChild(p);
		var delteacher = document.getElementById('delteacher');		
		delteacher.onclick = modalDeleteWindow.bind(p,f1,stringDelete);
		var update = document.getElementById('update');		
		update.onclick = updataPersonalElement.bind(p,nextElement);
		var temetable = document.getElementById('temetable');		
		temetable.onclick = temetablePersonalElement.bind(p,nextElement);
		viewPersonalTableElements(nextElement,personalData,arrTitleForTable);	
	}
}
//=======================================================================================================
function deletePersonalElement(idElementData){
    var theUrl = "/studentsAjax/elementDelete";
    var theParam = "idElement=" + idElementData;	
    ajaxPOST.setAjaxQuery(theUrl,theParam,viewPersonElement,'POST','xml');
}
function updataPersonalElement(nextElementData){
   	var updateModal = viewModalWindow()
	var div = document.createElement('div');
	updateModal.appendChild(div);
	div.innerHTML = "<form name='addStudentsForm' class='createElementForm'><p><input name='reset' type='reset'></input><input name='submit' type='submit'></input></p></form>"	
	var table = document.createElement('table');
	table.className = "updateTable";
	document.forms.addStudentsForm.appendChild(table);
	table.innerHTML = "<tr><td>Имя</td><td class='createInput' ><input name='name' type='text' value='" + nextElementData.name + "'></input></td></tr>";
	table.innerHTML += "<tr><td>Фамилия</td><td class='createInput'><input name='surname' type='text' value='" + nextElementData.surname + "'></input></td></tr>";
	table.innerHTML += "<tr><td>Дата рождения</td><td class='createInput'><input name='birthday' type='date' value='" + nextElementData.birthday + "'></input></td></tr>";
	table.innerHTML += "<tr><td>Телефон</td><td class='createInput'><input name='telephon' type='text' value='" + nextElementData.telephon + "'></input></td></tr>";
	table.innerHTML += "<tr><td>Адрес</td><td class='createInput'><input name='adress' type='text' value='" + nextElementData.adress + "'></input></td></tr>";
	table.innerHTML += "<tr><td>email</td><td class='createInput'><input name='email' type='email' value='" + nextElementData.email + "'></input></td></tr>";
	table.innerHTML += "<tr><td>skype</td><td class='createInput'><input name='skype' type='text' value='" + nextElementData.skype + "'></input></td></tr>";	
	var addStudentsForm = document.forms.addStudentsForm;
	addStudentsForm.setAttribute("autocomplete","off");
	addStudentsForm.onsubmit = submitValidate.bind(addStudentsForm,"/studentsAjax/elementAdd",'update',viewResultAddElement,nextElementData.id, 0 );
	for (var i =0; i < addStudentsForm.elements.length; i++ ){
		addStudentsForm.elements[i].setAttribute('errorValueFlaf',0);
		if((addStudentsForm.elements[i].type != 'reset') && (addStudentsForm.elements[i].type != 'submit')){
			addStudentsForm.elements[i].onblur = onblurValidate;
			addStudentsForm.elements[i].onfocus = onfocusValidate;
		if(addStudentsForm.elements[i].type != 'date') { addStudentsForm.elements[i].oninput = oninputValidate; }		
		}
	}	
}
function temetablePersonalElement(nextElementData){
    alert( 'temetable student' );
}

//----------------------------------------------------------------------------
function viewResultAddElement(responseXMLDocument){
    var flagResultDomElement = responseXMLDocument.getElementsByTagName('flagResult');	
        if (flagResultDomElement && flagResultDomElement.length > 0){
          if( flagResultDomElement[0].textContent == 0 ){
            var closeButton = document.getElementById('closeButton');
            closeButton.onclick();
            var idTeach = (  flagResultDomElement[0].getAttribute('idElement')  ) ? +(flagResultDomElement[0].getAttribute('idElement')) : 0 ;
            getPersonElement(idTeach);	
          }else if( flagResultDomElement[0].textContent == 2 ){
              var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
              if (nextElementDomElement && nextElementDomElement.length > 0){
                  var nextElement = JSON.parse(nextElementDomElement[0].textContent);
                  for (var i =0; i < addTeacherForm.elements.length; i++ ){
                      if((addTeacherForm.elements[i].type != 'reset') && (addTeacherForm.elements[i].type != 'submit')){
                          addTeacherForm.elements[i].value = nextElement[addTeacherForm.elements[i].name];
                          oninputValidate.call(addTeacherForm.elements[i]);
                      }
                  }
              }			
          }
    }
    var resultAddTeacherDomElement = responseXMLDocument.getElementsByTagName('resultAddTeacher');	
    if (resultAddTeacherDomElement && resultAddTeacherDomElement.length > 0 ){
        resultAddTeacher = resultAddTeacherDomElement[0].textContent;
        modalInformWindow(resultAddTeacher);
    }	
}














