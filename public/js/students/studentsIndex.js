//alert("teachers")
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
//	alert(responseXMLDocument);
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
		var stringDelete = "Вы уверены, что хотите удалить <br><strong>" + nextElement.name + " " + nextElement.surname + "</strong><br> из списка преподавателей?";
		var f1 = deletePersonalElement.bind(p,[nextElement.id]);
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

}
function updataPersonalElement(nextElementData){

}
function temetablePersonalElement(nextElementData){
	
}

















