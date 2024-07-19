<?php
/**
 * XOOPS form element
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
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @version         $Id: formselectmatchoption.php 8066 2011-11-06 05:09:33Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormSelect');

/**
 * A selection box with options for matching files.
 */
class XoopsFormSelectFile extends XoopsFormSelect
{
  var $_vars = array();
  
    /**
     * Constructor
     *
     * @param string $caption
     * @param string $name
     * @param mixed $value Pre-selected value (or array of them).
     * 							Legal values are {@link XOOPS_MATCH_START}, {@link XOOPS_MATCH_END},
     * 							{@link XOOPS_MATCH_EQUAL}, and {@link XOOPS_MATCH_CONTAIN}
     * @param int $size Number of rows. "1" makes a drop-down-list
     */
    function __construct($caption, $name, $value = null, $size = 1)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size, false);
    }

    function find($folder, $extentions, $addblanck, $isKeyName, $isFullNameFolder=false){
//       $this->_vars['folder'] = $folder;
//       $this->_vars['extention'] = $extention;
//       $this->_vars['addblanck'] = $addblanck;
//       $this->_vars['isKeyName'] = $isKeyName;
//       $this->_vars['isFullNameFolder'] = $isFullNameFolder;
// echoArray($this->getValue());    
// echo "getFiles ===> " . $folder . "<br />" . $this->getValue() . "<hr>";  
        //$tf = $this->getFiles ($this->_vars['folder'] , $this->_vars['extentions'],  $this->_vars['addblanck']);
        $tf = $this->getFiles ($folder, $extentions,  $addblanck, false,$isKeyName );
        $this->addOptionArray($tf);
     }
/***************************************************************
 *
 ***************************************************************/ 
//      function render(){
//         $tf = $this->getFiles ($this->_vars['folder'] , $this->_vars['extention'],  $this->_vars['addblanck']);
//         $this->addOptionArray($tf);
//         return $this::render();
//      }
/****************************************************************************
 *$isFullfolder : nouveau paramFiltre pour indiquer si $folder est un dossier complet 
 * ou un debut but de racine
 * exemple : 
 * "monsite/modules/hermes/admin"   Tquivalent a  "monsite/modules/hermes/admin/" 
 * "monsite/modules/hermes/admin_"   Tquivalent a  "monsite/modules/hermes/admin/admin_*"
 * le premier est un chemin complet le 2eme est un cemin avec une racine de fichiers
 * ce qui permet de cherchertous les fichiers qui commence par un prfixe   
 * 
 *  
 *
 *  $k = "imgFile";
  $xfValue[] = new XoopsFormSelect(_AM_WAL_IMAGE, sprintf($xName,$k), $t[$k], 0 , false) ; 
  $folder = _WALLS_ROOT_MODULE . '/images/watermarks';
  $tf = pw_getFiles ($folder, 'jpg;png', true);
  $xfValue[count($xfValue)-1]->addOptionArray($tf);
  $form->addElement($xfValue[count($xfValue)-1], false);     
     
 ****************************************************************************/
function getFiles ($folder, 
                      $extention = '', 
                      $addblanck = true, 
                      $fullName = false,
                      $isKeyName = true,
                      $isFullNameFolder = true)
{

    if (!(substr($folder,-1) == '/') & $isFullNameFolder) $folder.='/';
    $folder = str_replace('//','/',$folder);

    $tf = array();
    if ($addblanck) $tf[] = ' ';
    //-------------------------------------------
    if ($extention == '' ){
      $filtre = false;
    }else{
      $filtre = true;
       if (is_array($extention)){
        $t = $extention;
      }else{
        $t = explode(';', $extention); 
      }
      for ($h=0, $count=count($t); $h < $count; $h++){
        $t[$h] = strtolower($t[$h]);
        $t[$h] = str_replace ('.','', $t[$h]);
      }
    }
    //-------------------------------------------------
    if ($handle = opendir($folder)) {
        while (false !== ($file = readdir($handle))) {
          if ($file == '.' || $file == '..') continue;
          if ($filtre){
            $items = explode('.', $file);
            $ext = strtolower($items[count($items)-1]);
            if (in_array($ext, $t)) {
            $bolOk = true;
            }else{
              $bolOk = false;
            }
            
          }else{
            $bolOk = true;
          }
          //-------------------------------------------
          if ($bolOk){ 
            if($isKeyName){
              $tf[$file] = (($fullName) ? $folder : '') . $file;
            }else{
              $tf[] = (($fullName) ? $folder : '') . $file;
            }
          }
          
        }
        closedir($handle);
    }
    
    return $tf;
}

///////////////////////////////////////////////
} // fin de la classe Files
///////////////////////////////////////////////



///////////////////////////////////////////////
//              classe folder
///////////////////////////////////////////////

/**
 * A selection box with options for matching files.
 */
