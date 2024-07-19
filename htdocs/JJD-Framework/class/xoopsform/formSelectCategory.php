<?php
// formCategory.php,v 1
//  ---------------------------------------------------------------- //
// Author: JJDai                                         //
// ----------------------------------------------------------------- //
/**
 * select form element for Xoops categories
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @author 		Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @copyright Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @access 		public
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @version         1.00
 */


defined('XOOPS_ROOT_PATH') or die('Restricted access');
xoops_load('XoopsFormElement');
include_once (XOOPS_ROOT_PATH . "/class/xoopsform/formselect.php");


class XoopsFormCategory  extends XoopsFormSelect
{

    /**
     *  $_catName nom de la categorie xoops
     *
     * @var string
     * @access private
     */
    var $_catName = '';
    
/***
 *  constructeur
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $size Number or rows. "1" makes a drop-down-list
     * @param string $catName : nom de la categoris xoops
     * @param boolean $addNone : Ajoute une entre vide (id=0) en tete de liste       
 ***/ 
function __construct($caption, $name, $value = null, $size = 1, 
                     $catName ='', $addNone = false){
global $xoopsDB;

   XoopsFormCategory::__construct($caption,$name,$value,$size);
   //XoopsFormCategory::XoopsFormSelect($caption,$name,$value,$size);
   $this->_catName = $catName;
   $this->_isCat();
   
   
   $result = $this->_getList();
   
   $t = array();
   if ($addNone){
			$t[0] = _NONE;
   }
	 
   while ( $row = $xoopsDB->fetchArray($result) ) {
			$t[$row['image_id']] = $row['name'];
	 }
  $this->addOptionArray($t);
   
}

/***
 * rVerifie si la categorie existe sinon la creer
 ****/ 
function _isCat(){
global $xoopsDB;

  $sql = "SELECT count(tCat.imgcat_name) as nbEnr	 FROM " 
       . $xoopsDB->prefix("imagecategory") . ' tCat'
       . " WHERE  tCat.imgcat_name 	='{$this->_catName}'";
  //echo "<hr>{$sql}<hr>";
  
  $rst = $xoopsDB->query($sql);
  $t = $xoopsDB->fetchArray($rst);
  
  if ($t['nbEnr'] == 0){
    $sql = "INSERT INTO " . $xoopsDB->prefix("imagecategory")  
         . ' (imgcat_name,imgcat_maxsize,imgcat_maxwidth,imgcat_maxheight,imgcat_display,imgcat_weight,imgcat_type,imgcat_storetype)'
         . " VALUES ('{$this->_catName}','100000','250','250','1','0','C','file')";

    //echo "<hr>{$sql}<hr>";
    $xoopsDB->queryF($sql);  
  }

  return true;

}





/***
 *  renvoi un tableau des item de la categorie
 ***/
function _getArrayList(){
global $xoopsDB;

    $result = $this->_getList();
    $ret = array();
    
		while ( $row = $xoopsDB->fetchArray($result) ) {
			$ret[$row['image_id']] = $row;
		}
    
    return $ret;
}

/***
 *  permet de completer un tableau avec les options de la categorie liées (nom de la categorie nom de l'image, .. )
 ***/
function completeArray(&$externeArray, $keyCatIdName, $KeyList=''){
    
    if (!is_array($KeyList)) $KeyList = array('image_id', 'image_nicename'); 
    
    $tCat = $this->_getArrayList();
//      $t = print_r($tCat,true);
//     echo "<hr><pre>{$t}</pre><hr>";
//     $t = print_r($externeArray,true);
//     echo "<hr><pre>{$t}</pre><hr>";
    
    for ($h=0,$count=count($externeArray); $h<$count; $h++){
      $idCat = $externeArray[$h][$keyCatIdName]; 
      //echo "===> {$keyCatIdName} = {$idCat}<br>";
      if ($idCat != 0){
        for ($i=0; $i<count($KeyList);$i++){
          $externeArray[$h][$KeyList[$i]] = $tCat[$idCat][$KeyList[$i]];
        }
        //echo "<hr>{$externeArray[$keyCatName]}-{$tCat[$externeArray[$keyCatIdName]]}<br>";
      }else{
        for ($i=0; $i<count($KeyList);$i++){
          $externeArray[$h][$KeyList[$i]] = '';
        }
        //echo "<hr>{$externeArray[$keyCatName]}-{$tCat[$externeArray[$keyCatIdName]]}<br>";
      }
    }
//     $t = print_r($externeArray,true);
//     echo "<hr>{$keyCatIdName}<br><pre>{$t}</pre><hr>";
                                     
    return $externeArray;
}


/***
 * Renvoi le nombre de d'iteme dans la catégorie 
 ***/
function itemCount(){
  return count($this->_options);
}

/***
 *  Selection des enregistrement de la categorie
 ***/
function _getList(){
global $xoopsDB;

  $sql = "SELECT tImg.*, tImg.image_nicename AS name, tCat.imgcat_name 	 FROM " 
       . $xoopsDB->prefix("image") .' tImg, '
       . $xoopsDB->prefix("imagecategory") .' tCat'
       . ' WHERE  tImg.imgcat_id = tCat.imgcat_id '
       . "   AND  tCat.imgcat_name 	='{$this->_catName}'"
       . " ORDER BY tImg.image_nicename";
  //echo "<hr>{$sql}<hr>";
  
  $rst = $xoopsDB->query($sql);  

  return $rst;

}

/***
 *  count externes par categorie
 ***/
function _getListUsed($tblExterne, $fldIdCatExterne){
global $xoopsDB;

  $sql = "SELECT tm.{$fldIdCatExterne}, "
       . " if(isnull(ti.image_nicename), '', ti.image_nicename),"
       . "count(tm.{$fldIdCatExterne}) AS nbCat"
       . ' FROM '  .$xoopsDB->prefix($tblExterne) . ' tm'
       . ' left JOIN ' .$xoopsDB->prefix('image') . ' ti'
       . " ON tm.{$fldIdCatExterne}=ti.image_id" 
       . " group by tm.{$fldIdCatExterne}"
       . " having nbCat>0"; 

 /*
SELECT  tm.idCategorie, if(isnull(ti.image_nicename), '', ti.image_nicename), 
        count(tm.idCategorie) AS nbCat
FROM  `x250fra_walls_photowalls` tm left JOIN  `x250fra_image` ti 
ON tm.idCategorie=ti.image_id
group by tm.idCategorie
having nbCat>0
*/

   $result = $xoopsDB->query($sql);  
   while ( $row = $xoopsDB->fetchArray($result) ) {
			$t[$row[$fldIdCatExterne]] = $row['image_nicename'];
	 }

  //echo "<hr>{$sql}<hr>";
  

  return $rst;

}

 

}

