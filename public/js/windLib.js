// перехват onclick на ссылках. Чтобы повесить перехват, нужно присвоить ссылке класс intercep
// при выборе Ок в окне - переход по адресу, указанному в св-ве href тега А.
var intercep = document.getElementsByClassName('intercep');
	for (var i = 0; i <intercep.length; i++) 
	{ intercep[i].onclick = myf_modal_window; }		
	function myf_modal_window()
		{
	//	var ll = this.getAttribute('href');
		var modal = document.createElement('div');  		
		modal.innerHTML = "<h1>Вы уверены, что хотите удалить элемент?</h1><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
		document.body.insertBefore(modal, document.body.firstChild);	
		var ok_but = document.getElementById('ok_but');
		var cancel_but = document.getElementById('cancel_but');	
		modal.style.cssText="width:600px; max-width: 100%; padding:10px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);";
		ok_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
		cancel_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";
			
		cancel_but.onclick = function() 
			{ document.body.removeChild(modal); };			
		ok_but.onclick = function() 
			{
			document.body.removeChild(modal);
			return true;
	//		window.location = ll;				
			};		
		return false;
		};
//------------------------------------------------------------------------------------------	

	function dispModalQuestion()
		{
		var modal = document.createElement('div');  		
		modal.innerHTML = "<h1>Вы уверены, что хотите удалить элемент?</h1><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
		document.body.insertBefore(modal, document.body.firstChild);	
		var ok_but = document.getElementById('ok_but');
		var cancel_but = document.getElementById('cancel_but');	
		modal.style.cssText="width:600px; max-width: 100%; padding:10px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);box-shadow: 6px 6px #14536B;";
		ok_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
		cancel_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";		
		cancel_but.onclick = function() 
			{ document.body.removeChild(modal); };			
		ok_but.onclick = function() 
			{
			document.body.removeChild(modal);
			return true;			
			};		
		return false;
		};
//------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------
//Ф-я вывода таблицы персональных данных.Принимает:
//dataObject -	обьект для вывода			
//arrDataForviewTable - массив названий пунктов вывода
//domElementForviewTable - DOM элемент куда вставлять таблицу
function viewTablePesonalData(dataObject,arrDataForviewTable,domElementForviewTable){
	var table = document.createElement('table');
	table.className = "personalTable";
	domElementForviewTable.appendChild(table);
	for( elem in dataObject ){
		if(arrDataForviewTable[elem]){
			var tr = document.createElement('tr');
			tr.innerHTML = "<td>"+arrDataForviewTable[elem]+"</td><td>"+dataObject[elem]+"</td>";			
			table.appendChild(tr);
		}			
	}	
}
//======================================================================================================	



