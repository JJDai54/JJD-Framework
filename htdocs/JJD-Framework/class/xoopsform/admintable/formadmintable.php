<?php
/**
 * XoopsFormSpin element  - arrayform : table HTML
 *  
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @version         XoopsFormSpin v 2.0
 */
 
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

/**
 * A select field
 *
 * @author 		Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @copyright JJD http:xoops.kiolo.com
 * @access 		public
 */


/*--------------------------------------------------------------------*/
/* Composant d'affichage d'un tableau ou du resultat d'une requete    */
/*--------------------------------------------------------------------*/

class XoopsFormAdminTable extends XoopsFormElement
{

const col_empty = 'empty';    // Zone vide, utilise notamment pour l'option 'condition'
const col_read = 'ro';        // Lecture, Lien, +[hidden]
const col_link = 'link';        // Lecture, Lien 
const col_hidden = 'ih';      // Only hidden
const col_input = 'it';       // Input text
const col_checkbox = 'cb';    // Checkbox
const col_listbox = 'lb';     // Listbox
const col_dataList = 'dl';     // DataListbox (ne fonctionne que sou Firefox)
const col_editListbox = 'elb';     // Listbox
const col_radio = 'or';       // Options radio
const col_actions = 'ia';     // Icons+link to do something like 'delete', 'clone', ...
const col_join = 'jf';         // Implode of many fields like 'name pstname'
const col_merge = 'mc';       // Implode of many fields like 'name pstname' on different line
const col_merge2 = 'm2';       // Implode of many fields like 'name pstname' on different line
const col_expression = 'sf';  // Implode of many fields like a sprintf function
const col_matchIcon = 'mi';   // Match field and icons + link
const col_spin = 'sb';        // Spin button
const col_img = 'img';        // Image
// const col_zoom = 'zoom';        // only if the framework javascript hightslide is intalled



const col_match_defaut = -1; // valeur par defaut pour matchicon

const _HR_ = "<hr style='height:1px; color: #839D2D; background-color: #839D2D; border: none;'>";


/***
XoopsFormAdminTable::col_empty
XoopsFormAdminTable::col_read
XoopsFormAdminTable::col_link
XoopsFormAdminTable::col_hidden
XoopsFormAdminTable::col_input
XoopsFormAdminTable::col_checkbox
XoopsFormAdminTable::col_listbox
XoopsFormAdminTable::col_dataList

XoopsFormAdminTable::col_editListbox
XoopsFormAdminTable::col_radio
XoopsFormAdminTable::col_actions
XoopsFormAdminTable::col_merge
XoopsFormAdminTable::col_join
XoopsFormAdminTable::col_expression
XoopsFormAdminTable::col_matchIcon
XoopsFormAdminTable::col_spin
XoopsFormAdminTable::col_img
XoopsFormAdminTable::col_zoom
***/


    var $version = 2.20;
    var $dateVersion = '30-11-2012';
    var $myts = null;
      
    var $_tbl = array(); //Structure princiale contenant toute les informations et parametres
                         //nottament la structure des colonnes 

/*
tbl->columns->caption
            ->key  // doit correspondre pour les données à une clé du tableau ou du rst
            ->type ///voir la nomenclature ci-dessous
   ->params-> //parametre temporaires pour eviter de les passer en parametres dans les fonctions internes 
   
*/

    /**
     * arrayData : tableau de donnees a afficher. optionael, le composant affiche
     * arrayData s'il n'est pas vide et queryData sil il n'est pas vide. 
     * que ce sot l'un ou l'autre seuls seront affichés les enttre 
     * dont les a cles correspondent aux cles du tableau "titles"
     * normalement ces correspondes aux nom de champs de la source de donnees              
     *
     * @var mixed array
     * @access private
     */
    var $_data = array();
    var $_arrayData = null;
    
    /**
     * queryData : resultat d'une requete select 
     * voir aussi $_arrayData;     
     *
     * @var query
     * @access private
     */
    var $_queryData = null;
    
    
    /**
     * titles : tableau de description des colonnes. 
     * chaque iteme du tableau est un tableau associatif defini comme suit:
     *     key : Clé utilsee comme lien avec arayData et queryData (nom des colonnes)
     *     caption : Titre a afficher pour chaque colonne
     *     style   : attribut html style pour l'ffichage du ttre.  
     * exemple:
     *     $t->addTitle('idNotedef',   _AM_JJD_ID,   'align="center"');
     *     $t->addTitle('name',        _AM_JJD_NAME, 'width="300px"');
     *     $t->addTitle('description', _AM_JJD_DESCRIPTION);
     
     * @var array mixed array
     * @access private
     */
    var $_titles = null;
    
    /**
     * _extraRow : tableau de description des colonnes. 
     *     $t->addTitle('description', _AM_JJD_DESCRIPTION);
     
     * @var array mixed array
     * @access private
     */
    var $_extraRows = null;
    
    
    /**
     * name : nom du tableau <table name='name'> ... </table>
     *        permet les manipulation via javascript     
     *
     * @var string
     * @access private
     */
    var $_name = '';
    
    /**
     * class : nom de la clas de la table "<table class='class'">
     *
     * @var string
     * @access private
     */
    var $_className = '';
    
    /**
     * style : css a affecter a l'attribut "style" : "<table style='style'" >
     *
     * @var string
     * @access private
     */
    var $_style = '';
    
    /**
     * title : titre du tableau  
     *      Le titre est affiche si non vide
     *      il est pacé au dessus des titre de colonne          
     *      <caption class='head' style='border-style: solid; border-width: 1px;'>{$this->getCaption()}</caption>"
     *
     * @var string
     * @access private
     */
    var $_caption = '';
    
    var $_numRow = false;
    
    /**
     * actions : Ce tableau de tableau associatif qui definisse les actions possibles
     * Les action sont des liens avec des icones 
     * exemple : delette, edit, ....          
     * description des tableaux associatifs:
     *     $t = array(); 
     *     $t['link']  = $link; URL du lien lié a l'icone
     *     $t['icon']  = $icon; Url de l'icone a afficher
     *     $t['title'] = $title; infobulle de l'image
     *     $t['op']    = $op; nom de l'attribut 'op' du lien
     *     $t['opAttributName'] = $opAttributName; nom de l'attribut op du lien 'op' par defaut
     *    $this->_actions[$key][] = $t; la clé dans le tableu principal doit correspondre a une clé
     *  du tableau des titres de colonnes, sot le nom d'un champ.     
     *
     * @var array mixed array
     * @access private
     */
    var $_actions = array();
    
    
    /**
     * actions : Ce tableau de tableau associatif qui definisse les actions possibles
     * sur le contenu des cellule d'une colonne. 
     *  exemple: supposons un tableau de personnes: nom/prenom/age
     *  Nous pourrons ajouter un lien sur le nom pour amenner la fiche en edtion par exemple     
     *           
     * description des tableaux associatifs:
     *  $t = array(); 
     *  $t['link']     = $link;
     *  $t['params']     =     $t['params']   = $this->extractFieldsNames($link);
     *  $t['op']       = $op;
     *  $t['opAttributName']    = $opAttributName;
     *
     *  $this->_links[$key] = $t; la clé dans le tableu principal doit correspondre a une clé
     *  du tableau des titres de colonnes, sot le nom d'un champ.     
     *
     * @var array mixed array
     * @access private
     */
    var $_links = array();
    
