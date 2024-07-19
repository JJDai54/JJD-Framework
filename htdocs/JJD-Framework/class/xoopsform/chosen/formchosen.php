<?php
/**
 * XoopsDoubleList element  -  choosen list
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
 * @version         v 1.2
 */
 
defined('XOOPS_ROOT_PATH') or die('Restricted access');
xoops_load('XoopsFormElement');





/*----------------------------------------------------------*/


class XoopsFormChosen extends XoopsFormElement
{
    /**
     * Options
     *
     * @var array
     * @access private
     */
    var $_options = array();

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    var $_width;

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    var $_maxValues;
    
    /**
     * Pre-selcted values
     *
     * @var array
     * @access private
     */
    var $_value = array();

    var $_data_placeholder = 'Choose ...';
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $width Number or rows. "1" makes a drop-down-list
     * @param bool $multiple Allow multiple selections?
     */
  var $path = '';
  var $url = '';
  var $allowClear = true;
  var $dataList = '';  
/*************************************************************************
 *
 *************************************************************************/ 
function __construct($caption, $name, $value = null, $width=300, $maxValues=0, $allowClear=true)
{
      $this->path = str_replace('\\', '/', dirname(__file__));
      $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
      
                 
      
       $this->setCaption($caption);    
        $this->setName($name);
        $this->_width = intval($width);
        if (isset($value)) {
            if (is_array($value)){
              $this->setValue($value);
            }else{
              $this->setValue(explode(',', $value));
            }
        }
       $this->setMaxValues($maxValues);    
       $this->setAllowClear($allowClear);
    }


    /**
     * Get the width
     *
     * @return int
     */
    function getWidth()
    {
        return $this->_width;
    }
    /**
     * Set width
     *
     * @param  $value mixed
     */
    function setWidth($width)
    {
        $this->_width = $width;
    }

    /**
     * Get the dataList
     *
     * @return string
     */
    function getDataList()
    {
        return $this->dataList;
    }
    /**
     * Set dataList
     *
     * @param  $value string
     */
    function setDataList($value)
    {
        $this->dataList = $value;
    }

    /**
     * Get the maxValues
     *
     * @return int
     */
    function getMaxValues()
    {
        return $this->_maxValues;
    }
    /**
     * Set maxValues
     *
     * @param  $value int
     */
    function setMaxValues($maxValues)
    {
        $this->_maxValues = $maxValues;
    }





    /**
     * Get an array of pre-selected values
     *
     * @param bool $encode To sanitizer the text?
     * @return array
     */
    function getValue($encode = false)
    {
        if (! $encode) {
            return $this->_value;
        }
        $value = array();
        foreach($this->_value as $val) {
            $value[] = $val ? htmlspecialchars($val, ENT_QUOTES) : $val;
        }
        return $value;
    }

    /**
     * Set pre-selected values
     *
     * @param  $value mixed
     */
    function setValue($value)
    {
        if (is_array($value)) {
            foreach($value as $v) {
                $this->_value[] = $v;
            }
        } elseif (isset($value)) {
            $this->_value[] = $value;
        }
    }

    /**
     * Get AllowClear
     *
     * @param bool $AllowClear 
     * @return bool
     */
    function getAllowClear($allowClear)
    {
        return $this->AllowClear;
    }
    
    /**
     * Set AllowClear value
     *
     * @param  $allowClear bool
     */
    function setAllowClear($allowClear)
    {
        $this->allowClear = $allowClear;  
    }


