
/*************************************************************
 * getion des evennements
 **************************************************************/
function notation_onMouseMove(event){
  //------------------------------------------  
  notation = notation_getNotationEvent(event, "notation_onMouseMove");          
  if(!notation) return false;        
  //------------------------------------------      
  //spin.moveTo()      
  notation.onMouseMove(event);
}       
  
function notation_onMouseOut(event){
  //------------------------------------------  
  notation = notation_getNotationEvent(event, "notation_onMouseOut");          
  if(!notation) return false;        
  //------------------------------------------      
  //spin.moveTo()      
  notation.onMouseOut(event);
}       

function notation_onMouseDown(event){
  //------------------------------------------  
  notation = notation_getNotationEvent(event, "notation_onMouseDown");          
  if(!notation) return false;        
  //------------------------------------------      
  //spin.moveTo()      
  notation.onClick(event);
}       










/********************************************************
 * Renvoi l'instance de la classe spin correspondant au composant
 * qui a déclenche l'evennement
 * le balise concernee contienne :
 * - l'attrivut 'clname' dont la valeur correspon au nom de la classe
 ********************************************************/
function notation_getNotationEvent(event, source){
//debug(">>>>> source : " + source);
  var target = event.target || event.srcElement;  
  id = target.getAttribute('clName');
  //alert('notation_getNotationEvent : ' + id);
  if (!id) return false;
  notation = notation_getNotation(id);
  
  return notation; 
}
/********************************************************
 *
 ********************************************************/
function notation_getNotation(id){

  var clName = id.replace('[','_');
  clName = clName.replace(']','_');
  notation = eval(clName);
  notation.init();
  
  return notation; 
}


/**************************************************************
 *
 ***************************************************************/
  
