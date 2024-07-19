<!--

// On enregistre des raccourcis pour les 2 liste
//var c1 = document.configuration.colonne_stock ; // liste de gauche
//var c2 = document.configuration.colonne_afficher ; // liste de droite

//  var c1 = document.getElementById("colonne_stock");
//  var c2 = document.getElementById("colonne_afficher");


//init_objets("colonne_stock", "colonne_afficher");


// on déclare les valeurs possible
// SYNTAX    identifiant : libélé
/*
var colonne_texts = {	'photo':'Photos',
						'marque' : 'Marque',
						'prix' : 'Prix',
						'genre' : 'Genre',
						'boite':'Boite',
						'energie':'Energie',
						'proprietaire' : 'Propri‚taire',
						'reservation':'R‚servations',
						'commentaire':'Commentaires'
					};
// initialisation de la selection  PAR DeFAUT
var init_droite = 'genre,prix,energie' ;
*/


var colonne_texts = {	'16' : 'Photos',
          						'2'  : 'Marque',
          						'1'  : 'Prix',
          						'5'  : 'Genre',
          						'4'  : 'Boite',
          						'3'  : 'Energie',
          						'12' : 'Propri‚taire',
          						'10' : 'R‚servations',
          						'6'  : 'Commentaires'
          					};

// initialisation de la selection  PAR DeFAUT
var init_droite = '5,1,3,6' ;
var colonne_init   = init_droite.split(',');
//var colonne_init   = {'genre','prix','energie'};

//-->