class XoopsFormSelectFolder extends XoopsFormSelectFile
{

/****************************************************************************
 *
 ****************************************************************************/
function getFolder ($folder,
                      $extention = '', 
                      $addblanck = true, 
                      $fullName = false,
                      $isKeyName = true,
                      $isFullNameFolder = true)
{

    if (!(substr($folder,-1) == '/')) $folder.='/';
    $lg = strlen($folder);    
    //echo "<hr>{$folder}<hr>";
    $folder = str_replace('//','/',$folder);
    $tf = array();
    if ($addblanck) $tf[] = ' ';

    //-------------------------------------------
    
    if ($extention == ''){
    
          //foreach (glob("{$folder}*.*", GLOB_ONLYDIR) as $filename) {
          $td = glob($folder.'*', GLOB_ONLYDIR);
          //displayArray($td,"----- getFolder -----"); 
          foreach ($td as $filename) {          
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            //if (is_dir($folder.$filename)) $f[] = $folder.$filename;       
  
            $key = substr($filename,$lg);            
            if ($fullName){
              $lib = $filename;            
            }else{
              $lib = $key;            
            }
              
            if ($isKeyName){
              $tf[$key] = $lib;            
            }else{
              $tf[] = $lib;            
            }
                         
          }
    
    }else{
      //construction du tableu des extention
    //if (!substr($extention,0,1) == "."){$extention = ".".$extention; }      
    $extention = strtolower($extention);      
    $extention = str_replace ('.','', $extention);
    $t = explode(';', $extention); 
    //-------------------------------------------------
 
      for ($h=0; $h < count($t); $h++){
          $patern = "{$folder}*.{$t[$h]}";  
          //echo "<hr>$extention<br>$patern<hr>";   
          foreach (glob($patern) as $filename) {
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            $tf[] = basename ($filename);          
          }
        
      }
    
    }

      
    //displayArray($f, '----fichiers-----'.$folder);
    return $tf;
}
///////////////////////////////////////////////
} // fin de la classe folder
///////////////////////////////////////////////


///////////////////////////////////////////////
//              classe folder
///////////////////////////////////////////////

/**
 * A selection box with options for matching files.
 */
class XoopsFormSelectFromTable extends XoopsFormSelect//XoopsFormSelect
{

    function __construct($caption, $name, $value = null, $size = 1)
    {
    if(!isset($value)) $value = -1;
        parent::__construct($caption, $name, $value, $size, false);
    }
/****************************************************************************
 *
 ****************************************************************************/
function setParams ( $table, 
                     $colName, 
                     $colId, 
                     $colOrder, 
                     $clauseWhere = '',
                     $onClick = '',
                     $callback = '',
                     $addNone = false,
                     $colDefaut='defaut')
{   
	Global $xoopsDB;
    //pour ajout d'une colonne defaut si elle n'existe pas
    $colDefaut=(($colDefaut == '') ?  "0" : $colDefaut);
    if ($clauseWhere!='') $clauseWhere = " WHERE " . $clauseWhere;
    
    $sql = "SELECT DISTINCT {$colId} AS id,{$colName} AS nom, {$colDefaut}  AS defaut FROM ".$xoopsDB->prefix($table)
           ." {$clauseWhere} ORDER BY {$colOrder}";
    $sqlquery=$xoopsDB->query($sql);
    
    $value = $this->getValue();
    if (is_array($value)) $value=$value[0];
//echo "table = {$table} | valeur = {$value}<br>"  ;
    $options = array();
    //echo "XoopsFormSelectFromTable : value={$value}<br>";
    
    
    
    if ($addNone){
      if (is_numeric($value)){
        $options[0] = chr(0);         
      }else{
        $options[''] = '';         
      }
    }    
    
    
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $id   = $sqlfetch['id'];
      $name = $sqlfetch['nom'];
      //$options[$sqlfetch['nom']] = $sqlfetch['id'];         
      $options[$sqlfetch['id']] = $sqlfetch['nom'];         
      
      if ($name === '') continue;
      $defaut = ((isset($sqlfetch['defaut'])) ? $sqlfetch['defaut'] : 0);
      if ($value<0 && $defaut>0){
        $value = $id;
        //$this::setValue($value);
        $this->_value=array();
        $this->setValue($value);
        //$this->_value[0]=$value;
        //echo "valeur par defaut ok={$value}<br>";
      }
    }    
    
    $this->addOptionArray($options);
//jecho($options);  
}

///////////////////////////////////////////////
} // fin de la classe folder
///////////////////////////////////////////////


///////////////////////////////////////////////
//              classe folder
///////////////////////////////////////////////

/**
 * A selection box with options for matching files.
 */
class XoopsFormSelect2 extends XoopsFormSelect
{

/**********************************************************************
 *
 **********************************************************************/
function addOptionTable ($table, 
                     $colName, 
                     $colId, 
                     $colOrder, 
                     $clauseWhere = '',
                     $onClick = '',
                     $callback = '',
                     $addNone = false)
{


	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
	
    if ($clauseWhere != ''){
	     $clauseWhere = "WHERE " . $clauseWhere;	
    }
    $sql = "SELECT DISTINCT {$colId},{$colName} FROM ".$xoopsDB->prefix($table)
           ." {$clauseWhere} ORDER BY {$colOrder}";
    $sqlquery=$xoopsDB->query($sql);
    $t = array();
    while ($row = $xoopsDB->fetchArray($rst)){
      $t[$colId] = $row[$colName];
    }
    
    

    //-----------------------------------------------
    $this->addOptionArray($t);
}



///////////////////////////////////////////////
} // fin de la classe XoopsFormSelect2
///////////////////////////////////////////////



?>
