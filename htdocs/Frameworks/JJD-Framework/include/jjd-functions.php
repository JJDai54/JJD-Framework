<?php
namespace JJD;
/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use Xmf\Request;
use ArrayObject;
use ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/***************************************************************************
JJD - 15/07/2006
Petite modif juste pour dire que c'est JJD qu'a foutu un peu le bordel
****************************************************************************/
function getCopyright() {
global $xoopsModule;

    $module_handler = &xoops_gethandler('module');
    $versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));
    $v = $versioninfo->getInfo('version');
    $i = $versioninfo->getInfo('initiales');
    $n = $versioninfo->getInfo('name');

  $cr = "<a href='http://www.wakasensei.fr' target='_new'><B>{$n}</B> "
        .'Version'." {$v} "
        .'Author'." <B>{$i}</B></a>";
 
	return ($cr);
}

/**********************************************
 *
 **********************************************/
function  get_css_color($fileName = null, $addEmpty=false){
global $helper;
    if (is_null($fileName)) $fileName = JJD_PATH_CSS . "style-item-color.css";
    
    $content = file_get_contents ($fileName);

//echo "<br>{$fileName}<br>{$content}<br>";
    $tLines = explode("\n" , $content);
//echo "nbLines = " . count($tLines) . "<pre>" . print_r($tLines, true) . "</pre>";
//echo "nbLines = " . count($tLines) ;
//  echo "<pre>" . print_r($tLines, true) . "</pre>";

    //$tColors = array(XFORMS_DEFAULT => XFORMS_DEFAULT);
    $tColors = array();
    if ($addEmpty) $tColors[''] = '';
    foreach($tLines as $line){
      if(strlen($line)>0 && $line[0] == "."){
        $t = explode("-", $line);
        $color = substr($t[0],1);
        if (!array_key_exists($color, $tColors)){
            $tColors[$color] = $color;
        }
      }
    }

    return $tColors;
}

/**********************************************
 *
 **********************************************/
function get_css_path($dirname = '', $isUrl = false){
    if($dirname){
        $folder = "/modules/{$dirname}/assets/css";
    }else{
        $folder = "/Frameworks/JJD-Frawework/css";
    }
    
    
    if($isUrl){
        $dir = XOOPS_URL .  $folder;
    }else{
        $dir = XOOPS_ROOT_PATH  . $folder;
    }
    
    return $dir;
}

/**********************************************
 *
 **********************************************/
function load_css($dirname = ''){
//global $helper, $xoopsModuleCongig;


    //if ($helper->getConfig('css_folder') =="" ){
    //if ($xoopsModuleCongig['css_folder'] =="" ){
    /*
    if ($helper->getConfig('css_folder') =="" ){
          $dir = "browse.php?" . news_get_css_path();
    }else{
      $dir = news_get_css_path();
    }
    */
    /*
      $f = XOOPS_PATH . "/Frameworks/jquery/plugins/showHide.js";
      if (file_exists($f)){
        $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/plugins/showHide.js');
      }else{
        $f = XOOPS_ROOT_PATH . "/Frameworks/jquery/plugins/showHide.js";
        if (file_exists($f)){
          $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/Frameworks/jquery/plugins/showHide.js');
        }
      }

 $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/plugins/showHide.js');
    */
                    

                                                       
    $dir =  get_css_path($dirname, true);
    $GLOBALS['xoTheme']->addStylesheet($GLOBALS['xoops']->url($dir . "/style-item-design.css"));
    $GLOBALS['xoTheme']->addStylesheet($GLOBALS['xoops']->url($dir . "/style-item-color.css"));

    $GLOBALS['xoTheme']->addStylesheet($GLOBALS['xoops']->url($dir . "/style.css"));
}

/**************************************************************
 * 
 * ************************************************************/
function unzip($zipFile, $fldDest)
{
$zip = new ZipArchive();
$zip->open($zipFile, ZipArchive::CREATE);
//$zip->extractTo('uncompressed/', 'font_files/AlegreyaSans-Light.ttf');
$zip->extractTo($fldDest);
$zip->close();
  
  }
  
/**
 * Zip a folder (include itself).
 * Usage:
 *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
 *
 * @param string $sourcePath Path of directory to be zip.
 * @param string $outZipPath Path of output zip file.
 */
function zipSimpleDir($sourcePath, $zipFilename){
    $zip = new ZipArchive();        
//    echo "<hr>{$zipFilename}<hr>";

    $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    
    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $rootPath=$sourcePath;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourcePath), RecursiveIteratorIterator::LEAVES_ONLY);
    
    foreach ($files as $name => $file)
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
//    echo "===>{$filePath}<br>";
        $relativePath = substr($filePath, strlen($rootPath));
    
        if (!$file->isDir())
        {
            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }else {
            if($relativePath !== false)
                $zip->addEmptyDir($relativePath);
        }
    }
    
    // Zip archive will be created only after closing object
    $zip->close();
//exit;
}
/**
 * Zip a folder (include itself).
 * Usage:
 *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
 *
 * @param string $sourcePath Path of directory to be zip.
 * @param string $outZipPath Path of output zip file.
 */
function unZipFile($fullName, $destPath){
    $zip = new ZipArchive();
    if ($zip->open($fullName) === TRUE) {
        $zip->extractTo($destPath);
        $zip->close();
        return true;
     }else{
        return false;
     }              
}
/****************************************************************************
// copie le contenu du repertoire $orig vers le repertoire $dest en le cr??ant 
// copie tous les sous-reps de mani??re r??cursive 
// sous-entend qu'on a les droits d'??criture, bien s??r! 
 ****************************************************************************/
