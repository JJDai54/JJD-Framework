


/********************************************************
 * Renvoi l'instance de la classe spin correspondant au composant
 * qui a déclenche l'evennement
 * le balise concernee contienne :
 * - l'attrivut 'clname' dont la valeur correspon au nom de la classe
 * - l'attribut "index" qui contient le numero de lazone  du map survolee
 *      valeur possible de index:
 *          1: fleche haut, increment de la valeur
 *          2: fleche droite max de la valeur
 *          3: fleche bas, decrement de la vaeur
 *          4: fleche gauche, min de la valeur
 *          5: point du milieu, moyenne = (max-min)/2
 *          6: fleche retour; valeur d'origine        
 ********************************************************/
function spin_map_getSpinEvent(event, source){
debug(">>>>> source : " + source);
  var target = event.target || event.srcElement;  
  id = target.getAttribute('clName');
  if (!id) return false;
  spin = spin_map_getSpin(id);
  spin.offsetH = target.getAttribute('offsetH') * 1;
  spin.offsetV = target.getAttribute('offsetV') * 1;
  
  return spin; 
}
/********************************************************
 *
 ********************************************************/
function spin_map_getSpin(id){

  var clName = id.replace('[','_');
  clName = clName.replace(']','_');
  spin = eval(clName);
  spin.init();
  
  return spin; 
}




///////////////////////////////////////////////////////
//      Classe "spin" affectéee a chaque composant   //
///////////////////////////////////////////////////////


/********************************************************
 * constructeur
 * jsap : tableau json qui contient toutes les varaibles nécéssaire a la classe
 *        value, smallIncrement, largeIncrement, ....  
 * ini : tableau json qui contient le contnu du fichier ini du skin
 *        taille des image et definition des 'area' du 'map'  
 ********************************************************/
