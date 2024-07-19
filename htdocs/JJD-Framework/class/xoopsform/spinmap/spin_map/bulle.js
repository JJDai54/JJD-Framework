

///////////////////////////////////////////////////////
//     affichage d'une bulle pour affichage debug    //
///////////////////////////////////////////////////////


/********************************************************
 * constructeur
 * jsap : tableau json qui contient toutes les varaibles nécéssaire a la classe
 *        value, smallIncrement, largeIncrement, ....  
 * ini : tableau json qui contient le contnu du fichier ini du skin
 *        taille des image et definition des 'area' du 'map'  
 ********************************************************/
var clsBulle = function (bachground)
{                         
  
  
  	if ( typeof clsBulle.initialized == "undefined" ) {
  		clsBulle.prototype.exist = function() {
  			//alert("Oui j'existe");
  			return true;
  		}
  /****************************************************************************
   * Contruction HTML du composant
   ***************************************************************************/
	 clsBulle.prototype.init = function () {
     if (!this.ok) {
   	   //this.ob['img'] = document.getElementById(this.name + '_img');
	     this.build();
	     this.ob.val.value = this.value;
       this.ok = true;
//        alert('obImg : ' + this.name + '_img');
//      alert(this.name + " est initialise");
     }
     
     return true;
   }
  		
   
///////////////////////////////////////////////////////
/*******************************************************
 *
 ********************************************************/ 
clsBulle.prototype.hiddeBulle = function (killImmediate){ 
  killImmediate = killImmediate || false;
  if (killImmediate){
    idBulle = "spin[bulle]";  
    obBulle = document.getElementById(idBulle);
    if (obBulle) {
      //document.body.removeChild(obBulle);
    }
  }else{
      cmd = this.clName + '.hiddeBulle(true)';
      setInterval (cmd, 5000);    

  }
} 

/*******************************************************
 *
 ********************************************************/ 
clsBulle.prototype.showBulle = function (message,x,y,background){
  if (!x) x = 0;
  if (!y) y = 0;
  if (!background) background = "EFE4B0";
  obRef = this.ob.parent;
  idBulle = "spin[bulle]";  
  obBulle = document.getElementById(idBulle);
  //--------------------------------------------------------------
  if (!obBulle){
    obBulle = document.createElement("div");
    obBulle.id = idBulle;
    //bulle.setAttribute("id",idBulle);
    //bulle.setAttribute("name",idBulle);
    obBulle.className  = 'spin_bulle';
    obBulle.style.padding  = '5px';
    obBulle.style.backgroundColor= '#' + background;
    
    //y = obRef.style.top.replace("px","")*1;
    //height = obRef.style.height.replace("px","")*1;
    //alert(y + 'x' + height);
    //bulle.style.top  = (y + height *1 + 4) +'px'; 
    message += " | new"
    //clsBulle.prototype.obBulle = obBulle;
    document.body.appendChild(obBulle);
  }
    
    //t = this.getXY(this.ob.parent);
    t = this.findPos(this.ob.parent);
    //alert(t.x + "|" + t.y);
    height = obRef.offsetHeight;
//     obBulle.style.left = t.x +'px'; 
//     obBulle.style.top = t.y  +'px'; 
    
//    t = this.findPos(this.ob.parent)
    obBulle.style.left =(t.x+10)  +'px' ; 
    obBulle.style.top =(t.y + height+10)  +'px'; 
    
    obBulle.innerHTML =  (this.debugCompteur++) + ' >>> ' + message;
}

/*******************************************************
 *
 ********************************************************/ 
clsBulle.prototype.showBulle2 = function (message,x,y,background){
  if (!x) x = 0;
  if (!y) y = 0;
  if (!background) background = "EFE4B0";
  obRef = this.ob.parent;
  //--------------------------------------------------------------
  if (!this.ob.bulle){
    idBulle = this.clName + "[bulle]";  
    bulle = document.createElement("div");
    bulle.setAttribute("id",idBulle);
    //bulle.setAttribute("name",idBulle);
    bulle.className  = 'spin_bulle';
    bulle.style.padding  = '5px';
    bulle.style.backgroundColor= '#' + background;
    
    //y = obRef.style.top.replace("px","")*1;
    //height = obRef.style.height.replace("px","")*1;
    //alert(y + 'x' + height);
    //bulle.style.top  = (y + height *1 + 4) +'px'; 
    message += " | new"
    this.ob.bulle = bulle;
    obRef.appendChild(this.ob.bulle);
  }else{
    bulle = this.ob.bulle;
  }
    
//    t = this.getXY(this.ob.parent);
    //alert(t.x + "|" + t.y);
    height = obRef.style.height.replace("px","")*1;
//     bulle.style.left = t.x +'px'; 
//     bulle.style.top = t.y  +'px'; 
    
//    t = this.findPos(this.ob.parent)
    bulle.style.left = "0px"; 
    bulle.style.top =(height*1 +10)  +'px'; 
    
    bulle.innerHTML =  (this.debugCompteur++) + ' >>> ' + message;
}
/*******************************************************
 *
 ********************************************************/ 
clsBulle.prototype.findPos = function (obj)
{
	var x = y = 0;
  if (obj.offsetParent) {
  do {
			x += obj.offsetLeft;
			y += obj.offsetTop;
      } while (obj = obj.offsetParent);      
  
  t = new Array();
  t.x = x;
  t.y = y;
  return t; //['x':x,'y':y];
  }      
}


///////////////////////////////////////////////////////
  		clsBulle.initialized = true;
	  }
    
  	//------------------------------------------------------------
    initilisation es variables de travail
  	//------------------------------------------------------------
    var backGround = backGround;
    
    
///////////////////////////////////////////////////////
} //                 fin de la classe
///////////////////////////////////////////////////////


