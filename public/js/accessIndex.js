//alert("student");
var page = 1;
var asideAjaxGroupsContent = document.getElementById('asideAjaxGroupsContent');	
getUserList(1);

//====================================================================================
function getUserList(pageData){
	var theUrl = "/accessAjax/getAllElement";
	var theParam = "functionHandler=viewUserList&page=" + pageData;	
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewUserList,'POST','xml');	
//	setAjaxQuery(theUrl,theParam);
}
function viewUserList(responseXMLDocument){
//	alert(myReq.responseText);
	asideAjaxGroupsContent.innerHTML = "";
	var table = document.createElement('table');
	table.className = "resultTable";
	asideAjaxGroupsContent.appendChild(table);
	table.innerHTML = "<tr><th>NicName</th><th>статус</th><th>Имя</th><th>Фамилия</th><th>телефон</th><th>Email</th><th></th><th></th></tr>";
	var pageDomElement = responseXMLDocument.getElementsByTagName('page');
	if (pageDomElement.length){ page = pageDomElement[0].textContent; }	
	var pagerDomElement = responseXMLDocument.getElementsByTagName('pager');		
	if (pagerDomElement.length){
		var pagerText = pagerDomElement[0].textContent;
		var pager = JSON.parse(pagerText);		
		viewPager(pager,asideAjaxGroupsContent,page,getTemetableList);	
	}		
	var elementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
	if (elementDomElement.length){
		for (var i = 0; i < elementDomElement.length; i++){
			var nextElement = JSON.parse(elementDomElement[i].textContent);	
			var statusUser = nextElement.statusUser || "";
			var name = nextElement.name || "";
			var surname = nextElement.surname || "";
			var telephon = nextElement.telephon || "";
			var email = nextElement.email || "";
			var tr = document.createElement('tr');
			tr.innerHTML = "<td id='idUsers_"+nextElement.idUser+"'>"+nextElement.username+"</td><td id='statusUsers_"+nextElement.idUser+"'>"+statusUser+"</td><td>"+name+"</td><td>"+surname+"</td><td>"+telephon+"</td><td>"+email+"</td><td class='upd' onclick='updateElementList("+nextElement.idUser+")'></td><td class='del' onclick='modalDeleteWindow(\"deleteElementList("+nextElement.idUser+")\")'></td>";			
			table.appendChild(tr);
		}
	}	
	
}
//===========================================================================================================
function deleteElementList(idElementData){
	var theUrl = "/accessAjax/deleteElement";
	var theParam = "functionHandler=viewUserList&idUser=" + idElementData;	
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewUserList,'POST','xml');		
//	setAjaxQuery(theUrl,theParam);
}
function updateElementList(idElementData){
	var nicNameUser = document.getElementById('idUsers_'+idElementData).textContent;
	var statusUser = document.getElementById('statusUsers_'+idElementData).textContent;
	var domElementModalWindow = viewModalWindow(asideAjaxGroupsContent);
	if ((statusUser == 'teacher') || (statusUser == 'manager') ){		
		var p = document.createElement('p');
		p.innerHTML = "Выберите новый статус доступа для пользователя <strong>" + nicNameUser + "</strong>";
		domElementModalWindow.appendChild(p);
		var p = document.createElement('p');
		p.innerHTML = "<button value='teacher' idUser='"+idElementData+"' class='selectVariantBut'>TEACHER</button><button value='manager' idUser='"+idElementData+"' class='selectVariantBut'>MANAGER</button>";
		domElementModalWindow.appendChild(p);
		var buttonSelectVariant = document.querySelectorAll('p > .selectVariantBut');
		for (var i = 0; i < buttonSelectVariant.length; i++) { buttonSelectVariant[i].onclick =  updateStatusUser; }
	}else{ 	
		var p = document.createElement('p');
		p.innerHTML = "Выберите преподавателя для регистрации прав доступа пользователя <strong>" + nicNameUser + "</strong>";
		domElementModalWindow.appendChild(p);
		var div = document.createElement('div');
		div.id = "selectAddUserDiv";
		div.setAttribute('idUser',idElementData);
		domElementModalWindow.appendChild(div);	
		var theUrl = "/teacherAjax/getNotLoggetTeacher";
		var theParam = "functionHandler=viewSelectAddUser&idUser=" + idElementData;	
		ajaxPOST.setAjaxQuery(theUrl,theParam,viewSelectAddUser,'POST','xml');			
//		setAjaxQuery(theUrl,theParam);
	}	
}

function viewSelectAddUser(responseXMLDocument){
//	alert(myReq.responseText);
	var selectAddUserDiv = document.getElementById('selectAddUserDiv');
	var table = document.createElement('table');
	table.className = "resultTable";
	selectAddUserDiv.appendChild(table);
	var elementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
	if (elementDomElement.length){
		for (var i = 0; i < elementDomElement.length; i++){
			var nextElement = JSON.parse(elementDomElement[i].textContent);	
			var tr = document.createElement('tr');
			tr.setAttribute('idTeach',nextElement.id);
			tr.setAttribute('idUser',selectAddUserDiv.getAttribute('idUser') );
			tr.innerHTML = "<td>"+nextElement.name+"</td><td>"+nextElement.surname+"</td><td>"+nextElement.telephon+"</td><td>"+nextElement.email+"</td>";			
			table.appendChild(tr);
			tr.onclick = updateTeacherForUser;
		}
	}	
}
function updateTeacherForUser(){
	document.getElementById('closeButton').onclick();
	var theUrl = "/accessAjax/updateTeacherForUser";
	var theParam = "functionHandler=viewUserList&idUser=" + this.getAttribute('idUser')  + "&idTeach=" + this.getAttribute('idTeach');
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewUserList,'POST','xml');
//	setAjaxQuery(theUrl,theParam);
}
function updateStatusUser(){
	document.getElementById('closeButton').onclick();
	var idUser = this.getAttribute('idUser');	
	var theUrl = "/accessAjax/updateStatusElement";
	var theParam = "functionHandler=viewUserList&idUser=" + idUser + "&status=" + this.value;
	ajaxPOST.setAjaxQuery(theUrl,theParam,viewUserList,'POST','xml');
//	setAjaxQuery(theUrl,theParam);
}
//=================================================================================================================






















