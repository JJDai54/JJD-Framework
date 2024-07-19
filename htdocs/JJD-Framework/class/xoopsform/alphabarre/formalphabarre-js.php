<?php
//  ------------------------------------------------------------------------ //
/******************************************************************************


******************************************************************************/



class XoopsFormAlphaBarre extends XoopsFormElement  
{

var $version = 2.10;
var $path = '';
var $url = '';

/************************************************************
 * declaration des variables membre:
 ************************************************************/
 /*****************
  * @link : Page a appeler lors du click sur une lettre
  * @page : charge à l'aapli appelante de connettre le nombre de ligne à afficher 
  *          et le numero du premier enregistrement
  * @pages : charge à l'aapli appelante de connettre le nombre de ligne à afficher 
  *               et le numero du premier enregistrement
  * @letter : Lettre précédement cliquee (peut a remplacer par value puisque la varable existe dans la classe de base)
  * @scriptName : nom du scripr a appler lors d'un click sur une lettre
  * @letterParamName : nom de la cle du tableau renvoye dans $_GET la lttre cliquee
  *                     ex : letter=A  
  * @arrayParamName :  nom du tableau a recuper dans $GET  
  * @pageParamName : nom de la cle du tableau renvoye dans $_GET pour le numero de page cliquee
  * @alphabet : liste des caracterres affiché dan la barre
  *              ex : "ABCDEFGHIJKLMNOPQRSTUVWXZ#\n0123456789";
  * @lettersUsed : liste des caracteres clickable trouve dans la tables source   
  * @fontColorLettersUnused : Couleur des lettre inutilisees
  * @showLettersUnused : utilise avec _lettersUsed et permet de n'affichher queles letres utilisees  
  * @colorSelection : 
  * @delimitorSelection : Masque d'affichage du caractere selectionne
  *                     le @ sera remplace par le caractere  
  *                     ex : '(@)'
  * @delimitorLetter : Masque d'affichage de chaque caractere
  *                     le @ sera remplace par le caractere  
  * @colorSelectionOver :    3
  * @delimitorAlphabet : delimiteur ajoute au debut et a la fin de chaligne pour l'encadrer
  *                     le @ sera remplace par la liste des caracrteres mis en forme  
  *                       ex : '[ @ ]'       
  * @fontSize : taille de la poice d'affichage. Doit être une valeur entre 1 et 5
  *              Pardefaut la  valeur est 3                       
  * @fontName : nom de la police d'affichage; arial par defaut
  * @fontColor
  * @fontColorOver
  * @separator : Separatuer inserer entre chaque caractere
  *               ex : '|'  
  * @casse : force les majuscules ou les minuscules                  
  *          var  = 1; //-1=minuscule - 1=majuscule - 0=tel que passe en parametre
  * @name : attribut name de la balis DIV qui encadre le tout        
  * @signet : ancre dans la page a atteindre - #nomDuSignet dans le lien
  * @maxPage : Nombre maximum de pages à afficher
  *             si _page > __maxPage affichera quelquechose comme  '|< << 4 5 6 7 ... 30 31 32 >> >|'    
  */         
 

