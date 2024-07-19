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
//echo "<hr>XoopsFormLoadFile chargé<hr>";
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * A simple text field
 */
class XoopsFormLoadFileszzz extends XoopsFormElement
{
    
    /**
     * Maximum size for an uploaded file
     *
     * @var int
     * @access private
     */
    var $_maxFileSize = 5000000;
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
    var $_width = 150;    
    var $_names;    
    var $_deleteImgName = 'delete_img';    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $size Size
     * @param int $maxlength Maximum length of text
     * @param string $value Initial text
     */
    function __construct($caption , $names, $files, $width = null, $maxfilesize = null, $title='', $alt='')
    {
        
//         $myts =& MyTextSanitizer::getInstance();
//         $this->setValue($myts->htmlspecialchars($value));                         
        
        //$this->setValue($value);  
        $this->setCaption($caption);  
        if ($maxfilesize) $this->_maxFileSize = intval($maxfilesize);
        //$this->_names = $names;
        if ($width) $this->_width = $width;
        
        if(is_array($names)){
          $this->setValue($names);
        }else{
          $this->setValue($names);
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
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getDeleteImgName()
    {
        return $this->_deleteImgName;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setDeleteImgName($deleteImgName)
    {
        $this->_deleteImgName = $deleteImgName;
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
      
        $tValues = $this->getValue();
        
        $tHtml = array();
        $tHtml[] = "<table>";
        $maxFileSize = $this->getMaxFileSize() * count($tValues);
        $chkDelete = array();
        
        $tHtml[] = "<tr>";
        foreach($this->_files as $f){
          $tHtml[] = "<td>";
          
            $img = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $f);
            if(file_exists($img)){      
            $tHtml[] = "<img src='{$f}' width='{$this->_width }px' title='{$this->_title}' alt='{$this->_alt}' />";
            $chkDelete[] =  "<input type='checkbox' name='{$this->_deleteImgName}[{$f}]' id='{$this->_deleteImgName}[[{$f}]' value='1' />Suppression";

          }else{
            $chkDelete[] =  "";
          }
          $tHtml[] = "</td>";
        }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------  
        //affichage des case a cocher sur une nouvelle ligne de tableau      
        $tHtml[] = "<tr>";
        foreach($chkDelete as $chk){
          $tHtml[] = "<td>" . $chk . "</td>";
        }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------        
        $tHtml[] = "<tr>";
        foreach($tValues as $name){
         $tHtml[] = "<td><input type='hidden' name='MAX_FILE_SIZE' value='" . $maxFileSize . "' />"
                . "<input type='file' name='{$name}' id='{$name}' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                . "<input type='hidden' name='{$name}' id='{$name}' value='{$name}' />"
                . "</td>";		
       }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------        

        $tHtml[] = "</table>";
        $html = implode('', $tHtml);
        return $html;

    }
/***********************************************************************/    
    function render_old()
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
        $tHtml[] = "<table><tr><td>";
        $tValues = $this->getValue();
        $maxFileSize = $this->getMaxFileSize() * count($tValues);
        foreach($tValues as $name){
         $tHtml[] = "<input type='hidden' name='MAX_FILE_SIZE' value='" . $maxFileSize . "' />"
                . "<input type='file' name='{$name}' id='{$name}' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                . "<input type='hidden' name='{$name}' id='{$name}' value='{$name}' />"
                . "<br />";		
		
       }
/*
        $h = 0;
        foreach($this->getValue() as $name){
         $tHtml[] = "<input type='hidden' name='MAX_FILE_SIZE[{$h}]' value='" . $this->getMaxFileSize() . "' />"
                . "<input type='file' name='{$name}[{$h}]' id='{$name}[{$h}]' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                . "<input type='hidden' name='{$name}[{$h}]' id='{$name}[{$h}]' value='{$name}' />"
                . "<br />";		
		      $h++;
       }
*/        
         $tHtml[] = "</td><td>";
       
        //------------------------------------------------------
        // ajout des images
        $tHtml[] = "<table style='text-align: left; width: 100px;' border='0' cellpadding='2' cellspacing='2'><tr>";
        foreach($this->_files as $f){
          //$tHtml[] = "<img src='{$this->_url}{$f}' width='150px' title='{$this->_title}' alt='{$this->_alt}' />";
          //$tHtml[] = "<td style='vertical-align: top; text-align: left;'>";
          $tHtml[] = "<td>";
          
          
            $img = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $f);
            if(file_exists($img)){// echo $f . '<br />';         
            $tHtml[] = "<img src='{$f}' width='{$this->_width }px' title='{$this->_title}' alt='{$this->_alt}' />";
            
  
            $tHtml[] = "<br />";
  //           $tHtml[] = "<img src='{$f}' width='{$this->_width }px' title='{$this->_title}' alt='{$this->_alt}' />";
  
            $tHtml[] =  "<input type='checkbox' name='{$this->_deleteImgName}[{$f}]' id='{$this->_deleteImgName}[[{$f}]' value='1' />Suppression";

          }
          $tHtml[] = "</td>";
        }
        $tHtml[] = "</tr></table>";
        //------------------------------------------------------






        $tHtml[] = "</table></td></tr>";
        $html = implode('', $tHtml);
        return $html;

 /////////////////////////////       



    }
}

?>
