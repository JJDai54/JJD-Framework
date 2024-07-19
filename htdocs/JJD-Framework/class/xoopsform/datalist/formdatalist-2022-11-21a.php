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
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');


/**
 * A simple text field
 */
class XoopsFormDataList extends XoopsFormElement
{
  var $version = '1.04';
  var $path = '';
  var $url = '';
  var $_dataListOk = '';
  var $_maxValues = 0;
 
    function __construct($name, $options = null)
    {  
      //$this->setHidden();  

      $this->path = str_replace('\\', '/', dirname(__file__));
      $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
// echo "XOOPS_ROOT_PATH ->" . XOOPS_ROOT_PATH . "<br>";
// echo "XOOPS_URL       ->" . XOOPS_URL . "<br><br>";
// 
// echo "JJD_PATH ->" . JJD_PATH . "<br>";
// echo "JJD_URL  ->" . JJD_URL . "<br><br>";
//       
// echo "path ->" . $this->path . "<br>";
// echo "url  ->" . $this->url . "<br>";
     
        $this->setCaption('');     //$caption
        $this->setName($name);
        if (!is_null($options)) $this->addOptionArray($options);
        $this->_dataListOk = false;
        //$this->setHidden();
    }

/**********************************************************************
 *
 **********************************************************************/
     /**
     * Add an option
     *
     * @param string $value "value" attribute
     * @param string $name  "name" attribute
     */
    function addOption($value, $name = '')
    {
        if ($name != '') {
            $this->_options[$value] = $name;
        } else {
            $this->_options[$value] = $value;
        }
    }