/* ///////////////////////////////////////////////////////////////// */

class XoopsFormCategoryUsed  extends  XoopsFormCategory
{
/***
 *  constructeur
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $size Number or rows. "1" makes a drop-down-list
     * @param string $catName : nom de la categoris xoops
     * @param boolean $addNone : Ajoute une entre vide (id=0) en tete de liste       
 ***/ 
function __construct($caption, $name, $value, $size, 
                     $catName , $tblExterne, $fldIdCatExterne,
                     $addNone = false){
global $xoopsDB;

   //XoopsFormCategory::__construct($caption,$name,$value,$size);
   XoopsFormCategory::XoopsFormSelect($caption,$name,$value,$size);
   $this->_catName = $catName;
   $this->_isCat();
   
   
   $result = $this->_getList($tblExterne,$fldIdCatExterne);
   
   $t = array();
   if ($addNone){
			$t[0] = ' ';
   }
	 
   while ( $row = $xoopsDB->fetchArray($result) ) {
			$t[$row[$fldIdCatExterne]] = $row['name'];
	 }
   asort($t);

  $this->addOptionArray($t);
   
}

/***
 *  count externes par categorie
 ***/
function _getListUsed($tblExterne, $fldIdCatExterne){
global $xoopsDB;
    
    $none = _NONE;
    
  $sql = "SELECT tm.{$fldIdCatExterne}, "
       . " if(isnull(ti.image_nicename), '{$none}', ti.image_nicename) AS name,"
       . " count(tm.{$fldIdCatExterne}) AS nbCat"
       . ' FROM '  .$xoopsDB->prefix($tblExterne) . ' tm'
       . ' left JOIN ' .$xoopsDB->prefix('image') . ' ti'
       . " ON tm.{$fldIdCatExterne}=ti.image_id" 
       . " group by tm.{$fldIdCatExterne}"
       . " having nbCat>0"; 

 /*  exemple
SELECT  tm.idCategorie, if(isnull(ti.image_nicename), '', ti.image_nicename), 
        count(tm.idCategorie) AS nbCat
FROM  `x250fra_walls_photowalls` tm left JOIN  `x250fra_image` ti 
ON tm.idCategorie=ti.image_id
group by tm.idCategorie
having nbCat>0
*/

  $result = $xoopsDB->query($sql);  
  //echo "<hr>{$sql}<hr>";

  return $result ;

}

}
?>