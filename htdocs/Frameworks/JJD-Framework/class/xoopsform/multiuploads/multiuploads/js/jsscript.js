//lance l'upload ds flash

function goUpload(vargetgoupload) {
	//alert ('fonction JS goUplad : debut upload flash - variables GET envoy�es : ' + vargetgoupload);
	//en cr�ant la balise flash avec swfobject.js on est plus oblig� de tester le navigateur
	document.getElementById('nasuploader').goUpload(vargetgoupload);
}

//function lanc�e par flash une fois l'up  d'un fichier fini
function Upload_File_Finished(nomfichier) {
	//alert('Fonction JS Upload_File_Finished : un upload un fichier fini : ' + nomfichier);	
}  
//function lanc�e par flash une fois l'up de tous les fichiers fini
function Upload_Finished(param1, param2) {
	//alert('Fonction JS Upload_Finished : upload total fini');
	//alert ('on soummet le formulaire');
	document.getElementById('form_upload').submit();
}   

//ex�cut� � chaque ajout d'un fichier 
function Update_File(file) {
	//alert('Fonction JS Update_File : Ajout 1 un fichier � la liste : '+ file);
	
}
   