    /**
     * Add multiple options
     *
     * @param array $options Associative array of value->name pairs
     */
    function addOptionArray($options)
    {
        if (is_array($options)) {
            foreach ($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }
    /**
     * Get an array with all the options
     *
     * Note: both name and value should be sanitized. However for backward compatibility, only value is sanitized for now.
     *
     * @param bool|int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     *
     * @return array Associative array of value->name pairs
     */
    function getOptions($encode = false)
    {
        if (! $encode) {
            return $this->_options;
        }
        $values = array();
        foreach ($this->_options as $val => $name) {
            $values[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }

        return $values;
    }

/**********************************************************************
 *
 **********************************************************************/
function addOptionsFromTable($table, $libFields, $idField='', $filter='', $groupeField = '', $addNone=true){
  global $xoopsDB;
    
    $aliasExp = 'expConcat';

    if ($libFields == '' ) $libField = 'nom';
    if (strpos($libFields, ',')===false) {
      $libCols = $libFields;
        
    }else{
      $libCols = "concat(" . str_replace(',', ", ' ',", $libFields) . ")"; 
    }
    
    if ($idField  == '' )  $idField = $libField;
    $col= "{$idField}, {$libCols} as {$aliasExp}" . (($groupeField != '') ? ','.$groupeField: '');  
    $sorted =  (($groupeField != '') ? ','.$groupeField : '') . $libFields;
    $sql = "SELECT {$col} FROM ".$xoopsDB->prefix($table)
         . " WHERE {$libCols} <> '' "
         . " AND {$libCols} <> ' '" 
         . (($filter !='') ? " AND {$filter}" : '') 
         . " ORDER BY {$sorted}";
    
//echo $sql .  "<br>";    
    $rst = $xoopsDB->query($sql);
    $t = array();
    if($addNone && $this->_maxValues==1){     //
      $t[''] = 0;
    }
    while ($row = $xoopsDB->fetchArray($rst)){
      $t[$row[$idField]] = $row[$aliasExp];
    }
    $this->addOptionArray($t);
}

    
/************************************************************
 *
 ************************************************************/     
function render(){
global $xoTheme;
  
  
//-----------------------------------
     $xoTheme->addScript($this->url . '/datalist/datalist.js');
//-------------------------------------  
  
                              
    $tHtml = array();
/*exemple de code
<datalist id="bieres">
  <option value="Meteor" idList="1">
  <option value="Pils" idList="2">
  <option value="Kronenbourg" idList="3">
  <option value="Grimbergen" idList="4">
</datalist>
*/    
    //$name = $this->getVar('name');
    //$name = $this->getName();
    //$tHtml[] = "\n<datalist name='{$name}' id='{$name}'>\n";    
    $typeList = 1; //0 = associative (liste de cle) | 1 = index (liste d'id))
    $ele_options = $this->getOptions();
    //echo "--->datalist : ".count($ele_options)."<hr>";
    foreach($ele_options as $value => $name) {
      //$tHtml[] = "<option value='{$name}' idList='{$value}'>\n";   
      $tHtml[] = "<option value='{$value}'>{$name}</option>\n";   
      if (!is_numeric($value)) $typeList = 0;
      //echo "--->{$name} -> {$value} / " .  count($ele_options) . "<br />";
    }
    
    $name = $this->getName();
    $balise = "\n<datalist name='{$name}' id='{$name}' typeList='{$typeList}' >\n";
    array_unshift($tHtml, $balise);
    $tHtml[] = "</datalist>\n";

  
  return implode('', $tHtml);

} //ff


function newXoopsFormInputDataList($caption, $name, $value = null, $size = 50){
  
  $lib = (!is_null($value) && isset($this->_options[$value] ))  ? $this->_options[$value] : '' ;
  
  $idl = new XoopsFormInputDataList($caption, $name, null, $value, $lib, $size);
  $idl->setVar('dataListName', $this->getName());
//jecho($this->_options);  
  if (!$this->_dataListOk) {
    $idl->setVar('dataList', $this->render());
    $this->_dataListOk = true;
//  jecho($this->_options);
  }
//jecho($name . '->' . $value);  
  return $idl;
}



}// fdc --------------------------------------------------------


class XoopsFormInputDataList extends XoopsFormElement
{

  var $path = '';
  var $url = '';
  
  
  var $_vars = array();
//   var $_dataList='';
//   var $_value = '';  
//   var $_name = ''
//   var $_size = ''
  
    function __construct($caption, $name, $dataList, $value = null, $lib='', $size = 50)
    {
      $this->path = str_replace('\\', '/', dirname(__file__));
      $this->url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $this->path);
      
      $this->setCaption($caption);

      $this->setVar('name',$name);
      $this->setVar('dataList',$dataList);
      $this->setVar('value',$value);
      $this->setVar('size',$size);
      $this->setVar('dataList', '');
      $this->setVar('dataListName', $dataList);
      $this->setVar('lib', $lib);
      
//       $this->_dataList = $dataList;
//       
//       
//         $this->setCaption($caption);
//         $this->setName($name);
//         $this->_size = intval($size);
//         if (isset($value)) {
//             $this->setValue($value);
//         }


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

/************************************************************
 *
 ************************************************************/     
function render(){
global $xoTheme;
      $name = $this->getVar('name');
      $dataList = $this->getVar('dataList');
      $value = $this->getVar('value');
      $size = $this->getVar('size');
  
//     $name = $this->getVar();
//     $value = $this->getValue();
  
    $tHtml = array();
    $tHtml[] = $this->getVar('dataList');
    $dataListName = $this->getVar('dataListName');
    $lib = $this->getVar('lib');
    
    $tHtml[] = "\n";
    //$tHtml[] = "<input list='{$dataListName}' type='text' name='__{$name}' id='__{$name}' value='{$lib}' onblur='getIdListInDataList(this);'>\n";
    
    //$tHtml[] = "<input list='{$dataListName}' type='text' name='__{$name}' id='__{$name}' value='{$lib}' onblur='getIdListInDataList(this);'>\n";
    //$tHtml[] = "<input type='hidden' name='{$name}' id='{$name}' value='{$value}' />\n";
    
    $tHtml[] = "<input list='{$dataListName}' type='text' name='{$name}' id='{$name}' value='{$value}' onblur='getIdListInDataList(this);'>\n";
    



  
  return implode('', $tHtml);

} //ff







}

?>
