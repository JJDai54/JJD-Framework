/***
 *
 ***/
function getIdListInDataList(obSource){
   var v = obSource.value
   var dataList = obSource.getAttribute("list");
   var idList = 0;

  //alert(dataList);
   obList = document.getElementById(dataList);
   var typeList = obList.getAttribute('typeList');
 // alert(dataList + ' - type de liste : ' + typeList);
   
   
   for(var i = 0; i< obList.childNodes.length; i++){
    var element = obList.childNodes[i];
    //alert(element.value );
    if (element.value == v){
      idList = element.getAttribute("idList");
      break;
    }
   }
  
    if (idList == 0 && typeList == 0){
      //alert('id non trouve :' + v);
      idList = v;
    }
    
    var nameDestination = obSource.name.substr(2);
    //alert (nameDestination);
    
    obDest = document.getElementById(nameDestination);
    obDest.value = idList;    
}

/***    
 *  @idFrom         string id of object datalist
 *  @idTo           string id of object to add items from datalist
 *  @idsSelected    array of selected items
 ***/
function dataList_loadItems(idFrom,idTo,idsSelected){
  objFrom = document.getElementById(idFrom);
  objTo = document.getElementById(idTo);
  objTo.innerHTML = objFrom.innerHTML;

	for(var i = 0 ,il = objTo.options.length; i< il;i++ ){
	  for(var h = 0 ,hl = idsSelected.length; h< hl; h++ ){
      //alert(ListeOption.options[i].value + " - " + idSelected[h]);
				if(objTo.options[i].value == idsSelected[h]){
                    objTo.options[i].selected = true;
				}	
		}
  }    
}