    /**
     * bacground : defini un tableau associatif qui contien 
     *             les couleur de fond alternee pur chaque ligne du tableau
     *   function setBackground($evenBackground='CCC', $oddBackground='FFF'){          
     *  description du tableau
     *   $this->_background['even'] Couleur de fond des lignes paires 
     *   $this->_background['odd']  Couleur de fond des lignes impaires  
     *          
     * @var array string 
     * @access private
     */
    var $_background = null;
    
    
    /**
     * icons : Ce tableau de tableau associatif Permet de remplacer le contenu 
     *         d'une cellule par une icone selon sa valeur
     *         Permet aussi d'ajouter un lien différent sur l'icone selon la valeur du champ
     *         exmple des des champs boolean. 
     *         supposons un chmp nomme "actif" selon qu'il est vrai ou faux, 
     *         l'icone affiche pourra etre différente.
     *         Un lien pourra etre ajoute par esemple lorsque q'uil est faux
     *         Pour appeler une une procedure qui le rendra actif                     
     *           
     * description des tableaux associatifs:
     *  $t = array(); 
     *  
     *  $t['icons']    = $icons; 
     *  $t['links']    = (is_null($links)) ?array() : $links;
     *  $t['titles']   = (is_null($titles)) ?array() : $titles;
     *  $t['params']   = $this->extractFieldsNames($link);
     *  $t['op']       = $op;
     *  $t['opAttributName']    = $opAttributName;
    
    *    $this->_icons[$key] = $t; la clé dans le tableu principal doit correspondre a une clé
     *  du tableau des titres de colonnes, sot le nom d'un champ.     
     *
     * @var array mixed array
     * @access private
     */
    var $_icons = array();

    /**
     * _extraColonnes : Ce tableau de tableau associatif Permet de remplacer le contenu 
     *
     * @var array mixed array
     * @access private
     */
    var $_extraColonnes = array(); 

    /**
     * _extrafields : Ce tableau de tableau associatif Permet de remplacer le contenu 
     *
     * @var array mixed array
     * @access private
     */
    var $_extraFields = array(); 
    
    /**
     * _mergeFields : Ce tableau de tableau associatif 
     *             Permet de combiner plusieurs champ dans un seule colonne; 
     *
     * @var array mixed array
     * @access private
     */
    var $_mergeFields = array(); 
    
    /**
     * $_form :  
     *
     * @var array mixed array
     * @access private
     */
    var $_form = ''; 
            
    /**
     * $_urlImg :  
     *
     * @var array mixed array
     * @access private
     */
    var $_urlImg = ''; 
    
    /**
     * $_submitBtn :  
     *
     * @var array mixed array
     * @access private
     */
    var $_submitBtn = 0; //position des boutons de soumission ''= pas de bouton, "left" "right" "center"
    
    /**
     * $_cols :  
     *
     * @var array mixed array
     * @access private
     */
    var $_cols= 0; //nombre de colonne affichees calculées lors du render()
    
    /**
     * $_prefixName :  
     *
     * @var array mixed array
     * @access private
     */
    var $_prefixName = array(); 
    
    //var $_loadJS = true;
    
    var $_columns = array();
    var $_newRows = array();
    var $_currentColName = ''; //memorise la derniere colonne ajoutee ou fixer avec la fonction setcurrentColumn
    
    
    
    
    var $_params = array();
    var $_requestName = 'params';
    
    var $_caption_merge_color = '#4177A6';
    var $_caption_merge_separator = '&nbsp;:&nbsp;';    
    var $_footer = '';    
    var $_signet = '';    
 
                    
    /*---------------------------------------------------------------*/    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $value Pre-selected value.
     * @param int $min value
     * @param int $max value
     * @param int $smallIncrement  Increment when click on button
     * @param int $largeIncrement  Increment when click on button
     * @param int $size Number caractere of inputtext
     * @param string $unite of the value
     * @param string $imgFolder of image gif for button
     * @param string $styleText style CSs of text
     * @param string $styleBordure style CSs of frame
     * @param bool $minMaxVisible show min and mas buttons
     *                                        
     */
    function __construct($name, 
                         $caption = '', 
                         $data = null,
                         $className   = '',
                         $style   = '',
                         $urlImg  = '')

    {
      
        $this->myts = MyTextSanitizer::getInstance();
        
        $this->setName($name);
        $this->setCaption($caption);
        
        //$this->setUrlImg( $urlImg .       ((substr($urlImg,-1,1)=='/' ) ? '' : '/')      );
        if ($urlImg == '') {
          $urlImg = XMA_URL  . '/icons/20/';
        }else{
          $urlImg .= ((substr($urlImg,-1,1)=='/' ) ? '' : '/');
          if (strpos($urlImg,'//') === false) $urlImg = XMA_URL  . $urlImg;
        }
        $this->setUrlImg($urlImg);
        
        
        
        
        $this->_className = $className;
        $this->_style = $style;
        //--------------------------------------------------
        if (!is_null($data)){
            $this->setArrayData($data);
          if (is_array($data)){
          }else{
            $this->setQueryData($queryData);
          }
        }
        
      $this->_prefixName = array();
      $this->_prefixName['name']   = '';
      $this->_prefixName['params'] = array();
              
    }
     /*********************************************************************
     *
     *********************************************************************/
  function getNumRow(){
    return $this->_numRow;
  }
    /*********************************************************************
     *
     *********************************************************************/
  function setNumRow($numRow = true){
    $this->_numRow = $numRow;
    //if ($this->getNumRow()){
      $this->addColumn('__numRow__','#', self::col_read, null, 20, "r");
    //}
    
  }
    
     /*********************************************************************
     *
     *********************************************************************/
  function getArrayData(){
    return $this->_data;
  }
    /*********************************************************************
     *
     *********************************************************************/
  function setArrayData($arrayData){
    $this->_data = array_merge($this->_data, $arrayData);
    //echoArray($this->_data,'setArrayData');
  }
    /*********************************************************************
     *
     *********************************************************************/
  function addRow($row){
    if(is_null($this->_arrayData)) $this->_arrayData = array();
    $this->_data[] = $row;
  }
    
    /*********************************************************************
     * Resultat d'une requete a afficher
     *********************************************************************/
  function setQueryData($queryData){
    global $xoopsDB;
    while ($row = $xoopsDB->fetchArray($queryData)){
      $this->_data[] = $row;
    }
  }
    
  ////////////////////////////////////////////////////////////////////////  
    /********************************************************************
     *    
     ********************************************************************/    
    function addColumn($key, $caption, $type, $options= null, $witdh=0, $align='', $style='')
    {
      $this->setCurrentColumn($key);
      
      if (is_null($options)) $options = array();
      if (array_key_exists($key, $this->_columns)) return false;
      
      $col = array();
      $col['type'] = $type;
      $col['key'] = $key;
      $col['caption'] = $caption;
      $col['style'] = $this->_getStyle($witdh, $align, $style);
      $col['styleHead'] = $this->_getStyle($witdh, 'c', $style);
      
      if (isset($options['link'])){
        $col['params'] = $this->_extract_keys($key.'-'.$options['link']);
      }else{
        $col['params'] = $this->_extract_keys($key);
      }
      
      $col['hidden'] = ($type == self::col_hidden);
      if (!is_array($options)) $options = array(); 
        //-----------------------------------------------------------
      $col['options'] = $options;
      $this->_columns[$key] = $col;
    }
    
