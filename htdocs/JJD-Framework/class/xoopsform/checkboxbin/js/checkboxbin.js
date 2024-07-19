
/***********************************************************************
 *
 ***********************************************************************/
function updateChkBin(name, prefixChk){
  var obVal = document.getElementById(name);
  var obItems = document.getElementsByName(prefixChk + name + '[items]');
  //alert('updateChkBin : ' + name + " = " + obVal.value + " - nb = " + obItems.length);

  var newVal = 0;
  var binFlag = '0';
  
  for(var i=0; i< obItems.length; i++)
     {
       //if (tableau[i] != '') Chaine_commande += tableau[i];
       //alert(obItems[i].name + ' : ' + i + " : " + obItems[i].checked +  ' = ' + obItems[i].getAttribute("binFlag"));
       if(obItems[i].checked){
          binFlag = obItems[i].getAttribute("binFlag");
          //newVal += binFlag*1;
          //alert(binFlag);
          //newVal += Math.pow(2,i);
          newVal += Math.pow(2, binFlag*1) ;

       //alert(i + " : " + newVal);
       }
     }
  //alert('updateChkBin :' + name + " = " + obVal.value + " - newVal = " + newVal);
  obVal.value = newVal;
}


/***********************************************************************
 *
 ***********************************************************************/
function updateGroupeChkBin(name, prefixChk, groupName){
  obAll = document.getElementById(prefixChk + name + '[' + groupName + ']');
  if (!obAll) return false;
  newEtat = obAll.checked;
  //alert(groupName);

  obVal = document.getElementById(name);
  obItems = document.getElementsByName(prefixChk + name + '[items]');
  //alert('updateChkBin : ' + name + " = " + obVal.value + " - nb = " + obItems.length);

  var newVal = 0;
  for(var i=0;i<obItems.length;i++)
     {
      if (obItems[i].getAttribute('groupName') == groupName){
       obItems[i].checked = newEtat;
      }
       //alert(binFlag);
       //if (tableau[i] != '') Chaine_commande += tableau[i];
       //alert(i + " : " + obItems[i].checked);
       if(obItems[i].checked){
          binFlag = obItems[i].getAttribute("binFlag");
          newVal += Math.pow(2, binFlag*1) ;
          //newVal += Math.pow(2,i);
       //alert(i + " : " + newVal);
       }
     }
  //alert('updateChkBin (' + i + ') :' + name + " = " + obVal.value + " - newVal = " + newVal);
  obVal.value = newVal;
}
