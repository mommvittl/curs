// Модуль работы с окном поиска search в header

var searchData = document.forms.globalSearch.elements.searchData;
searchData.oninput = searchFormInputData;
searchData.setAttribute("autocomplete","off");
var promptingWindow = document.getElementById('promptingWindow');
var globalSearch = document.forms.globalSearch;
globalSearch.onsubmit = searchFormSubmit;
promptingWindow.hidden = true;

//----------------------------------------------------------
function searchFormInputData(){
	promptingWindow.hidden = "";
	var searchDataValue = searchData.value;
	if (searchDataValue.length > 0){
		var theUrl = "/ajaxStudents/globalSearch";
		var theParam = "functionHandler=viewSearchPrompting&searchValue=" + encodeURIComponent(searchDataValue);	
		setAjaxQuery(theUrl,theParam);
	}else{ 
		promptingWindow.hidden = true;
	}
}
//-----------------------------------------------------------------
function viewSearchPrompting(responseXMLDocument){
//	alert(myReq.responseText);	
	promptingWindow.innerHTML = "";	
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	if(nextStaff.length > 0){ 
		promptingWindow.hidden = ""; 
	}else{ promptingWindow.hidden = true; }
	for (var i = 0; i < nextStaff.length; i++){
		var staffData = nextStaff[i].textContent;
		var student = JSON.parse(staffData);
		var row = document.createElement('p');
		row.className = "promptingRow";
		row.textContent = student.surname + " " + student.name + " группа: " + student.groupTitle;
		row.onclick = getDetaliedPromptingInfo;
		row.setAttribute('idStaff', student.id) ;
		promptingWindow.appendChild(row);		
	}
}
//------------------------------------------------------------------
function getDetaliedPromptingInfo(){
	promptingWindow.hidden = true;	
	searchData.value = "";
	var id = this.getAttribute('idStaff');
	var theUrl = "/students/index/" + id;
	window.location = theUrl;	
};
//-----------------------------------------------------------------
function searchFormSubmit(){
	promptingWindow.hidden = true;
/*	
	var searchDataValue = searchData.value;
	searchData.value = "";	
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewAllstaff&searchList=search&surnameSearch=" + encodeURIComponent(searchDataValue);	
	setAjaxQuery(theUrl,theParam);	
*/	
	return false;
}
//---------------------------------------------------------------------


