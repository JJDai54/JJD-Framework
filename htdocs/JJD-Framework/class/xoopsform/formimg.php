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
 * @copyright       (c) 2000-2017 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             kernel
 * @subpackage          form
 * @since               2.0.0
 * @author              Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * A simple text field
 */
class XoopsFormImg extends XoopsFormElement
{
    /**
     * Size
     *
     * @var int
     * @access private
     */
    public $_width  = 0;
    public $_height = 0;
    public $_img;
    public $_link;
    public $_title = '';
    public $_alt = '';

    /**
     * Maximum length of the text
     *
     * @var int
     * @access private
     */
    public $_maxlength;

    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    public $_value;

    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    public $_min = 0;

    /**
     * Initial text
     *
     * @var string
     * @access private
     */
    public $_max = 100;

    /**
     * Constructor
     *
     * @param string $caption   Caption
     * @param string $name      "name" attribute
     * @param int    $size      Size
     * @param int    $maxlength Maximum length of text
     * @param string $value     Initial text
     */
    public function __construct($title, $img, $link = '', $width = 0, $height = 0, $alt = '', $extra = '')
    {
        $this->_width = $width;
        $this->_height = $height;
        $this->_img = $img;
        $this->_link = $link;
        $this->_title = $title;
        $this->_alt = $alt;
        
        $this->setExtra('style="text-align : right;"');
        
    }

//     /**
//      * Get size
//      *
//      * @return int
//      */
//     public function getSize()
//     {
//         return $this->_size;
//     }
// 
//     /**
//      * Get maximum text length
//      *
//      * @return int
//      */
//     public function getMaxlength()
//     {
//         return $this->_maxlength;
//     }
// 
//     /**
//      * Get initial content
//      *
//      * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
//      * @return string
//      */
//     public function getValue($encode = false)
//     {
//         return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
//     }
// 
//     /**
//      * Set initial text value
//      *
//      * @param string $value
//      */
//     public function setValue($value)
//     {
//         $this->_value = $value;
//     }
// ////////////////////////////
//     /**
//      * Get initial content
//      *
//      * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
//      * @return string
//      */
//     public function getMin($encode = false)
//     {
//         return $encode ? htmlspecialchars($this->_min, ENT_QUOTES) : $this->_min;
//     }
// 
//     /**
//      * Set initial text value
//      *
//      * @param string $value
//      */
//     public function setMin($min)
//     {
//         $this->_min = $min;
//     }
// 
//     /**
//      * Get initial content
//      *
//      * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
//      * @return string
//      */
//     public function getMax($encode = false)
//     {
//         return $encode ? htmlspecialchars($this->_max, ENT_QUOTES) : $this->_max;
//     }
// 
//     /**
//      * Set initial text value
//      *
//      * @param string $value
//      */
//     public function setMax($max)
//     {
//         $this->_max = $max;
//     }
// 
//     /**
//      * Set initial text value
//      *
//      * @param string $value
//      */
//     public function setMinMax($min, $max)
//     {
//         $this->_min = $min;
//         $this->_max = $max;
//     }
////////////////////////////////
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    public function render()
    {

    $html = "<img src='{$this->_img}' title='{$this->_title}' alt='{$this->_alt}' {width} {height} />" ;   
    if ($this->_width > 0)  $html = str_replace('{width}',  "width={$this->_width}px", $html);
    if ($this->_height > 0) $html = str_replace('{height}', "height={$this->_height}px", $html);
    
    if ($this->_link != '') 
        $html = "<a href='{$this->_link}' title='{$this->_title}', alt='' " . $this->getExtra() . ">{$html}</a>";
    else
        $html = "<a  title='{$this->_title}', alt='' " . $this->getExtra() . ">{$html}</a>";
    
    return $html;
    }
} // fin de la classe