    /**
     * Add an option
     *
     * @param string $value "value" attribute
     * @param string $name "name" attribute
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
            foreach($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }

    /**
     * Get an array with all the options
     *
     * Note: both name and value should be sanitized. However for backward compatibility, only value is sanitized for now.
     *
     * @param int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     * @return array Associative array of value->name pairs
     */
    function getOptions($encode = false)
    {
        if (! $encode) {
            return $this->_options;
        }
        $value = array();
        foreach($this->_options as $val => $name) {
            $value[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }
        return $value;
    }



/*************************************************************************
 *
 *************************************************************************/ 
function render(){
global $xoTheme;

//-----------------------------------
     $xoTheme->addScript($this->url . "/chosen/chosen.jquery.js");
     $xoTheme->addScript($this->url . "/formchosen.js");
//-------------------------------------  
    $buttonWidth =($this->allowClear) ? 30: 0;
    $inputWidth = $this->_width - $buttonWidth;
    $containerWidth = $this->_width + $buttonWidth;
    
    $name = $this->getName();
    $id=   str_replace(array('[',']'), array('_','_'), $name);
    $class = $id;
   
    $keysSelecd = array_flip($this->getValue());    
    // echoarray($keysSelecd,'>>>>>');

      global $xoTheme;
      
      $xoTheme->addStylesheet($this->url . "/chosen/chosen.css");
      //$xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation.css");
      //$xoTheme->addScript("https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js");
   
    $tHhtml = array(); 
//     $tHtml[] = "<hr>zzzzzzzzzzzzzzzzzzzzzzzzzzz<hr>";

    //$containerName = "js_".$name;
    $containerName = str_replace("[","_" ,"js_".$name);
    $containerName = str_replace("]","_" ,$containerName);                                              
    
    $tHtml[] = "<div name='{$containerName}' id='{$containerName}' style='width:{$containerWidth}px;' width_default='{$inputWidth}px'>";   //    style='width:{$this->_width}px;'
//      $tHtml[] = "<hr>zzzzzzzzzzzzzzzzzzzzzzzzzzz<hr>";
// 
//       $tHtml[] = "<datalist id='dl-{$name}' zzzzz>";
//     foreach($this->_options as $key => $value){
//       $select = (isset($keysSelecd[$key])) ? 'selected="selected"': '';
//       $tHtml[] = "<option value='{$key}' {$select}>{$value}</option> ";
//     }
//       $tHtml[] = '</datalist>';

 /*
 list="bieres"   
 */
 //echo "=====>" . $this->_width . "<br>";  
    if($this->_maxValues == 1){
      $tHtml[] = "<select  type='jchosen' name='{$name}' id='{$id}' class='{$class}'  size='12' data-placeholder='{$this->_data_placeholder}' style='width:{$inputWidth}px;'>";
    }else{
      $tHtml[] = "<select  type='jchosen' name='{$name}[]' id='{$id}' class='{$class}'  size='12' data-placeholder='{$this->_data_placeholder}' multiple style='width:{$inputWidth}px;'>";
    }                               
    if ($this->dataList == ''){
      foreach($this->_options as $key => $value){
        $select = (isset($keysSelecd[$key])) ? 'selected="selected"': '';
        $tHtml[] = "<option value='{$key}' {$select}>{$value}</option> ";
      }
    }
    $tHtml[] = "</select>";
    
    if ($this->dataList != ''){
      $tHtml[] = "<script type='text/javascript'>";
      $tSelected=implode(',',$this->getValue());
      $tHtml[] = "dataList_loadItems('{$this->dataList}','{$id}',[{$tSelected}]);";
      $tHtml[] = "</script>";
    }
    
    
    if($this->allowClear){
      $tHtml[] = "<input value='...' type='button' onclick='chosen_clear_criteres(\"{$class}\")' style='width:{$buttonWidth}px;'>";
    }
    $tHtml[] = "</div>";
    
    
    if($this->_maxValues == 1){
      $tHtml[] = "<script type='text/javascript'> $('.{$class}').chosen(); $('.{$class}').chosen({allow_single_deselect:true}); </script>";    
    }else{
      $tHtml[] = "<script type='text/javascript'> $('.{$class}').chosen(); $('.{$class}').chosen({allow_single_deselect:true});</script>";   
    }                               
    

//     $tHtml[] = ""
//     $tHtml[] = ""
//     $tHtml[] = ""
/*
      <div>
        <em>Into This</em>        
        
          <option value=""></option> 
          <optgroup label="aaaaaaaaa">
            <option value="batracien">batracien</option> 
            <option value="animal">animal</option> 
          </optgroup>
          <optgroup label="bbbbb">
            <option value="félin">félin</option> 
            <option value="chat">chat</option> 
            <option value="objet">objet</option> 
            <option value="poisson">poisson</option> 
            <option value="pingouin">pingouin</option> 
            <option value="oiseau">oiseau</option> 
            <option value="oiseau">palourde</option> 
          </optgroup>
        </select>
      </div>
    
*/   

    //------------------------------------------------------
    $html = "\n" . implode("\n", $tHtml) . "\n";
    return $html;

}

    /**
     *  
     *
     * @param array $options Associative array of value->name pairs
     */
    function setOptionArray($options)
    {
      $this->_options = $options;
    }

/**********************************************************************
 *
 **********************************************************************/
function addOptionTable($table, $libFields, $idField='', $filter='', $groupeField = '', $addNone=true){
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
    $sql = "SELECT DISTINCT {$col} FROM ".$xoopsDB->prefix($table)
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
    //echo "<hr>";
    while ($row = $xoopsDB->fetchArray($rst)){
      //echo $row[$idField] . " / " . $row[$aliasExp] ."<br/>" ;
      $t[$row[$idField]] = $row[$aliasExp];
    }
    $this->addOptionArray($t);
}
    
    
    
} // ----- fin de la classe ------
















?>