// function CopyRep ($orig,$dest) { return CopieRep ($orig,$dest);}
// function CopieRep ($orig,$dest) { 
//    
//   if (!is_dir($dest)) mkdir ($dest,0777); // ?? modifier si le rep cible existe d??j??
//   $dir = dir($orig); 
//   while ($entry=$dir->read()) { 
//     $pathOrig = "$orig/$entry"; 
//     $pathDest = "$dest/$entry"; 
//     // repertoire ->copie r??cursive
//     if (is_dir($pathOrig) and (substr($entry,0,1)<>'.')) CopieRep ($pathOrig,$pathDest);     
//    // fichier -> copie simple
//    if (is_file($pathOrig) and ($pathDest<>'') and ($fp=fopen($pathOrig,'rb'))) { 
//       $buf = fread($fp,filesize($pathOrig)); 
//       $cop = fopen($pathDest,'ab+'); 
//       fputs ($cop,$buf); 
//       fclose ($cop); 
//       fclose ($fp); 
//     } 
//   } 
//   $dir->close(); 
// } 
/****************************************************************************
 * 
 ****************************************************************************/
function include_highslide($options = null, $moduleDirName = ''){
  Global $xoTheme,$helper, $xoopsModuleConfig;

  //$xoTheme->addScript('browse.php?jquery/jquery.js');
//	$xoTheme->addScript(XOOPS_URL . '/browse.php?Frameworks/jquery/jquery.js');  
  
//   $xoTheme->addStylesheet('browse.php?Frameworks/zoom/highslide.css');
//   $xoTheme->addScript('browse.php?Frameworks/zoom/highslide.js');

//$fldHighslide = $xoopsModuleConfig['highslide'];
$fldHighslide = "highslide";
//$link = XOOPS_ROOT_PATH . "/Frameworks/" . $helper->getConfig('highslide');  
$link = XOOPS_URL . "/Frameworks/" . $fldHighslide;  
//echo "===>highslide : <hr>{$link}<hr>";  

  $xoTheme->addStylesheet("{$link}/highslide.css");
  $xoTheme->addScript("{$link}/highslide.js");

  //$xoTheme->addScript('browse.php?modules/slider/assets/js/highslide.js');
  if(file_exists(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/assets/js/config_highslide.js"))
  {
    $xoTheme->addScript(XOOPS_URL . "/modules/{$moduleDirName}/assets/js/config_highslide.js");
  }else{
    $xoTheme->addScript(XOOPS_URL . "/Frameworks/JJD_Framework/js/config_highslide.js");
  }

  if (!is_array($options)) $options = array();
  $options['graphicsDir'] = "{$link}/graphics/";
  \JJD\array2js('hs', $options, false, true);
//exit ("include_highslide");
}

/****************************************************************************
Genere la declaration d'un tableau en javascript
$name : nom du ta&bleau javascript
$options : tableau associatif. les clefs seront les m??me en javascript
$bolEcho : si true envoie directement la chaine g??n??r??e dans le flux html
retour : string a envoyer dans le flus html
note : la balise script est ajout??e automatiquement
 ****************************************************************************/
function array2js($name, $options, $isNew = false, $bolEcho = false){

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
  if ($bolEcho) echo $js;
  
  return $js;
}

/* *********************************************
* pr??pare un texte pour une comparaison avec un autre texte saisi
* - supprime les "<br>" et les  "|n"
* - supprime les caract??res de poncuation
* - remplace les caract??res accetu??s
* *********************************************** */
function sanityseNameForFile($exp){

    $reponse = str_replace(" ", "_", $exp);
    
  $a = array('??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', 
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', 
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??',
             '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??');

  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
             'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
             'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
             'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
             'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
             'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
             'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
             'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
             's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
             'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
             'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  $reponse = str_replace($a, $b, $reponse);

    return $reponse;
}
    
    /**
     * enleve_accent : enl??ve tous les accent d'une chaine de caract??re utf8, unicode, ...
     * @param $str 
     *
     * @return string
     */
function enleve_accents($chaine=''){
    $accent = array('%C3%80'=>'A','%C3%81'=>'A','%C3%82'=>'A','%C3%83'=>'A','%C3%84'=>'A','%C3%85'=>'A','%C3%A0'=>'a','%C3%A1'=>'a','%C3%A2'=>'a','%C3%A3'=>'a','%C3%A4'=>'a','%C3%A5'=>'a',
                    '%C3%88'=>'E','%C3%89'=>'E','%C3%8A'=>'E','%C3%8B'=>'E','%C3%A8'=>'e','%C3%A9'=>'e','%C3%AA'=>'e','%C3%AB'=>'e',
                    '%C3%8C'=>'I','%C3%8D'=>'I','%C3%8E'=>'I','%C3%8F'=>'I','%C3%AC'=>'i','%C3%AD'=>'i','%C3%AE'=>'i','%C3%AF'=>'i',
                    '%C3%92'=>'O','%C3%93'=>'O','%C3%94'=>'O','%C3%95'=>'O','%C3%96'=>'O','%C3%98'=>'O','%C3%B2'=>'o','%C3%B3'=>'o','%C3%B4'=>'o','%C3%B5'=>'o','%C3%B6'=>'o','%C3%B8'=>'o',
                    '%C3%99'=>'U','%C3%9A'=>'U','%C3%9B'=>'U','%C3%9C'=>'U','%C3%B9'=>'u','%C3%BA'=>'u','%C3%BB'=>'u','%C3%BC'=>'u',
                    '%C3%BF'=>'y',
                    '%C3%87'=>'C','%C3%A7'=>'c', '%C3%91'=>'N','%C3%B1'=>'n');
    $chaine = urlencode($chaine);
//     foreach ($accent as $key => $value) {
//         $chaine = str_replace($key,$value,$chaine);
//     }
    $chaine = str_replace(array_keys($accent),$accent,$chaine);
    return urldecode($chaine);
}

?>