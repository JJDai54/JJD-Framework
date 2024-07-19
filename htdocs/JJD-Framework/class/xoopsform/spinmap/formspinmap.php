<?php
/**
 * XoopsFormSpin element  -  Spin button
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
 * @version         XoopsFormSpin v 2.0
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

class XoopsFormSpinMap extends XoopsFormElement
{
const _SPIN_VERSION = 1.1;


    /**
     * Value
     *
     * @var integer
     * @access private
     */
    var $_value = 0;

    /**
     * Folder of arrow image
     *
     * @var string
     * @access private
     */
    var $_imgFolder = 'default';

    /**
     * index of image in folder
     *
     * @var string
     * @access private
     */
    var $_imgIndex = 1;

    /**
     * size of input text in nb car
     *
     * @var integer
     * @access private
     */
    var $_size = 2;

    /**
     *  styleText : style CSS of input text
     *
     * @var string
     * @access private
     */
    var $_styleText = "color: #000000; text-align: right; margin-left: 0px; margin-right: 2px; margin-top: 0px; margin-bottom: 0px; padding-right: 8px"; 

    /**
     * Allow loading of javascript
     *
     * @var bool
     * @access private
     */
    var $_loadJS = true;
    
    /**
     * array to transfert params to javascript via json
     *
     * @var bool
     * @access private
     */
    var $jsap = array();
    /*---------------------------------------------------------------*/    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param int $value Pre-selected value.
     * @param int $min value
     * @param int $max value
     * @param int $smallIncrement  Increment when click on button
     * @param int $largeIncrement  Increment when click on button
     * @param int $size Number caractere of inputtext
     * @param string $unite of the value
     * @param string $imgFolder of image for button
     * @param string imgIndex index of image in folder
     * @param string $styleText style CSs of text
     * @param string $styleBordure style CSs of frame
     * @param bool $minMaxVisible show min and mas buttons
     *                                        
     */
