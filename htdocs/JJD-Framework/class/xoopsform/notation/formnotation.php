<?php
//  ------------------------------------------------------------------------ //

//class XoopsFormNotation extends XoopsFormElement  
//include_once("../form_jjd.php");
//include_once(JJD_FOEM_PATH . "/form_jjd.php");
//include_once(dirname(dirname(__FILE__)) . "/form_jjd.php");

//class XoopsFormNotation extends Form_JJD  
class XoopsFormNotation extends XoopsFormElement   
{
const _ROUND_ROUND =  0;
const _ROUND_FLOOR = -1;
const _ROUND_CEIL  = -2;



    /**
     * modele : sous dossier  du kin
     *
     * @var string
     * @access private
     */
var $_modele = 'default';

    /**
     * img0, img1, img2 : images du composant
     *
     * @var string
     * @access private
     */
var $_img0 = 'yellow.png';
var $_img1 = 'green.png';
var $_img2 = 'grey.png';


    /**
     * cursor : cursor affiche au survol des images 
     * La propriéte de feuille de style cursor css peut prendre la valeur de :
- auto,
- nw-resize, curseur en forme de double petite flèche en diagonale bas droit vers haut gauche,
- crosshair, curseur en forme de croix fine,
- n-resize, curseur en forme de double petite flèche verticale,
- default, curseur en forme de grosse flèche,
- se-resize, curseur en forme de double petite flèche en diagonale bas droit vers haut gauche,
- pointer, curseur en forme de main avec un doigt déplié,
- sw-resize, curseur en forme de curseur en forme de double petite flèche en diagonale bas gauche vers haut droit,
- move curseur en forme de quatre flèches en croix,
- s-resize, curseur en forme de double petite flèche verticale,
- e-resize, curseur en forme de double petite flèche horizontale,
- w-resize, curseur en forme de double petite flèche horizontale,
- ne-resize, curseur en forme de double petite flèche en diagonale bas gauche vers haut droit,
- text, curseur en forme de sorte de grand I,
- help, curseur en forme de flèche et "?",
- wait, curseur en forme de sablier,
- inherit, la forme du curseur hérite de son parent
- progress, curseur en forme de flèche avec sablier,
- not-allowed, curseur en forme de rond barré,
- no-drop, curseur en forme de main avec un doigt déplié avec un rond barré,
- col-resize, curseur fait de deux traits verticaux avec une flèche de chaque coté.
- row-resize, curseur fait de deux traits horizontaux avec une flèche de chaque coté.          
     *
     * @var string
     * @access private
     */
var $_cursor = 'pointer'; //e-resize



    /**
     * array to transfert params to javascript via json
     *
     * @var bool
     * @access private
     */
    var $jsap = array();
var $path = '';
var $url = '';

/****************************************************************************
 * constructeur
 ****************************************************************************/
function __construct($caption, 
                     $name, 
                     $average, 
                     $outMode,
                     $noteMin, 
                     $noteMax, 
                     $round = 0, 
                     $modele = null, 
                     $img0 = null, 
                     $img1 = null, 
                     $img2 = null){
                     

      $this->path = str_replace('\\', '/', dirname(__FILE__)) . '/notation';
      $this->url = str_replace(JJD_PATH, JJD_URL, $this->path) ;
  //$note = round($note,0);
  //$note = 2.5;
  $this->initJsap();
  
  $this->setCaption($caption);
  $this->setName($name);
  $this->setValue($average);
  $this->setOutMode($outMode) ;
 
  $this->setNoteMin($noteMin);
  $this->setNoteMax($noteMax);
  $this->setRound($round);
  
  if (!$modele == null && $modele!='') $this->_modele = $modele;
  //if (!$img0 == null   && $img0!='')   $this->_img0 = $img0;
  if ($img0 != null)   $this->_img0 = trim($img0);

//   $this->_img0 = $img0;
//   if ($this->_img0 == null)   $this->_img0 = "";
  
  if (!$img1 == null   && $img1!='')   $this->_img1 = $img1;
  if (!$img2 == null   && $img2!='')   $this->_img2 = $img2;

  //------------------------------------------------------
  global $xoopsConfig;
  $shortName = "libelle.php";
  //$f = XOOPS_ROOT_PATH."/modules/jjd_tools/language/{$xoopsConfig['language']}/{$shortName}";
  $f = dirname(__FILE__)."/notation/language/{$xoopsConfig['language']}/{$shortName}";  
  
  if (!is_readable($f)){
    $f = dirname(__FILE__)."/notation/language/english/{$shortName}";  
    //$f = XOOPS_ROOT_PATH."/modules/jjd_tools/language/english/{$shortName}";  
  }
  //echo "<hr>language<br>{$f}<hr>";
  include_once($f);
  //------------------------------------------------------
  
  
}
/****************************************************************************
 * 
 ****************************************************************************/
    function initJsap()
    {
        $this->jsap['outMode'] = "w";
        $this->jsap['background'] = "EFE4B0";;
        $this->jsap['noteMin'] = 0;
        $this->jsap['noteMax'] = 9;
        $this->jsap['round'] = 1;
        $this->jsap['showAverage'] = 1;
        $this->jsap['url'] = '';
        $this->jsap['showBulle'] = -100;  // -100
        
    }


/****************************************************************************
 * 
 ****************************************************************************/
 
