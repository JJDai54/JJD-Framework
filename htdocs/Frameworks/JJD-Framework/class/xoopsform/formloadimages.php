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
//echo "<hr>XoopsFormLoadImages chargé<hr>";
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * A simple text field
 */
class XoopsFormLoadFiles extends XoopsFormElement
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
    var $_width;    
    var $_names;    
    var $_deleteName = 'delete_file';  
    var $_extAllowed = "doc,docx,txt,pdf";
      
    var $_libelles = ['add'=>'Ajouter','del'=>'Supprimer'];
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $size Size
     * @param int $maxlength Maximum length of text
     * @param string $value Initial text
     */
    function __construct($caption , $names, $files, $width = 150, $maxfilesize=500000, $title='', $alt='')
    {
        
//         $myts =& MyTextSanitizer::getInstance();
//         $this->setValue($myts->htmlspecialchars($value));                         
        
        //$this->setValue($value);  
        $this->setCaption($caption);  
        $this->_maxFileSize = intval($maxfilesize);
        //$this->_names = $names;
        $this->_width = $width;
        
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
     * Set initial text value
     *
     * @param  $libelle[] string
     */
    function setlibellese($add, $del)
    {
        $this->_libelles['add'] = $add;
        $this->_libelles['del'] = $del;
    }
    /**
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getExtensions()
    {
        return $this->_extAllowed;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setExtensions($value)
    {
        $this->_extAllowed = $value;
    }
    function setDefaultExtensions($value = 'img')
    {
        switch($value){
            case 'img':
                $this->_extAllowed = "gif,jpg,jpeg,png";
                break;
            case 'video':
                $this->_extAllowed = "mp4,avi,mpeg,mov";
                break;
            case 'doc':
            default :
                $this->_extAllowed = "doc,docx,txt,pdf";
                break;
        }
    }

    /**
     * Get initial content
     *
     * @param bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return string
     */
    function getDeleteName()
    {
        return $this->_deleteName;
    }
    
    /**
     * Set initial text value
     *
     * @param  $value string
     */
    function setDeleteName($deleteName)
    {
        $this->_deleteName = $deleteName;
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
    
   
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      
        $tValues = $this->getValue();
        $maxFileSize = $this->getMaxFileSize() * count($tValues);
        $chkDelete = array();
        $ext = '.' . str_replace(',', ',.', $this->_extAllowed);        
        
// echoArray($tValues,"======== tValues ==========");        
// echoArray($this->_files,"======== this->_files ==========");        
        //------------------------------------------     
        $tHtml = array();
        $tHtml[] = "<table>";
        for($h = 0; $h<count($tValues); $h++){

            $name = $tValues [$h];
            if (isset($this->_files[$h]) && $this->_files[$h] !=''){
                $f = $this->_files[$h];
                $chkDelete =  "<input type='checkbox' name='{$this->_deleteName}[{$f}]' id='{$this->_deleteName}[[{$f}]' value='1' />{$this->_libelles['del']}";
            }else{
                $f = '';
                $chkDelete = $this->_libelles['add'];
            } 
            
            $tHtml[] = "<tr>";
            $tHtml[] = "<td style='text-align:left;'>{$chkDelete}</td>";
            $tHtml[] = "<td style='text-align:left;'><input type='hidden' name='MAX_FILE_SIZE' value='" . $maxFileSize . "' />"              
                     . "<input type='file' name='{$name}' id='{$name}' accept='{$ext}' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                     . "<input type='hidden' name='{$name}' id='{$name}' value='{$name}' />"
                     . "</td>";		
            $tHtml[] = "<td style='text-align:left;'>{$f}</td>";
            $tHtml[] = "</tr>";        
        }
        
        //------------------------------------------        

        $tHtml[] = "</table>";
        $html = implode('', $tHtml);
        return $html;

    }
/***********************************************************************/    
}

class XoopsFormLoadImages0 extends XoopsFormLoadFiles
{
    function __construct($caption , $names, $files, $width = 150, $maxfilesize=500000, $title='', $alt='')
    {  
        parent::__construct($caption , $names, $files, $width, $maxfilesize, $title, $alt);
        $this->setDefaultExtensions('img');
        $this->setDeleteName('delete_img');
        
    }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
      
        $tValues = $this->getValue();
//echoArray($tValues,"======== tValues ==========");        
        
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
            $chkDelete[] =  "<input type='checkbox' name='{$this->_deleteName}[{$f}]' id='{$this->_deleteName}[[{$f}]' value='1' />{$this->_libelles['del']}";
          }else{
            $chkDelete[] =  "";
          }
          $tHtml[] = "</td>";
        }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------        
        $tHtml[] = "<tr>";
        foreach($chkDelete as $chk){
          $tHtml[] = "<td>" . $chk . "</td>";
        }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------        
        $ext = '.' . str_replace(',', ',.', $this->_extAllowed);        
        $tHtml[] = "<tr>";
        foreach($tValues as $name){
         $tHtml[] = "<td><input type='hidden' name='MAX_FILE_SIZE' value='" . $maxFileSize . "' />"
                . "<input type='file' name='{$name}' id='{$name}' accept='{$ext}' title='" . $this->getTitle() . "' " .$this->getExtra() . " />"
                . "<input type='hidden' name='{$name}' id='{$name}' value='{$name}' />"
                . "</td>";		
       }
        $tHtml[] = "</tr>";        
        
        //------------------------------------------        

        $tHtml[] = "</table>";
        $html = implode('', $tHtml);
        return $html;

    }
}
?>
