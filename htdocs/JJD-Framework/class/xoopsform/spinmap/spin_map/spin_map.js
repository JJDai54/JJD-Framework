/****************************************************************
 *Scipt de gestion du composant Noatation pour Xops
 *Auteur Jean-Jacques DELALANDRE
 *version 1.1
 *date version 7/10/2012   
 ****************************************************************/

/*************************************************************
 * Fonction d debugage pour fire foxe
 * renvoi un message dans la fenetre weblog de firefoxe 
 **************************************************************/
debug = function (log_txt) {
    if (window.console != undefined) {
        console.log(log_txt);
    }
}
//debug("foo!");

/*************************************************************
 * getion de l'eveennement onmouseover de la balise "map"
 * ls ossfet y de l'image sont décale selon la zone survolee   
 **************************************************************/
function spin_map_onMouseOver(event){
  //------------------------------------------  
  spin = spin_map_getSpinEvent(event, "spin_map_onMouseOver");          
  if(!spin) return false;        
  //------------------------------------------      
  spin.moveTo()      
}       
  
/*************************************************************
 * getion de l'evenement onmouseout de la balise "map"
 * Les offset x et y de l'image sont remositione en 0,0 
 **************************************************************/
function spin_map_onMouseOut(event){
  spin = spin_map_getSpinEvent(event, "spin_map_onMouseOut");          
  if(!spin) return false;        
  //------------------------------------------            
  spin.move(0,0);
}
/*************************************************************
 * getion de l'evenement onmouseout de la balise "div" parent
 * Les offset x et y de l'image sont remositione en 0,0 
 **************************************************************/
function spin_map_onMouseOutDiv(event){
  spin = spin_map_getSpinEvent(event, "spin_map_onMouseOutDiv");          
  if(!spin) return false;        
  //------------------------------------------            
  spin.move(0,0);
}

/*************************************************************
 * gestion de l'evennement onmouseup de la balise "map"
 * la nouvelle valeur est affecté a la balise "input hidden" de validation du formulaire
 * et l'image est racle en posisiotn 0,0  
 **************************************************************/
function spin_map_onMouseUp(event){
  spin = spin_map_getSpinEvent(event, "spin_map_onMouseUp");          
  if(!spin) return false;        
  //------------------------------------------            
  spin.stop(0, spin.offsetV);
  
}
/*************************************************************
 * gestion de l'evenement onmousedown de la balise "map"
 * l'image est cale sur le jeu de droite selon la zone cliquee
 * un timer est mis en route pour incremente ou decrementer
 * la valeur tant que la souris est enfoncee   
 **************************************************************/
function spin_map_onMouseDown(event){
  spin = spin_map_getSpinEvent(event, "spin_map_onMouseDown");          
  if(!spin) return false;        
  //------------------------------------------            
  spin.start(1, spin.offsetV);

}    
/*************************************************************
 * gestion de l'evennement ontextchange de la balise "input text"
 * La valeur saisie est affectée a la balise "input hidden" de validation du formulaire 
 **************************************************************/
function spin_map_onTextChange(event){
   spin = spin_map_getSpinEvent(event, "spin_map_onTextChange");  
   if(!spin) return false;        
   //------------------------------------------            
//   spin_map_text2Val(spin.id,spin.id)
    spin.text2Val();
}    
/*************************************************************
 * initialistion de la classe affectée au spin button une fois construit le HTML
 **************************************************************/
function spin_map_onLoad(id){
  spin = spin_map_getSpin(id);  
  if(!spin) return false;        
  //------------------------------------------            
  spin.text2Val();

}    













 

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////


/****************************************************************************
 * function utilisée uniquement pour des tests du callback
 * la formule est: IMC=masse (en kg)/ [taille(en mètre) au carré] 
 *  par exemple pour une taille de 1m70 et un poids de 70 kgs, 
 *  l' IMC sera de 70/(1,7*1,7)= 24,2   
 ***************************************************************************/
 function compute_IMC(newValue){
 idPoids  = "poids";
 idTaille = "taille"; 
 idIMC    = "IndiceMasseCorporelle";
//spin_map_debug('test' , obCallBack[0].value  + '(' + newValue + ')' );        
 
    obPoids = document.getElementsByName(idPoids);
    obTaille = document.getElementsByName(idTaille);
    imc = obPoids[0].value / (obTaille[0].value  * obTaille[0].value );
//spin_map_debug('test' , imc.toFixed(2));        
    
    obImc = document.getElementsByName(idIMC);
    obImc[0].innerHTML = imc.toFixed(2);
  
 }