 function setStat($count,$sum){
    $this->jsap['count'] = $count;
    $this->jsap['sum'] = $sum;
 }
/****************************************************************************
 * proprietes
 ****************************************************************************/
    /**
     * Get the value index of the onglet by default
     *
     * @param bool $encode To sanitizer the text?
     * @return array
     */
    function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the value index of the onglet by default
     *
     * @param integer $
     */
    function setValue($value)
    {
        $this->_value = $value;
    }
    


    /**
     * Get the url de mise a jour de la moyenne de la notation
     *           et enregistrer une nouvelle note     
     *
     * @return string
     */
    function getUrl()
    {
        return $this->jsap['url'];
    }

    /**
     * Set the url
     *
     * @param string $
     */
    function setUrl($url)
    {
        $this->jsap['url'] = $url;
    }
    
  /**
   *  noteMin
   *
   * @var integer
   * @access private
   */
   function getNoteMin(){
    return $this->jsap['noteMin'];
   }
   function setNoteMin($noteMin){
    $this->jsap['noteMin'] = $noteMin;
   }
   
  /**
   * noteMax
   *
   * @var integer
   * @access private
   */
   function getNoteMax(){
    return $this->jsap['noteMax'];
   }
   function setNoteMax($noteMax){
    $this->jsap['noteMax'] = $noteMax;
   }

  /**
   *  round >=  0 : arrondi au nombre de cécimale, les image seront partielles
   *        = -1 : arrondi a l'entier inferieur
   *        = -2 : Arrondi a l'entier superrieur
   *
   * @var integer
   * @access private
   */
   function getRound(){
    return $this->jsap['round'];
   }
   function setRound($round){
    $this->jsap['round'] = $round;
   }


  /**
   * showAverage : mode d'affichage de la moyenne en chiffre
   *              0 = pas d'affichage
   *              1 = moyenne
   *              2 = moyenne / note maximum          
   * @var array
   * @access private
   */
   function getShowAverage(){
    return $this->jsap['showAverage'];
   }
   function setShowAverage($showAverage){
    $this->jsap['showAverage'] = $showAverage;
   }
   

  /**
   * ShowBulle : affichage de l'infobulle
   *              0 = pas d'affichage
   *              1 = Fixe sous le composant
   *              +-# = Mobile horizontelement sous le composant 
   *                  la valeur est ajoutée a la position en x (acepte une valeur négative)         
   * @var integer
   * @access public
   */
   function getShowBulle(){
    return $this->jsap['showBulle'];
   }
   function setShowBulle($showBulle){
    $this->jsap['showBulle'] = $showBulle;
   }
   
     /**
     * background : Couleur de fond de la bulle affichee au survole de la souris
     *
     * @var integer
     * @access private
     */
   function getBackground(){
    return $this->jsap['background'];
   }
   function setBackground($background){
    $this->jsap['background'] = $background;
   }
   
  /**
   *
   **/     
   function getCursor(){
    return $this->_cursor;
   }
   function setCursor($cursor){
    $this->_cursor = $cursor;
   }
   
