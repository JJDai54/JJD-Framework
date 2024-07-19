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
 * @version         $Id: formtext.php 4941 2010-07-22 17:13:36Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

// /**
//  * A list of chextbox that generate a bin value
//  */
class XoopsFormBinCheckbox extends xoopsFormCheckboxBin
{  }

class xoopsFormCheckboxBin extends XoopsFormElement
{
    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    var $_value = 0 ;
    
    
    /**
     * options
     *
     * @var string
     * @access private
     */
    var $_options;
    
    /**
     * options
     *
     * @var string
     * @access private
     */
    var $_showCaptions;
    /**
     * separator  if $options is string
     *
     * @var string
     * @access private
     */
    //var $_optionsSeparator;

    /**
     * cols nombre de colonnes
     *
     * @var int
     * @access private
     */
    var $_cols;
    
    /**
     * cols nombre de colonnes
     *
     * @var int
     * @access private
     */
    var $_allowCheckAll;
    
    /**
     * style nombre de colonnes
     *
     * @var int
     * @access private
     */
    var $_style = '';
    var $_width = 0;
    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $options tiles of each checkbox
     * @param string $value Initial text
     * @param int $cols nb columns (nb rows = count($options)/$cols
     */
    
    var $path = '';
    var $url = '';
    var $className = 'checkboxbin';

    function __construct($caption, $name, $value = 0, 
                         $cols = 1, $allowCheckAll = false,
                         $optionsSeparator = ";")
    {
        $this->className = basename(dirname(__FILE__));

      $this->path = str_replace('\\','/',dirname(__FILE__)) . '/' . $this->className;
//       $this->url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $this->path);

      $this->url = JJD_XFORM_URL .  '/' . 'checkboxbin';
 
// echo "<hr>" . XOOPS_ROOT_PATH . "<br>" 
//             . JJD_PATH . "<br>" 
//             . JJD_URL . "<br>" 
//             . $this->path . "<br>" 
//             . $this->url . '/checkboxbin.js' . "<hr>";  
        $this->setCaption($caption);
        $this->setName($name);
        
        
        $this->setValue($value);
        $this->setCols(intval($cols));
        $this->setAllowCheckAll($allowCheckAll);
        $this->setShowCaptions(true);
        
    }
    
    /**
     * Get size
     *
     * @return int
     */
    function getOptions()
    {
        return $this->_itemsOptions;
    }
    function setOptions($options, $optionsSeparator=";")
    {
        if (is_array($options)){
          $this->_options = $options;
        }else{
          $this->_options = explode($optionsSeparator, $options);
        }
    }
    
    /**
     * Get maximum text length
     *
     * @return int
     */
    function getCols()
    {
        return $this->_cols;
    }
    function setCols($cols)
    {
        $this->_cols = $cols;
    }
    
    /**
     * Get $_style text length
     *
     * @return int
     */
    function getStyle()
    {
        return $this->_style;
    }
    function setStyle($style)
    {
        $this->_style = $style;
    }
    
    /**
     * Get $_width text length
     *
     * @return int
     */
    function getWidth()
    {
        return $this->_width;
    }
    function setWidth($width)
    {
        $this->_width = $width;
    }
    
    /**
     * Get allowCheckAll text length
     *
     * @return int
     */
    function getAllowCheckAll()
    {
        return $this->_allowCheckAll;
    }
    function setAllowCheckAll($allowCheckAll)
    {
        $this->_allowCheckAll = $allowCheckAll;
    }
    /**
     * Get $_showOptions text length
     *
     * @return int
     */
    function getShowCaptions()
    {
        return $this->_showCaptions;
    }
    function setShowCaptions($showCaptions)
    {
        $this->_showCaptions = $showCaptions;
    }
    /**
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getValue()
    {
        return $this->_value;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setValue($value)
    {
        $this->_value = intval($value);
    }
    
    
    /**
     *    
     */
  function isBitOk($bit, $val){
    $b = pow(2, $bit);
    $v = (($val &  $b) <> 0 ) ? 1 : 0 ;
    return $v;
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
     *  ajout d'option simple
     *  les valeur binaire sont fonction de l'index     
     *
     * @param array $options Associative array of value->name pairs
     */
    function setOptionsCaptions($options)
    {
      $this->_options = array();
      foreach($options as $key=>$value){
        $b = pow(2, $key-1);
        $this->_options[$b] = $value;
      }
    }
    /**
     *  
     *
     * @param array $options Associative array of value->name pairs
     */
    function setOptionsArray($options)
    {
      $this->_options = $options;
    }

  /**********************************************************************
   *
   **********************************************************************/
  function addOptionTable($table, $libField, $idField='', $actifField='', $groupeField = '', $sorted=''){
    global $xoopsDB;
      
         
        $orderBy = 
        $sql = "SELECT * FROM " . $xoopsDB->prefix($table)
             . " WHERE {$libField} <> ''"
             . (($actifField <> "") ?  " AND {$actifField} = true" : "")
             . " ORDER BY " . (($groupeField != '') ? $groupeField.',' : '') 
                            . (($sorted != '') ?  $sorted.',' : '') 
                            . "{$libField}";  
        $rst = $xoopsDB->query($sql);
        $options = array();
        
        while ($row = $xoopsDB->fetchArray($rst)){
          $options[$row[$idField]] = $row[$libField];
        } 
  
      $this->setOptionsArray($options);
  }
   
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      $prefixChk = 'chk_';
      global $xoTheme;
      //$xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation/notation.css");
      //$xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation.css");
      $xoTheme->addScript($this->url . '/js/' . $this->className . '.js');

        if ($this->_cols < 0){
          $row = 1;
          $cols = count($this->_options);
          
        }else{
          $cols = $this->_cols;
          $row = ceil(count($this->_options) / $this->_cols);
        }
        $name = $this->getName();
        $value = $this->getValue('value');
        //$cols  = $this->_cols;
        $style = (($this->_style != '') ?  "style='{$this->_style}'" : '');
        //--------------------------------------------------------------
        $groupeName = "all";
        
        $tHtml = array();
        $tHtml[] = "<INPUT TYPE='hidden' name='{$name}' id='{$name}' VALUE='{$value}'>";        
        
        $styleTable = (($this->_width == 0 ) ? '' : "style='width:{$this->_width}px'");
        $tHtml[] = "<table border='0px' {$styleTable}>";


        
        $tHtml[] = "<tr>";
        
        if ($this->getAllowCheckAll()){
          $oc = "onclick='updateGroupeChkBin(\"{$name}\",\"{$prefixChk}\",\"{$groupeName}\")'";
          //$line =  '<td '.$style.'><input type="checkbox" name="'.$prefixChk.$name.'[all]" id="'.$prefixChk.$name.'[all]" '.$oc.'>&nbsp;(*)</td>';
          $line =  "<td {$style}><input type='checkbox' name='{$prefixChk}{$name}[{$groupeName}]' id='{$prefixChk}{$name}[{$groupeName}]' {$oc}>(*){$groupeName}</td>";

          $tHtml[] = "<tr>{$line}</tr>";
        }
        
        
        $oc = "onclick='updateChkBin(\"{$name}\",\"{$prefixChk}\")'";
        $td1 =  '<td '.$style.'>';
        $td2 =  '</td>';
        $line = '<input type="checkbox" name="'.$prefixChk.$name.'[items]"'
              . ' id="'.$prefixChk.$name.'[items][%1$s]" %2$s '
              . $oc . ' binFlag="%4$s" groupName="%5$s">&nbsp;%3$s';
        
        
        //$line =  "<input type='checkbox' name='{$prefixe}[{$v}][value]' {$oc} {$value}>&nbsp;{$item[$keyLib]}";
        
        $hCol=0;
        $nbRows = ceil(count($this->_options) / $cols);
//echo "nbRows = {$nbRows} | $cols = {$cols} | nbOptions = " . count($this->_options);        
        
        //$tHtml[] ='<tr>' .  $td1;        
        $tHtml[] = $td1;        
        $h = 0;
        foreach($this->_options as $k => $caption) {
          $h++;
          if ($h > $nbRows){
            $tHtml[] = $td2.$td1;   
            $h = 1;     
          }
          
// echo "{$k} - {$value} = "   . $this->isBitOk($k, $value) . " <br>";      
// echo "{$k} - {$value} = "   .  ((($k & $value)!=0) ? 1 : 0) . " <br>";      
          //$v = $this->isBitOk($k, $value);
          $v = (((pow(2, $k) & $value)!=0) ? 1 : 0);
          $checked = (($v == 1)) ? 'checked' : 0;
          if (!$this->_showCaptions) $caption = "";
          $tHtml[] = sprintf($line, $k, $checked, $caption, $k, $groupeName);
          if ($h < $nbRows) $tHtml[] = '<br />';
        }
        //$tHtml[] = $td2 . '</tr>';        
        $tHtml[] = $td2;

        $tHtml[] = "</tr>";
        $tHtml[] = "</table>";

        //-----------------------------------------
        $html = "\n" . implode("\n", $tHtml) . "\n";
        return $html;
        //return "<input type='text' name='" . $this->getName() . "' title='" . $this->getTitle() . "' id='" . $this->getName() . "' size='" . $this->getSize() . "' maxlength='" . $this->getMaxlength() . "' value='" . $this->getValue() . "'" . $this->getExtra() . " />";
    }



// -----------------------------------------------------
} // ----- fin de la classe
// -----------------------------------------------------

class XoopsFormBinCheckboxGroup extends  XoopsFormBinCheckbox{
    /**
     * options
     *
     * @var string
     * @access private
     */