const _SPIN_FOLDER = '/class/xoopsform/spin_map/spin_map';
var $path = '';
var $url = '';

    function __construct($caption, $name, $value = 0, 
                           $min = 0, $max=100, 
                           $smallIncrement = 1, $largeIncrement = 10, 
                           $size = 5, $unite='', 
                           $imgFolder='default', $imgIndex=1,
                           $styleText = '', $styleBordure = '', 
                           $decimales = 0)

    { 
        
        
      $this->path = str_replace('\\', '/', dirname(__FILE__)) . '/spin_map';
      $this->url = str_replace(JJD_PATH, JJD_URL, $this->path);
        
        
        $this->setName($name);
        $this->setCaption($caption);
        $this->setSize($size);
        $this->setStyleText($styleText);
        $this->setImgFolder($imgFolder);
        $this->setImgIndex($imgIndex);
        $this->setStyleBordure($styleBordure);        
        
        
        $t = explode('.', $smallIncrement);
        if  (isset($t[1]) && $decimales == 0){
          $this->setDecimales(strlen($t[1]));
          //echoArray($t, true);
        }else{
          $this->setDecimales($decimales);
        }
        
        $this->setValue($value);
        $this->setMin($min);
        $this->setMax($max);
        $this->setSmallIncrement($smallIncrement);
        $this->setLargeIncrement($largeIncrement);
        $this->setUnite($unite);

              

        $this->jsap['name'] = $name;
        $this->jsap['value'] = $value;
        
        $this->jsap['callback_url'] = '';
        $this->jsap['callback'] = '';

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
         $this->_value = $value;
    }


    /*-----------------------------------------------------------------*/    
    /**
     * Get the min value
     */
    function getMin()
    {
        return $this->jsap['min'];
    }

    /**
     * Set the min value
     *
     * @param  $min int
     */
    function setMin($min)
    {
        $this->jsap['min'] = round($min, $this->jsap['decimales']);        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the max value - must be more great then max
     */
    function getMax()
    {
        return $this->jsap['max'];
    }

    /**
     * Set the max value - must be more great then max
     *
     * @param  $max int
     */
    function setMax($max)
    {
        $this->jsap['max'] = round($max, $this->jsap['decimales']);        
    }

    /*-----------------------------------------------------------------*/
    /**
     * Get the small increment when click a short time on up down nutton
     */
    function getSmallIncrement()
    {
        return $this->jsap['smallIncrement'];
    }

    /**
     * Set the small increment when click a short time on up down nutton
     * must be  " > 0 "
     *      
     * @param  $value int
     */
    function setSmallIncrement($smallIncrement)
    {
        //$this->jsap['smallIncrement'] = round($this->jsap['smallIncrement'],$this->jsap['decimales']);        
        $this->jsap['smallIncrement'] = $smallIncrement; 
        if ($this->jsap['smallIncrement'] == 0) $this->jsap['smallIncrement'] = 1; 
    }
    
    /*-----------------------------------------------------------------*/
    /**
     * Get the large increment when click a long time on up down nutton
     */
    function getLargeIncrement()
    {
        return $this->jsap['largeIncrement'];
    }

    /**
     * Set the large increment when click a long time on up down nutton
     *
     * @param  $largeIncrement int
     */
    function setLargeIncrement($largeIncrement)
    {
        //$this->_largeIncrement = round($largeIncrement,$this->jsap['decimales']);        
        $this->jsap['largeIncrement'] = $largeIncrement; 
        if ($this->jsap['largeIncrement'] == 0) $this->jsap['largeIncrement'] = 10; 
    }
    
    /*-----------------------------------------------------------------*/
    /**
     * Get the number of decimal to show
     */
    function getDecimales()
    {
        return $this->jsap['decimales'];
    }

    /**
     * Set the number of decimal to show
     *
     * @param  $decimales int
     */
    function setDecimales($decimales)
    {
        $this->jsap['decimales'] = intval($decimales);        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the size in nb car of the input text for the value
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * Set the size in nb car of the input text for the value 
     * must be 2 car min
     *     
     * @param  $size mixed
     */
    function setSize($size)
    {
        $this->_size = intval($size);
        if ($this->_size == 0) $this->_size = 2; 
    }
    /*-----------------------------------------------------------------*/
    function getImgFolder()
    /**
     * Get the shortname of the folder images
     */
    {
        return $this->_imgFolder;
    }

    /**
     * Set the shortname of the folder images
     *
     * @param  $folder string
     */
    function setImgFolder($folder)
    {
        if ($folder <> '' ) $this->_imgFolder = $folder;        
    }
    /*-----------------------------------------------------------------*/
    function getImgIndex()
    /**
     * Get the shortname of the folder images
     */
    {
        return $this->_imgIndex;
    }

    /**
     * Set the shortname of the folder images
     *
     * @param  $folder string
     */
    function setImgIndex($index)
    {
        $this->_imgIndex = $index;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the group delimiter (separateur de millier)
     */
    function getGroupDelimiter()
    {
        return $this->jsap['groupDelimiter'];
    }

    /**
     * Set the group delimiter (separateur de millier)
     *
     * @param  $groupDelimiter string
     */
    function setGroupDelimiter($groupDelimiter)
    {
        $this->jsap['groupDelimiter'] = $groupDelimiter;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the label of unites between value and buttons
     */
    function getUnite()
    {
        return $this->jsap['unite'];
    }

    /**
     * Set the label of unites between value and buttons 
     *
     * @param  $unite string
     */
    function setUnite($unite)
    {
        $this->jsap['unite'] = $unite;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the callback to call when value change
     */
    function getCallback()
    {
        return $this->jsap['callback'];
    }

    /**
     * Set the callback to call when value change
     *
     * @param  $callback string
     */
    function setCallback($callback)
    {
        $this->jsap['callback'] = $callback;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get or SET the javascript wich contain the callback function
     */
    function getCallback_url()
    {
        return $this->jsap['callback_url'];
    }

    /**
     * Set the javascript wich contain the callback function 
     *
     * @param  $callback_url string
     */
    function setCallback_url($callback_url)
    {
        $this->jsap['callback_url'] = $callback_url;        
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the style CSS of the text
     */
    function getStyleText()
    {
        return $this->_styleText;
    }

    /**
     * Set the style CSS of the text
     *
     * @param  $style string
     */
    function setStyleText($style)
    {
        if ($style <> '') $this->_styleText = $style; 
    }
    /*-----------------------------------------------------------------*/
    /**
     * Get the style CSS of the frame
     */
    function getStyleBordure()
    {
        return $this->jsap['styleBordure'];
    }

    /**
     * Set the style CSS of the frame 
     *
     * @param  $style string
     */
    function setStyleBordure($styleBordure)
    {
        //if ($styleBordure <> '') $this->jsap['styleBordure'] = $styleBordure; 
        $this->jsap['styleBordure'] = $styleBordure; 
    }

    /**********************************************************************/
    function sanityseName()
    {
      //----------------------------------------------------------
      $clName = str_replace('[','_', $this->getName());
      $clName = str_replace(']','_', $clName);
      return $clName; 
    }
    /**********************************************************************/
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
    global $xoTheme;
    
     $url = $this->url;
     $pathImg = $this->path . "/images/{$this->getImgFolder()}";       
     $imgUrl = $url . "/images/{$this->getImgFolder()}";       

     $xoTheme->addStylesheet($url . "/spin_map.css");
     $xoTheme->addScript($url . '/spin_map.js');
     $xoTheme->addScript($url . '/spin_map_new.js');
     
     if (strpos($this->jsap['callback_url'],'//') > 0){
        $xoTheme->addScript($this->jsap['callback_url']);
     }elseif($this->jsap['callback_url'] != ''){
        $xoTheme->addScript(XOOPS_URL . $this->jsap['callback_url']);
     }
     
     
     //$xoTheme->addScript($url . '/spin_map_old.js');

      //----------------------------------------------------------
      $ini = parse_ini_file($pathImg . '/spin_arrows.ini', true);
     
      $name   = $this->getName(); 
      $clName = $this->sanityseName();
      //----------------------------------------------------------
      //$this->jsap['ini'] = parse_ini_file($pathImg . '/spin_arrows.ini', true);
      $this->jsap['clName'] = $clName; 
      $this->jsap['imgUrl'] = $imgUrl . '/spin_arrows_{$this->_imgIndex}.png';
      //----------------------------------------------------------
      
      $prefixe = $this->getName();
    
      /*----------------------------------------------*/
      
      //----------------------------------------------------------------
      $styleBordure = $this->htmlAddAttribut ('style', $this->getStyleBordure());
      $styleText    = $this->htmlAddAttribut ('style', $this->getStyleText());  
      $styleArrow = "style=\"display: table-cell;vertical-align: middle; text-align: center; line-height: 100%; font-size: 7 pt; margin-top: 0; margin-bottom: 0; padding: 0\"";
      //----------------------------------------------------------------  
      $t = array();

     
      $t[] = "\n<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->\n";  
      $t[] = "<script type='text/javascript'>";
      $t[] = "var {$clName} = new clsSpin(" . json_encode($this->jsap).','. json_encode($ini) . ");";
      
      $t[] = "</script>";


      $t[] = "\n<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->\n";  
     
      //--------------------------------------------------------------
      
      $t[] = "<div STYLE='width:50px;position: relative;' onmouseout=\"spin_map_onMouseOutDiv(event);\">";  
      //$t[] = "<table border='0' width='8%' cellpadding='0' cellspacing='0'>";
      $t[] = "<table width='8%' class='spin_map_tbl' {$styleBordure}>";  
      $t[] = "  <tr>";
      //$t[] = "    <td width='60%'>{$Caption}</td>";    
      $t[] = "    <td width='60%'>";
      $t[] = "      <input type='text' name='{$prefixe}_text'   id='{$prefixe}_text' size='{$this->GetSize()}'  autocomplete='off'"
                  . " value='{$this->getValue()}' {$styleText} "
                  . " clName='{$clName}' offsetH='0' offsetV='0'"
                  . " onkeyup='spin_map_onTextChange(event);'>";
      $t[] = "    </td>";
      
      $unite = $this->getUnite();
      if ($unite <> ''){
        $t[] = "    <td style='display: table-cell;vertical-align: middle; '>&nbsp;{$unite}&nbsp;</td>";  
      }
      //-------------------------------------------------------
/***************************************************************************
 *Construction de la balise <map>
 * ***************************************************************************/   
      $tImg = array();
      $tImg[] = "<!-- ******************** MAP ****************************** -->";                                     
      $tImg[] = "    <td>";
      $divName = $name; //. '_img';
      $tImg[] = "<div id='{$divName}_img' class='spin_map_fleches'"
              . " style=\"cursor :pointer;"
              . "width:{$ini['size']['width']}px;height:{$ini['size']['height']}px;"
              . "background: url('{$imgUrl}/spin_arrows_{$this->_imgIndex}.png');\""
              . " onmouseout=\"spin_map_onMouseOut(event);\">";
      $tImg[] = "<MAP name='{$prefixe}_map'"
              . " onmouseup=\"spin_map_onMouseOut(event);\""
              . " onmouseout=\"spin_map_onMouseOut(event);\" >";
      
      
      
      $onMouseDown1 = 'spin_map_start(\'%1$s\', \'%2$s\',  %3$s, %4$s, %5$s,  %6$s, %7$s, %8$s);';
      $onMouseUp1 = 'spin_map_stop(\'%1$s\', \'%2$s\',  %3$s, %4$s);';
      
      foreach($ini['map'] as $k => $v) {
        if ($v !=''){
          $area = explode(':', $v);
          
          $tImg[] = "<AREA shape='{$area[0]}' coords='{$area[1]}'  tabindex='-1'"
                  . " clName=\"{$clName}\" offsetH='0' offsetV='{$k}'"
                  . " onmouseover=\"spin_map_onMouseOver(event);\" "
                  . " onmousedown=\"spin_map_onMouseDown(event);\" "
                  . " onmouseup=\"spin_map_onMouseUp(event);\" >";
                  

        }
 
      }   
      $tImg[] = "</map>";
      $tImg[] = "<IMG    USEMAP='#{$prefixe}_map'"
              . " SRC='{$url}/images/spin_masque.png' border='0'"
              . "  style='top:0;left:0;width:{$ini['size']['width']}px;height:{$ini['size']['height']}px;'"
              . "  onmouseout=\"spin_map_onMouseOut(event);\" />";

      $tImg[] = "</div>";
      $tImg[] = "    </td>";
      $tImg[] = "<!-- ************************************************** -->";
      $t[] = implode("\n", $tImg);
      /************************************************************************
       ajout d'une balise div or debug le JS notamment le calcul de position      
       
       ************************************************************************/            
              
      //-------------------------------------------------------
      
      $t[] = "  </tr>";
      $t[] = "</table>"."\n";
      $t[] = "</div>";
      $t[] = "<script type='text/javascript'>";
      $t[] = "spin_map_onLoad(\"{$prefixe}\");";  
      $t[] = "</script>";
      //-------------------------------------------
      $html = implode ("\n", $t);
      return $html;

}


/********************************************************************
 *
*********************************************************************/
function htmlAddAttribut($attribut, $value, $default = ''){

  if ($value == ''){$value = $default;}
  
  if ($value <> ""){
    if (substr($value,0,strlen($attribut)) <> $attribut){
      $r ="{$attribut}=\"{$value}\""; 
    }
  }else{
    $r = '';
  }
  
  return $r;

}

/*-----------------------------------------------*/
/*---          fin de la classe               ---*/
/*-----------------------------------------------*/


}

?>
