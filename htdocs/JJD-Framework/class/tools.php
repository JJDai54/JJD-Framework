<?php
/**
 * XOOPS Form Class Elements
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         JJD_Framework
 * @subpackage      form
 * @since           2.5.0
 * @author          JJDai <jjdelalandre@orange.fr>
 * @version         $Id: formbuttontray.php 8066 2011-11-06 05:09:33Z beckmi $
 * 
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');


/**
 *
 * @author 		JJDai <jjdelalandre@orange.fr>
 * @package 	JJD_Framework
 * @access 		public
 */
class BoolBin{


/***************************************************************************
Renvoie la valeur d'un bit préciser par un index dans la valeur binaire
****************************************************************************/
  public static function isBitOk($bitIndex, $binValue){
    $b = pow(2, $bitIndex);
    $v = (($binValue &  $b) <> 0 ) ? 1 : 0;
    return $v;
  }

/**
 * Returns an array of boolean
 * @$valueBin  int binaire
 * @return array
 */
  public static function convert_bin_to_array($valueBin, $nbMaxBits = 32)  
  {  
    return self::bin_to_array($valueBin, $nbMaxBits);  
  }    
  public static function bin_to_array($valueBin, $nbMaxBits = 32)  
  {      
      $tBin = array();                                  
      for($h = 0; $h < $nbMaxBits; $h++) {
          $tBin[$h] =     (($valueBin & pow(2,$h))  != 0) ? 1 : 0;
      }
  
//echo "<hr><pre>" .  print_r($tBin, true) . "</pre><hr>";        
     
    return $tBin;
}
 
  public static function bin_to_arrayA($valueBin, $keys, $sep=',')  
  {  
    if (!is_array()) $keys = explode($sep, $keys);  
      $tBin = array();  
      foreach($keys as $index=>$key)   
          $tBin[$key] = (($valueBin & pow(2,$index))  != 0) ? 1 : 0;
//echo "<hr><pre>" .  print_r($tBin, true) . "</pre><hr>";        
     
    return $tBin;
}

/***************************************************************************
Renvoie une nuvelle valeur de binOctet en chant un bitIndex
****************************************************************************/
  public static function getNewBin($binOctet, $bitIndex, $bool=0)  
  {
     $newBinOctet  = ($binOctet & ~pow(2,$bitIndex));
     echo "getNewBin :  " . ~pow(2,$bitIndex);      //exit;
     if($bool) $newBinOctet = ($newBinOctet | pow(2,$bitIndex));
     echo "getNewBin :  " . pow(2,$bitIndex);      //exit;
     echo "getNewBin : {$binOctet}-{$newBinOctet}-{$bitIndex}-{$bool}";      //exit;
     return  $newBinOctet;
  }      

} // ----- fin de la classe -----


//echo "<hr>************ tools - highslide ***********************<hr>";
/**
 *
 * @author 		JJDai <jjdelalandre@orange.fr>
 * @package 	JJD_Framework
 * @access 		public
 */
class highslide{


/****************************************************************************
 * 
 ****************************************************************************/
public static function get_path($moduleDirName = '', $version = 'highslide'){

    $url = XOOPS_URL . "/Frameworks/" . $version;  
    
    $p = array();
    $p['url'] = $url;
    $p['css'] = $url . '/highslide.css';
    $p['js']  = $url . '/highslide.js';

    if(file_exists(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/assets/js/config_highslide.js"))
    {
      $p['config'] = $url . "/modules/{$moduleDirName}/assets/js/config_highslide.js";
    }else{
      $p['config'] = $url . '/Frameworks/JJD_Framework/js/config_highslide.js';
    }
    
    return $p;
}
/****************************************************************************
 * 
 ****************************************************************************/
public static function get_html($options = null, $moduleDirName = '', $version = 'highslide'){
    $p = self::get_path($moduleDirName, $version);

    $html = "<script src='{$p['js']}' type='text/javascript'></script>\n"    
          . "<link rel='stylesheet' href='{$p['css']}' type='text/css' />\n"
          . "<script src='{$p['config']}' type='text/javascript'></script>\n";

    if (!is_array($options)) $options = array();
    $options['graphicsDir'] = "{$p['url']}/graphics/";
    $html .= self::array2js('hs', $options, false, false) ;
//exit ("include_highslide");
    return $html;
}

/****************************************************************************
 * 
 ****************************************************************************/
public static function include_files($options = null, $moduleDirName = '', $version = 'highslide'){
  Global $xoTheme,$helper, $xoopsModuleConfig;

    $p = self::get_path($moduleDirName, $version);

                                  
    $xoTheme->addStylesheet("{$p['css']}");
    $xoTheme->addScript("{$p['js']}");
    $xoTheme->addScript("{$p['config']}");
  
    if (!is_array($options)) $options = array();
    $options['graphicsDir'] = "{$p['url']}/graphics/";
    self::array2js('hs', $options, false, true);
//exit ("include_highslide");
}

/****************************************************************************
 * 
 ****************************************************************************/
public static function get_a($imgUrl, $width = '', $height = '', $path = ''){
    if($path) $imgUrl   = $path . '/' . $imgUrl;
    
    $style = "";
    if ($width)  $style .= "max-width:{$width}px;";
    if ($height) $style .= "max-height:{$height}px;";
    if ($style) $style = "style='{$style}'";
    
    $html = "<div class='highslide-gallery'>"  
          . "<a href='${imgUrl}' class='highslide' onclick='return hs.expand(this);'>"
          . "<img src='${imgUrl}'  alt='' {$style}/>"
          . "</a></div>";
    return $html; 
}


/****************************************************************************
Genere la declaration d'un tableau en javascript
$name : nom du ta&bleau javascript
$options : tableau associatif. les clefs seront les même en javascript
$bolEcho : si true envoie directement la chaine générée dans le flux html
retour : string a envoyer dans le flus html
note : la balise script est ajoutée automatiquement
 ****************************************************************************/
private static function array2js($name, $options, $isNew = false, $bolEcho = false){

  $t = array();
  $t[] = "\n<script type='text/javascript'>"; 
  
  if ($isNew){
    $t[] = "{$name} = new Array()"; 
  }
  
  foreach($options as $key=>$value){
    if (is_numeric($value)){
      $t[] = "{$name}.{$key} = {$value};"; 
    }else{
      $t[] = "{$name}.{$key} = '{$value}';"; 
    }
  }
  
  $t[] = "</script>\n"; 
  
  $js = implode("\n", $t);
  if ($bolEcho) echo "===>{$js}";
  
  return $js;
}

 }  // ----- Fin de la classe -----
 
?>
