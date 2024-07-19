	/************************************************************************************************************
	Editable select
	Copyright (C) September 2005  DTHMLGoodies.com, Alf Magne Kalleland
	
	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.
	
	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.
	
	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
	
	Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
	written by Alf Magne Kalleland.
	
	Alf Magne Kalleland, 2006
	Owner of DHTMLgoodies.com
		
	************************************************************************************************************/	

/****************************************************
 * Modifications apportées par Jean-Jacques DELALANDRE
 * - Selection du texte lors d'un click sur la zone opur permttre une nouvelle saisi directe
 * - Fermeture de la liste sur clicke de la zone de texte
 * - Parametrage de la coleur de font de la liste
 * - Enregistrement de l'id du composant dans l'attribut 'idOption' de la zone de text
 * - Parametrage de la largeur du composant, zone de texte et liste deroulante
 * - Parametrage de la hauteur de la liste deroulante     
 * - Parametrage de l'url des images pour intégration dans xoops 
 ****************************************************/
	// Path to arrow images
	var arrowImage = '';	// Regular arrow
	var arrowImageOver = '';	// Mouse over
	var arrowImageDown = '';	// Mouse down

	if (!selectBoxIds)	var selectBoxIds = 0;
	var currentlyOpenedOptionBox = false;
	var editableSelect_activeArrow = false;
	
	var currentSelectedId = 0;	// Mouse down	


  function selectBox_getWidth(el){
		try{
		  return el.style.width;
    }catch(err){
		  return el.width;
    }
  }
  function selectBox_getHeight(el){
		try{
		  return el.style.height;
    }catch(err){
		  return el.height;
    }
  }

  function selectBox_setWidth(el, width){
		try{
		  el.style.width = width;
    }catch(err){
		  el.width = width;
    }
  }
  function selectBox_setHeight(el, height){
		try{
		  el.style.height = height;
    }catch(err){
		  el.height = height;
    }
  }