var clsNotation = function (jsap)
{                         
  
  
  	if ( typeof clsNotation.initialized == "undefined" ) 
    {
  		clsNotation.prototype.exist = function() {
  			//alert("Oui j'existe");
  			return true;
  		}
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.init = function (){
        this.getObjects();
      }
      /****************************************************************************
       * Fonction d'affichage de valeur pour debugage
       * ca evite d'uttiliser la fonction "alert" qui est parfois génante
       * surtout sur l'evennement mouseover par exemple  
       ***************************************************************************/
       clsNotation.prototype.debug = function (message) {
        if (!this.ob.debug){
          this.ob.debug = document.createElement("div");
          this.ob.debug.id = 'debug';
          this.ob.debug.className  = 'notation_debug';
          document.body.appendChild(this.ob.debug);
        }
        this.ob.debug.innerHTML = this.clName + "<br>" + message;
        //alert(message);
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.getObjects = function (){
        //if(this.ob.note!=null) return true;
        
        keys= new Array('component','img0','img1','img2',
                        'bulle','libAverage','masque');
      
        this.ob = new Array();
        //alert('getObjects : ' + this.jsap.name);
        this.ob.note = document.getElementById(this.jsap.name);
        
        for (h=0; h<keys.length; h++){
          id = this.jsap.name + '[' + keys[h] + ']';
          this.ob[keys[h]] = document.getElementById(id);
        }
        
        if(this.ob.masque){
          this.ob.masque.style.left='0px';
          this.ob.masque.style.top='0px';
        }
        
//         for (i in this.ob)
//         {
//            //if (this.ob[i]) alert(this.ob[i].id);
//            //alert(i);
//         }
        return true;  
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.showBulle = function (message, x, y){
      //x=0;y=0;
      if (this.jsap.showBulle == 0) return false; 
      
      //this.debug(x + '-' + y + ' : ' + message);
        if (!this.ob.bulle){
          idBulle = this.jsap.name + "[bulle]";  
          this.ob.bulle = document.createElement("div");
          //this.ob.bulle.setAttribute("id",idBulle);
          this.ob.bulle.id = idBulle;
          //this.ob.bulle.setAttribute("name",idBulle);
          this.ob.bulle.className  = 'notation_bulle';
          this.ob.bulle.style.padding  = '5px';
          this.ob.bulle.style.backgroundColor = '#' + this.jsap.background;
          this.ob.bulle.style.top  = (y) +'px'; 
          message += " | new";
          //this.ob.component.appendChild(this.ob.bulle);
          document.body.appendChild(this.ob.bulle);
        }
          this.ob.bulle.style.left = x +'px'; 
          this.ob.bulle.innerHTML = message;
          
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.getPosBulle = function (event){
        t = this.findPos(this.ob.component);
        if (this.jsap.showBulle !=1) t.x = event.clientX + this.jsap.showBulle*1; 
        t.y += this.jsap.height*1 + 4;
        
//         t = new Array();
//         t['x'] = this.getLeft(this.ob.component) + 16;
//         t['y'] = this.getTop(this.ob.component) + this.jsap.height*1 + 4;
        
        
        //t['x'] = event.clientX - this.getLeft(this.ob.component);
        //t['y'] = (this.jsap.height*1 + 4);
        return t;

      }
      
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.onMouseOut = function (event){
        this.getObjects();
         
        //event.stopPropagation(); 
        if (this.ob.bulle){
          this.ob.bulle.parentNode.removeChild(this.ob.bulle);
          this.ob.bulle = null;
        } 
        
        if (this.jsap.outMode == 'r')  return true;
        
        
         if (this.ob.note.value != this.jsap.newNote){
            this.jsap.newNote = this.ob.note.value;  
            this.adjust(0);
         }
        return true;
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.onClick = function (event){
        this.getObjects();
      
        newNote = this.jsap.newNote;
        //alert("nouvelle note : " + this.jsap.newNote);
        //this.adjust(1);
         
        this.setNewNote(newNote, 1);
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.onMouseMove = function (event){
        this.getObjects();
        
        //event.stopPropagation(); 
       //alert("this.jsap.outMode = " + this.jsap.outMode); 
        switch(this.jsap.outMode){
          case 'w':   this.onMouseMove_write(event);     break;
          default:    this.onMouseMove_read(event);      break;
        }
        
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.onMouseMove_read = function (event){
          /***
          t = this.getPosBulle(event);
          bulleText = this.jsap.caption + " : " + this.jsap.note + ' / ' + this.jsap.noteMax;     // + '|' +this.ob.component.style.left
          this.showBulle(bulleText, t.x, t.y);
           ***/          
      }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.onMouseMove_write = function (event){
        
          newNote = (event.clientX - this.getLeft(this.ob.component)) / (this.jsap.fullWidth) * this.jsap.noteMax;
          //newNote = newNote.toFixed(0)*1;
          //newAverage = (event.clientX-this.getLeft(ob.component)) / (ob.fullWidth.value) * ob.noteMax.value;
          if (newNote > this.jsap.noteMax) newNote = this.jsap.noteMax * 1;
          if (newNote < this.jsap.noteMin) newNote = this.jsap.noteMin * 1;
          
          switch(this.jsap.round){
            case -1:
              break;
              newNote= Math.floor(newNote)*1;
            case -2:
              newNote= Math.ceil(newNote)*1;
              break;
            default:
              newNote = newNote.toFixed(this.jsap.round)*1;
              break;
          }
          this.jsap.newNote = newNote;
          if(this.jsap.url == ''){
            newAverage = newNote;
          }else{
            newAverage = (this.jsap.sum*1 + this.jsap.newNote * 1) / (this.jsap.count*1 + 1);
          }
            this.jsap.newAverage = newAverage.toFixed(1);
      /***
          t = new Array();
          h = -1;
          h++; t[h] = ob.sum.value;
          h++; t[h] = ob.newNote.value;
          h++; t[h] = ob.count.value;
          h++; t[h] = ob.newAverage.value;
          lib = t.join("|");
      var bulleText = ob.caption.value + " = " + ob.note.value  + " => " +  ob.newNote.value + " - Moyenne = " + newAverage + " / " + lib;
      
      var bulleText = ob.component.getAttribute('name') + "=" + ob.note.value  + " | " +  ob.noteMax.value + " | " + newNote.toFixed(1);
       ****/    
          
        t = this.getPosBulle(event);
        var bulleText = this.jsap._NOT_VALIDATE_NEW_NOTE + this.jsap.newNote ;
        this.showBulle(bulleText, t.x, t.y);
        //-----------------------------------------------------------------------------    
        this.adjust(1);  
      }
      
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.adjust = function (mode){ 
      //deux mode fonctionnement
      // 0 : mode normale, la valeur a afficher est la moyenne en base
      // 1 : mode interactif : la valeur a afficher est la nouvelle note potentielle
      //mode = 1;  
       
        if (mode == 1){
          v = this.jsap.newNote;
          if(v < this.jsap.noteMin) v = this.jsap.noteMin;
          if(v > this.jsap.noteMax) v = this.jsap.noteMax;
          average = this.jsap.newAverage * 1;
      //     average = (ob.sum.value*1 + v) / (ob.count.value*1 + 1);
      //     average = 12;
      //     ob.newAverage.value = 12;
        }else{
          v = this.jsap.average;
          if(v < this.jsap.noteMin) v = this.jsap.noteMin;
          if(v > this.jsap.noteMax) v = this.jsap.noteMax;
          average = this.jsap.average * 1;
        }
        
       //-------------------------------------------------------------- 
        vInt	= Math.floor(v);  
        vDec	= v - vInt;
        imgWidth = this.jsap.imgWidth;
        
        img1WidthInt = (vInt - this.jsap.noteMin) * this.jsap.imgWidth;
        img1WidthDec = Math.floor((imgWidth * vDec)) * 1;
        img1Width = img1WidthInt + img1WidthDec;
        img2Width = this.jsap.width - img1Width;
        
        //if(img2Width<=0) img2Width=0;
        grisLeft = -img1WidthDec;
        
        this.ob.img1.style.width = img1Width + 'px';
        this.ob.img2.style.width = img2Width + 'px';
        this.ob.img2.style.backgroundPosition = grisLeft + 'px 0px';
       //-------------------------------------------------------------- 
        
        
        
        //alert("adjust : " + ob.component.id + " = " + newAverage);
        
        if (this.ob.libAverage){
          if(this.jsap.showAverage == 1){
            libelle = "&nbsp;" + average.toFixed(1);
          }else{
            libelle = "&nbsp;" + average + ' / ' + this.jsap.noteMax;
          }
          this.ob.libAverage.innerHTML = "&nbsp;" + libelle;
          /***
         t = new Array();
          h=-1;
          h++; t[h] = ob.noteMin.value;
          h++; t[h] = ob.noteMax.value;
          h++; t[h] = ob.sum.value;
          h++; t[h] = ob.count.value;
          h++; t[h] = ob.average.value;
          h++; t[h] = ob.newAverage.value;
          h++; t[h] = average;
          ob.libAverage.innerHTML = "&nbsp;===>" + t.join("|");
           ****/    
        }
        
      }
      
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.getLeft = function (MyObject)
      //Fonction permettant de connaître la position d'un objet
      //par rapport au bord gauche de la page.
      //Cet objet peut être à l'intérieur d'un autre objet.
          {
          if (MyObject.offsetParent)
              return (MyObject.offsetLeft + this.getLeft(MyObject.offsetParent));
          else
              return (MyObject.offsetLeft);
          }
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.getTop = function (MyObject)
      //Fonction permettant de connaître la position d'un objet
      //par rapport au bord haut de la page.
      //Cet objet peut être à l'intérieur d'un autre objet.
          {
          if (MyObject.offsetParent)
              return (MyObject.offsetTop + this.getTop(MyObject.offsetParent));
          else
              return (MyObject.offsetTop);
          }
      
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.findPos = function (obj)
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
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.setNewNote =	function (newNote, op){
        this.getObjects();

          if (this.jsap.url == '') {
//alert("setNewNote : " + newNote);          
//             id = this.jsap.name;
//             var clName = id.replace('[','_');
//             clName = clName.replace(']','_');
//             notation = newNote;

            //this.jsap.note = newNote;
            //this.jsap.average = newNote;
            this.jsap.newAverage = newNote;
            this.jsap.sum = newNote;
            this.jsap.count = 1;
            this.ob.note.value = newNote;
            
//             notation.adjust(1); 
//             if (r.op==1){ 
//               message = notation.jsap._NOT_NEW_AVERAGE.replace("%newAverage%", r['noteAverage']);
//               message = message.replace("%newNote%", r['newNote']);
//               alert(message);
//             }
          return false;
          }
          //---------------------------------------------------
          url = this.jsap.url;

          
          tParams = new Array();
          if (url.indexOf("values",0)>0){ 
            url +=   '|' + this.jsap.name + '|' + op + '|' + newNote ;
            tParams={};
          }else{
            tParams={'jsRootId':this.jsap.name, 'op':op, 'note':newNote};
          }
          
          //alert(url);
      		$.getJSON(url, tParams, function(r){		
      		
            alert(r['message']);
      		
            if (r['error'] > 0) {
               return false;
            }
            id = r['jsRootId'];
            var clName = id.replace('[','_');
            clName = clName.replace(']','_');
            notation = eval(clName);
            
            notation.jsap.note = r['noteAverage'];
            notation.jsap.average = r['noteAverage'];
            notation.jsap.newAverage = r['noteAverage'];
            notation.jsap.sum = r['noteSum'];
            notation.jsap.count = r['noteCount'];
            
            
            notation.adjust(0); 
            if (r.op==1){ 
              message = notation.jsap._NOT_NEW_AVERAGE.replace("%newAverage%", r['noteAverage']);
              message = message.replace("%newNote%", r['newNote']);
              //alert(message);
            }
      		});
      		return false;
      	}

      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.initNewNote =	function (op){
        this.getObjects();
// alert(this.jsap.note
// + "\n" + this.jsap.average
// + "\n" + this.jsap.count
// + "\n" + this.jsap.sum
// + "\n" + 
// + "\n")
          //---------------------------------------------------
    
      		return false;
      	}
      /*******************************************************
       *
       ********************************************************/ 
      clsNotation.prototype.initNewNote2 =	function (newNote, noteCount, noteSum, op){
        this.getObjects();
//             this.jsap.note = newNote;
//             this.jsap.average = newNote;
//             this.jsap.newAverage = newNote;
//             this.jsap.sum = noteSum;
//             this.jsap.count = noteCount;
// alert(this.jsap.note
// + "\n" + this.jsap.average
// + "\n" + this.jsap.count
// + "\n" + this.jsap.sum
// + "\n" + 
// + "\n")
          //---------------------------------------------------
            this.adjust(0); 
            if (r.op==1){ 
              message = this.jsap._NOT_NEW_AVERAGE.replace("%newAverage%", r['noteAverage']);
              message = message.replace("%newNote%", r['newNote']);
              //alert(message);
            }
    
      		return false;
      	}
      	
///////////////////////////////////////////////////////
  		clsNotation.initialized = true;
	  }
    
  	//------------------------------------------------------------
  	this.jsap = jsap;
    if (jsap.clName){
      this.clName = jsap.clName;
    }else{
      this.clName = name.replace('[','_');
      this.clName = this.clName.replace(']','_');
    }
  	//------------------------------------------------------------
    
    this.value = jsap.value;
    
  	//------------------------------------------------------------
    
    this.debugCompteur = 0;
    this.ob = new Array();
    this.getObjects();
//     this.ob.note.value = jsap.value;
//     alert (jsap.value + " | " + this.ob.note.value);
    
    this.ok = false;
//alert("init : " + this.jsap.name);
///////////////////////////////////////////////////////
} //                 fin de la classe
///////////////////////////////////////////////////////










      
/*
<a onmouseover="tooltip.show('Voici une infobulle ! ', 200);" onmouseout="tooltip.hide();">Infobulle</a>
*/
/*******************************************************
 *
 ********************************************************/ 
//notation = new clsNotation();


