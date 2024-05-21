
<!--

//variable objet sur les deux listes
var c1, dblList_c2, dblList_sep;
  
function init_objets(id0)
{
  //alert("init_objets : " + id0);
  dblList_c1 = document.getElementById(id0 + "_source");
  dblList_c2 = document.getElementById(id0 + "_selection");
  dblList_sep = document.getElementById(id0 + "_resultSeparator").value;
  //alert(dblList_sep);

}


// initlisation des listes
function dblList_init(id0, lSize, lWidth, bgListSource, bgListSelect)
{
  init_objets(id0);  

  dblList_c1.style.width = lWidth + "px";
  dblList_c1.size = lSize;
  if (bgListSource) dblList_c1.style.background = bgListSource;

  dblList_c2.size = dblList_c1.size;  
  dblList_c2.style.width = dblList_c1.style.width;  
  if (bgListSelect) dblList_c2.style.background = bgListSelect; 
  
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
}

// remplissage des listes
function fill_listes(id0, tSource, tSelection)
{
  init_objets(id0);  

   
  // on rempli la liste de gauche en chargeant la page
  dblList_c1.innerHTML = "";
  for(i in tSource)
  {	ajoute = true ;
  	for(j=0 ; j<tSelection.length ; j++)
  		if (i == tSelection[j])
  		{	ajoute = false ; break ;
  		}
  	
  	if (ajoute)
  		dblList_c1.options[dblList_c1.options.length] = new Option(tSource[i],i);
  }

  // on rempli la liste de selection PAR DEFAUT en chargeant la page
  dblList_c2.innerHTML = "";
  for(i=0 ; i<tSelection.length ; i++)
    if (tSelection[i] != '')
  	dblList_c2.options[i] = new Option(tSource[tSelection[i]],tSelection[i]);
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
}


// ajoute toute les valeurs dans la selection
function dblList_addAll(id0)
{
  init_objets(id0);  

	while(dblList_c1.options.length > 0)
	{	// ajoute a droite
		dblList_c2.options[dblList_c2.options.length] = new Option(dblList_c1.options[0].text,dblList_c1.options[0].value);
		// supprime a gauche
		dblList_c1.options[0] = null;
	}
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
} 


// supprime toutes les valeurs dans la selection
function dblList_removeAll(id0)
{
  init_objets(id0);  

	while(dblList_c2.options.length > 0)
	{	// ajoute a gauche
		dblList_c1.options[dblList_c1.options.length] = new Option(dblList_c2.options[0].text,dblList_c2.options[0].value);
		// supprime a gauche
		dblList_c2.options[0] = null;
	}
				
	//---mise a jour de la valeur dans l'objet hidden
	dblList_updateValue(id0);
}


// ajoute qu'une ou plusieurs valeurs dans la selection
function dblList_addSelection(id0)
{
  init_objets(id0);  

	var a_supp = new Array();
	
	// on envoi les valeurs selection a droite
	for(i=0 ; i<dblList_c1.options.length ; i++)
		if (dblList_c1.options[i].selected)
		{	dblList_c2.options[dblList_c2.options.length] = new Option(dblList_c1.options[i].text,dblList_c1.options[i].value);
			a_supp.push(dblList_c1.options[i].value);
		}

	// on supprime les colonne passé a droite pour ne plus les rendre disponible a la selection
	for(i=0 ; i<dblList_c1.options.length ; i++)
		for (j=0 ; j<a_supp.length ; j++)
			if (dblList_c1.options[i].value == a_supp[j])
				dblList_c1.options[i] = null;
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
}

// supprime qu'une ou plusieurs valeurs de la selection
function dblList_removeSelection(id0)
{
  init_objets(id0);  

	var a_supp = new Array();
	
	// on réenvoi les valeurs selectionné dans la liste de gauche
	for(i=0 ; i<dblList_c2.options.length ; i++)
	{	if (dblList_c2.options[i].selected)
		{	dblList_c1.options[dblList_c1.options.length] = new Option(dblList_c2.options[i].text,dblList_c2.options[i].value);
			a_supp.push(dblList_c2.options[i].value);
		}
	}

	// on supprime les anciennes valeur de la liste de droite
	for(i=0 ; i<dblList_c2.options.length ; i++)
		for (j=0 ; j<a_supp.length ; j++)
			if (dblList_c2.options[i].value == a_supp[j])
				dblList_c2.options[i] = null;
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
}


// permet de remonter les valeurs selectionnées dans la liste de droite
function dblList_moveUp(id0)
{
  init_objets(id0);  

	for(i=0 ; i<dblList_c2.options.length ; i++)
	{	if (dblList_c2.options[i].selected)
		{	if (i > 0)
			{	// on sauve la valeur de l'option du dessus
				var temp_text = dblList_c2.options[i - 1].text ;
				var temp_value = dblList_c2.options[i - 1].value ;

				// on copie l'option selected au dessus
				dblList_c2.options[i - 1].text = dblList_c2.options[i].text ;
				dblList_c2.options[i - 1].value = dblList_c2.options[i].value ;

				// on recopie la sauvegarde sur l'option selectionnée
				dblList_c2.options[i].text = temp_text ;
				dblList_c2.options[i].value = temp_value ;

				// on met la seclection sur celui du dessus
				dblList_c2.options[i - 1].selected = true ;
				dblList_c2.options[i].selected = false ;
			}
		}
	}
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);

}