  /********************************************************************
   * function raccourcis pour cajouter une colonne "actif"   
   ********************************************************************/    
  function addColumn_actif($link, $columnName = 'actif'){
    $this->addColumn($columnName, _AM_JJD_ACTIF, 'mi', null, 50, "c");
    $this->matchIcon(0, 'interdit.gif', $link, JJD_OP_ACTIVATE, 'Inactif');
    $this->matchIcon(1, 'smiley.gif', $link, JJD_OP_ACTIVATE, 'Actif');
  }     
    /********************************************************************
     * fixe le nom de la colonne courante pour eviter de la passerr
     * en paramettre a chaque appel de addOption
     * elle appelle aussi par addColumn()     
     ********************************************************************/    
  function setCurrentColumn(&$columnName = ''){
    if ($columnName == ''){
      $columnName = $this->_currentColName;
    }else{
      $this->_currentColName = $columnName;
    }
    return $columnName;
  }     
    /********************************************************************
     * Controle chaque colonne et selon le type ajoute ou caclul les options manquantes
     * pour ne pas avoir a le faire à chaque ligne du tableau.        
     ********************************************************************/    
    function _valid_columns()
    { 
//echoArray($this->_columns);      
      $keys = array_keys($this->_columns);
      reset($this->_columns);
      foreach ($keys as $key){
        if (!isset($this->_columns[$key]['options'])) $this->_columns[$key]['options'] = array();
        //------------------------------------------------------------
      /////////////////////////////////////////////////////////////////////
      $options = $this->_columns[$key]['options'];
      if (!is_array($options)) $options = array();
      //-----------------------------------------------------------
      //switch($this->_columns[$key]['type']){ 
    if (!isset($this->_columns[$key]['type']))    {
      $this->_columns[$key]['type'] = "z_null";
      //echoArray($this->_columns);      
    }
         
      switch($this->_columns[$key]['type']){
      
      
        case self::col_read : // XoopsFormAdminTable::col_read -> champ en lecture normal au plus simple
          if (isset($options['link'])){
            $options['opAttributName'] = '_op_';
            $options['link'] = str_replace('{' . $options['opAttributName'] . '}' , 
                        $options['op'] , $options['link']);
            $options['params'] = $this->_extract_keys($options['link']);
//             echoArray($options,'1-col_read-'.$key);
          }
          break;
          
        //-------------------------------------------------------------------  
        case self::col_img : // affichage d'une image
          if (isset($options['link'])){
            $options['opAttributName'] = '_op_';
            $options['link'] = str_replace('{' . $options['opAttributName'] . '}' , 
                        $options['op'] , $options['link']);
            $options['params'] = $this->_extract_keys($options['link']);
//             echoArray($options,'1-col_read-'.$key);
          }elseif (isset($options['original'])){
            $options['zoom'] = true;
          }

          break;
        //-------------------------------------------------------------------  
//         case self::col_zoom : // affichage d'une image avec zoom sur une deuxième image
//           if (isset($options['original'])){
//             $options['zoom'] = true;
//           }
//           break;
        //-------------------------------------------------------------------  
        case self::col_link :  
          if (isset($options['libelle'])){
//             $options['opAttributName'] = '_op_';
//             $options['link'] = str_replace('{' . $options['opAttributName'] . '}' , 
//                         $options['op'] , $options['link']);
            $options['params'] = $this->_extract_keys($options['libelle']);
//             echoArray($options,'1-col_read-'.$key);
          }else{
            $options['params'] = array();
          }
          break;
         
        //-------------------------------------------------------------------  
        case self::col_input: // 'io' -> champ text en saisie
          if (!isset($options['size']))      $options['size'] = 50; 
          if (!isset($options['maxLength'])) $options['maxLength'] = 50; 
          break;
          
        //-------------------------------------------------------------------  
        case self::col_hidden: // XoopsFormAdminTable::col_read -> champ en lecture normal au plus simple
          $this->_columns[$key]['hidden'] = 1;
          break;
          
        //-------------------------------------------------------------------  
        case self::col_actions: // icons+link to do something like 'delete', 'clone', ...
          //raf
          break;
        //-------------------------------------------------------------------  
        case self::col_matchIcon: // affecte une icon selon la valeur et permet une action exemple : 'defaut'
//           $opt = array();
//                   foreach($options as $k => $t) {
//             if(!isset($t['title'])) $t['title'] = ''; 
//             if(!isset($t['alt']))   $t['alt'] = '';
//             
//             if(isset($t['icon']) && $t['icon'] != ''){
//               $t['icon']  = $this->_getUrlIcon($t['icon']);
//             }else{
//               $t['icon']  = '';
//             }
//  
//             if(isset($t['link']) && $t['link'] != ''){
//               $t['opAttributName'] = '_op_'; // $opAttributName;
//               if(!isset($t['op'])) $t['op'] = 'none';
//               $t['link'] = str_replace('{' . $t['opAttributName'] . '}' , 
//                                        $t['op'], $t['link']);
//               $t['params']  = $this->_extract_keys($t['link']);
//             }else{
//               $t['link']  = '';
//             }
//             
//             $opt['values'][$k] = $t;
//           }
//           $options = $opt;
          break;
        //-------------------------------------------------------------------  
        case self::col_checkbox: // checkbox
          break;
        //-------------------------------------------------------------------  
        case self::col_radio: // options radio 
          break;
        //-------------------------------------------------------------------  
        case self::col_spin: // spin button
          if (!isset($options['min'])) $options['min'] = 0;
          if (!isset($options['max'])) $options['max'] = 100;
          if (!isset($options['imgFolder'])) $options['imgFolder'] = '';
          if (!isset($options['unite'])) $options['unite'] = '';
          if (!isset($options['smallIncrement'])) $options['smallIncrement'] = 1;
          if (!isset($options['largeIncrement'])) $options['largeIncrement'] = 10;
          if (!isset($options['size'])) $options['size'] = 5;
          break;
        //-------------------------------------------------------------------  
        case self::col_listbox:  
          break;
        //-------------------------------------------------------------------  
        case self::col_dataList:  
          break;
        //-------------------------------------------------------------------  
        case self::col_join: // join fields 
          if (!isset($options['separator'])) $options['separator'] = ' ';
          break;
        //-------------------------------------------------------------------  
        case self::col_merge: // merge columns 
          //echoArray($options['fields'], $key);
          foreach ($options['fields'] as $field){
             if (isset($this->_columns[$field])){
               $this->_columns[$field]['merged'] = $key;
             }else{
               //$this->_columns[$field]['merged'] = $key;
             }
          }
        
          break;
        //-------------------------------------------------------------------  
        case self::col_expression: // 'like sprinf 
          
          if (isset($options['link'])){
            $options['opAttributName'] = '_op_';
            $options['link'] = str_replace('{' . $options['opAttributName'] . '}' , 
                        $options['op'] , $options['link']);
            $options['params'] = $this->_extract_keys($options['link'].$options['expression']);
//             echoArray($options,'1-col_read-'.$key);
          }else{
            //$options['params'] = array();
            $options['params'] = $this->_extract_keys($options['expression']);
          }
          //echoarray($options,self::col_expression);
          break;
        //-------------------------------------------------------------------  
        default:
          //return false;
          break;
        }
        $this->_columns[$key]['options'] = $options;
      }
      //echoArray($this->_columns);
    }
    
    /********************************************************************
     *    
     ********************************************************************/    
    function addOption($key, $value){
      $this->setCurrentColumn($column);
      
      if(func_num_args() > 2){
        $value = array_slice(func_get_args(), 1);
      }
      $this->colOption($column, $key, $value);
    }
    /********************************************************************
     * Ajoute une options à la colonnes dont la cle est passer en parametre
     * Il est préférable d'avoir au préalable créer la colonne avec "addColumn"     
     ********************************************************************/    
    function colOption($column, $key, $value)
    { 
      $this->setCurrentColumn($column);
      if(func_num_args() > 3){
        $value = array_slice(func_get_args(), 2);
      }
      //-----------------------------------------------------
      if (!isset($this->_columns[$column])){
        $col = array();
        $col['key'] = $column;        
        $col['hidden'] = 1;
        $col['caption'] = $key;
        $col['type'] = self::col_read;
        $col['style'] = '';
        $col['styleHead'] = $this->_getStyle(0, 'c', '');
        $col['params'] = $this->_extract_keys($key);
        //-------------------------------------
        $this->_columns[$column] = $col;
      }
      
      if (!isset($this->_columns[$column]['options'])) $this->_columns[$column]['options'] = array();
      $this->_columns[$column]['options'][$key] = $value;
    }
    /********************************************************************
     * Ajoute une options à la colonnes dont la cle est passer en parametre
     * Il est préférable d'avoir au préalable créer la colonne avec "addColumn"     
     ********************************************************************/    
    function addOptionArray($column, $options)
    {
      $this->_columns[$column]['options'] = $options;
    }
    
