<?php
/**
 * XoopsDoubleList element  -  double list
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

/**
 * A select field
 *
 * @author 		Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>
 * @copyright JJD http:xoops.kiolo.com
 * @access 		public
 */


/*----------------------------------------------------------*/
/* set here the folder of the clas relative at the root     */
/*----------------------------------------------------------*/
define('_DOUBLELIST_FOLDER','/class/xoopsform/doublelist/');
/*----------------------------------------------------------*/

class XoopsFormDoubleList extends XoopsFormElement
{

    /**
     * Value
     *
     * @var array of keys
     * @access private
     */
    var $_value = array();
    var $_selected = Array();
    
    
    /**
     * options liste to select
     *
     * @var array associatif
     * @access private
     */
    var $_options = array();

    /**
     * Width in pixels of each list (the two list ave teh same width)
     *
     * @var int
     * @access private
     */
    var $_width = 120;
    
    
    /**
     * nb items of each list. That determin tthe height (the two list ave teh same size)
     *
     * @var int
     * @access private
     */
    var $_size = 12;
    
    /**
     * sub folder of the set of image for the buttons
     * default = 'default'     
     *
     * @var string
     * @access private
     */
    var $_imgFolder = 'default';
    
    
    /**
     * style CSS tho the options list (on the left) without 'style='
     * for exemple: "background-color:yellow;font-family: arial;font-size:14pt;color:#FF0000;"     
     * deault : null string
     * @var string
     * @access private
     */
    var $_styleListOptions='';
    
    /**
     * style CSS tho the selected list (on the right)) without 'style='
     * for exemple: "background-color:yellow;font-family: arial;font-size:14pt;color:#FF0000;"     
     * deault : null string
     *
     * @var string
     * @access private
     */
    var $_styleListSelected = '';
    
    /**
     * show the butons to sort the selected list
     * deault : false
     *
     * @var bool
     * @access private
     */
    var $_updownVisible = false;
    
    /**
     * Separator the the reilt list
     * deault : ','
     *
     * @var char
     * @access private
     */
    var $_resultSeparator = ',';
    
    /**
     * Show the button witch allow ti preview the result
     * This option is used for developpement, let it on false
     * deault : false
     *
     * @var bool
     * @access private
     */
    var $_showVisible = false;


    /**
     * Allow loading of javascript
     *
     * @var bool
     * @access private
     */
    static $_loadJS = true;
    
    /*---------------------------------------------------------------*/    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $values list of item preselected separed by "separator".
     * @param array string  $options values liste of optinos
     * @param int $size  number of itam visible of each list
     * @param int $width width in pixels of each list 
     * @param string $imgFolder of image png for button
     * @param string $styleListOptions style CSs of optinos list (on left)
     * @param string $styleListSelected style CSs of optinos list (on right)
     * @param bool $updownVisible show button to sort selected list
     *                                        
     */
public function __construct($caption, 
                           $name, 
                           $values,
                           $options,
                           $size = 12, 
                           $width = 120, 
                           $imgFolder='default',
                           $styleListOptions = '', 
                           $styleListSelected = '', 
                           $updownVisible = false)
    {
        $this->setValue($values);
        $this->setName($name);
        $this->setCaption($caption);
        $this->setOptions($options);
        $this->setWidth($width);
        $this->setSize($size);
        $this->setImgFolder($imgFolder);
        $this->setStyleListOptions($styleListOptions);
        $this->setStyleListSelected($styleListSelected);
        $this->setUpdownVisible($updownVisible);
    }

    /*-----------------------------------------------------------------*/
    /**
     * Get the values
     */
    function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the value
     *
     * @param  $value int
     */
     