 /*****************
  * Options d'affichage de la barre de lettres 
  *****************/  
var $_vars = array();



//$table = '', $colonne='',$filter='',
  
         
/*============================================================
 * Constructucteur:
 =============================================================*/
//function  cls_hermes_texte($table, $colNameId, $becho = 0){
function  __construct ($name,  
                       $link,  
                       $letter = "",
                       $page = 1,
                       $limit = 0,
                       $signet = ''
                      ){
    $this->path = str_replace('\\', '/', dirname(__FILE__)) . '/alphabarre';
    $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
 
  $this->init();
                      
  if (!$letter) {
    $letter = "A";
    $this->setVar('showAlphaBarre', true);
  }elseif($letter == '-'){
    $letter = "*";
    $this->setVar('showAlphaBarre', false);
  }else{
    $this->setVar('showAlphaBarre', true);
  }
  
  if (!$page)  $page = 1;
  if (!$signet)  $signet = "";
  
  
  if($name != ''){
    $this->setVar ('name', $name);
  }
  $this->setVar ('arrayParamName', $this->_vars['name']);
  
  
  $this->setVar ('link', $link);
  
  $this->setVar ('letter', $letter);
  $this->setVar ('page', $page);
  $this->setVar ('limit', $limit);
  $this->setVar ('signet', $signet);
  
  
  return true;  
}

/*****************************************
 *
 *****************************************/
  function init (){
    /***
     *990000 = rgb(153, 0, 0)  
     *787878 =  rgb(153, 153, 153)   
     ***/     
   $this->_vars = array('name'               => 'alphaBarre',
                     'arrayParamName'     => 'alphabarre',  
                     'notin'              => '?',                  
                     'all'                => '*',                  
                     'number'             => '#',                  
                     'alphabet'           => '',                  
                     'casse'              => 1,                  
                     'lettersUsed'        => '',                  
                     'fontColorLettersUnused' => '#DDDDDD',  
                     'showLettersUnused'  => true,  
                     'colorSelection'     => '#FF0000',  
                     'colorSelectionOver' => '#888888',  
                     'delimitorAlphabet'  => '<span style="color:#990000;">[</span> @ <span style="color:#990000;">]</span>',    //[ # ]  exemple : '#;(#);[#];{#};<#>'     
                     'delimitorLetter'    => ' @ ',  
                     'delimitorSelection' => '(@)',  
                     'fontColor'          => '#0000FF',  
                     'fontColorOver'      => '#00FF00',  
                     'fontName'           => 'arial',  
                     'fontSize'           => '3',   //valeur e 1 à 5
                     'letterParamName'    => 'letter',  
                     'link'               => '',  
                     'letter'             => '',  
                     'signet'             => '',  
                     'signetParamName'    => 'signet',  
                     'otherParams'        => '',  
                     'pageParamName'      => 'page',  
                     'scriptName'         => '',  
                     'separator'          => '<span style="color:#787878;"> | </span>',  
                     'pagesSeparator'     => '<span style="color:#787878;"> . </span>',  
                     'page'               => 1,  
                     'pages'              => 0,  
                     'maxPage'            => 10,  
                     'start'              => 0,  
                     'limit'              => 0,  
                     'imgPoints'          => 'points_2.png',  
                     'interLigne'         => '<br />',
                     ['js']               => false  
                     );
                     
   $this->setVar('alphabet', $this->setAlphabet(1));
  }    
/*============================================================
 * functions
 =============================================================*/
  function getParamsUrl ($pGet){
      $key = $this->_vars['name']; 
      $keyPL = 'letterParamName'; 
      
      if (isset($pGet[$key])){
        $alphaBarre = $_GET[$key];
      }else{     
        $alphaBarre = array($this->_vars[$keyPL] => 'A',
                            $this->_vars['pageParamName'] => 1,
                            $this->_vars['signetParamName'] => '');
      }
      $alphaBarre[$keyPL] =  urldecode ($alphaBarre[$keyPL]);  
  }  

/*****************************************
 *
 *****************************************/
  function setInfoTable ($table, $fieldName, $filtre){ 
  
    $this->setVar('table', $table);
    $this->setVar('fieldName', $fieldName);
    $this->setVar('filtre', $filtre);
 
    $this->setLettersUsed ($table, $fieldName, $filtre);
    
    if ($this->_vars['limit'] > 0){
      $this->setPagesInfo($table, $fieldName,  $this->_vars['letter'], 
                          $this->_vars['page'], $this->_vars['limit'],
                          $filtre);
    }
    return $this->getCriteria();
  }  
/*****************************************
 *
 *****************************************/
  function setLettersUsed ($tblSource, $fieldName='nom', $filter=''){
  global $xoopsDB;
                   
  $sql0 = "SELECT distinct upper(left(%1\$s,1)) AS letter FROM `%2\$s` %3\$s ORDER BY %1\$s";
  if ($filter != '') $filter = ' WHERE ' . $filter; 
  $sql1 = sprintf($sql0, $fieldName, $xoopsDB->prefix($tblSource), $filter) ;      
  //echo $sql1.'<br>';
  $rst = $xoopsDB->query($sql1);
  $t = array();
	while ( $row = $xoopsDB->fetchArray($rst) ) {
		$t[] = $row['letter'];
	}

    $value = implode('', $t)
           . $this->_getLetterIfExist($this->_vars['notin'])
           . $this->_getLetterIfExist($this->_vars['all']);

    $this->_vars['lettersUsed'] = $value;
    
    //si la letre passée en parametre n'est pas utilisee
    //affectation de la premiere utilisée pour éviter une liste vide par defaut
    if (strpos($value, $this->_vars['letter']) === false) 
        //$this->_vars['letter'] =  substr($value,0,1);
        $this->_vars['letter'] =  $value[0];
  }

/*****************************************
 *
 *****************************************/
  function setPagesManuelle ($rows, $rowsByPage){
    //$this->setVar('page', $page);
    $this->setVar('rows', $rows);
    $this->setVar('rowsByPage', $rowsByPage);
    $this->setVar('pages', ceil($rows /  $rowsByPage));
  
  }
  function setPagesInfo ($tblSource, $fieldName, $letter, $page, $limit = 10, $filter=''){
    global $xoopsDB;
    $t = $this->getCriteria();
    $criteria = $t['criteria'];
    
    if ($criteria!='')   $criteria = ' WHERE ' . $criteria;
    if ($filter!=''){
      if ($criteria!=''){
         $criteria = ' WHERE ' . $fileter;
      }else{
         $criteria .= ' AND ' . $fileter;
      }
    }       
    
    $sql0 = "SELECT count({$fieldName}) AS rows "
          . " FROM "  . $xoopsDB->prefix($tblSource)  
          . $criteria;
    $rst = $xoopsDB->query($sql0);
    $t = $xoopsDB->fetchArray($rst);
//     $t['limit'] = $rowsByPage;
//     $t['pages'] = ceil($t['rows'] /  $rowsByPage);
    
    $this->setVar('page', $page);
    $this->setVar('rows', $t['rows']);
    //$this->setVar('limit', $limit);
    $this->setVar('pages', ceil($t['rows'] /  $limit));
    
    return true;
  }

/*****************************************
 *
 *****************************************/
  function getCriteria(){
  
    $fieldName = $this->_vars['fieldName'];
    $letter = $this->_vars['letter'];
    $notin = $this->_vars['notin'];
    $all = $this->_vars['all'];
    
    //----------------------------------------
    $t = array();
    if($letter=='' || $letter == $notin){
      $t['criteria'] = "upper(left({$fieldName},1)) NOT IN(". $this->toString(',', $notin). ")" ;
    }elseif($letter == $all){
      $t['criteria'] = "";
    }else{
      $t['criteria'] = "{$fieldName} LIKE '{$letter}%'";
    }




    if ($this->_vars['pages'] > 1){
      $t['start'] = ($this->_vars['page']-1) * $this->_vars['limit'];
      $t['limit'] = $this->_vars['limit'];
    }else{
      $t['start'] = 0;
      $t['limit'] = 0;
    }
    
//     $this->setVar('start', $t['start']);
//     $this->setVar('limit', $t['limit']);
//     echoArray($this->_vars);
    
    return $t;
  }

/*****************************************
 *
 *****************************************/
  function getAlphabet (){    
    return $this->gerVar('alphabet');
  }
  //--------------------------------
  function setAlphabet ($alphabet){
    if (is_numeric ($alphabet)){
      switch ($alphabet){
        case 1: 
          $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXZ{$this->_vars['notin']}{$this->_vars['all']}\n0123456789";                  
          break;
        case 2: 
          $alphabet = "0123456789";                  
          break;
        default:
          $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ{$this->_vars['notin']}{$this->_vars['all']}";
          break;
      }
    }
    $this->setVar('alphabet', $alphabet);
  }
/*****************************************
 *
 *****************************************/
  function toString($sep = ',', $car2exclude = null){ 
    if (!$car2exclude) $car2exclude = $this->_vars['notin'].$car2exclude = $this->_vars['all'];
    $alphabet = $this->_vars['alphabet'];  
    $t = array();  
    for ($h=0; $h<strlen($alphabet); $h++){
      $letter = substr($alphabet, $h, 1);
      if (strpos($car2exclude, $letter) === false)
          $t[] = "'{$letter}'";
    }     
    return implode($sep, $t);
  }
/*============================================================
 * accesseurs
 =============================================================*/
/*****************************************
 *
 *****************************************/
  function getLink (){
    return $this->gerVar('link');
  }
  //--------------------------------
  function setLink ($link){
    $this->setVar('link', $link);
  }

/*****************************************
 *
 *****************************************/
  function getPage (){
    return $this->gerVar('page');
  }
  //--------------------------------
  function setPage ($page){
    $this->setVar('page', $page);
  }
/*****************************************
 *
 *****************************************/
  function getletter (){
    return $this->gerVar('letter');
  }
  //--------------------------------
  function setletter ($letter){
    $this->setVar('letter', $letter);
  }

/*****************************************
 *
 *****************************************/
  function getSignet (){
    return $this->gerVar('signet');
  }
  //--------------------------------
  function setSignet ($signet){
    $this->setVar('signet', $signet);
  }


/*****************************************
 *
 *****************************************/
  function getVars (){
    return $this->_vars;
  }
  //--------------------------------
  function setVars ($vars){
    $this->_vars = $vars;
  }

/*****************************************
 *
 *****************************************/
  function getVar ($key){
    return $this->_vars[$key];
  }
  //--------------------------------
  function setVar ($key, $value){
    $this->_vars[$key] = $value;
  }

/*****************************************
 *
 *****************************************/
  private function _getLetterIfExist($letter){
    return ((strpos($this->_vars['alphabet'],$letter)===false) ? '' : $letter);
  }
/***************************************************************************
 *
 ****************************************************************************/


private function _getLink(){
  $link0 = $this->_vars['link'];
  $link0 .= ((stripos($link0, '?') === false ) ? '?' : '&');

  $link1 = "<a class='%class%' href='" . $link0 
         . "{$this->_vars['arrayParamName']}[{$this->_vars['letterParamName']}]=%letter%" 
         . '&' . "{$this->_vars['arrayParamName']}[{$this->_vars['pageParamName']}]=%page%"
         . '&' . "{$this->_vars['arrayParamName']}[{$this->_vars['signetParamName']}]=%signet%"
         . "' >%visu%</a>";
  //$link = base64_encode($link);
  $visu1 = "<span class='alphaBarre2'><b>%visu%</b></span>";

  if ($this->_vars['signet'] !=''){
    $link1 = str_replace('?', "#{$this->_vars['signet']}?", $link1);
  }
  $link1 = str_replace('%signet%', $this->_vars['signet'], $link1);
  $this->_vars['link1'] = $link1;

}

/***************************************************************************
 *
 ****************************************************************************/
private function _render_barre(){ 
  reset ($this->_vars);
  foreach($this->_vars as $key => $val) {
    $$key = $val;
  }
  //=================================================================
  
  switch($casse){
    case 1:
      $alphabet = strtoupper($alphabet);
      $letter = strtoupper($letter);
      $lettersUsed = strtoupper($lettersUsed);
      break;
    case -1:
      $alphabet = strtolower($alphabet);
      $letter = strtolower($letter);
      $lettersUsed = strtolower($lettersUsed);
      break;
  }
  
  $ta = explode("\n", $alphabet);

    $visu1 = "<span class='alphaBarre2'><b>%visu%</b></span>";

  for ($h=0; $h < count($ta); $h++){
    $tl = array();
    for ($i=0; $i<strlen($ta[$h]) ; $i++){
      $currentLetter = $ta[$h]{$i};
      $isLetterOk = (!(strpos($lettersUsed, $currentLetter)===false) || $lettersUsed =='');
      $visu = $currentLetter;
      
      //construction des parametres du lien
      $link2 = str_replace ('%letter%',urlencode($currentLetter), $link1); 

      if ($currentLetter == $letter){
        $visu = str_replace("@", $visu, $delimitorSelection);
        $class = 'alphaBarre2';                  
      }else{
        //$p = (($pages > 0) ? $page : '1'); 
        $class = 'alphaBarre1';                  
      }
      //si c'est une lettre qui a ete cliquer il foaut forcer le n° de page à 1
      $p = 1;
      $link2 = str_replace ('%page%',$p, $link2); 

      
      if ($delimitorLetter != ''){
        $visu = str_replace("@", $visu, $delimitorLetter);
      }
      
      $link2 = str_replace('%class%', $class, $link2);
      $link2 = str_replace('%visu%', $visu, $link2);

      if ($isLetterOk){
        $tl[] = $link2;  
      }elseif ($showLettersUnused){
        $tl[] = str_replace('%visu%', $visu,   $visu1);
      }
    }
    $ta[$h] = implode($separator ,$tl);
    if ($delimitorAlphabet != ''){
        $ta[$h] = str_replace("@", $ta[$h], $delimitorAlphabet);
    }
  }
    return implode('', $ta);
    
}


/***************************************************************************
 *
 ****************************************************************************/
private function _render_pages(){ 
  reset ($this->_vars);
  foreach($this->_vars as $key => $val) {
    $$key = $val;
  }
  //=================================================================
  //traitement des pages si il y en a
  //=================================================================
    $img1 = "<img src='%img%' title=''>";
    $link2 = str_replace ('%letter%', $letter, $link1);
         
     
    $tl =array();
      
    //--------------------------------------------------------
    $p1 = $page - intval($maxPage/2);
    $p2 = $p1 + $maxPage - 1;
    
    if ($p1 < 1) {
      $p1 = 1;
      $p2 = $p1 + $maxPage - 1;
      if ($p2 > $pages) $p2 = $pages;
    }elseif($p2 > $pages){
      $p2 = $pages;
      $p1 = $p2 - $maxPage + 1;
      if ($p1 < 1) $p1 = 1;
    }
    //--------------------------------------------------------
    // numero de pages
    //--------------------------------------------------------
    for ($p=$p1; $p<=$p2; $p++){
    //for ($p=1; $p<=$pages; $p++){
      $visu = $p;
      if ($p == $page){
        $visu = str_replace("@", $visu, $delimitorSelection);
//         $visu =  "<font color='{$colorSelection}'>" .$visu. "</font>";
        $class = 'alphaBarre2';                  
      }else{
        $class = 'alphaBarre1';                  
      }
      $link3 = str_replace('%class%', $class, $link2);
      $link3 = str_replace('%visu%', $visu, $link3);
      $link3 = str_replace('%page%', $p, $link3);
      $tl[] = $link3;  
    
    }
    //--------------------------------------------------------
    // points de suspension - deplacement par plage de pages
    //--------------------------------------------------------

    $imgPoints = $this->_vars['imgPoints'];
    $imgPointsSpc = 'blank_08.png';
    $visu = str_replace ('%img%', $this->url."/images/default/{$imgPoints}", $img1);
    $blank = str_replace ('%img%', $this->url."/images/default/{$imgPointsSpc}", $img1); 
    
    if ($p1 > 1) {
      $p = $page - $maxPage;
      if ($p < 1) $p = 1;
      $visu = str_replace ("title=''","title='Page {$p}'", $visu) . $blank;
      
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $tl[0] = $link3 . $tl[0];
    }
    if ($p2 < $pages) {
      $p = $page + $maxPage;
      if ($p > $pages) $p = $pages;
      $visu = $blank . str_replace ("title=''","title='Page {$p}'", $visu);
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $h = count($tl)-1;
        $tl[$h] = $tl[$h] . $link3;
    }

    
    $htmlPages = implode($pagesSeparator ,$tl);
    if ($delimitorAlphabet != ''){
        $htmlPages = str_replace("@", $htmlPages, $delimitorAlphabet);
    }
    
    //--------------------------------------------------------
    $blank = str_replace ('%img%', $this->url."/images/default/blank_13.png", $img1);
    //--------------------------------------------------------
    //$indexImg = (($page == 1)?0:1);
    if ($page == 1){
      $first = str_replace ('%img%', $this->url."/images/default/first_0.png", $img1);  
      $previous = str_replace ('%img%', $this->url."/images/default/previous_0.png", $img1);  
    }else{
      $p = 1;
      $visu = str_replace ('%img%', $this->url."/images/default/first_1.png", $img1);
      $visu = str_replace ("title=''","title='Page {$p}'", $visu);
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $first = $link3;  
      //--------------------------------------------------------
      $p = $page-1;
      $visu = str_replace ('%img%', $this->url."/images/default/previous_1.png", $img1);
      $visu = str_replace ("title=''","title='Page {$p}'", $visu);
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $previous = $link3;  
      //--------------------------------------------------------
    }
    //echo  $this->url."/images/default/first.png". "</ br>";
    //--------------------------------------------------------
    if ($page == $pages){
       $next = str_replace ('%img%', $this->url."/images/default/next_0.png", $img1);  
       $last = str_replace ('%img%', $this->url."/images/default/last_0.png", $img1);  
    }else{
      $p = $page+1;
      //echo  $this->url."/images/default/first.png". "</ br>";
      $visu = str_replace ('%img%', $this->url."/images/default/next_1.png", $img1);
      $visu = str_replace ("title=''","title='Page {$p}'", $visu);
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $next = $link3;  
      //--------------------------------------------------------
      $p = $pages;
      $visu = str_replace ('%img%', $this->url."/images/default/last_1.png", $img1);
      $visu = str_replace ("title=''","title='Page {$p}'", $visu);
      $class = 'alphaBarre1';                  
        $link3 = str_replace('%class%', $class, $link2);
        $link3 = str_replace('%visu%', $visu, $link3);
        $link3 = str_replace('%page%', $p, $link3);
        $last = $link3;  
    }
        
    //--------------------------------------------------------
   //if ($this->_vars['showAlphaBarre']) $tHtml[]  = $interLigne ;
   return $interLigne . $first . $previous . $blank . $htmlPages . $blank . $next . $last;


}
/***************************************************************************
 *
 ****************************************************************************/


function render(){
  reset ($this->_vars);
  foreach($this->_vars as $key => $val) {
    $$key = $val;
  }
// echoArray($options);  
  
  $tHtml = array();
  $tHtml[] = "<div align='center' width='100%'>";
  $tHtml[] = "<style type='text/css'>";
  $tHtml[] = "<!--";
  $tHtml[] = "a.alphaBarre1 { color: " . $fontColor . "; }";
  $tHtml[] = "a.alphaBarre1:hover { color: " . $fontColorOver . "; }";
  $tHtml[] = "a.alphaBarre2 { color: " . $colorSelection . "; }";
  $tHtml[] = "a.alphaBarre2:hover { color: " . $colorSelectionOver . "; }";
  $tHtml[] = "span.alphaBarre2 { color: " . $fontColorLettersUnused . "; }";
  $tHtml[] = "-->";
  $tHtml[] = "</style>\n";
  $tHtml[] = "";


  $this->_getLink();
  $tHtml[] = "<font face='{$fontName}' size='{$fontSize}' color='{$fontColor}'>";
  
  //=================================================================
  // generation de la barre de lettres
  //=================================================================
  if ($this->_vars['showAlphaBarre']){
      $tHtml[]  = $this->_render_barre();
  } 

  //=================================================================
  //traitement des pages si il y en a
  //=================================================================
  if ($pages > 0) {
     if ($this->_vars['showAlphaBarre']) $tHtml[]  = $interLigne ;
     //$tHtml[]  = $interLigne . $first . $previous . $blank . $htmlPages . $blank . $next . $last;
     $tHtml[]  = $this->_render_pages();
  }  
  
  $tHtml[] = '</font></div>';
  return implode('', $tHtml);
}

/***
 *
 ***/
function display($extra = nul){
  if ($extra){
    echo $this->render();
  }else{
    echo "<div {$extra}>" . $this->render() . "</div>";
  }
}

//==============================================================================
} // fin de la classe


