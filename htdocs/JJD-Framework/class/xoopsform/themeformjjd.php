<?php
/**
 * XOOPS table form
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
 * @version         $Id: tableform.php 12537 2014-05-19 14:19:33Z beckmi $
 */

defined('XOOPS_ROOT_PATH') || die('Restricted access');

xoops_load('XoopsForm');

/**
 * Form that will output formatted as a HTML table
 *
 * No styles and no JavaScript to check for required fields.
 */
class XoopsThemeFormJjd extends XoopsForm
{
    /**
     * create HTML to output the form as a table
     *
     * YOU SHOULD AVOID TO USE THE FOLLOWING Nocolspan METHOD, IT WILL BE REMOVED
     *
     * To use the noColspan simply use the following example:
     *
     * $colspan = new XoopsFormDhtmlTextArea( '', 'key', $value, '100%', '100%' );
     * $colspan->setNocolspan();
     * $form->addElement( $colspan );
     *
     * @return string
     */
     
     
    /**
     * @baliseForm booleen
     */
    var $_baliseForm = true;

    /**
     * @baliseForm booleen
     */
    var $_baliseTable = true;
     
     
    function setBalises($showBaliseForm = false,$showBaliseTable = false)
    {
       $this->_baliseForm = $showBaliseForm;
       $this->_baliseTable = $showBaliseTable;
    }
     
    /**
     * Insert an empty row in the table to serve as a seperator.
     *
     * @param string $extra HTML to be displayed in the empty row.
     * @param string $class CSS class name for <td> tag
     */
    function insertBreak($extra = '', $description = '', $class = '', $styleDescription="")
    {
        $classCaption = ($class != '') ? " class='" . preg_replace('/[^A-Za-z0-9\s\s_-]/i', '', $class) . "'" : '';
        $html = "";
        // Fix for $extra tag not showing
        if ($extra) {
            $html = '<tr><th colspan="2" ' . $class . '>' . $extra . '</th></tr>';


          if ($description != '') 
          {     
            $styleDescription = (($styleDescription != '')) ? "style='{$styleDescription};'" : "style='font-style:italic;color : blue;'";
            $html .= '<tr><td colspan="2" class="odd">'; // align="center"
            $html .= "<span {$styleDescription}>" . $description . '</span>';
            $html .= "</td></tr>";
          }
        } else {
            $html = '<tr><td colspan="2" ' . $class . '>&nbsp;</td></tr>';
        }
        
        $this->addElement($html);
    }
     
    function render()
    {
      $tHtml = array();
      
        $ele_name = $this->getName();
        if($this->_baliseForm) 
            $tHtml[] = '<form name="' . $ele_name . '" id="' . $ele_name . '" action="' . $this->getAction() . '" method="' . $this->getMethod() . '" onsubmit="return xoopsFormValidate_' . $ele_name . '();"' . $this->getExtra() . '>';
        
        if($this->_baliseTable)
            $tHtml[] = '<table width="100%" class="outer" cellspacing="1">';
        
        $tHtml[] = '<tr><th colspan="2">' . $this->getTitle() . '</th></tr>';
        
        $hidden = '';
        $class = 'even';
        
        foreach ($this->getElements() as $ele) {
            if (!is_object($ele)) {
                $tHtml[] = $ele;  
            } else if (!$ele->isHidden()) {
                if (!$ele->getNocolspan()) {
                    $tHtml[] = '<tr valign="top" align="left" zzz="yyy"><td class="head">';
                    if (($caption = $ele->getCaption()) != '') {
                        $tHtml[] =  '<div class="xoops-form-element-caption' . ($ele->isRequired() ? '-required' : '') . '">';
                        $tHtml[] =  '<span class="caption-text">' . $caption . '</span>';
                        $tHtml[] =  '<span class="caption-marker">*</span>';
                        $tHtml[] =  '</div>';
                    }
                    if (($desc = $ele->getDescription()) != '') {
                        $tHtml[] =  '<div class="xoops-form-element-help">' . $desc . '</div>';
                    }
                    $tHtml[] =  '</td><td class="' . $class . '">' . $ele->render() . '</td></tr>' . NWLINE;

                } else {
                    //modif JJD : pour ajout d'une ligne de sous-titre dans les options
                    $caption = $ele->getCaption();
                    if($caption=="\n")
                    {
                      $tHtml[] = '<tr><th colspan="2">';
                      $tHtml[] = $ele->getValue();
                              
                      if (($desc = $ele->getDescription()) != '') {
                           $myts =& MyTextSanitizer::getInstance();
                           $desc = $myts->htmlspecialchars($desc);

                          $tHtml[] =  '<div class="xoops-form-element-help"><i>' . $desc . '</i></div>';
                      }
                      $tHtml[] = '</th></tr>';
                    }
                    else  
                    {
                      if (($caption = $ele->getCaption()) != '') {
                      $tHtml[] =  '<tr valign="top" align="left"><th class="head" colspan="2">';
                          $tHtml[] =  '<div class="xoops-form-element-caption' . ($ele->isRequired() ? '-required' : '') . '">';
                          $tHtml[] = '<span class="caption-text">' .$caption . '</span>';
                          $tHtml[] =  '<span class="caption-marker">*</span>';
                          $tHtml[] =  '</div>';
                      $tHtml[] =  '</th></tr>';
                      $tHtml[] =  '<tr valign="top" align="left"><td class="' . $class . '" colspan="2">' . $ele->render() . '</td></tr>';
                      }
                      else
                      {
                        $tHtml[] = '<tr><th colspan="2">';
                        $tHtml[] = $ele->getValue();
                                
                        if (($desc = $ele->getDescription()) != '') {
                             $myts =& MyTextSanitizer::getInstance();
                             $desc = $myts->htmlspecialchars($desc);
  
                            $tHtml[] =  '<div class="xoops-form-element-help"><i>' . $desc . '</i></div>';
                        }
                        $tHtml[] = '</th></tr>';
                      
                      }
                    }
                
                
                
                
                
                
                } //--------------------------
            } else {
                $hidden .= $ele->render();
            }
        }

        if($this->_baliseTable)
            $tHtml[] = '</table>' . NWLINE;
            
        //$tHtml[] = $hidden . NWLINE;
        
        if($this->_baliseForm)
            $tHtml[] = '</form>' . NWLINE;
        
        
        //$tHtml[] =  $this->renderValidationJS(true);
        
        
        return implode(NWLINE, $tHtml);
    }





}