    var $_groupes = array();

    /**
     *  
     *
     * @param array $options Associative array of value->name pairs
     */

    function setGroupesArray($groupes)
    {
      $this->_groupes = $groupes;
    }
  /**********************************************************************
   *
   **********************************************************************/
  function addOptionTable($table, $libField, $idField='', $actifField='', $groupeField = '', $orderField=''){
    global $xoopsDB;
      
        global $xoopsDB;
      
        $sql = "SELECT * FROM " . $xoopsDB->prefix($table)
             . " WHERE {$libField} <> ''"
             . (($actifField <> "") ?  " AND {$actifField} = true" : "")
             . " ORDER BY " . (($groupeField!='') ? $groupeField.',' : '') 
                            . (($orderField!='') ? $orderField.',' : '') 
                            . "{$libField}";  
        $rst = $xoopsDB->query($sql);
        $options = array();
        $groupes = array();
                
        while ($row = $xoopsDB->fetchArray($rst)){
          $options[$row[$idField]] = $row[$libField];
          $groupes[$row[$groupeField]][] = $row[$idField];
        } 
  
      $this->setOptionsArray($options);
      $this->setGroupesArray($groupes);
  }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      $prefixChk = 'chk_';
      global $xoTheme;
      //$xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation/notation.css");
      //$xoTheme->addStylesheet(XOOPS_URL . "/class/xoopsform/notation/notation.css");
      $xoTheme->addScript($this->url . '/checkboxbin.js');
      