  /*********************************************************************
   * permet de fusioner pluisuers données dans une meme colonne
   *********************************************************************/
  function merge(){
     $this->setCurrentColumn($column);
     
     
     $t = func_get_args();
     $this->_columns[$column]['options']['fields'] = $t;
     foreach ($t as $v){
        if (isset($this->_columns[$v])){
          $this->_columns[$v]['merged'] = $column;
        }else{
          $this->_columns[$v]['merged'] = $v;
        }

     }
  }
    
  /*********************************************************************
   * permet de fusioner pluisuers données dans une meme colonne
   *********************************************************************/
  function colMerge($column){
     $t = array_slice(func_get_args(), 1);
     $this->_columns[$column]['options']['fields'] = $t;
     foreach ($t as $v){
        if (isset($this->_columns[$v])){
          $this->_columns[$v]['merged'] = $column;
        }else{
          $this->_columns[$v]['merged'] = $v;
        }
     }
  }
    /*********************************************************************
     * Ajout d'une action representee par une icone
     *********************************************************************/
          
  function matchIcon($values, $icon, $link='', $op='none', $title='', 
                     $alt='', $opAttributName='_op_'){
      $this->setCurrentColumn($column);
      $this->colMatchIcon($column, $values, $icon, $link, $op, $title, $alt, $opAttributName);
  }
    /*********************************************************************
     * Ajout d'une action representee par une icone
     *********************************************************************/
  function colMatchIcon($key, $values, $icon, $link='', $op='none', $title='', $alt='', $opAttributName='_op_'){
      $t = array();
      
      $t['title'] = $title; 
      $t['alt']   = $alt;
      $t['icon']  = $this->_getUrlIcon($icon);
      

      if($link != ''){
        $t['opAttributName'] = '_op_'; // $opAttributName;
        //if(!isset($t['op']) || $t['op'] == '') $t['op'] = 'none';
        $t['op'] = $op;
        $t['link'] = str_replace('{' . $t['opAttributName'] . '}' , 
                                 $t['op'], $link);
        $t['params']  = $this->_extract_keys($t['link'] . $title);
      }else{
        $t['link']  = '';
        $t['params']  = $this->_extract_keys($title);
      }
      
      if (is_null($values)) $values = self::col_match_defaut;
      $this->_columns[$key]['icons'][$values] = $t;
      
  }
      
  
    /*********************************************************************
     * Ajout d'une action representee par une icone
     *********************************************************************/
  function addAction($link, $icon, $title, $op='', $condition = null, $opAttributName='_op_'){
    $this->setCurrentColumn($column);
    $this->colAddAction($column, null, null, $link, $icon, $title, $op, $condition, $opAttributName);
  }
    /*********************************************************************
     * Fonction obsolete mais a garder pour analyse (JJD)
     *********************************************************************/
//   function addActionKey($action, $type, $link, $icon, $title, $op='', $condition = null, $opAttributName='_op_'){
//     $this->setCurrentColumn($column);
//     $this->colAddAction($column, $action, $type, $link, $icon, $title, $op, $condition, $opAttributName);
//   }
    /*********************************************************************
     * Ajout d'une action representee par une icone
     *********************************************************************/
  function colAddAction($key, $action, $type ,$link, $icon, 
                        $title, $op='', $condition = null, 
                        $opAttributName='_op_'){
    $t = array(); 

    
    if (!isset($this->_columns[$key])) 
      $this->addColumn($key, $key, XoopsFormAdminTable::col_actions, array(), 250, "c"); 
    //--------------------------------------------------------      
    //$t['opAttributName'] = '_op_';
    $t['opAttributName'] = $opAttributName;
    $t['link'] = str_replace('{' . $t['opAttributName'] . '}' , 
                             $op , $link);
    $t['params']   = $this->_extract_keys($t['link'].$title);
    $t['icon']  = $this->_getUrlIcon($icon);
    $t['title'] = $title;
    $t['op']    = $op;
    
    $tr = array();
    $tr['typeAction'] = 'single'; 
    $tr['icons'] = $t; 
    if (!is_null($condition)) $tr['condition'] = $condition; 
    $this->_columns[$key]['action'][] = $tr;

//     $this->_columns[$key]['action'][] = array(
//           'typeAction' => 'single',
//           'icons' => $t);
   
  }
    

    /*********************************************************************
     * 
     *********************************************************************/
          
  function matchAction($action, $field, $values, $icon, $link='', 
                       $title='', $op='none', $condition = null,  
                       $alt='', $opAttributName='_op_'){
      $this->setCurrentColumn($column);
      $this->colMatchAction($column, $action, $field, $values, $icon, $link, 
                            $title, $op, $condition, 
                            $alt, $opAttributName);
  }

    /*********************************************************************
     * 
     *********************************************************************/
  function colMatchAction($key, $action, $field, $values, $icon, $link='', 
                          $title='', $op='none', $condition = null,   
                          $alt='', $opAttributName='_op_'){
      $t = array();
            
      $t['field'] = $field; 
      $t['title'] = $title; 
      $t['alt']   = $alt;
      $t['icon']  = $this->_getUrlIcon($icon);
      

      if($link != ''){
        $t['opAttributName'] = '_op_'; // $opAttributName;
        //if(!isset($t['op']) || $t['op'] == '') $t['op'] = 'none';
        $t['op'] = $op;
        $t['link'] = str_replace('{' . $t['opAttributName'] . '}' , 
                                 $t['op'], $link);
        $t['params']  = $this->_extract_keys($t['link'] . $title);
      }else{
        $t['link']  = '';
        $t['params']  = $this->_extract_keys($title);
      }
      
      //$this->_columns[$key]['options']['values'][$values] = $t;
      if (is_null($values)) $values = self::col_match_defaut;
      $this->_columns[$key]['action'][$action]['typeAction'] = 'match';
      $this->_columns[$key]['action'][$action]['key'] = $field;
      $this->_columns[$key]['action'][$action]['icons'][$values] = $t;
      if (!is_null($condition)) $this->_columns[$key]['action'][$action]['condition'] = $condition; 
    
  }
  
  
    /*********************************************************************
     *  
     *********************************************************************/
  function addExtraRow($key, $row){
    if (!$this->_extraRows) $this->_extraRows = array();
    $this->_extraRows[$key] = $row; 
  }
  
    /*********************************************************************
     *  
     *********************************************************************/
  function setSignet($signet){
  //exempleple $signet = "signet-{idMedia}";
    $this->_signet = $signet; 
    
  }
  function getSignet(){
  //exempleple $signet = "signet-{idMedia}";
    return $this->_signet; 
    
  }
    /*********************************************************************
     *  
     *********************************************************************/
  function addFooter($footer){
    $this->_footer = $footer; 
  }
    /////////////////////////////////////////////////////////////////////////
    /*********************************************************************
     * Encadre le tableau HTML dans un formulaire
     * Il n'est pas possible pour l'instant d'ajouter les boutons de validation
     * aussi le submit doit être fait via un bouton externe et une commande javascript
     * exemple:
     *  $extra = "javascript: document.forms[\"myform\"].elements[\"op\"].value=\"activer_selection\";"
     *                     . "document.forms[\"myform\"].submit();";
     *  Noter la modification de la valeur de variable "op"     
     * puis utiliser ce code soit dans le onclick d'un bouton                   
     * <input type='button' onclick='{$extra}' value='Valider' title='' />
     * soit avec les bouton du framework moduleadmin               
     * $index_admin->addItemButton(_AM_JJD_ACTIVATE_SELECTION, $extra, 'add');                    
     *********************************************************************/
  function setForm($name, $action, $opAttributName='op', $prefixName=''){ 
  
    $this->_form = "<form name='{$name}' id='{$name}' action='{$action}' "
                 . "method='post' enctype='multipart/form-data'>\n" 
                 . "<input type='hidden' id='{$opAttributName}' name='{$opAttributName}' value='???'>\n";
  }
  