//-------------------------------------------------------
	function selectBox_updateUrl()
	{
	  //alert (editListUrl);
  	arrowImage = editListUrl + 'images/select_arrow.gif';	// Regular arrow
  	arrowImageOver = editListUrl + 'images/select_arrow_over.gif';	// Mouse over
  	arrowImageDown = editListUrl + 'images/select_arrow_down.gif';	// Mouse down
	  
//     selectBoxIds = 0;
//     currentlyOpenedOptionBox = false;
//     editableSelect_activeArrow = false;
	}
	
	function selectBox_switchImageUrl()
	{
		if(this.src.indexOf(arrowImage)>=0){
			this.src = this.src.replace(arrowImage,arrowImageOver);	
		}else{
			this.src = this.src.replace(arrowImageOver,arrowImage);
		}
		
		
	}
	
	function selectBox_showOptions()
	{
		if(editableSelect_activeArrow && editableSelect_activeArrow!=this){
			editableSelect_activeArrow.src = arrowImage;
			
		}
		editableSelect_activeArrow = this;
		//alert(this.id);
		var numId = this.id.replace(/[^\d]/g,'');
		currentSelectedId = numId;
		//alert ('currentSelectedId = ' + currentSelectedId);
		var optionDiv = document.getElementById('selectBoxOptions' + numId);
		if(optionDiv.style.display=='block'){
			optionDiv.style.display='none';
			if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
			this.src = arrowImageOver;	
		}else{			
			optionDiv.style.display='block';
			if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='block';
			this.src = arrowImageDown;	
			if(currentlyOpenedOptionBox && currentlyOpenedOptionBox!=optionDiv)currentlyOpenedOptionBox.style.display='none';	
			currentlyOpenedOptionBox= optionDiv;			
		}
	}
	
	function selectOptionValue()
	{
		var parentNode = this.parentNode.parentNode;
		var textInput = parentNode.getElementsByTagName('INPUT')[0];
		textInput.value = this.innerHTML;	
		this.parentNode.style.display='none';	
		document.getElementById('arrowSelectBox' + parentNode.id.replace(/[^\d]/g,'')).src = arrowImageOver;
		
		if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + parentNode.id.replace(/[^\d]/g,'')).style.display='none';
		
	}
	
	function selectOptionHide()
	{ 
// selectBox_showOptions	();	
// alert('selectOptionHide');
// 		var numId = this.id.replace(/[^\d]/g,'');
// 			optionDiv.style.display='none';
// 			if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
//			this.src = arrowImageOver;	
		
	}
	
	
	var activeOption;
	function highlightSelectBoxOption()
	{
		if(this.style.backgroundColor=='#316AC5'){
			this.style.backgroundColor='';
			this.style.color='';
		}else{
			this.style.backgroundColor='#316AC5';
			this.style.color='#FFF';			
		}	
		
		if(activeOption){
			activeOption.style.backgroundColor='';
			activeOption.style.color='';			
		}
		activeOption = this;
		
	}
	
	function createEditableSelectByName(sName, params)
	{
    dest = document.getElementsByName(sName)[0];
    createEditableSelect(dest, params);
    //alert (dest.name);
	}
	
	function createEditableSelect(dest, params)
	{
    selectBox_updateUrl();
  
		dest.className='selectBoxInput';		
		var div = document.createElement('DIV');
		div.style.styleFloat = 'left';
		
 		div.style.width = dest.offsetWidth + 16 + 'px';
		div.style.position = 'relative';
		div.id = 'selectBox' + selectBoxIds;
		var parent = dest.parentNode;
		parent.insertBefore(div,dest);
		div.appendChild(dest);	
		div.className='selectBox';
		div.style.zIndex = 10000 - selectBoxIds;

		var img = document.createElement('IMG');
		img.src = arrowImage;
		img.className = 'selectBoxArrow';
		
		img.onmouseover = selectBox_switchImageUrl;
		img.onmouseout = selectBox_switchImageUrl;
		img.onclick = selectBox_showOptions;
		img.id = 'arrowSelectBox' + selectBoxIds;

		div.appendChild(img);
		
		var optionDiv = document.createElement('DIV');
		optionDiv.id = 'selectBoxOptions' + selectBoxIds;
		optionDiv.className='selectBoxOptionContainer';
  	//optionDiv.style.width = div.offsetWidth-2 + 'px';
  	selectBox_setWidth(optionDiv,div.offsetWidth-2 + 'px');
		optionDiv.style.background = params['bgColor'];
		optionDiv.style.height = params['height']+'px';
		//optionDiv.onMouseOut = SelectBoxOption_alert;
		div.appendChild(optionDiv);

		if(navigator.userAgent.indexOf('MSIE')>=0){
		//alert('MSIE');
			var iframe = document.createElement('<IFRAME src="about:blank" frameborder=0>');
			iframe.style.width = optionDiv.style.width;
			iframe.style.height = optionDiv.offsetHeight + 'px';
			iframe.style.display='none';
			iframe.id = 'selectBoxIframe' + selectBoxIds;
			div.appendChild(iframe);
		}
		
		if(dest.getAttribute('selectBoxOptions')){
			var options = dest.getAttribute('selectBoxOptions').split(';');
			var optionsTotalHeight = 0;
			var optionArray = new Array();
			for(var no=0;no<options.length;no++){
				var anOption = document.createElement('DIV');
				anOption.innerHTML = options[no];
				anOption.className='selectBoxAnOption';
				anOption.onclick = selectOptionValue;
				//anOption.style.width = optionDiv.style.width.replace('px','') - 2 + 'px'; 
				var lw = selectBox_getWidth(optionDiv);
				selectBox_setWidth(anOption,lw.replace('px','') - 2 + 'px');
				anOption.onmouseover = highlightSelectBoxOption;
				optionDiv.appendChild(anOption);	
				optionsTotalHeight = optionsTotalHeight + anOption.offsetHeight;
				optionArray.push(anOption);
			}
			if(optionsTotalHeight > optionDiv.offsetHeight){				
				for(var no=0;no<optionArray.length;no++){
					optionArray[no].style.width = optionDiv.style.width.replace('px','') - 22 + 'px'; 	
				}	
			}		
			optionDiv.style.display='none';
			optionDiv.style.visibility='visible'; 
			//optionDiv.onmouseout = SelectBoxOption_alert;

		}
		
		dest.setAttribute("idOption", selectBoxIds);
		//alert(dest.getAttribute('idOption'));
		selectBoxIds = selectBoxIds + 1;
	}	
	
	function refreshEditableSelect(sName)
	{
	   try{
      dest = document.getElementsByName(sName)[0];
  		if (!dest) return false;
      var selectBoxIds = dest.getAttribute("idOption");
  
      var div  = document.getElementById('selectBox' + selectBoxIds);
  		div.style.styleFloat = 'left';
  		//div.style.width = dest.offsetWidth + 16 + 'px';
    	selectBox_setWidth(div,dest.offsetWidth + 16 + 'px')
  		div.style.position = 'relative';
  
  		var optionDiv = document.getElementById('selectBoxOptions' + selectBoxIds);
  		//alert('selectBoxOptions' + selectBoxIds + '->' + optionDiv.id);
    	//optionDiv.style.width = div.offsetWidth-2 + 'px';
    	selectBox_setWidth(optionDiv,div.offsetWidth-2 + 'px')
     }catch(err){
      alert(sName);    
     }
		
	 
	}	
	
function SelectBoxOption_alert()
{
  alert ('ok');
  return false;  
}
	
function selectBox_select_all(sName)
{  
    obText = document.getElementsByName(sName)[0];
    obText.focus();
    obText.select();

		//var numId = currentSelectedId;
		var numId = obText.getAttribute("idOption");
		
		
		var optionDiv = document.getElementById('selectBoxOptions' + numId);
  	optionDiv.style.display='none';
  	if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
		
		var optionBtn = document.getElementById('arrowSelectBox' + numId);
    optionBtn.src = arrowImageOver;	

}