        if ($this->_cols < 0){
          $row = 1;
          $cols = count($this->_options);
          
        }else{
          $cols = $this->_cols;
          $row = ceil(count($this->_options) / $this->_cols);
        }
        $name = $this->getName();
        $value = $this->getValue('value');
        //$cols  = $this->_cols;
        $style = (($this->_style != '') ?  "style='{$this->_style}'" : '');
        $oc = "onclick='updateChkBin(\"{$name}\",\"{$prefixChk}\")'";
        //--------------------------------------------------------------
        
        $tHtml = array();
        $tHtml[] = "<INPUT TYPE='hidden' name='{$name}' id='{$name}' VALUE='{$value}'>";        

        $styleTable = (($this->_width == 0 ) ? '' : "style='width:{$this->_width}px'");
        $tHtml[] = "<table border='0px' {$styleTable}>";
        $tHtml[] = "<tr>";
        /****************************************************************/
        $line = '<input type="checkbox" name="'.$prefixChk.$name.'[items]"'
              . ' id="'.$prefixChk.$name.'[items][%1$s]" %2$s '
              . $oc . ' binFlag="%4$s" groupName="%5$s">&nbsp;%3$s';
              
        foreach($this->_groupes AS $groupeName=>$groupe){
          $tHtml[] = '<td '.$style.'>';
          $tCol = array();
          //$tHtml[] = $kg . '<br />';
          if ($this->getAllowCheckAll()){
            $oc = "onclick='updateGroupeChkBin(\"{$name}\",\"{$prefixChk}\",\"{$groupeName}\")'";
            //$line =  '<td '.$style.'"><input type="checkbox" name="'.$prefixChk.$name.'[all]" id="'.$prefixChk.$name.'[all]" '.$oc.'>&nbsp;(*)</td>';
            $tHtml[] =  "<input type='checkbox' name='{$prefixChk}{$name}[{$groupeName}]' id='{$prefixChk}{$name}[{$groupeName}]' {$oc}>(*){$groupeName}<br />";
           
          }
          foreach($groupe AS $k){
            $caption = $this->_options[$k];
                      
            $v = ((($k & $value)!=0) ? 1 : 0);
            $checked = (($v == 1)) ? 'checked' : 0;
            if (!$this->_showCaptions) $caption = "";
            $tCol[] = sprintf($line, $k, $checked, $caption, $k, $groupeName);
            //if ($h < $nbRows) $tHtml[] = '<br />';
          }
          $tHtml[] = implode('<br />', $tCol);
          $tHtml[] = "</td>";
        }
        /****************************************************************/
        
        
        
        

