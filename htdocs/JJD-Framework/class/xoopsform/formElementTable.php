<?php
/**
 * XOOPS form element table
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
 * @version         $Id: formelementtray.php 9339 2012-04-16 00:15:04Z beckmi $
 */
 
defined('XOOPS_ROOT_PATH') or die('Restricted access');




class XoopsFormElementTable extends  XoopsFormElementTray
{
var $aWidth = array();

	/**
	 * Add an element to the group
	 *
	 * @param object $ &$element    {@link XoopsFormElement} to add
	 */
	public function addElementCell( &$formElement, $required = false , $newCol=false, $width=0) {
	 $this->aWidth[$formElement->getName()] = array('newCol'=>$newCol,'width'=>$width);
	 XoopsFormElementTray::addElement($formElement, $required);
}
	/**
	 * prepare HTML to output this group
	 *
	 * @return string HTML output
	 */
	function render() {
		$count = 0;
		$ret = "";
		
		$tHtml = array();
		
		$tHtml[] = "\n<table><tr>";
		$count = 0;
		
		foreach ( $this->getElements() as $ele ) {
		  $ppt = $this->aWidth[$ele->getName()];
		  
		  if($ppt['newCol'] || $count==0){
		    if($count > 0) $tHtml[] = "</td>";;
        $w = $ppt['width'];
        
  		  $width = (($w==0) ? '' : "width='{$w}px'");
  		  $tHtml[] = "<td {$width}>";
      }else{
  		  $tHtml[] = "<br /><br />";
      }
		  
  			if ( $ele->getCaption() != '' ) {
  				$tHtml[] = $ele->getCaption() . "<br />";
  			}
  			$tHtml[] = $ele->render()  ;
		  
      
		  $count++;
		}
    $tHtml[] = "</td>";
		
		
    $tHtml[] = "<td></td>";
		$tHtml[] = "</tr></table>\n";
		$ret = implode("\n", $tHtml);
		return $ret;
 
}


} // fin de la classe



?>
