<?php
/**
 * XOOPS Form Class Elements
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @subpackage      form
 * @since           2.4.0
 * @author          John Neill <catzwolf@xoops.org>
 * @version         $Id: formbuttontray.php 8066 2011-11-06 05:09:33Z beckmi $
 * 
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * XoopsFormButtonTray
 *
 * @author 		John Neill <catzwolf@xoops.org>
 * @package 	kernel
 * @subpackage 	form
 * @access 		public
 */
class XoopsFormButtonTray2 extends XoopsFormElement {
	/**
	 * Value
	 *
	 * @var string
	 * @access private
	 */
	var $_value;

  	/**
	 * XoopsFormButtonTray::render()
	 *
	 * @return
	 */
	var $_prompt = "Ok pour supprimer ?";
  
	/**
	 * Type of the button. This could be either "button", "submit", or "reset"
	 *
	 * @var string
	 * @access private
	 */
	var $_type;

	/**
	 * XoopsFormButtonTray::XoopsFormButtonTray()
	 *
	 * @param mixed $name
	 * @param string $value
	 * @param string $type
	 * @param string $onclick
	 */
	function __construct( $name, $value = '', $type = '', $onclick = '', $showDelete = false , $showAdd = false) {
		$this->setName( $name );
		$this->setValue( $value );
		$this->_type = ( !empty( $type ) ) ? $type : 'submit';
		$this->_showDelete = $showDelete;
		$this->_showAdd = $showAdd;  //JJD
		
		if ( $onclick ) {
			$this->setExtra( $onclick );
		} else {
			$this->setExtra( '' );
		}
	}

	/**
	 * XoopsFormButtonTray::getValue()
	 *
	 * @return
	 */
	function getValue() {
		return $this->_value;
	}

	/**
	 * XoopsFormButtonTray::setValue()
	 *
	 * @param mixed $value
	 * @return
	 */
	function setValue( $value ) {
		$this->_value = $value;
	}

	
	/**
	 * XoopsFormButtonTray::getValue()
	 *
	 * @return
	 */
	function getPrompt() {
		return $this->_prompt;
	}

	/**
	 * XoopsFormButtonTray::setValue()
	 *
	 * @param mixed $value
	 * @return
	 */
	function setPrompt( $value ) {
		$this->_prompt = $value;
	}

	/**
	 * XoopsFormButtonTray::getType()
	 *
	 * @return
	 */
	function getType() {
		return $this->_type;
	}

	/**
	 * XoopsFormButtonTray::render()
	 *
	 * @return
	 */
	function render() {
		// onclick="this.form.elements.op.value=\'delfile\';
		$ret = '';
	  $prompt = $this->getPrompt();
    
    
		if ( $this->_showDelete && $prompt !='') 
    {
		$ret .= <<<__js__
<script type="text/javascript">
function formbuttontray_delete(obForm){

//document.Forms[0].submit() ;
  var r = confirm('{$prompt}');
  if (r==1){
  //alert(obForm.name + " - " + obForm.getAttribute('action'));
    obForm.elements.op.value='delete_ok';
    //obForm.submit();
    //document.forms[obForm.name].submit();
    return true;
  }
  return false;
}
</script>
__js__;
			$ret .= '<input name="delete" type="submit" class="formbutton" name="delete" id="delete" value="' . _DELETE . '" onclick="return formbuttontray_delete(this.form);">';
    }
		else if ($this->_showDelete) 
    {
			$ret .= '<input type="submit" class="formbutton" name="delete" id="delete" value="' . _DELETE . '" onclick="this.form.elements.op.value=\'delete\'">&nbsp;';
    }
    
    
    

	$ret .= '<input type="button" value="' . _CANCEL . '" onClick="history.go(-1);return true;" />&nbsp;';
    $ret .= '<input type="reset" class="formbutton"  name="reset"  id="reset" value="' . _RESET . '" />&nbsp;';
    $ret .= '<input type="' . $this->getType() . '" class="formbutton"  name="' . $this->getName() . '"  id="' . $this->getName() . '" value="' . $this->getValue() . '"' . $this->getExtra() . '  />';
		
	if ( $this->_showAdd ) {
      $ret .= '&nbsp;<input type="' . $this->getType() . '" class="formbutton"  name="' . "add" . '"  id="' . $this->getName() . '" value="' . _ADD . '"' . $this->getExtra() . '  />';
	}
		
		return $ret;
	}
}

// /******************************************************
//  * JJD - 18-08-2013
//  ******************************************************/
// class XoopsFormButtonTray2 extends  XoopsFormButtonTray{
// 	 
// 	function render() {
// 		// onclick="this.form.elements.op.value=\'delfile\';
// 	  $prompt = $this->getPrompt();
// 		$tHtml = array();
// 		
// 		
// 		
// 		if ( $this->_showDelete ) {
// 			//$tHtml[] = '<input name="delete" type="' . $this->getType() . '" class="formbutton" name="delete" id="delete" value="' . _DELETE . '" onclick="this.form.elements.op.value=\'delete\'">';
// 			$tHtml[] = '<input name="delete" type="submit" class="formbutton" name="delete" id="delete" value="' . _DELETE . '" onclick="return formbuttontray_delete(this.form);">';
// 			//$tHtml[] = '<input name="delete" type="button" class="formbutton" name="delete" id="delete" value="' . _DELETE . '" onclick="delete_media2(this.form);">';
// 		}
// 		//$t[] = '<input type="button" value="' . _CANCEL . '" onClick="history.go(-1);return true;" />',
// 		$tHtml[] = '<input name="cancel" type="button" value="' . _CANCEL . '" ' . $this->getExtra() . '/>';
//     $tHtml[] = '<input name="reset" type="reset" class="formbutton"  name="reset"  id="reset" value="' . _RESET . '" />';
//     $tHtml[] = '<input name="submit" type="' . $this->getType() . '" class="formbutton"  name="' . $this->getName() . '"  id="' . $this->getName() . '" value="' . $this->getValue() . '"' . $this->getExtra() . '  />';
// 		
// 		
// 		return implode("\n", $tHtml);//'&nbsp;'
// 	}
// }

?>
