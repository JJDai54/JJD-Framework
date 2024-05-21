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
 * @version         $Id: formtext.php 8066 2011-11-06 05:09:33Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * A simple text field
 */
class XoopsFormTableTray extends XoopsFormElement
{
    /**
     * Size
     *
     * @var int
     * @access private
     */
    //var $_width="100%";
    
    /**
     * Maximum length of the text
     *
     * @var int
     * @access private
     */
    var $_tdStyle = array();    
    var $_globalTdStyle = array();    
    var $_elements = array();    
    var $_hiddens = array();    
    var $_odd = '';    
    var $_even = '';    

    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param int $col "cols" nombre de colonne de la table
     * @param int $row nombre de ligne de la table
     * @param string width largeur de la table
     */
    function __construct($caption = '', $globalTdStyle = null , $extra = null)
    { 
        $this->setCaption($caption);
        //$this->setName($name);
        if($globalTdStyle) $this->addGlobalTdStyle($globalTdStyle);

        if ($extra) $this->setExtra($extra);
    }
    function setEven($style){
        $this->_even = $style;    
    }
    function setOdd($style){
        $this->_odd = $style;    
    }
    
    function addGlobalTdStyle($globalTdStyle){
        //ajoute un ";" si il n'est pas présent
        $this->_globalTdStyle[] = $globalTdStyle . ((substr($globalTdStyle,-1,1) != ';') ? ';' : '' );
    }
    /**
     * addElement : ajoute un elements dans le tableau
     * @element : xoopsform a ajouter
     * @numCol : numero de colonne de destination
     * @numRow : numero de ligne de destination
     * @delimiter : default '<br>' - Delimiteur si plusieurs objets sont dans la même cellule
     * @return bool
     */
    function addElement($element, $numCol, $numRow = 0, $delimiter = '<br>')
    {
        if(is_null($numRow)) $numRow = 0;
        if(is_null($numCol)) $numCol = 0;
        
        if($numCol >= 0){
            if(!isset($this->_elements[$numRow])) $this->_elements[$numRow] = array();
            $this->_elements[$numRow][$numCol][] = [$element,$delimiter];
        }else{
          $this->_hiddens[] = $element;
        }
        $nbRows = count($this->_elements);
        $nbHiddens = count($this->_hiddens);
        //echo "<hr>addElement : row={$numRow} - nbRows={$nbRows} - col={$numCol} - hidden={$nbHiddens}<br>";// . $element->render();
        return true;
    }
    
    function addTdStyle($numCol, $tdStyle){
        if(is_null($numCol) || $numCol<0) $numCol = 0;
        //ajoute un ";" si il n'est pas présent
        $this->_tdStyle[$numCol][] = $tdStyle  . ((substr($tdStyle,-1,1) != ';') ? ';' : '' );
    }
    
    function getTdStyle($numCol){
        if(isset($this->_tdStyle[$numCol]))
            return "style='" . implode("", $this->_tdStyle[$numCol]) . "'";
        else
            return '';
    }
    
        
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    public function render()
    {
        $tHtml = array();
             //$tHtml[] = "<style>.form-control{margin:5px;}</style>";
             
             //$tHtml[] = "<style>.tblForm {line-height:2em;}</style>";
//              $tHtml[] = "<style>.tblForm {" . implode('', $this->_style) . ";}</style>";
//              $tHtml[] = "<style>.tblForm td{padding:5px 0px 0px 5px;}</style>";
             $tHtml[] = "<style>\n";
             
             if(count($this->_globalTdStyle)>0){
                $tHtml[] = ".tblForm td{" . implode('', $this->_globalTdStyle)  . "}\n";
             }
             //$tHtml[] = ".tblForm {" . implode('', $this->_style) . "}\n";
             $tHtml[] = "</style>\n";
        
        // Ajout des élement invisible (hidden
          
        for ($h = 0; $h < count($this->_hiddens); $h++)
             $tHtml[] = $this->_hiddens[$h]->render();
        //--------------------------------------------
        //$tHtml[] = "<table class='tblForm' " . implode(' ', $this->_extra) . ">"; 
        $tHtml[] = "<table class='tblForm' " . $this->getExtra() . ">"; 

        $rows = count($this->_elements);      
        for ($row = 0; $row < $rows; $row++){
        //echo ("<hr>--->render : {$row} / {$rows}<br>");   
            if(($row % 2 == 0) && $this->_odd){
                $tHtml[] = "<tr style='" . $this->_odd . "'>";
            }else if($this->_even){
                $tHtml[] = "<tr style='" . $this->_even . "'>";
            }else {
                $tHtml[] = "<tr>";
            };
            
            $cols = count($this->_elements[$row]);
          
            
            for ($col = 0; $col < $cols; $col++){
                $tHtml[] = "<td " . $this->getTdStyle($col) . ">";
                $countElements = count($this->_elements[$row][$col]);
                foreach($this->_elements[$row][$col] as $key=>$elem){
                  $elemCaption = ($elem[0]->getCaption() ) ? $elem[0]->getCaption() . ' : ' :  '';
                  $tHtml[] = $elemCaption . $elem[0]->render();
                  if($key < $countElements-1) $tHtml[] = $elem[1];
               }
                $tHtml[] = "</td>";
            }
            $tHtml[] = "</tr>";
        }
        $tHtml[] = "</table>";
        return implode("\n", $tHtml);
    }
}
//--------------------------------------------------------------------
class XoopsFormTableTrayStrict extends XoopsFormElement
{
    /**
     * Size
     *
     * @var int
     * @access private
     */
    var $_cols=1;
    var $_rows=1;
    var $_width="100%";
    
    /**
     * Maximum length of the text
     *
     * @var int
     * @access private
     */
    var $_elements = array();    
    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param int $col "cols" nombre de colonne de la table
     * @param int $row nombre de ligne de la table
     * @param string width largeur de la table
     */
    function __construct($caption, $cols, $rows=1, $width='100%', $extra='')
    {
        $this->setCaption($caption);
        //$this->setName($name);
        $this->_cols = ($cols<1) ? 1 : $cols;
        $this->_rows = ($rows<1) ? 1 : $rows ;
        $this->_width = $width;
        $this->setExtra($extra);

    }
    /**
     * Get size
     *
     * @return int
     */
    function addElement($element, $numCol, $numRow = 0)
    {
        if ($numCol >= $this->_cols) return false;
        if ($numRow >= $this->_rows) return false;
//         if ($numCol >= $this->_cols) $numCol = $this->_cols-1;
//         if ($numRow >= $this->_rows) $numRow = $this->_rows-1;
        $this->_elements[$numRow][$numCol][] = $element;
        return true;
    }
    
    
    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    public function render()
    {
        $tHtml = array();
        $tHtml[] = "<table width='{$this->_width}' " . implode(' ', $this->_extra) . ">"; 

        for ($row = 0; $row < $this->_rows; $row++){
            $tHtml[] = "<tr>";
            for ($col = 0; $col < $this->_cols; $col++){
                $tHtml[] = "<td>";
                $countElements = count($this->_elements[$row][$col]);
                foreach($this->_elements[$row][$col] as $key=>$elem){
                  $caption = ($elem->getCaption() ) ? $elem->getCaption() . ' : ' :  '';
                  $tHtml[] = $caption . $elem->render();
                  if($key < $countElements-1) $tHtml[] = '<br>';
               }
                $tHtml[] = "</td>";
            }
            $tHtml[] = "</tr>";
        }
        $tHtml[] = "</table>";
        return implode("\n", $tHtml);
    }
} // fin de la classe

?>
