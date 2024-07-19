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
 * @since           5.5.0
 * @author          JJD http://xoops/jubile.fr, http://jp.xoops.org/
 * @version         $Id: formselectmatchoption.php 8066 2011-11-06 05:09:33Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormSelect');
/**
 * A selection box with options for matching files.
 */
class XoopsFormSelectSysTab extends XoopsFormSelect
{
/****************************************************************************
 *
 ****************************************************************************/
function addOptionFolder ($folder,
                      $extention = '', 
                      $addblanck = true, 
                      $fullName = false,
                      $isKeyName = true,
                      $isFullNameFolder = true)
{

     
    //displayArray($f, '----fichiers-----'.$folder);
//     $z=array("zzz"=>"zzzzzzzzzzzz","xxx"=>"xxxxxxxxxxxxxx","sss"=>"sssssssssss");
//     $this->addoptionarray($z) ;
    $tOpt = $this->getFolders($folder, $extention, $addblanck, $fullName, $isKeyName, $isFullNameFolder);
   // $tOpt = array_replace($this->getOptions(), $tOpt);
    $this->addoptionarray($tOpt) ;
}


/****************************************************************************
 *
 ****************************************************************************/
function addOptionTable ($table, 
                     $colName, 
                     $colId, 
                     $colOrder, 
                     $clauseWhere = '',
                     $addNone = false)
{
    $tOpt = $this->getOptionsTable($table,$colName,$colId,$colOrder,$clauseWhere,$addNone);
    $tOpt = array_replace($this->getOptions(), $tOpt);
    $this->addoptionarray($tOpt) ;
}

/****************************************************************************
 *
 ****************************************************************************/
function addOptionsFiles ($folder, 
                      $extention = '', 
                      $addblanck = true, 
                      $fullName = false,
                      $isKeyName = true,
                      $isFullNameFolder = true)
{
    $tOpt = $this->getFiles($folder,$extention,$addblanck,$fullName,$isKeyName,$isFullNameFolder);
    $tOpt = array_replace($this->getOptions(), $tOpt);
    $this->addOptionArray($tOpt) ;

}

//================================================================

/****************************************************************************
 *
 ****************************************************************************/
function getFolders ($folder,
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
    $tOpt = array();
    if ($addblanck) $tOpt[] = ' ';

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
              $tOpt[$key] = $lib;            
            }else{
              $tOpt[] = $lib;            
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
            $tOpt[] = basename ($filename);          
          }
        
      }
    
    }

    return $tOpt;  

}

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
/****************************************************************************
 *
 ****************************************************************************/
function getQuery ($table, 
                     $colName, 
                     $colId, 
                     $colOrder, 
                     $clauseWhere = '',
                     $addNone = false)




{
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
  
  $tOpt = array();
  
    if ($clauseWhere != ''){
	     $clauseWhere = "WHERE " . $clauseWhere;	
    }
    $sql = "SELECT DISTINCT {$colId},{$colName} FROM ".$xoopsDB->prefix($table)
           ." {$clauseWhere} ORDER BY {$colOrder}";
    $sqlquery=$xoopsDB->query($sql);
  
    if ($addNone){
      $v = ($colName==$colId) ? '': 0;
      $tOpt[0] = $v;
    }


    $h = 0;
    while ($sqlfetch=$xoopsDB->fetchArray($sqlquery)) {
      $id   = $sqlfetch[$colId];
      $name = $sqlfetch[$colName];
      $tOpt[$id] = $name;
    }  
    //---------------------------------------------------
    return $tOpt;

}




//-------------------------------------------------
}  //Fin de la classe
//-------------------------------------------------


?>