  /***********************************************************************
   *
   ***********************************************************************/
  function setPrefix($prefixName=''){ 
    $this->_prefixName['name']   = $prefixName;
    $this->_prefixName['params'] = $this->_extract_keys($prefixName);
  }
  /***********************************************************************
   *
   ***********************************************************************/
  function addNewRows($idName, $prefixName, $dataEmpty, $rows=5, $firstId = 10000){ 
    $this->_newRows['prefixName'] = $prefixName;
    $this->_newRows['idName'] = $idName;
    $this->_newRows['dataEmpty'] = $dataEmpty;
    $this->_newRows['rows'] = $rows;
    $this->_newRows['firstId'] = $firstId;
  }
    /*-----------------------------------------------------------------*/
    /**
     * Get the urlImg string
     */
    function getUrlImg()
    {
        return $this->_urlImg;
    }

    /**
     * Set the urlImg
     *
     * @param  $urlImg string
     */
    function setUrlImg($urlImg)
    {
         $this->_urlImg = $urlImg;
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the $_submitBtn bool
     */
    function submitBtn($align='center')
    {
        if (is_null($align)){
          $align='';
        }elseif($align==''){
          $align='center';
        }
        $this->_submitBtn = $align;
    }
    /*********************************************************************
     * defini les couleurs alternative de fond des lignes du tableau
     *********************************************************************/
  function setBackground($evenBackground='FFFFFF', $oddBackground='EFEFEF'){
  //  CCC   FFF       
    $this->_background = array(); 
    $this->_background['even'] = ((substr($evenBackground,0,1) == "#") ? "": "#") . $evenBackground; 
    $this->_background['odd']  = ((substr($oddBackground,0,1)  == "#") ? "": "#") . $oddBackground; 
  }
    /*********************************************************************
     *
     *********************************************************************/
  function _getAlign($exp){
    if ($exp == '') return '';
    $c = strtolower(substr($exp,0,1));
    if (!isset($this->tAlign))
    $this->tAlign = array('l'=>'left','g'=>'left',
                          'r'=>'right','d'=>'right',
                          'c'=>'center','m'=>'center');
               
    if (array_key_exists($c, $this->tAlign)){
      return $this->tAlign[$c];
    }else{
      return '';
    }
  }
  
    /*********************************************************************
     *
     *********************************************************************/
  function _getStyle($width=0, $align='', $style=''){
     
      if ($style != '') $style = " style='{$style}'";
      
      if ($width != 0)  $style .= " width=\"{$width}px\"";
      if ($align != '') {
        $align = $this->_getAlign($align);
        $style .= " align=\"{$align}\"";
      }
      
      return $style;
  }
    

    /*********************************************************************
     *
     *********************************************************************/
    private function _getUrlIcon($icon)
    {                    
      if (is_array($icon)){   
      jecho ($icon); exit;      
        $t = array();
        foreach($icon as $k => $v) {
          $t[$k] = $this->_getUrlIcon($v);
        }
        return $t;
      }else{
        if (strpos($icon,'://') === false){
           $icon  =  $this->_urlImg ."/icons/20/". $icon;
        }
       // echo "===> {$icon}<br>";exit;
           return $icon;
      
      }
      
    }


    /*********************************************************************
     *  Extrait les nom de champ entre accolades dans l'expression passe en parametre
     *  utilise notamment pour les lien pour remplacer par exemple un identifiant pour chaque ligne     
     *  $exp peut être un tableau d'expressions ou une expression simple
     *  les mot cle cherches son entr accolade
     *  exemple "idTogodo={idTogodo}"     
     *          {idTogodo} sera remplace par l'identifiant ou la donnée de la ligne en cours
     *          ce doit être une clé de $_data               
     *********************************************************************/
  private function _extract_keys($exp){
//     $motif = "#.*\{(.*)\}.*#";    
//     $motif = "#.*[\{](.*)[\}].*#U";    
    
    $motif = "#.*\{(.*)\}.*#U";    
    
    if (is_array($exp)){
      $t = array();
     foreach($exp as $k => $v) {
        preg_match_all($motif, $v, $tExp, PREG_PATTERN_ORDER);
        $t = array_merge($t, $tExp[1]);
      }
    }else{
      preg_match_all($motif, $exp, $tExp, PREG_PATTERN_ORDER);
      $t = $tExp[1];
    }
    
    //echoArray($tExp, 'preg_match_all');    
    return array_unique($t);
  
  }
  
    /*********************************************************************
     * Construction du code HTML des liens sur le contenu des colonnes
     *********************************************************************/
  private function _replace_keys($exp, &$params, $row, $debug = false){
  
    $ok = true;
    if (!is_array($params)){
      //echo "{$exp}<br>";
      //$params = array_keys($row);
      return false;
    }
    reset ($params);
    foreach($params as $k => $v) {
      if (isset($row[$v])){
        if($debug) echo "_replace_keys 1 -> " . $exp . '<br>';
        $exp = str_replace('{' . $v .'}' , $row[$v], $exp);
        if($debug) echo "_replace_keys 2 => " . $exp . '<br>';
      } 
    }
    
    return $exp;
  }


  ///////////////////////////////////////////////////////////////////////////
  /**************************************************************************/
  ///////////////////////////////////////////////////////////////////////////
      
    /************************************************************************
     *    
     ************************************************************************/    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     * http://www.w3.org/Style/Examples/007/evenodd.html     
     */
    function render($display = false)
    {
//$this->_display_array($this->_columns,'Detail des colonnes définies');
//$this->_display_array($this->_data,'Data');
//$this->_display_array($this->_prefixName,'prefix des nom de champs');

      global $xoopsDB;
      //initilastion des clefs manquantes dans le tableau d'options
      //pour eviter les if a la elle qui aloiurdissent le code
      $numRow = 0;
      
      $this->_valid_columns();
      
      $t = array();
      
      if ($this->_form != ''){
        $t[] = $this->_form;
      }

      if (!is_null($this->_background)){
        $t[] = "<style>";
        $t[] = "#{$this->getName()} tr:nth-child(even) {background: {$this->_background['even']};}";
        $t[] = "#{$this->getName()} tr:nth-child(odd)  {background: {$this->_background['odd']};}";
        
        //pour les cellule qui sont de type "merge"
        $t[] = "#{$this->getName()}_subtable tr:nth-child(even) {background: transparent;}";
        $t[] = "#{$this->getName()}_subtable tr:nth-child(odd)  {background: transparent;}";
        
        $t[] = "</style>";
      }
      //-------------------------------------------
      $t[] = $this->_render_ParamsForm();
      
      //-------------------------------------------
      $t[] = "<table name='{$this->getName()}' id='{$this->getName()}' style='table-layout:fixed;word-wrap:break-word;border-style: solid; border-width: 1px;'>";
 
      //-------------------------------------------
      //construction du titre du tableau
      $t[] = $this->_render_caption();
      $t[] = "<thead>";
      
      //construction des titres de colonnes
      $t[] = $this->_render_titles();
      $t[] = "</thead>";
      //-------------------------------------------
      $t[] = "<tbody>";
      //-------------------------------------------
      //echoArray($this->_actions);
      //if (!is_null($this->_arrayData)){
      if (count($this->_data) > 0){
        foreach($this->_data as $kRow => $row) {
          $row['__numRow__'] = ++$numRow;
          $t[] = $this->_render_row($row);
        }
      }
      //-------------------------------------------
      // echoArray($this->_newRows);//jexit;
      if(isset($this->_newRows['rows'])){
      $t[] = "<tr><th colspan='{$this->_cols}' >"._AM_JJD_NEW_ENTRY."</th></tr>";
      //$this->setbackground('FFFFFF','EFEFEF');
        //$this->_render_empty();
        $row = $this->_newRows['dataEmpty'];
        $this->setPrefix($this->_newRows['prefixName']);
        for ($h=0; $h<$this->_newRows['rows']; $h++){
          $row[$this->_newRows['idName']] = $this->_newRows['firstId'] + $h;
          $t[] = $this->_render_row($row);
        }
        
      }
      
      //-------------------------------------------
      if ($this->_submitBtn != ''){
        //$t[] = "<tr><td align='{$this->_submitBtn}' colspan='".count($this->_titles)."'>";
        $t[] = "<tr><td align='{$this->_submitBtn}' colspan='".$this->_cols."'>";
        $submit = new XoopsFormButtonTray("Send", _SEND, "submit", '') ; 
        $t[] = $submit->render() ; 
        $t[] = "</td></tr>";
      }
      //-------------------------------------------
      $t[] = "</tbody>";
      $t[] = $this->_render_footer();
      $t[] = "</table>";
      if ($this->_form != '') $t[] = "</form>";
    

      //-------------------------------------------
      $html = implode ("\n", $t);
      if ($display) echo $html;
      return $html;

}
    
    
    /*********************************************************************
     * Construction du code HTML du titer du tableau et des colonnes du tableau
     *********************************************************************/
  private function _render_caption(){  
    $caption = $this->getCaption();
    if($caption == '' && $this->_extraRows['caption'] == '') return ""; 
    //-----------------------------------------------------------------
    $t = array();
    $t[] = " <caption class='head' style='border-style: solid; border-width: 1px;'>";
    if ($caption != '') $t[] = $caption;
      //-------------------------------------------
      if(isset($this->_extraRows['caption'])){
        if ($caption != '') $t[] = "<br /><br />";
        $t[] = $this->_extraRows['caption'];
      }
    $t[] = " </caption>";
    return implode('', $t);
  }

    /*********************************************************************
     * Construction du code HTML du titer du tableau et des colonnes du tableau
     *********************************************************************/
  private function _render_footer(){  
    $footer = $this->_footer;
//     echo '>>>' . $this->_footer;
//     jexit;
    //$footer = 'zz e rrrrr ';
    if($footer == '') return ""; 
    //-----------------------------------------------------------------
    $t = array();
    
    $t[] = " <tr><td class='head' style='border-style: solid; border-width: 1px;' colspan='{$this->_cols}'>";
    $t[] = $footer;
    $t[] = " </td></tr>";
    
    return implode('', $t);
  }
    /*********************************************************************
     * Construction du code HTML du titre du tableau et des colonnes du tableau
     *********************************************************************/
    private function _render_titles(){
    
    //echoarray($this->_titles,'_render_titleRow');
    $t = array();
    $this->_cols = 0;
    //-------------------------------------------
    $t[] = "<tr class='head'>";
      foreach($this->_columns as $key => $col) {
        if (isset($col['hidden']) && $col['hidden'] == 1) continue;
        if (isset($col['merged'])) continue;
        
        if (!isset($col['styleHead'])) $col['styleHead']='';
        $t[] = "<td {$col['styleHead']}>{$col['caption']}</td>";
        $this->_cols ++;
     }
//     if (count($this->_actions) > 0) 
//         $t[] = "<td align='center'>" . _AM_JJD_ACTIONS . "</td>";
    $t[] = "</tr>";
    //----------------------------------------------------------------------  
    $html = implode ("\n", $t);
    return $html;
  }
    /************************************************************************
     *    
     ************************************************************************/    
    private function _isColumnOk(&$param, &$row){
//echoArray($col,'col_checkbox');
      $ok = true;
      if(isset($param['condition'])){
        $filter = '$ok=(' . $param['condition'] . ');';
        eval($filter);
//echo "condition : ({$filter}) = " . (($ok)?"O":"N"). "<br>";  
        if (!$ok) $colType = self::col_empty;
      }
       return $ok;       
    }

    /************************************************************************
     *    
     ************************************************************************/    
    private function _render_column($key, &$col, &$row, $addTD = true){
        if (!isset($row[$key])) $row[$key] = '';
        
        if (true){
           $name  = $this->_replace_keys($this->_prefixName['name'], $this->_prefixName['params'], $row, false);
           $name .= $this->_replace_keys("[{$key}]", $col['params'], $row, false);
        }else{
          //$name = $key;
          $name = $this->_replace_keys("{$key}", $col['params'], $row, false);  
        };
        //-------------------------------------------------------------------  
        $colType = ($this->_isColumnOk($col['options'], $row)) ? $col['type'] : self::col_empty;
        //-------------------------------------------------------------------  
        //switch($col['type']){
        switch($colType){
        case self::col_read : // XoopsFormAdminTable::col_read -> champ en lecture normal au plus simple
// echoArray($col['options'], $colType);   
// echoArray($row, 'sommaire');   
         if(isset($col['options']['link'])){
            $link = $this->_replace_keys($col['options']['link'], $col['options']['params'], $row);
            
//             echoArray($col['options'],'2-col_read -' . $key."<br>-{$link}");
            $cell = "<a href='{$link}'>{$row[$key]}</a>";
          }else{
//if (!isset($row[$key])) echo "$key<br>";
            $cell = $row[$key];
          }
          //-----------------------------------------------------------'
         if(isset($col['options']['name'])){
            //$link = "<a href name='{$col['options']['name']}' />"  ;
            $link = "<a href name='{$row[$col['options']['name']]}' />"  ;
            $cell .= $link;
          }
          //-----------------------------------------------------------'
          if(isset($col['options']['hidden']) && $col['options']['hidden']==true){
            $xf = new XoopsFormHidden($name, $row[$key]);
            $cell .= $xf->render();
          }
          break;
        //-------------------------------------------------------------------  
         case self::col_img : // image
          $padding = (isset($col['options']['padding']) ? $col['options']['padding'] : 2);
          $img = "<img src='{$row[$key]}' style='padding:{$padding}px;' {$col['style']} title='' alt=''/>";
          if(isset($col['options']['link'])){
            $link = $this->_replace_keys($col['options']['link'], $col['options']['params'], $row);
            
//             echoArray($col['options'],'2-col_read -' . $key."<br>-{$link}");
            $cell = "<a href='{$link}'>{$img}</a>";
          }elseif($col['options']['zoom']){
            $cell = "<a href='{$row[$col['options']['original']]}' class='highslide' onclick='return hs.expand(this);' >"
                  . $img . "</a>";
          }else{
            $cell = $img;
          }
          
          break;
        //-------------------------------------------------------------------  
//          case self::col_zoom : // image avex zoom
//           $padding = (isset($col['options']['padding']) ? $col['options']['padding'] : 2);
//           $img = "<img src='{$row[$key]}' style='padding:{$padding}px;' {$col['style']} title='' alt=''/>";
//           if($col['options']['zoom']){
//             $cell = "<a href='{$row[$col['options']['original']]}' class='highslide' onclick='return hs.expand(this);' >"
//                   . $img . "</a>";
//           }else{
//             $cell = $img;
//           }
//           
//           break;
        //-------------------------------------------------------------------  
       case self::col_link :      
          if ($row[$key] != ''){
            if(isset($col['options']['field']) && $row[$col['options']['field']] !=''){
              $siteName =  $row[$col['options']['field']];
            }else{
              $siteName = $col['options']['defaut'];
            }
          
          
//             if(isset($col['options']['libelle'])){
//               $libelle = $this->_replace_keys($col['options']['libelle'], $col['options']['params'], $row);
//             }else{
//               $libelle = $row[$key];
//             }
            
            if(strpos($row[$key],'://') === false){
              $link = 'http://' . $row[$key];
            }else{
              $link = $row[$key];
            }
//            echoArray($col['options'],'2-col_link -' . $key."<br>-{$link}");
            $cell = "<a href='{$link}' target='blank'>{$siteName}</a>";
          }else{
            $cell = "";
          }
          break;
        //-------------------------------------------------------------------  
        case self::col_input: // 'io' -> champ text en saisie
        //echoArray($col['options'],'col_input');
        //echoArray($row);
          //$xf =  new XoopsFormText('', $name, $col['options']['size'], $col['options']['maxLength'], $row[$key]);      
                    $xf =  new XoopsFormText('', $name, $col['options']['size'], $col['options']['maxLength'],$this->myts->htmlSpecialChars($row[$key], "1", null, "1"));
          
          if (isset($col['options']['extra'])) $xf->setExtra($col['options']['extra']);
          $cell = $xf->render();
          break;
          
        //-------------------------------------------------------------------  
        case self::col_hidden: // XoopsFormAdminTable::col_hidden -> 
          $colName = (isset($col['options']['field'])) ? $col['options']['field'] : $key;
          $v = (isset($row[$colName]) ? $row[$colName] : 0);
          $obName = (isset($row[$key])) ? $name : $this->_replace_keys($key, $col['params'], $row, false);
          
          $xf = new XoopsFormHidden($obName, $v);
          $cell = $xf->render();
          $addTD = false;
          break;
          
        //-------------------------------------------------------------------  
        case self::col_actions: // icons+link to do something like 'delete', 'clone', ...
          $cell = $this->_render_actions($col, $row);
// echoArray($col,"zzzzzzzz");
//           switch($col['options']['typeAction']){
//             case 'match':
//               $cell = $this->_render_matchIcon($col, $row);        
//               break;
//             
//             case 'single':
//             default:
//               break;
//           }
          break;

        //-------------------------------------------------------------------  
        case self::col_matchIcon: // affecte une icon selon la valeur et permet une action exemple : 'defaut'
          $cell = $this->_render_matchIcon($col, $row);        
          //$cell = 'ooooooooooo';        
          break;
          
        //-------------------------------------------------------------------  
        case self::col_checkbox: // affichage d'une case a cocher
//echo "===>{$name}<hr>";
//$this->_display_array($this->_prefixName['params'],'params : ' . $this->_prefixName['name']);
//$this->_display_array($row,'data');
//echoArray($col);
          
          $colName = (isset($col['options']['field'])) ? $col['options']['field'] : $key;
          $v = (isset($row[$colName])) ? $row[$colName] : 0;
          $obName = (isset($row[$key])) ? $name : $this->_replace_keys($key, $col['params'], $row, false);
//           if (isset($row[$colName])){
//             $v = $row[$colName];
//             $cbName = $name;
//           }else{
//             $v = 0;
//             $cbName = $this->_replace_keys($key, $col['params'], $row, false);
//           }
          $xf = new XoopsFormCheckBox('', $obName, $value = $v, '');
          //$xf->addOptionArray($col['options']);
          $xf->addOption(1, chr(0)); //chr(0) permet d'avoir un libelle non vide sinon la valeur s'affiche comme un libelle)
          $cell = $xf->render();
          //$cell = $this->_render_cb($col, $row);        
          //$cell = 'ooooooooooo';        
          break;

        //-------------------------------------------------------------------  
        case self::col_radio: // options radio
          $xf = new XoopsFormRadio('', $name, $row[$key], '');
          $xf->addOptionArray($col['options']);
          $cell = $xf->render();
        //$html->setExtra('{state}');

          break;
        //-------------------------------------------------------------------  
        case self::col_spin: // 's' -> spin button
          //echoArray($col['options'],'options');
          $xf = new XoopsFormSpinMap('',$name, $row[$key], 
                      $col['options']['min'], 
                      $col['options']['max'],
                      $col['options']['smallIncrement'], 
                      $col['options']['largeIncrement'], 
                      $col['options']['size'], 
                      $unite=$col['options']['unite'] , 
                      $urlImgFolder=$col['options']['imgFolder']);
          $cell = $xf->render();
        //$html->setExtra('{state}');

          break;
        //-------------------------------------------------------------------  
        case self::col_listbox: // list deroulante
          //echoArray($col['options'],'options');
          $xf = new XoopsFormSelect('', $name, $value = $row[$key], $size = 1, $multiple = false);
          //$xf->setExtra("style=\"background:#00FF55;border-width:5px;border-color:#FF0000;\"");
          $xf->addOptionArray($col['options']);
          $cell = $xf->render();
        //$html->setExtra('{state}');

          break;
          
        //-------------------------------------------------------------------  
        case self::col_dataList: // list deroulante
            /*
            a developper pour avoir une meme liste pour plusieurs liste deroulante
            sur me modele de "self::col_listbox"
            */
            //echo "===>{$name}<hr>";
            //jecho ($row);
            if (!isset($col['xf'])){
              $col['xf'] = new XoopsFormDataList($key . '_dataList');   
              $col['xf']->addOptionArray($col['options']);
            }
            $xf = $col['xf']->newXoopsFormInputDataList('', $name, $row[$key]); 
            $cell = $xf->render();
          break;
          
        //-------------------------------------------------------------------  
        case self::col_editListbox: // list deroulante editable
          //echoArray($col['options'],'options');
          $xf = new XoopsEditList('', $name, $value = $row[$key], $size = 1, $multiple = false);
          //$xf->setExtra("style=\"background:#00FF55;border-width:5px;border-color:#FF0000;\"");
          $xf->addOptionArray($col['options']['list']);
          if (isset($col['options']['width'])) $xf->setWidth($col['options']['width']);
          $cell = $xf->render();
        //$html->setExtra('{state}');

          break;
          
        //-------------------------------------------------------------------  
        case self::col_merge: // merge columns
            $tHtml = array();
            $tHtml[]="<table id='{$this->getName()}_subtable'>";
            //$tHtml[]="<table style='background-opacity:0;'>";
            foreach ($col['options']['fields'] as $field){
              if (isset($row[$field])){
                $tHtml[]="<tr>";

                //$tHtml[]="<td style='background:transparent;'>".$this->_columns[$field]['caption']."</td>";
                $tHtml[]="<td width='10%' align='right' style='color:{$this->_caption_merge_color};'>".str_replace(' ','&nbsp;',$this->_columns[$field]['caption'])."</td>";
                $tHtml[]="<td width='5px' align='center'>{$this->_caption_merge_separator}</td>";
                $tHtml[] = $this->_render_column($field, $this->_columns[$field], $row, true);
                $tHtml[]="</tr>";
              }else{
                $tHtml[]="<tr><td colspan='3'>" . self::_HR_ . "</td></tr>";
              } 
            }
            //$cell = implode($col['options']['separator'], $values);
            $tHtml[]="</table>";
            $cell = implode("\n", $tHtml);
          break;
        //-------------------------------------------------------------------  
        case self::col_merge2: // merge columns
            $tHtml = array();
            foreach ($col['options']['fields'] as $field){
              if (isset($row[$field])) 
                $tHtml[] = $this->_render_column($field, $this->_columns[$field], $row, false);
            }
            $sep = (isset($col['options']['sep'])) ? $col['options']['sep'] : "<br />";
            //$cell = implode("<br />", $tHtml);
            $cell = implode($sep, $tHtml);
          break;
        //-------------------------------------------------------------------  
        case self::col_join: // join fields 
            $values = array();
            foreach ($col['options']['fields'] as $field){
              if (isset($row[$field])) $values[] = $row[$field];
            }
            $cell = implode($col['options']['separator'], $values);
          break;
        //-------------------------------------------------------------------  
        case self::col_expression: // Build an expression like sprintf 
          //echoArray($col['options'], $key);
          $lib = $this->_replace_keys($col['options']['expression'], $col['options']['params'], $row);
          
          if(isset($col['options']['link'])){
            $link = $this->_replace_keys($col['options']['link'], $col['options']['params'], $row);
            
//             echoArray($col['options'],'2-col_read -' . $key."<br>-{$link}");
            $cell = "<a href='{$link}'>{$lib}</a>";
          }else{
//if (!isset($row[$key])) echo "$key<br>";
            $cell = $lib;
          }
          
          
          break;
        //-------------------------------------------------------------------  
        case self::col_empty: // Zone vide
          //echoArray($col['options'], $key);
          $cell = '';
          break;
        //-------------------------------------------------------------------  
        default:
          $cell = '???';
          break;
        }
        //=======================================================
        if ($addTD){
          $cell = "<td {$col['style']}>".$cell."</td>";
        }
        //$tHtml[] = "<td {$col['style']}>".$key.'-' .$cell."</td>";
        return $cell;
        
    }
    /************************************************************************
     *    
     ************************************************************************/    
    private function _render_row($row){
      //$this->_addFields($vData);
      //---------------------------------------------

      
      reset($this->_columns);
      $tHtml = array();
      if ($this->_signet == ''){
        $tHtml[] = "<tr>";
      }else{
        $params = $this->_extract_keys($this->_signet);
        $signet = $this->_replace_keys($this->_signet, $params, $row);
        $tHtml[] = "<tr name='{$signet}' id='{$signet}' >";
      }
      
      //echoArray($this->_links);
      //--------------------------------------------------------------
      //$this->_display_row($row);
      foreach($this->_columns as $key => $col) {
        if (isset($col['merged'])) continue;
        $tHtml[] = $this->_render_column($key,$col,$row);
      }
      //--------------------------------------------------------------


      $tHtml[] = "</tr>";
    //----------------------------------------------------------------------  
    $html = implode ("\n", $tHtml);
    return $html;
    }
    
/************************************************************************
 *    
 ************************************************************************/    
    private function _render_empty(){
      $row = $this->_newRows['dataEmpty'];
      $this->setPrefix($this->_newRows['prefixName']);
      for ($h=1; $h<=$this->_newRows['rows']; $h++){
        $row[$this->_newRows['idName']] = -$h;
        $this->_render_row($row);
      }
//     $this->_newRows['prefixName'] = $prefixName;
//     $this->_newRows['dataEmpty'] = $dataEmpty;
//     $this->_newRows['rows'] = $prefixName;
//     $this->_newRows['idName'] = $prefixName;
    
    }

    /*********************************************************************
     * construction du code HTML des actions (iconnes: delete, edit, ...)
     *********************************************************************/
    private function _render_actions(&$col, &$row){
    //echoArray($col,"zzzzzzzz");
      $tHtml = array();
      //reset($cols['icons']);  
      //$tHtml[] = "<td align='center'>";       
      foreach($col['action'] as $kAction => $vAction) {
    //echoArray($vAction, "typeAction = " . $col['action']['typeAction']);
       
        $typeAction = ($this->_isColumnOk($vAction, $row)) ? $vAction['typeAction'] : '';
        
        switch($typeAction){
          case 'match';
            $tHtml[] = $this->_render_matchIcon($vAction, $row);
            break;
            
          case 'single':
            $tHtml[] = $this->_render_single_action($vAction['icons'], $row);
            break;
            
          default:
            $tHtml[] = $this->_getBlankIcon();
            break;
        }
       }
      //$t[] = "</td>";         
      
    //----------------------------------------------------------------------  
    $html = implode ("\n", $tHtml);
    return $html;
    }

    /*********************************************************************
     * construction du code HTML des actions (iconnes: delete, edit, ...)
     *********************************************************************/
    private function _render_single_action($vAction, $row){
        $link = $this->_replace_keys($vAction['link'], $vAction['params'], $row);
        $html = "<A href='{$link}'>"
             . "<img src='" . $this->_urlImg . "/icons/20/_05.gif' border=0 alt='' title='' />"
             . "<img src='{$vAction['icon']}' border=0 "
             . "Alt=\"\" title=\"{$vAction['title']}\" ALIGN='absmiddle' />"
             . "<img src='" . $this->_urlImg . "/icons/20/_05.gif' border=0 alt='' title='' />"
             . "</A>";
      return $html;
    }
    
    /*********************************************************************
     * construction du code HTML des actions (iconnes: delete, edit, ...)
     *********************************************************************/
    private function _getBlankIcon($size = '20'){
      return "<img src='" . $this->_urlImg . "/icons/20/_{$size}.gif' border=0 alt='' title='' />";
    }
    /*********************************************************************
     * construction du code HTML des actions (iconnes: delete, edit, ...)
     *********************************************************************/
    private function _render_matchIcon(&$col, $row){
  
//echoArray($col, '_render_matchIcon');         
        $key = $col['key'];
        
        $key = $col['key'];
        if (!isset($row[$key])) return $this->_getBlankIcon();
        $v = $row[$key];
        $index = (isset($col['icons'][$v])) ? $v : self::col_match_defaut;
        
        //des fois que la valeur par defaut n'est pas ete definie
        if (!isset($col['icons'][$index])) return $this->_getBlankIcon(); 
        
                 
//     $tr = print_r($row,true);
//     $tr = print_r($col,true);
//     echo "{$key}<pre>{$tr}</pre>";
        
        
        
        
        $tmi = $col['icons'][$index];
//echoArray($tmi,'_render_matchIcon');
        $title = $this->_replace_keys($tmi['title'], $tmi['params'], $row);
        
        if (isset($tmi['link']) && $tmi['link'] != ''){
           $link = $this->_replace_keys($tmi['link'], $tmi['params'], $row);
           $html = "<a href='{$link}'>"
                 . "<img src='{$tmi['icon']}' title='{$title}' alt='{$tmi['alt']}' />"
                 . "</a>";
        }else{
           $html = "<img src='{$tmi['icon']}'  title='{$title}'/>";
        }
               
    //----------------------------------------------------------------------  
    return $html;
           
            

    }
    
    /************************************************************************
     *    
     ************************************************************************/    
    function addParamsForm($name='', $value='', $requestName='params'){
        if (isset($requestName)) $this->_requestName = $requestName;
        if (!is_array($this->_params)) $this->_params = array();
        if ($name != '') $this->_params[$name] = $value;
        return implode('&', $this->_params);
    }
    /************************************************************************
     *    
     ************************************************************************/    
    function _render_ParamsForm(){
        if (!is_array($this->_params)) $this->_params = array();
        $t = array();
        foreach($this->_params as $name => $value) {
          $t[] = "<input type='hidden' name='{$this->_requestName}[{$name}]' value='{$value}' />";
        }

        //echoArray($this->_params,_render_ParamsForm);
        return "\n" . implode("\n", $t) . "\n" ;
    }
    /************************************************************************
     *    
     ************************************************************************/    
    function display(){
      //echo $this->render();
      $this->render(true);
    }
    
    
    
    /************************************************************************
     *    
     ************************************************************************/    
    private function _display_array($t, $title=''){
      reset($t);
      $tr = print_r($t, true);
      echo "<hr>{$title}<pre>{$tr}</pre><hr>";
    }
    

}
/*-----------------------------------------------*/
/*---          fin de la classe               ---*/
/*-----------------------------------------------*/

class xfAT extends XoopsFormAdminTable {}

?>