    function setValue($value)
    {
        if (is_array($value)) {
         $this->_value = $value;
        }else{
          //$this->_value = array($value);
          $this->_value = explode(',', $value);
        }
    }
    /*-----------------------------------------------------------------*/    
    /**
     * Set the optins list array (list on left) 
     *     
     * @param  $options mixed
     */
    function setOptions($options)
    {
        if (is_array($options)) {
         $this->_options = $options;
        }else{
          $this->_options = explode ($this->_resultSeparator, $options);
        }
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the items number visible of each list , deermine yhe height of list
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * Set the items number visible of each list , deermine yhe height of list
     * must be 5 items min
     *     
     * @param  $size mixed
     */
    function setSize($size)
    {
        $this->_size = $size;
        if ($this->_size == 0){
          $this->_size = 12; 
        }elseif($this->_size < 5){
          $this->_size = 5; 
        }
        if ($size > 0 && $size < 5) $size = 5; 
        if ($size > 0 ) $this->_size = $size; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the width in pixels of each list  
     */
    function getWidth()
    {
        return $this->_width;
    }

    /**
     * Set the width in pixels of each list 
     * must be 80 pixls min
     *     
     * @param  $width  int mixed
     */
    function setWidth($width)
    {
        if ($width > 0 && $width < 80) $width = 80; 
        if ($width > 0 ) $this->_width = $width; 
    }
    /*-----------------------------------------------------------------*/
    function getImgFolder()
    /**
     * Get the shortname of the folder images set (ex: blue, green default, ...)
     */
    {
        return $this->_imgFolder;
    }

    /**
     * Set the shortname of the folder images set (ex: blue, green default, ...)
     *
     * @param  $folder string
     */
    function setImgFolder($folder)
    {
        if ($folder <> '' ) $this->_imgFolder = $folder;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the style CSS of the options list (on the left)
     */
    function getStyleListOptions()
    {
        return $this->_styleListOptions;
    }

    /**
     * Set the style CSS of the options list (on the left)  
     * for exemple: "background-color:yellow;font-family: arial;font-size:14pt;color:#FF0000;"
     *           
     * @param  $style string
     */
    function setStyleListOptions($style)
    {
        if ($style <> '') $this->_styleListOptions = $style; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the style CSS of the text
     */
    function getStyleListSelected()
    {
        return $this->_styleListSelected;
    }

    /**
     * Set the style CSS of the values list (on the right)  
     * for exemple: "background-color:yellow;font-family: arial;font-size:14pt;color:#FF0000;"
     *           
     * @param  $style string
     */
    function setStyleListSelected($style)
    {
        if ($style <> '') $this->_styleListSelected = $style; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get updown : show the button to up and down iteme in selected list
     */
    function getUpDownVisible()
    {
        return $this->_upDownVisible;
    }

    /**
     * set updown : show the button to up and down iteme in selected list
     *
     * @param $updownVisible bool
     */
    function setUpdownVisible($updownVisible)
    {
        $this->_upDownVisible = $updownVisible; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the separator list of result coma by default
     */
    function getResultSeparator()
    {
        return $this->_resultSeparator;
    }

    /**
     * Set the separator list of result coma by default
     *
     * @param $resultSeparator string 
     */
    function setResultSeparator($resultSeparator)
    {
        if ($resultSeparator != '') $this->_resultSeparator = $resultSeparator; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get $showVisible :  show the button to prview result
     */
    function getShowVisible()
    {
        return $this->_showVisible;
    }

    /**
     * Set  showVisible : show the button to prview result
     * used gor developpement, let it on false     
     *
     * @param  $showVisible bool
     */
    function setShowVisible($showVisible)
    {
        $this->_showVisible = $showVisible; 
    }
    /**********************************************************************/
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
    
    //the xoopsformdoublelist use a template 
    $template = XOOPS_ROOT_PATH . _DOUBLELIST_FOLDER ."tplDoubleList.html";       

    //we load all the params use in the template in an array
    $params = array();  
    $params['name'] = $this->getName();  
    $params['$prefixe'] = $params['name'];
    $params['$prefixe2'] =  'dblList'.$params['$prefixe'];
    $params['url'] = $this->getURL();
    $params['img'] =  "{$params['url']}images/{$this->getImgFolder()}/";
    $params['size'] =  $this->getSize();
    $params['width'] = $this->getWidth();
    $params['table_width'] = $params['width'] * 2;
    $params['styleListOptions'] = $this->getStyleListOptions();
    $params['styleListSelected'] = $this->getStyleListSelected();
    $params['upDownVisible'] = $this->getUpDownVisible();
    $params['br'] = (($params['size']>10) ? '<br/>' : '') ;
    $params['resultSeparator'] = $this->_resultSeparator;
    $params['showVisible'] = $this->_showVisible;
    $params['buttonVisible'] = false;
     
    //-------------------------------------------------   
    //list of options (list on left)
    $params['arrayOptions'] = $this->_options;
     //$r = print_r($this->_value, true);
     //$r = print_r($this->getValue(), true);
     //echo "<hr><pre>{$r}</pre><hr>";

    //list of values (list on right)
    $params['arraySelected'] = $this->getValue();
    
    //-------------------------------------------------     
    //include the template   
   include_once XOOPS_ROOT_PATH.'/class/template.php';
   $tpl = new XoopsTpl();
   //--------------------------------------------------------
   // Assign smarty variables
   $tpl->assign('params', $params);  
    
   //--------------------------------------------------------  
   // Call template
   //$tpl->display($template);  //for test only
   $html =  $tpl->fetch($template);
   //-------------------------------------------
    return $html;
    }
    
    /**********************************************************************/

/**************************************************************************
 * privates functions
 *************************************************************************/

/**************************************************************************
 * calcul de l'URL dossier du composant
 *************************************************************************/
function getURL (){

    $url = XOOPS_URL . _DOUBLELIST_FOLDER;
    return $url;
}


/*-----------------------------------------------*/
/*---          fin de la classe               ---*/
/*-----------------------------------------------*/


}

?>