                                             /**
     * outMode : mode d'affichage
     *          'r' = affichage simple sans interractivité
     *          'w' = Affichage avec interractivite et enregistrement d'une nouvelle note           
     *
     * @var string
     * @access private
     */
   function getOutMode(){
    return $this->jsap['outMode'];
   }
   function setOutMode($outMode){
    $this->jsap['outMode'] = strtolower($outMode);
   }
/*****************************************************
 *
 *****************************************************/
function getNote(){
    switch ($this->jsap['round']){
    case self::_ROUND_CEIL:
        $note =  ceil($this->getValue());    
        break; 
         
    case self::_ROUND_FLOOR:
        $note =  floor($this->getValue());    
        break;  

    default:
        $note =  round($this->getValue(), $this->jsap['round']);    
        break;
    }
  return $note;
}
/*****************************************************
 *
 *****************************************************/
private function _getSizeFromFolderName(){
    $p = "#([0-9][0-9])#U";     // "img=11x14           //etoile-bleue.png"
    preg_match_all($p, $this->_modele,$t);
// $pr = print_r($t[1],true);    
// echo "<hr>{$this->_modele}<pre>{$pr}</pre>";
    return $t[1]; 
}
/*****************************************************
 *
 *****************************************************/
//private function _getSizeFromfile(){
private function _getSize(){
   $sFile = $this->path . "/images/icons/{$this->_modele}/{$this->_img1}";    
   $image_info = getimagesize($sFile); 
// $pr = print_r($image_info,true);    
// echo "<hr>{$this->_modele}<pre>{$pr}</pre>";

  return $image_info; 
}

/*****************************************************
 *
 *****************************************************/
function getHidden($name, $key, $value){
  if($key == ''){
    return  "<INPUT TYPE='hidden' NAME='{$name}' ID='{$name}' VALUE='{$value}'>"; 
  }else{
    return  "<INPUT TYPE='hidden' NAME='{$name}[{$key}]' ID='{$name}[{$key}]' VALUE='{$value}'>"; 
  }
}
/*****************************************************
 *
 *****************************************************/
function getHiddens($t){
  $tHiddens = array();
  foreach($t as $k => $v) {
    $tHiddens[] = $this->getHidden($v[0], $v[1], $v[2]);
  }
  return  "\n" . implode ("\n", $tHiddens) . "\n"; 
}
/**********************************************************************/
function sanityseName()
{
  //----------------------------------------------------------
  $clName = str_replace('[','_', $this->getName());
  $clName = str_replace(']','_', $clName);
  return $clName; 
}

/*****************************************************
 *rendu HTMLM du composant
 *****************************************************/
function render(){
  switch($this->jsap['outMode']){
    case 'wr':  return $this->render_read_write();  break;
    case 'w':   return $this->render_write();       break;
    case 'o':   return $this->render_old();         break;
    default:    return $this->render_write();        break;
    //default:    return $this->render_read();        break;
  }
}
/*****************************************************
 *rendu HTMLM du composant
 *****************************************************/
function render_read(){
    
}
/*****************************************************
 *rendu HTMLM du composant
 *****************************************************/
function render_write(){
    global $xoTheme;
    $xoTheme->addStylesheet($this->url . "/notation.css");
    $xoTheme->addScript($this->url . '/notation.js');
    
    
    
    //$this->load_js('/class/xoopsform/notation/notation/notation.js');    
    
//     if(file_exists(XOOPS_ROOT_PATH . '/class/xoopsform/notation/notation/notation-mini.js')){
//       $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/notation/notation/notation-mini.js');
//     }else{
//       $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/notation/notation/notation.js');
//     }
    
    //----------------------------------------------------
    $urlImg0 = $this->url . "/images/icons/{$this->_modele}/{$this->_img0}";    
    $urlImg1 = $this->url . "/images/icons/{$this->_modele}/{$this->_img1}";    
    $urlImg2 = $this->url . "/images/icons/{$this->_modele}/{$this->_img2}";    
    // calcul de la note en fonction d mode d'arrondi
    //----------------------------------------------------
    $note =  $this->getNote();    
    $size = $this->_getSize();
    
//$note += 0.5;
    $noteMax    = $this->getNoteMax();
    $noteMin    = $this->getNoteMin();

    //---------------------------------------------
 
    $name = $this->getName();
    $clName = $this->sanityseName();
    //----------------------------------------------------------
  
  $noteInt	= intval($note);
  $noteDec	= $note - $noteInt;
  $noteWidthInt = ($noteInt - $noteMin) * $size[0];
  $noteWidthDec = round($size[0] * $noteDec, 0);
  $noteWidth = $noteWidthInt + $noteWidthDec;
  
  $minWidth = $noteMin *  $size[0];
  $width = ($noteMax - $noteMin) * $size[0];
  $fullWidth = $width + $minWidth;
  $grisWidth = $width - $noteWidth;
  $grisLeft = -$noteWidthDec;
  $height = $size[1];
  
    //-----------------------------------------------------------------------
    // rendu HTML
    if($this->jsap['outMode'] == "r"){
      $onMouseMove = "";
      $onMouseOut = "";
      $onClick = "";
      $ComponentStyle = "";
    }else{
      $onMouseMove = "onmousemove=\"notation_onMouseMove(event);\"";
      $onMouseOut = "onmouseout=\"notation_onMouseOut(event);\"";
      $onClick = "onmousedown=\"notation_onMouseDown(event);\"";
//       $onMouseMove = "onmousemove=\"{$clName}.onMouseMove(event);\"";
//       $onMouseOut = "onmouseout=\"{$clName}.onMouseOut(event);\"";
//       $onClick = "onmousedown=\"{$clName}.onClick(event);\"";
      $ComponentStyle = "style='cursor:{$this->_cursor};'";
    }
    
    $name = $this->_name;
    $this->jsap['name'] = $name; 
    $this->jsap['clName'] = $clName; 
    $this->jsap['width'] = $width;
    $this->jsap['fullWidth'] = $fullWidth;
    $this->jsap['newNote'] = $this->getValue();
    $this->jsap['imgWidth'] = $size[0];
    $this->jsap['note'] = $this->getValue();
    $this->jsap['average'] = $this->getValue();
    $this->jsap['newAverage'] = $this->getValue();
    $this->jsap['sum'] = $this->getValue();
    $this->jsap['count'] = $this->getValue();
    $this->jsap['_NOT_VALIDATE_NEW_NOTE'] = _NOT_VALIDATE_NEW_NOTE;
    $this->jsap['_NOT_NEW_AVERAGE'] = _NOT_NEW_AVERAGE;
       
    $this->jsap['height'] = $height;
    $this->jsap['caption'] = $this->getCaption();
//     $this->jsap[''] = ;
//     $this->jsap[''] = ;
//     $z=print_r($this->jsap,true);
//     echo"<pre>{$z}</pre>";
    $t = array();
      $t[] = "\n<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->\n";  
    $t[] = "<script type='text/javascript'>";
    $t[] = "var {$clName} = new clsNotation(" . json_encode($this->jsap) . ");";
    //$t[] = "{$clName}.setNewNote('{$name}', 0, 0)";    
    $t[] = "</script>";    

    $t[] = "<div style='position:relative;height:{$height}px;'>";

    $t[] = "<div name='{$name}[component]' id='{$name}[component]' class='notation_component' $ComponentStyle>";
    $t[] = $this->getHidden($name, '', $this->getValue());
    
//     $t[] = "<div style=\"float:left;border:0;"
//           ."width:50px; "
//           ."height:{$height}px; "
//           ."background:#FF0000;\" >"
//           ."</div>";
    
  
    
    if ($noteMin > 0 && $this->_img0 != ''){
    $t[] = "<div  name='{$name}[img0]' id='{$name}[img0]' style=\"float:left;border:0;background-color:transparent;"
          ."width:{$minWidth}px; "
          ."height:{$height}px; "
          ."background: url('{$urlImg0}') repeat 0px 0px ;\" >"
          ."</div>";
    
    }
    $t[] = "<div  name='{$name}[img1]' id='{$name}[img1]' style=\"float:left;border:0;background-color:transparent;"
          ."width:{$noteWidth}px; "
          ."height:{$height}px; "
          ."background: url('{$urlImg1}') repeat 0px 0px ;\" >"
          ."</div>";
          
     $t[] = "<div   name='{$name}[img2]' id='{$name}[img2]' style=\"float:left;border:0;background-color:transparent;"
          ."width:{$grisWidth}px; "
          ."height:{$height}px; "
          ."background: url('{$urlImg2}') repeat {$grisLeft}px 0px ;\" >"
          ."</div>";
     
     if ($this->jsap['showAverage'] > 0){
       if ($this->jsap['showAverage'] == 1){
            $libNote = $note;
       }else{
            $libNote = $note . ' / ' . $this->jsap['noteMax'];
       }     
       $t[] = "<div   name='{$name}[libAverage]' id='{$name}[libAverage]' style=\"float:left;border:0;background-color:transparent;"
            ."width:150px; "
            ."height:{$height}px;\" >"
            . "&nbsp;" . $libNote
            ."</div>";
     }
     
     
     /* ce div sert uniquement a eviter le sintillement de la bulle qui est refermée et réouverte
        quand on passe de imgo a img1 et a img2;
        en faisant comme ca c'est ce div qui recouvre tout qui génére l'evennement.
     */     
     //$t[] = "<div style=\"float:left;\" ></div>";
          
//      $t[] = "<div  name='debug' id='debug' style=\"float:left;border:0;background-color:transparent;"
//           ."width:300px; "
//           ."height:{$height}px;\" >"
//           ."</div>";

          
    // le masque est plus grand pour permettre les de cliquer les valeurs des borne sinon cela est presque impossible
    $maskWidth=$fullWidth+8; 
    
//      $t[] = "<div   NAME='{$name}[masque]' ID='{$name}[masque]'  {$onMouseMove} {$onMouseOut} {$onClick} "
//           . " class=\"notation_masque\" " //transparent
//           . " style=\"width:{$maskWidth}px;height:5px;background:#00F00F;\" "
//           . " clName='{$clName}'>"
//           ."</div>";
     $t[] = "<div   NAME='{$name}[masque]' ID='{$name}[masque]'  {$onMouseMove} {$onMouseOut} {$onClick} "
          . " class=\"notation_masque\" " //transparent
          . " style=\"left:-125px;width:{$maskWidth}px;height:{$height}px;\" "
          . " clName='{$clName}'>"
          ."</div>";
    $t[] = "</div>";
    $t[] = "</div>";


// $masque = $this-> . "/images/masque-2.png";
// //echo $masque.'<br />';
//       $t[] = "<img  src='{$masque}' border='0'"
//               . "  style='position:relative;top:0;left:0;width:{$fullWidth}px;height:{$height}px;'"
//               . "  />";

//     $t[] = "</div>";    //-------------------------------------------------------------------
//      $t[] = "<div   NAME='febug' ID='debug'  style=\"position:absolute;left:0;top:0;background:#aaaaaa;\" >"
//           . "zzzzzzzzzz"
//           ."</div>";
          
    $t[] = "<script type='text/javascript'>";
    //$t[] = "var {$clName} = new clsNotation(" . json_encode($this->jsap) . ");";
    
    //$t[] = "{$clName}.setNewNote({$note}, 1);";    
    //$t[] = "{$clName}.setValues({$note}, 1);";    
    $t[] = "{$clName}.initNewNote(1);";    
    
    
    $t[] = "</script>";    
    $t[] = "\n<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->\n";  
    $html = implode("\n", $t);
    return $html;
}
/*****************************************************
 *rendu HTMLM du composant
 *****************************************************/
function render_read_write(){
    global $xoTheme;
    $xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation.css");
    $xoTheme->addScript(XOOPS_URL . '/class/xoopsform/notation/notation.js');
    //-------------------------------------------------------------------
    $t = array();
    //-------------------------------------------------------------------
    $html = implode("\n", $t);
    return $html;
}

//---------------------------------------------------------------------
} //fin de la classe
//---------------------------------------------------------------------



