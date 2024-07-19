<?php
/**
 * XOOPS form checkbox compo
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * extension of class : FormCheckBox : add options checkAll
 *   
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @since           2.0
 * @author          Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @version         $Id: formcheckboxall.php 4941 2010-07-22 17:13:36Z beckmi $
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

class XoopsFormCheckboxAll extends XoopsFormCheckBox
{

    /**
     * Caption for otpion checkAll
     *
     * @var string
     * @access public
     */
    var $_checkboxAllCaption = 'All';

    /**
     * position for otpion checkAll
     *
     * @var int
     * @access public
     */
    var $_checkboxAllPos = 0;
    
    /**
     * value default (checked)
     *
     * @var bool
     * @access public
     */
    var $_checkboxAllChecked = '';

    /**
     * value default ('')
     *
     * @var string : couleur de la police pour l'option All
     * @access public
     */
    //var $_checkboxAllDefault = '';

    var $_checkboxAllColor = false;

    var $_checkboxAllId = '';
    var $_checkboxAllName = '';
     
     //constructeur : 
     //public function __construct($caption, $name, $value = null, $delimeter = '&nbsp;')  
       
    /**
     * Add an option to check all checkbox
     *
     * @param string $caption
     * @param string $pos (-1: in first, 0: none, 1:in last)
     * 
     * doit etre appeler juste après le nes, avant le addOptionArray et le addOption
     */
    function addOptionChecboxkAll($value, $name = '', $pos=-1, $checked=false, $color='')
    {
        $this->_checkboxAllPos = $pos;
        $this->_checkboxAllName = $name;    
        $this->_checkboxAllChecked = ($checked) ? 'checked' : '';    
        $this->_checkboxAllColor = $color;
        $this->_checkboxAllId = ($value) ? $value : $this->getName() . '_chkAll_' . rand(1,999999) ;
        return $this->_checkboxAllId;
                
    }           
    /**
     * Add an option to check all checkbox
     *
     * @param string $caption
     * @param string $pos (-1: in first, 0: none, 1:in last)
     * 
     *  ===== obsolete =====
     */
    function addOptionCheckAll($name = '', $pos=-1, $checked=false, $color='')
    {
 
        return $this->addOptionChecboxkAll(null, $name, $pos, $checked, $color);
    }
    
    function setColorCheckAll($color='')
    {
        $this->_checkboxAllColor = $color;    
    }
    
    /**
     * return optoin checkboxxAll
     *
     * private function     
     * @return string
     */
/*
*/      
    function getCheckAll($checkboxAllId)
    {
      $ele_id = substr($this->getName(),0,-2);
      $ele_options = $this->getOptions();

      $h = 0;
      reset($ele_options);
      foreach($ele_options as $value => $name) {
          $h++;
          $t[] = "'" . $ele_id . $h . "'";
      }
      $ids = implode(',', $t);
      
      $event = "onclick=\""
             . "var optionids = [{$ids}];"
             . "xoopsCheckAllElements(optionids, '{$checkboxAllId}');\" "; 
      return $event;
    }
    
    /**
     * prepare HTML for output
     *
     * @return string
     */
    function render()
    {
        if($this->_checkboxAllChecked == 'checked') $this->setValue(array_keys($this->getOptions()));
        $ret = parent::render();
        //return parent::render();
        //--- JJD
        if(count($this->getOptions()) > 1){
            $checkboxAllId = $this->_checkboxAllId;
            $event = $this->getcheckAll($checkboxAllId);
            $caption = ($this->_checkboxAllColor) ? "<span style='color:{$this->_checkboxAllColor};'>{$this->_checkboxAllName}</span>"  : $this->_checkboxAllName;
            $chkAll = "<input type='checkbox' name='{$checkboxAllId}' id='{$checkboxAllId}'{$this->_checkboxAllChecked}"
                    . " title='' value='1' {$event} /><label for='{$checkboxAllId}'>{$caption}</label>";        
        }else{
            $chkAll = "";        
        }
        
        //$caption = $this->_checkboxAllName;
        switch ($this->_checkboxAllPos){
          case 1:
            //Ajout de l'option 'tout' en fin de liste
            $ret =  $ret . $this->_delimeter . $chkAll;
            break;

          case -1:
            //Ajout de l'option 'tout' en début de liste
            $ret = $chkAll . $this->_delimeter . $ret;
            break;

          default:

            //$ret =  XoopsFormCheckBox::render() ;
            break;
        }  

        return $ret;
    }
    
    

}

?>