        $tHtml[] = "</tr>";
        $tHtml[] = "</table>";

        //-----------------------------------------
        $html = "\n" . implode("\n", $tHtml) . "\n";
        return $html;
        //return "<input type='text' name='" . $this->getName() . "' title='" . $this->getTitle() . "' id='" . $this->getName() . "' size='" . $this->getSize() . "' maxlength='" . $this->getMaxlength() . "' value='" . $this->getValue() . "'" . $this->getExtra() . " />";
    }


// -----------------------------------------------------
} // ----- fin de la classe
// -----------------------------------------------------
  /**************************************************************
   *  
   **************************************************************/  
class XoopsFormBinCheckboxMultiple extends XoopsFormElement
{
  //var $_libelles = array();
  //var $_names = array();
  var $_values = array();
  var $_captions = array();
  var $_allowCheckAll = false;
  var $_captionsSeparator = ";";
  
  /**************************************************************
   *  
   **************************************************************/  
    function __construct($caption, $values, $captions, 
                         $allowCheckAll = false,
                         $captionsSeparator = ";")
    {
      //$this->_libelles = $libelles;
      //$this->_names = $names;
      $this->_values = $values;
      $this->_captions = $captions;
      $this->_allowCheckAll = $allowCheckAll;
      $this->_captionsSeparator = $captionsSeparator;
    }
    
  /**************************************************************
   *  
   **************************************************************/  
   function render(){
      $tHtml = array();
      $tHtml[] = "<table border='0px'>";
      //-----------------------------------------
      $captions = $this->_captions;
//echoArray($captions);      
      //-----------------------------------------
      //affichage des titres de colonne
      reset($this->_values);
      $tHtml[] = "<tr>";
      //$tHtml[] = "<td align='center'></td>";
      foreach($this->_values as $k => $v) {
        $tHtml[] = "<td align='center'>{$v['libelle']}</td>";
      }
      $tHtml[] = "</tr>";
      
      //-----------------------------------------
      //affichage des checkbox
      $h = 0;
      reset($this->_values);
      $tHtml[] = "<tr>";
      //$tHtml[] = "<td align='center'>".implode("<br />", $captions)."</td>";
      foreach($this->_values as $k => $v) {
//echoArray($v, $k);  
        $tHtml[] = "<td align='center'>";
        
        $chkBin = new XoopsFormBinCheckbox('', $k, $v['value'], 1, $this->_allowCheckAll,$this->_captionsSeparator) ; 
        $chkBin->setOptionsCaptions($captions);
        if ($h>0){
          $chkBin->setShowCaptions(false);
          $chkBin->setStyle("vertical-align: top; text-align: center;");
        }
        
        $tHtml[] = $chkBin->render();

        $tHtml[] = "</td>";
        $h++;
      }
      //-----------------------------------------
      $tHtml[] = "</tr>";
      $tHtml[] = "</table>";
      $html = "\n" . implode("\n", $tHtml) . "\n";
      return $html;
   }
      
  /**************************************************************
   *  
   **************************************************************/  
   function render2(){
      $tHtml = array();
      $tHtml[] = "<table border='0px'>";
      //-----------------------------------------
      $captions = $this->_captions;
//echoArray($captions);      
      //-----------------------------------------
      //affichage des titres de colonne
      reset($this->_values);
      $tHtml[] = "<tr>";
      $tHtml[] = "<td align='center'></td>";
      foreach($this->_values as $k => $v) {
        $tHtml[] = "<td align='center'>{$v['libelle']}</td>";
      }
      $tHtml[] = "</tr>";
      
      //-----------------------------------------
      //affichage des checkbox
      $h = 0;
      reset($this->_values);
      $tHtml[] = "<tr>";
      $tHtml[] = "<td align='center'>".implode("<br />", $captions)."</td>";
      foreach($this->_values as $k => $v) {
//echoArray($v, $k);  
        $tHtml[] = "<td align='center'>";
        
        $chkBin = new XoopsFormBinCheckbox('', $name, $captions, $v['value'], 1, false) ; 
        $chkBin->setShowCaptions(false);
        $tHtml[] = $chkBin->render();

        $tHtml[] = "</td>";
        $h++;
      }
      //-----------------------------------------
      $tHtml[] = "</tr>";
      $tHtml[] = "</table>";
      $html = "\n" . implode("\n", $tHtml) . "\n";
      return $html;
   }

// -----------------------------------------------------
} // ----- fin de la classe
// -----------------------------------------------------


?>
