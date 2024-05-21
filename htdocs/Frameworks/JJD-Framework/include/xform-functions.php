<?php
namespace JJD;
/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


/* ****
 *
 * *****/
 
 /**
 * @param \Xmf\Module\Helper $helper
 * @param array|null         $options
 * @return \XoopsFormDhtmlTextArea|\XoopsFormEditor
 */
function getAdminEditor($helper, $caption, $name, $value, $description = '')
{
    /** @var Creaquiz\Helper $helper */
    $editorConfigs = [];
    if ($isAdmin) {
    	$editor = $helper->getConfig('editor_admin');
    } else {
    	$editor = $helper->getConfig('editor_user');
    }
    $editorConfigs['name'] = $name;
    $editorConfigs['value'] = $value;
    $editorConfigs['rows'] = 5;
    $editorConfigs['cols'] = 40;
    $editorConfigs['width'] = '100%';
    $editorConfigs['height'] = '400px';
    $editorConfigs['editor'] = $editor;
    $editor = new \XoopsFormEditor($caption, $name, $editorConfigs);
    if ($description != '')
        $editor->setDescription($description);
        
    return $editor;
}

/* **********************************************************
*
* *********************************************************** */
function getformTextarea($caption, $name, $value, $description = "", $rows = 5, $cols = 30) {

      $editor = 'textarea';
      
      $editorConfigs = [];
      $editorConfigs['name'] = $name;
      $editorConfigs['value'] = $value;
      $editorConfigs['rows'] = $rows;
      $editorConfigs['cols'] = $cols;
      $editorConfigs['width'] = '80%';
      $editorConfigs['height'] = '400px';
      $editorConfigs['editor'] = $editor;
      $inpText = new \XoopsFormEditor($caption , $name, $editorConfigs);
      
      if ($description) $inpText->setDescription($description);
      return $inpText;     
}       
		 
		 
/**
 * @param $caption
 * @param $okName
 * @param $okValue
 * @param $dateName
 * @param $dateValue
 * @param $okCaption
 * @param $delimeter
 * @return \XoopsFormDateOk
 */
function xoopsformDateOkTray($caption, 
                             $okName, 
                             $okValue, 
                             $dateName, 
                             $dateValue, 
                             $okCaption = 'Ok', 
                             $delimeter = ' ')
{ 
    if (is_string($dateValue)) $dateValue = strtotime($dateValue);
    $trayDBE = new \XoopsFormElementTray  ($caption, $delimeter);
    
    // Form Check Box quizDateOk
    $inpOk = new \XoopsFormCheckBox('' , $okName, $okValue);        
    $inpOk->addOption(1, $okCaption);        
    $trayDBE->addElement($inpOk);
    
    // Form Text Date Select quizDateBegin
    $inpDate = new \XoopsFormDateTime('' , $dateName, '',  $dateValue);
    $trayDBE->addElement($inpDate);
    
    return $trayDBE;    
}

function xoopsformDateSimple($caption, 
                             $dateName, 
                             $dateValue)
{ 
    if (is_string($dateValue)) $dateValue = strtotime($dateValue);
    //$trayDBE = new \XoopsFormElementTray  ($caption, $delimeter);
    
    // Form Text Date Select quizDateBegin
    $inpDate = new \XoopsFormTextDateSelect($caption , $dateName, '',  $dateValue);

    
    return $inpDate;    
}

function getSelectFormTbl($caption, $name, $table, $fieldName, $fieldId, $defaut=-1, $addAll=false, $addNull=false){
global $xoopsDB;

       $tbl = $xoopsDB->prefix($table);
       $sql = "SELECT DISTINCT {$fieldName}, $fieldId  FROM  {$tbl} WHERE {$fieldName} <> '' ORDER BY {$fieldName} ASC";
       $rst = $xoopsDB->query($sql);



//////////////////////////////////////////////////////
        $inpList = new \XoopsFormSelect($caption, $name, $defaut);
        if ($addAll) $inpList->addOption(Constants::ALL, _AM_CARTOUCHES_SELECT_ALL);
        if ($addNull) $inpList->addOption('_NULL_', _AM_CARTOUCHES_NULL);

       while (false !== ($row = $xoopsDB->fetchArray($rst))) {
            $inpList->addOption($row[$fieldId],$row[$fieldName]);

       }
       
        return $inpList;
}

/* *******

****** */
function loadXFormArr($arr){
    if(!is_array($arr))  return false;  
    foreach($arr as $key=>$name){
        ///verifie si le xfoem est a la racine du dossier
        $f = JJD_PATH_XFORMS . "/form{$name}.php";
        
        //si il n'y est pas verifie si il est dans un sous dossier
        if (!file_exists($f)) $f = JJD_PATH_XFORMS . "/{$name}/form{$name}.php";

//echo "{$f}<hr>" ;       
        //il y a erreur sur lnom du xForm
        if (!file_exists($f)) return false;
        
        include_once($f);
    } 
    return true;
}

/* *******

****** */
function loadXForm($name){
    $name = strtolower($name);
    $f = JJD_PATH_XFORMS . "/{$name}/form{$name}.php";
    if (!file_exists($f))
      return include_once($f);
    else
      return false;
}

/* *******
* Charge les xforms du framework
* $namesString  string : liste des xform séparés par $sep
* $sep string : searateur des noms à charger
****** */
function loadXForms($namesString, $sep = ","){
    $arr = explode($sep, $namesString);
    
    for ($h=0; $h < count($arr); $h++){
        $name = strtolower($arr['$h']);
        $f = JJD_PATH_XFORMS . "/{$name}/form{$name}.php";
        if (file_exists($f)) include_once($f);
    }
}

/* ***********************

************************** */
function loadAllXForms(){
    xoops_load('XoopsFormLoader');      
       
    //chargement des xforms composés d'un dossier
    $arr = \XoopsLists::getDirListAsArray(JJD_PATH_XFORMS);
//    echoArray($arr);

    foreach ($arr as $key=>$fld){
        $f = JJD_PATH_XFORMS . "/" . $fld .  "/form" . $fld . ".php";
        if (file_exists($f)) include_once($f);
        //if (!file_exists($f)) echo "{$f}<br>";
        //echo "{$f}<br>";
    }
    
    //chargement des xforms formés d'un seul fichier
    $arr = \XoopsLists::getFileListAsArray(JJD_PATH_XFORMS);
    //echoArray($arr);
    foreach ($arr as $key=>$file){
        if ($file === "index.html") continue;
        $f = JJD_PATH_XFORMS . "/" . $file;
        if (file_exists($f)) include_once($f);
        //if (file_exists($f)) echo "{$f}<br>";
    }
}

?>