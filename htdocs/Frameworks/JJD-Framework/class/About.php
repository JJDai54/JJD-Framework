<?php
//  ------------------------------------------------------------------------ //

class About  
{
    var $helper = null;
    var $module = null;
    var $dirname = null;
	var $_codePaypal = null;
    var $_btnImg     = null;
    var $_pixelImg   = null;

	public function __construct($helper, $codePaypal = null, $btnImg=null, $pixelImg=null)
	{
        $this->helper = $helper;
        $this->module = $helper->getModule();
        $this->dirname = $this->module->getInfo('dirname');
        
        $this->_codePaypal = $codePaypal;
        $this->_btnImg     = $btnImg;
        $this->_pixelImg   =$pixelImg;
        //xoops_loadLanguage('admin', $moduleDirName);
        
        
//echo "<hr>__construct : {$this->dirname}<hr>";
	}

/**********************************
 * 
 * ****************************** */
function moduleInfo(){

//echoArray($this->module);    
  $lines = array();
  
  $lines[] = ['title' => 'Auteur',
              'value' => $this->module->getInfo('author'),
              'color' => 'red',
              'bold'  => true];
    
  $lines[] = ['title' => 'author_mail',
              'value' => $this->module->getInfo('author_mail'),
              'color' => '',
              'bold'  => true];
     
  $lines[] = ['title' => 'author_website_url',
              'value' => $this->module->getInfo('author_website_url'),
              'color' => '',
              'bold'  => true];
             
     
  $lines[] = ['title' => 'author_website_name',
              'value' => $this->module->getInfo('author_website_name'),
              'color' => '',
              'bold'  => true];

 $lines[] = ['title' => 'module',
              'value' => $this->module->getInfo('name'),
              'color' => 'red',
              'bold'  => true];
  
  $lines[] = ['title' => 'dirname',
              'value' => basename(dirname(__DIR__)),
              'color' => 'red',
              'bold'  => true];
    
  $lines[] = ['title' => 'version',
              'value' => $this->module->getInfo('version'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'release_info',
              'value' => $this->module->getInfo('release_info'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'release_file',
              'value' => $this->module->getInfo('release_file'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'release_date',
              'value' => $this->module->getInfo('release_date'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'description',
              'value' => $this->module->getInfo('description'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'license',
              'value' => $this->module->getInfo('license'),
              'color' => '',
              'bold'  => true];
    
  $lines[] = ['title' => 'credits',
              'value' => $this->module->getInfo('credits'),
              'color' => '',
              'bold'  => true];
 return $lines;   
    
}

/**********************************
 * 
 * ****************************** */
function htmlTableInfo(){
    $tLines = $this->moduleInfo();
    $html = array();
    $html[] = "<table>";
    
    foreach($tLines as $k=>$line){
        $html[] = "<tr>";
        $html[] = "<td style='text-align:right;width:30%'>{$line['title']}</td>";
        $html[] = "<td style='text-align:center;'>:</td>";
        $html[] = "<td style='text-align:left;'>{$line['value']}</td>";
        $html[] = "</tr>";
    }
    $html[] = "</table>";
    return implode("\n", $html);
}

/**********************************
 * 
 * ****************************** */
function changelog(){

    $path = XOOPS_ROOT_PATH . '/modules/' . $this->dirname;
//echo "<hr>changelog : {$path}<hr>";    
    $language = empty( $GLOBALS['xoopsConfig']['language'] ) ? 'english' : $GLOBALS['xoopsConfig']['language'];
    $file     = "{$path}/language/{$language}/changelog.txt";
    if ( !is_file( $file ) && ( 'english' !== $language ) ) {
        $file = "{$path}/language/english/changelog.txt";
    }
    if ( is_readable( $file ) ) {
        $ret = ( implode( '<br>', file( $file ) ) ) . "\n";
    } else {
        $file = "{$path}/docs/changelog.txt";
        if ( is_readable( $file ) ) {
            $ret = implode( '<br>', file( $file ) ) . "\n";
        }
    }
    $ret  = str_replace(" ","&nbsp;", $ret);
    //--------------------------------------------
    $html = array();

    $html[] = "<div class=\"txtchangelog\">\n";
    //$html[] = "|" . $file . "|<br>";
    $html[] = $ret;
    
    $html[] = "</div>\n";
    return implode("\n", $html);

}

/**********************************
 * 
 * ****************************** */
function localHeaderInfo($addExtra = true){
$modId = '';

    $license_url = $this->module->getInfo('license_url');
    $license_url = preg_match('%^(https?:)?//%', $license_url) ? $license_url : 'http://' . $license_url;

    if($addExtra){
        $modId = " - mid = " . $this->module->getVar('mid');
    }
    $xoopsUrl = XOOPS_URL;
    $aboutWy = _AM_JJD_ABOUT_BY;
 
 $langArr = \JJD\languageFWJJD2Array('admin');
 //echoArray($langArr);   


$html =  <<<___contribution___
<table><tr>
    <td style="width: 100px;">
        <img src="{$xoopsUrl}/modules/{$this->dirname}/{$this->module->getInfo('image')}" alt="{$this->dirname}" style="float: left; margin-right: 10px;">
    </td>
    <td>
        <div style="margin-top: 1px; margin-itemRound-bottom: 4px; font-size: 18px; line-height: 18px; color: #2F5376; font-weight: bold;">
            {$this->module->getInfo('name')} - {$this->module->getInfo('version')} - {$this->module->getInfo('module_status')}{$modId}
            <div style="line-height: 16px; font-weight: bold;">
        </div>
        {$langArr['_AM_JJD_ABOUT_BY']} : {$this->module->getInfo('author')}
        </div>
        <div style="line-height: 16px;">
            {$langArr['_AM_JJD_ABOUT_LICENCE']} : <a href="{$license_url}" target="_blank" rel="external">{$this->module->getInfo('license')}</a>
            <br>
            {$langArr['_AM_JJD_ABOUT_WEB_SITE']} : <a href="{$this->module->getInfo('author_website_url')}" target="_blank">{$this->module->getInfo('author_website_name')}</a>
        </div>
</td></tr></table>
___contribution___;


    return $html;

}

/**********************************
 * 
 * https://www.paypal.com/donate?hosted_button_id=H9EMH5M4XA48A
 * ****************************** */
function contribution($codePaypal, $btnImg, $pixelImg){
    
  $whyDonate = _AM_JJD_ABOUT_WHY_DONATE;  

$html =  <<<___contribution___
<div style=\"clear: both; height: 1em;\"></div>
<div>{$whyDonate}</div><center>
    <form action="https://www.paypal.com/donate" method="post" target="_top">
        <input type="hidden" name="hosted_button_id" value="{$codePaypal}" />
        <input type="image" src="{$btnImg}" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
        <img alt="" border="0" src="{$pixelImg}" width="1" height="1" />
    </form>
</center></div>
___contribution___;
   
    return $html;

/*
*/
}

function getBox(){


  $box = array();
  /* ------------------------- PAYPAL -----------------------------*/

  $box['module']['legend'] = _AM_MODULEADMIN_ABOUT_MODULEINFO;
  $box['module']['content'] = $this->htmlTableInfo();

  /* ------------------------- Module -----------------------------*/
  $box['paypal']['legend'] = _AM_JJD_ABOUT_CONTRIBUTION;
  $box['paypal']['content'] = $this->contribution($this->_codePaypal, $this->_btnImg , $this->_pixelImg);

  /* ------------------------- Header Info -----------------------------*/
  $box['header']['legend'] = "header";
  $box['header']['content'] = $this->localHeaderInfo();

  /* ------------------------- Chanlog -----------------------------*/
  $box['changelog']['legend'] = _AM_MODULEADMIN_ABOUT_CHANGELOG;
  $box['changelog']['content'] = $this->changelog();
    
  /* ------------------------- retour -----------------------------*/
    return $box;
}

} // ----------- Fin de la Classe ----------------------

?>