/****************************************************************************
 * 
 ****************************************************************************/

/****************************************************************************
 * 
 ****************************************************************************/
function buildImgString($exp, 
                        $modele, 
                        $link = '', 
                        $op='chr', 
                        $casse = 0, 
                        $alt = '',
                        $title = ''){

    if ($casse > 0){
        $exp = strtoupper();
    }else if ($casse < 0){
        $exp = strtolower();    
    }
    //--------------------------------------------
    $t = array();
    for ($h = 0; $h < strlen($exp); $h++){
        $l = substr($exp,$h,1);
        $chr = substr('00000' . ord($l), -3);
        $f = str_replace('?', $chr, $modele);
        if ($alt <> '')   $alt   = "Alt='{$alt}'";
        if ($title <> '') $title = "title='{$title}'";    
        
        $chaine =  "<img src='"._JJD_ALPHABET_URL."{$f}' border=0 {$alt} {$titel} ALIGN='absmiddle'>";            
        //$chaine =  "img src='"._JJD_ALPHABET_URL."{$f}' border=0 {$alt} {$titel} ALIGN='absmiddle'";
        
        if ($link <> ''){
            if ($op <> '') $op = 'chr';
            $sep = ((strpos($link, '?')  === false ) ? "?" : '&');
            $chaine = "<A HREF='{$link}{$sep}{$op}={$l}'>{$chaine}</A>";            
        }
        $t [] = $chaine;  
    }

    //displayArray($t,"------buildImgString--------");

    return implode ('', $t);

}



?>
