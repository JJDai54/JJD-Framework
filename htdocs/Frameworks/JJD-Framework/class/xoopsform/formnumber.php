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
 * @author              JJDai, http://jubile.fr
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * A simple text field
 */
class XoopsFormNumber extends XoopsFormElement
{
    /**
     * Size
     *
     * @var int
     * @access private
     */
    public $_size;

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
     * Initial text
     *
     * @var string
     * @access private
     */
    public $_unit = '';
    

    /**
     * Constructor
     *
     * @param string $caption   Caption
     * @param string $name      "name" attribute
     * @param int    $size      Size
     * @param int    $maxlength Maximum length of text
     * @param string $value     Initial text
     */
    public function __construct($caption, $name, $size, $maxlength, $value = '')
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_size      = (int)$size;
        $this->_maxlength = (int)$maxlength;
        $this->setValue($value);
        
        //$this->setExtra('style="text-align : right;"');
        
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * Get maximum text length
     *
     * @return int
     */
    public function getMaxlength()
    {
        return $this->_maxlength;
    }

    /**
     * Get initial content
     *
     * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
     * @return string
     */
    public function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }
////////////////////////////
    /**
     * Get initial content
     *
     * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
     * @return string
     */
    public function getMin($encode = false)
    {
        return $encode ? htmlspecialchars($this->_min, ENT_QUOTES) : $this->_min;
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function setMin($min)
    {
        $this->_min = $min;
    }

    /**
     * Get initial content
     *
     * @param  bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compatibility
     * @return string
     */
    public function getMax($encode = false)
    {
        return $encode ? htmlspecialchars($this->_max, ENT_QUOTES) : $this->_max;
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function setMax($max)
    {
        $this->_max = $max;
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function setMinMax($min, $max, $unit = '')
    {
        $this->_min = $min;
        $this->_max = $max;
        $this->_unit = $unit;        
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function setUnit($unit)
    {
        $this->_unit = $unit;
    }

    /**
     * Set initial text value
     *
     * @param string $value
     */
    public function getUnit()
    {
        return $this->_unit;
    }

////////////////////////////////
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    public function render()
    {   $libStyle = 'style=';
        $styleDefault = 'text-align:right;';        
        $extra = $this->getExtra();
        $h = stripos($extra, $libStyle);
        if($h===false){
            $extra = "style='{$styleDefault}'";
        }else{
            $j = $h + strlen($libStyle);
            $extra = substr($extra, 0, $j) . $styleDefault . substr($extra, $j+1); 
        }
        
        
        $ret =  "<input class='form-control' type='number' name='"
            . $this->getName() . "' title='" . $this->getTitle() . "' id='" . $this->getName()
            . "' size='" . $this->getSize() . "' maxlength='" . $this->getMaxlength()
            . "' value='" . $this->getValue() 
            . "' min='" . $this->getMin() 
            . "' max='" . $this->getMax() 
            . "'" . $extra . ' />';
        if($this->_unit){
            $ret .= '&nbsp;' . $this->_unit;
        }
        
        return $ret;
    }
}