// permet de dessendre les valeurs selectionnées en haut dans la liste de droite
function dblList_moveTop(id0)
{
  init_objets(id0);  

  var j = 0;
  
	for(i=0 ; i<dblList_c2.options.length ; i++)
	{	if (dblList_c2.options[i].selected)
		{	if (i > j)
			{	// on sauve la valeur de l'option du dessus
				var temp_text = dblList_c2.options[i].text ;
				var temp_value = dblList_c2.options[i].value ;

        for (k=i; k>j; k--){
  				// on copie l'option selected au dessus
  				dblList_c2.options[k].text = dblList_c2.options[k-1].text ;
  				dblList_c2.options[k].value = dblList_c2.options[k-1].value ;
        
        }

				// on recopie la sauvegarde sur l'option selectionnée
				dblList_c2.options[j].text = temp_text ;
				dblList_c2.options[j].value = temp_value ;

				// on met la seclection sur celui du dessus
				dblList_c2.options[j].selected = true ;
				dblList_c2.options[i].selected = false ;
				j++;
			}
		}
	}
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);

}

// permet de dessendre les valeurs selectionnées en bas dans la liste de droite
function dblList_moveBottom(id0)
{
  init_objets(id0);  
  
  var j = dblList_c2.options.length-1;
  // alert('dblList_moveBottom : ' + j);
 
	for(i=j ; i>=0 ; i--)
	{	if (dblList_c2.options[i].selected)
		{	if (i < j)
			{	// on sauve la valeur de l'option du dessus
				var temp_text = dblList_c2.options[i].text ;
				var temp_value = dblList_c2.options[i].value ;

        for (k=i; k<j; k++){
  				// on copie l'option selected au dessus
  				dblList_c2.options[k].text = dblList_c2.options[k+1].text ;
  				dblList_c2.options[k].value = dblList_c2.options[k+1].value ;
        
        }

				// on recopie la sauvegarde sur l'option selectionnée
				dblList_c2.options[j].text = temp_text ;
				dblList_c2.options[j].value = temp_value ;

				// on met la seclection sur celui du dessus
				dblList_c2.options[j].selected = true ;
				dblList_c2.options[i].selected = false ;
				j--;
			}
		}
	}
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);

}

// permet de dessendre les valeurs selectionnées dans la liste de droite
function dblList_moveDown(id0)
{	
  init_objets(id0);  
  
  for(i=dblList_c2.options.length - 1 ; i>=0 ; i--) // ATTENTION on commence par la fin du tableau
	{	if (dblList_c2.options[i].selected)
		{	if (i < dblList_c2.options.length)
			{	// on sauve la valeur de l'option du dessous
				var temp_text = dblList_c2.options[i + 1].text ;
				var temp_value = dblList_c2.options[i + 1].value ;

				// on copie l'option selected au dessous
				dblList_c2.options[i + 1].text = dblList_c2.options[i].text ;
				dblList_c2.options[i + 1].value = dblList_c2.options[i].value ;

				// on recopie la sauvegarde sur l'option selectionnée
				dblList_c2.options[i].text = temp_text ;
				dblList_c2.options[i].value = temp_value ;

				// on met la seclection sur celui du dessus
				dblList_c2.options[i + 1].selected = true ;
				dblList_c2.options[i].selected = false ;
			}
		}
	}
				
	//---mise a jour de la valeu dans l'objet hidden
	dblList_updateValue(id0);
}

// donne la liste des valeurs selectionné et dans l'ordre !
function dblList_updateValue(id0)
{
  init_objets(id0);  

	var tmp = new Array();
	for(i=0 ; i<dblList_c2.options.length ; i++)
		tmp.push(dblList_c2.options[i].value);

  sep = document.getElementById(id0 + "_resultSeparator").value;
  obx = document.getElementById(id0);
	obx.value = tmp.join(dblList_sep);

  obx = document.getElementById(id0 + "_array");
	obx.value = tmp;
}	

// donne la liste des valeur selectionnées et dans l'ordre !
function dblList_getValue(id0)
{
  
  //dblList_updateValue(id0)

	// a vous de faire ce que vous voulez avec colonne.value
  obx = document.getElementById(id0);
	alert(obx.value);
	
	
  obx = document.getElementById(id0 + "_array");
	alert(obx.value);
	
}	

// donne la liste des valeur selectionnées et dans l'ordre !
function dblList_show(id0)
{

	// a vous de faire ce que vous voulez avec colonne.value
  obx = document.getElementById(id0);
	alert('Liste des Id selectiones : ' + obx.value);
	
	
}	

//-->