var clsSpin = function (jsap,ini)
{                         
  
  
  	if ( typeof clsSpin.initialized == "undefined" ) {
  		clsSpin.prototype.exist = function() {
  			//alert("Oui j'existe");
  			return true;
  		}
  /****************************************************************************
   * Contruction HTML du composant
   ***************************************************************************/
	 clsSpin.prototype.init = function () {
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
  		
  /****************************************************************************
   * Contruction HTML du composant
   ***************************************************************************/
	 clsSpin.prototype.build = function () {

    
    
    
  // alert(this.name + "_text");
       this.ob.txt = document.getElementById(this.name + "_text");
//         this.ob.txt = document.getElementById(this.name);
//         this.ob.txt.id =  this.name + "_text";
//         this.ob.txt.setAttribute("name", this.ob.txt.id );
       
       
       this.ob.parent = this.ob.txt.parentNode;
       
       obVal = document.createElement("input");
       obVal.id = this.name
       obVal.value = this.value;
       obVal.setAttribute('name' , obVal.id);
       obVal.setAttribute('type' , 'hidden')
       this.ob.val = obVal; 
       this.ob.parent.appendChild(this.ob.val);

   	   this.ob.img = document.getElementById(this.name + '_img');
       
       //-----------------------------------------------------------
//        this.ob.debug = this.createEl("debug");
//        this.ob.parent.appendChild(this.ob.debug);
       
     
   }




   
/****************************************************************************
 * modifie les coordonnées de l'image a affichée selon l'offset vertical
 * sur l'evennement onmousover 
 ***************************************************************************/
	 clsSpin.prototype.createEl = function (el) {
      switch(el){
        case 'test':
          newOb = document.createElement("div");
          newOb.setAttribute("id", this.name + '[img]');
          newOb.className = 'spin_map_fleches';
          newOb.setAttribute("style", "cursor :pointer;");
          newOb.style.top =  '0px';
          newOb.style.left =  '0px';
          newOb.style.width =  this.ini.size.width + 'px';
          newOb.style.height =  this.ini.size.height + 'px';
          newOb.style.background =  "url('" + this.imgUrl + "')";
          //newOb.style.background =  'url("' + this.imgUrl + '")';
          //this.parent.appendChild(this.zzz);
          break;
        //-------------------------------------------------------------
        case 'input-text':
        	  newOb1 = document.getElementsByName(this.name);
        	  newOb = newOb1[0];
        	  newOb.id = this.name +  "[text]";
            //newOb.setAttribute("name", this.obTxt.id);    
            newOb.setAttribute("clName", this.clName);    
            newOb.setAttribute("index", 0);    
            newOb.onkeyup = spin_onTextChange;
            newOb.value= this.formatNumber();
          break;
            
        //-------------------------------------------------------------
        case 'input-hidden':
            newOb= document.createElement("input");
        	  newOb.id = this.name;
            newOb.setAttribute("type", 'hidden');    
            //newOb.setAttribute("name", this.obVal.id);    
            newOb.setAttribute("clName", this.clName);    

          break;
        //-------------------------------------------------------------
        case 'table':
            newOb = document.createElement("table");
            newOb.className = ("spin_map_tbl");
            newOb.setAttribute("style", this.jsap.styleBordure);
            newOb.style.width = '8%';

            break;
        //-------------------------------------------------------------
        case 'tbody':
            newOb = document.createElement("tbody");
            break;
        //-------------------------------------------------------------
        case 'tr':
            newOb = document.createElement("tr");
            break;
        //-------------------------------------------------------------
        case 'td':
            newOb = document.createElement("td");
            break;
        //-------------------------------------------------------------
        case 'td-unite':
            newOb = document.createElement("td");
            newOb.setAttribute("style", 'display: table-cell;vertical-align: middle;');
            newOb.innerHTML = this.unite;
            break;
        //-------------------------------------------------------------
        case 'div-img':
            newOb = this.buildImgDiv();
            break;
        //-------------------------------------------------------------
        case 'debug':
            newOb = document.createElement("div");
            newOb.id = this.name + "[debug]";
            newOb.innerHTML = this.clName + " -> Zone de debugage";
            break;
        //-------------------------------------------------------------
        default:
            newOb = null;
            break;
          
      }    
    
    return newOb;
    
  }
   
  /****************************************************************************
   *  
   ***************************************************************************/
	 clsSpin.prototype.zzz = function () {
   }
   
   



/****************************************************************************
 * Fonction d'affichage de valeur pour debugage
 * ca evite d'uttiliser la fonction "alert" qui est parfois génante
 * surtout sur l'evennement mouseover par exemple  
 ***************************************************************************/
	 clsSpin.prototype.debug = function (message) {
      if (this.ob.debug) {
        this.debugCompteur++;
        this.ob.debug.innerHTML = this.debugCompteur + ':' + this.clName + "\n" + message;
      }
   }


/****************************************************************************
 * fonction appelée sur l'evennement "onmousedown"
 * seleon l'offsetV, la valeur est incrémentéen décrémenté ou bornée. 
 ***************************************************************************/
	 clsSpin.prototype.start = function (offsetH, offsetV) {
//     alert('start' + "-" + offsetH + "-" + offsetV);
    this.move(offsetH, offsetV);  
    this.debug(typeof offsetV);
    
     switch(offsetV){
      case 1: // incremantation de la valeur, on ne chage pas les incrément 
        this.sens = 1;
        break;
      case 2:  // affectationde la valeur maximum et sortie
        this.setValue(this.jsap.max);   
        return; 
        break;
      case 3:  // décrémentation de la valeur  on change de signe les incréments    
        this.sens = -1;
        break;
      case 4: //affectation de la valeur minimum et sortie
        this.setValue(this.jsap.min);  
        return; 
        break;
      case 5: //affection de la moyenne des bornes et sortie
        moyenne =  (this.jsap.max - this.jsap.min) / 2;
        this.setValue(moyenne);  
        return; 
        break;
      case 6: //affection de la valeur d'origine
        this.setValue(this.oldValue);  
        return; 
        break;
     }
    
    this.increment         = this.jsap.smallIncrement * this.sens;    
    this.compteur          = 0;    
    
  
    this.doIncrement( );
    
    //on continue au cas ou la souris reste enfoncée
    cmd = this.clName + '.timer()';
    this.idTimer = setInterval (cmd, this.delai);    
}
/*************************************************************
 *
 **************************************************************/
	 clsSpin.prototype.moveTo = function () {         
  //------------------------------------------  
  ob = this.ob.img;
  if (ob){
    lw = ob.style.width.replace("px","");  
    lh = ob.style.height.replace("px","");  
    ob.style.backgroundPosition= "-" + (lw * this.offsetH + 0) + "px -" + (lh * this.offsetV+0) + "px";
    
    if (this.ob.debug) this.ob.debug.innerHTML = ob.style.backgroundPosition;
   
    return true;
  }
}       

/****************************************************************************
 * modifie les coordonnées de l'image a affichée selon l'offset horizontal et vertical
 ***************************************************************************/
	 clsSpin.prototype.move = function (offsetH, offsetV) {         
   //modifieTexte();
	 offsetH = offsetH*1;
   offsetV = offsetV*1;          
//alert("move " + offsetH + " | " + offsetV);   
  ob = this.ob.img;
  if (ob){
   this.debug('move=' + offsetH + 'x' + offsetV);
    lw = ob.style.width.replace("px","");  
    lh = ob.style.height.replace("px","");  
    ob.style.backgroundPosition= "-" + (lw * offsetH + 0) + "px -" + (lh * offsetV+0) + "px";
    
  }
  return true;
}


/****************************************************************************
 * appelé sur l'evennement onmouseup
 ***************************************************************************/
	 clsSpin.prototype.stop = function (offsetH, offsetV) {

    clearInterval (this.idTimer);   
    this.move(offsetH, offsetV);  

}

/****************************************************************************
 * fonction rapeller à interval réguler dans la cas ou la souris reste enfoncée
 ***************************************************************************/
	 clsSpin.prototype.timer = function () {
    this.doIncrement ();
  }


/****************************************************************************
 * calcul de la nouvelle valeur
 ***************************************************************************/
	 clsSpin.prototype.doIncrement = function () {

    oldValue = this.value ;
    newValue = this.round((1*(this.value)) + this.increment, this.jsap.decimales)  ;
    if (newValue < (1 * this.jsap.min)){
      newValue = 1*this.jsap.min;
      this.stop();
    }else if (newValue > (1*this.jsap.max)){
      newValue = 1*this.jsap.max;
      this.stop();      
    }
//spin_map_debug('test' ,obVal[0].name + " = " + obVal[0].value);        
        
    this.value = newValue;   
    this.ob.txt.value = this.formatNumber(this.value, this.jsap.groupeDelimiter, this.jsap.decimales);  
    this.ob.val.value = newValue; 
    //alert('doIcrement' + "-" + this.offsetH + "-" + this.offsetV + "- newValue"  + this.value);
    
    this.call_callback();

            
    this.compteur++;
    if (this.compteur > 10){
      this.increment = this.jsap.largeIncrement * this.sens;
    }
}


/****************************************************************************
 * affectation de la nouvelle valeur
 * et appel de la fonction de callback si ele existe. 
 ***************************************************************************/
	 clsSpin.prototype.setValue = function (newValue) {
    //alert("setValue = " + newValue);
    this.value = newValue;   
    this.ob.txt.value = this.formatNumber();
    this.ob.val.value = newValue;
    
    this.call_callback();
    cmd = this.clName + '.stop(0,0)';
    this.idTimer = setInterval (cmd, this.delai);    
   
}


  /********************************************************
   *
   ********************************************************/
	 clsSpin.prototype.val2Text = function () {
      //alert (prefixe + " - " + prefixe2);
      obTxt.value = this.formatNumber();   
  
      return true;
    }



  /********************************************************
   *
   ********************************************************/
	clsSpin.prototype.text2Val = function () {

    newValue = ((this.ob.txt.value).replace(this.jsap.groupeDelimiter,""))*1;
    this.value = newValue;   
    this.ob.val.value = newValue;

    this.call_callback ()

    return true;
  
  };


  /********************************************************
   * callback
   ********************************************************/
	clsSpin.prototype.call_callback = function () {
    //alert (prefixe + " - " + prefixe2);
    if (this.jsap.callback != ''){
      callback =  this.jsap.callback + '(' + this.value + ')';
      eval (callback);
    }

    return true;

};


  /****************************************************************************
   * calcul de la valeur a afficher dans la zone de texte en tenant compte du nombre de décimale
   ***************************************************************************/
	clsSpin.prototype.formatNumber = function () {
	   value = this.value; 
     delimiter = this.jsap.groupeDelimiter;  
     nbDec = this.jsap.decimales;  
     
    value = (value*1).toFixed(nbDec);
  
    if (delimiter=='' || delimiter==',') return value;
    tn1 = value.split('.'); 
    
    value=(value+'').replace(" ","");
    r= value.replace(/[^\d\.\-]/g, '').replace(/(\.\d{2})[\W\w]+/g, '$1').split('').reverse().join('').replace(/(\d{3})/g, '$1,').split('').reverse().join('').replace(/^([\-]{0,1}),/, '$1').replace(/(\.\d)$/, '$1'+'0').replace(/\.$/, '.00');
    r = r.replace(",", delimiter);
    
    tn2 = value.split('.'); 
    if (tn1[1]){
      r = tn2[0] + '.' + tn1[1].substring(0,nbDec);
    }else{
      r = tn2[0];
    }
    
    //alert(value  + '-' + r);  
    //alert('formatNumber : ' + number + '-' + r);
    
  
    return r;
  }

 
/****************************************************************************
 * calcul de l'arondi 4/5
 ***************************************************************************/
	clsSpin.prototype.round = function (num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}
   

///////////////////////////////////////////////////////
  		clsSpin.initialized = true;
	  }
    
  	//------------------------------------------------------------
  	this.jsap = jsap;
  	this.ini  = ini;
  	
  	//alert('imgUrl = ' + this.jsap.imgUrl);

    this.name = jsap.name;
    this.id = this.name;
    this.oldValue = jsap.value;
    this.value = jsap.value;
    
  	//------------------------------------------------------------
    h = this.jsap.imgUrl.lastIndexOf("/"); 
    h = this.jsap.imgUrl.lastIndexOf("/",h-1); 
    this.masque = '/spin_masque.png';
    this.imgMasque = this.jsap.imgUrl.substring(0,h) + this.masque;
    this.imgMasque2 = this.jsap.imgUrl.substring(0,h) + '/spin_masque-2.png';
  	//------------------------------------------------------------
    if (jsap.clName){
      this.clName = jsap.clName;
    }else{
      this.clName = name.replace('[','_');
      this.clName = this.clName.replace(']','_');
    }
  	//------------------------------------------------------------
  	if (!this.jsap.callback) this.jsap.callback='';
    //------------------------------------------------------------
    
    
    //initialisation de variable de travail
    this.comteur = 0;  
    this.sens = 1;  
    
    this.idTimer = 0;
    this.increment = 0;
    this.compteur = 0;
    this.sens = 0;
    this.delai = 200;
    
    this.debugCompteur = 0;
    this.ob = new Array();
    this.ok = false;
    //alert(this.name + " est instancie");
    //this.init();
    
//    alert('constructor img = ' + this.imgUrl);    
//     this.obVal = document.getElementById(this.name);
    //this.build();

///////////////////////////////////////////////////////
} //                 fin de la classe
///////////////////////////////////////////////////////


