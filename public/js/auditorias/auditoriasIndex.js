//alert("auditorias");
var asideAjaxGroupsContent = document.getElementById('asideAjaxGroupsContent');
getElementList(1);
//====================================================================================
function getElementList(pageData){
        var pageData = pageData || 1;
        var theUrl = "/auditoriasAjax/elementsList";
        var theParam = "arrParam=" + JSON.stringify({"work":"1"}) + "&page=" + pageData;	
        ajaxPOST.setAjaxQuery(theUrl,theParam,viewElementList,'POST','xml');
}
//====================================================================================
function viewElementList(responseXMLDocument){
//    alert(responseXMLDocument);
	asideAjaxGroupsContent.innerHTML = "";	
    var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
    if (nextElementDomElement && nextElementDomElement.length > 0){
		var table = document.createElement('table');
		table.className = "resultTable";
		asideAjaxGroupsContent.appendChild(table);
		table.innerHTML = "<tr><th>Название</th><th>адрес</th><th>описание</th><th></th><th></th></tr>";
		var arrTitleForTable = { 'title' : 'название' , 'adress' : 'адрес' , 'description' : 'описание' };
		for (var i = 0; i < nextElementDomElement.length; i++){
            var nextElement = JSON.parse(nextElementDomElement[i].textContent);
			var tr = document.createElement('tr');
			tr.setAttribute('idElement',nextElement.id);
			tr.innerHTML = "<td>" + nextElement.title + "</td><td>" + nextElement.adress + "</td><td>" + nextElement.description + "</td><td class='upd' id='updAuditorias"+i+"'></td><td class='del' id='delAutitorias"+i+"'></td>"				
			table.appendChild(tr);
			var str = "Вы уверены, что хотите удалить аудиторию <br><strong>" + nextElement.title + "</strong><br> по адресу <br><strong>" + nextElement.adress + "</strong><br> из списка используемых аудиторий?";		
			var updAuditorias = document.getElementById('updAuditorias'+i);		
			updAuditorias.onclick = updateAuditorias.bind(tr,nextElement);
			var delAutitorias = document.getElementById('delAutitorias'+i);		
			delAutitorias.onclick = modalDeleteWindow.bind(tr,deleteAuditorias.bind(tr,nextElement.id),str);	
		}	
    }   
}

function deleteAuditorias(idElementData){
	var idElement = idElementData || 0 ;
	var theUrl = "/auditoriasAjax/elementsDelete";
    var theParam = "&idElement=" + idElement;	
    ajaxPOST.setAjaxQuery(theUrl,theParam,getElementList,'POST','xml');
}
function updateAuditorias(nextElementData){
	var updateModal = viewModalWindow()
	var div = document.createElement('div');
	updateModal.appendChild(div);
	div.innerHTML = "<form name='addAuditoriasForm' class='createElementForm'><p><input name='reset' type='reset'></input><input name='submit' type='submit'></input></p></form>";
	var table = document.createElement('table');
	table.className = "updateTable";
	var addAuditoriasForm = document.forms.addAuditoriasForm;
	addAuditoriasForm.appendChild(table);
	table.innerHTML = "<tr><td>Название аудитории</td><td class='createInput' ><input name='title' type='text' value='" + nextElementData.title + "'</td></tr>";
	table.innerHTML += "<tr><td>адрес</td><td class='createInput'><input name='adress' type='text' value='" + nextElementData.adress + "'</td></tr>";
	table.innerHTML += "<tr><td>Описание</td><td class='createInput'><textarea name='description' cols='50' rows='8' >" + nextElementData.description + "</textarea></td></tr>";
	addAuditoriasForm.setAttribute("autocomplete","off");
	var addAuditoriasForm = document.forms.addAuditoriasForm;
	addAuditoriasForm.setAttribute("autocomplete","off");
	addAuditoriasForm.onsubmit = submitValidate.bind(addAuditoriasForm,"/auditoriasAjax/elementsUpdate","update",viewResultUpd.bind(addAuditoriasForm),nextElementData.id,0);
	for (var i =0; i < addAuditoriasForm.elements.length; i++ ){
		addAuditoriasForm.elements[i].setAttribute('errorValueFlaf',0);
		if((addAuditoriasForm.elements[i].type != 'reset') && (addAuditoriasForm.elements[i].type != 'submit')){
			addAuditoriasForm.elements[i].onblur = onblurValidate;
			addAuditoriasForm.elements[i].onfocus = onfocusValidate;
			addAuditoriasForm.elements[i].oninput = oninputValidate; 		
		}
	}		
}
//----------------------------------------------------------------------------
function viewResultUpd(responseXMLDocument){
//	alert("result add ");
	var flagResultDomElement = responseXMLDocument.getElementsByTagName('flagResult');	
	if (flagResultDomElement && flagResultDomElement.length > 0){
		if( flagResultDomElement[0].textContent == 0 ){
			var closeButton = document.getElementById('closeButton');
			closeButton.onclick(); 
			getElementList();
		}else if( flagResultDomElement[0].textContent == 2 ){
			var nextElementDomElement = responseXMLDocument.getElementsByTagName('nextElement');
			if (nextElementDomElement && nextElementDomElement.length > 0){
				var nextElement = JSON.parse(nextElementDomElement[0].textContent);
				for (var i =0; i < this.elements.length; i++ ){
					if((this.elements[i].type != 'reset') && (this.elements[i].type != 'submit')){
						this.elements[i].value = nextElement[this.elements[i].name];
						oninputValidate.call(this.elements[i]);
					}
				}
			}			
		}
	}
	var resultAddTeacherDomElement = responseXMLDocument.getElementsByTagName('resultAddElement');	
	if (resultAddTeacherDomElement && resultAddTeacherDomElement.length > 0 ){
		resultAddTeacher = resultAddTeacherDomElement[0].textContent;
		modalInformWindow(resultAddTeacher)
	}
}














