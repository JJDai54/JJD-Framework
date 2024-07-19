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
class XoopsFormFilesImages.php extends XoopsFormElement
{
    
    /**
     * Maximum size for an uploaded file
     *
     * @var int
     * @access private
     */
    var $_maxFileSize;
    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    var $_value;
    var $_local_description;    
    var $_url='';    
    var $_files;    
    var $_title;    
    var $_alt;    
    var $_names;    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $size Size
     * @param int $maxlength Maximum length of text
     * @param string $value Initial text
     */
    function __construct($caption , $names, $files, $title='', $alt='')
    {
        
//         $myts =& MyTextSanitizer::getInstance();
//         $this->setValue($myts->htmlspecialchars($value));                         
        
        //$this->setValue($value);  
        $this->setCaption($caption);  
        $this->_maxFileSize = intval($maxfilesize);
        $this->_names = $names;
        
        if(is_array($name)){
          $this->setName($name);
        }else{
          $this->_files = array(setName($name));
        }
        
//         $this->_url = $url;
        if(is_array($files)){
          $this->_files = $files;
        }else{
          $this->_files = array($files);
        }
                             

    }
    
    
    /**
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Get the maximum filesize
     *
     * @return int
     */
    function getMaxFileSize()
    {
        return $this->_maxFileSize;
    }
    
//     /**
//      * Get initial content
//      *
//      * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
//      * @return string
//      */
//     function getDescription($encode = false)
//     {
//         return $encode ? htmlspecialchars($this->_local_description, ENT_QUOTES) : $this->_local_description;
//     }
//     
//     /**
//      * Set initial text value
//      *
//      * @param  $value string
//      */
//     function setDescription($description)
//     {
//         //XoopsFormElement::setDescription(null);
//         //$parent->setDescription(null);
//         $this->_local_description = $description;
//     }
//     function getTitle(){return false;}
//     function getCaption(){return false;}     
//     
     
    
    
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      
    //$this->setFormType(false);    
    //global $config;
//         $myts =& MyTextSanitizer::getInstance();
//                     //$form->insertBreak($title);
//         $class = $myts->htmlspecialchars($config[$i]->getConfValueForOutput());
//         $class = ($class != '') ? " class='" . preg_replace('/[^A-Za-z0-9\s\s_-]/i', '', $class) . "'" : '';
//       $html = '<tr><td colspan="2" ' . $class . '>'
      
//         if($this->getDescription() != ''){
//           $this->_local_description = $this->getDescription(); 
//           $this->setDescription('');
//         }
        
//         if (strpos($this->_url,'//' )===false){
//           $this->_url = XOOPS_URL . '/' . $this->_url;
//         }
//         if (substr($this->_url, -1) !='/') $this->_url .= '/';
        
        $tHtml = array();
        $tHtml = "<table><tr><td>";
      
        foreach($this->_names as $name){
         $tHtml = "<input type='hidden' name='MAX_FILE_SIZE' value='" . $this->getMaxFileSize() . "' />"
                . "<input type='file' name='{$name}' id='{$name}' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                . "<input type='hidden' name='{$name}' id='{$name}' value='{$name}' />"
                . "<br />";		
		
       }
        
         $tHtml = "</td><td>";
       

        
        foreach($this->_files as $f){
// echo $f . '<br />';         
          //$tHtml[] = "<img src='{$this->_url}{$f}' width='150px' title='{$this->_title}' alt='{$this->_alt}' />";
          $tHtml[] = "<img src='{$f}' width='150px' title='{$this->_title}' alt='{$this->_alt}' />";
        }

        $tHtml = "</table></td></tr>";
        $html = implode('', $tHtml);
        return $html;

 /////////////////////////////       



    }
}

?>