class XoopsFormAlphaBarreJS extends XoopsFormAlphaBarre
{


function render(){
  reset ($this->_vars);
  foreach($this->_vars as $key => $val) {
    $$key = $val;
  }
// echoArray($options);  
  
  $tHtml = array();
      $tHtml[] = "<div align='center' width='100%'"
      . " onclick='alphabarre_onclick(event,this);'" 
      . "href='" . $this->getVar('link') . "'>"
      . ">";
  
  $tHtml[] = "<style type='text/css'>";
  $tHtml[] = "<!--";
  $tHtml[] = "a.alphaBarre1 { color: " . $fontColor . "; }";
  $tHtml[] = "a.alphaBarre1:hover { color: " . $fontColorOver . "; }";
  $tHtml[] = "a.alphaBarre2 { color: " . $colorSelection . "; }";
  $tHtml[] = "a.alphaBarre2:hover { color: " . $colorSelectionOver . "; }";
  $tHtml[] = "span.alphaBarre2 { color: " . $fontColorLettersUnused . "; }";
  $tHtml[] = "-->";
  $tHtml[] = "</style>\n";
  $tHtml[] = "";


  $this->_getLink();
  $tHtml[] = "<font face='{$fontName}' size='{$fontSize}' color='{$fontColor}'>";
  
  //=================================================================
  // generation de la barre de lettres
  //=================================================================
  if ($this->_vars['showAlphaBarre']){
      $tHtml[]  = $this->_render_barre();
  } 

  //=================================================================
  //traitement des pages si il y en a
  //=================================================================
/*
  if ($pages > 0) {
     if ($this->_vars['showAlphaBarre']) $tHtml[]  = $interLigne ;
     //$tHtml[]  = $interLigne . $first . $previous . $blank . $htmlPages . $blank . $next . $last;
     $tHtml[]  = $this->_render_pages();
  }  
  
  $tHtml[] = '</font></div>';
  return implode('', $tHtml);
}
*/

}

/***************************************************************************
 *
 ****************************************************************************/
private function _render_barre(){ 
  reset ($this->_vars);
  foreach($this->_vars as $key => $val) {
    $$key = $val;
  }
  //=================================================================
  
  switch($casse){
    case 1:
      $alphabet = strtoupper($alphabet);
      $letter = strtoupper($letter);
      $lettersUsed = strtoupper($lettersUsed);
      break;
    case -1:
      $alphabet = strtolower($alphabet);
      $letter = strtolower($letter);
      $lettersUsed = strtolower($lettersUsed);
      break;
  }
  
  $ta = explode("\n", $alphabet);

    $visu1 = "<span class='alphaBarre2'><b>%visu%</b></span>";

  for ($h=0; $h < count($ta); $h++){
    $tl = array();
    for ($i=0; $i<strlen($ta[$h]) ; $i++){
      $currentLetter = $ta[$h]{$i};
      $isLetterOk = (!(strpos($lettersUsed, $currentLetter)===false) || $lettersUsed =='');
      $visu = $currentLetter;
      
      //construction des parametres du lien
      $link2 = str_replace ('%letter%',urlencode($currentLetter), $link1); 

      if ($currentLetter == $letter){
        $visu = str_replace("@", $visu, $delimitorSelection);
        $class = 'alphaBarre2';                  
      }else{
        //$p = (($pages > 0) ? $page : '1'); 
        $class = 'alphaBarre1';                  
      }
      //si c'est une lettre qui a ete cliquer il foaut forcer le n° de page à 1
      $p = 1;
      $link2 = str_replace ('%page%',$p, $link2); 

      
      if ($delimitorLetter != ''){
        $visu = str_replace("@", $visu, $delimitorLetter);
      }
      
      $link2 = str_replace('%class%', $class, $link2);
      $link2 = str_replace('%visu%', $visu, $link2);

      if ($isLetterOk){
        $tl[] = $link2;  
      }elseif ($showLettersUnused){
        $tl[] = str_replace('%visu%', $visu,   $visu1);
      }
    }
    $ta[$h] = implode($separator ,$tl);
    if ($delimitorAlphabet != ''){
        $ta[$h] = str_replace("@", $ta[$h], $delimitorAlphabet);
    }
  }
    return implode('', $ta);
    
}

?>

