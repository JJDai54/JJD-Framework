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

/**************************************************************
 *découpe le fichier par definition et analyse chaque definition
 **************************************************************/ 

function language2Array($file){
  $text = \JJD\FSO\loadTextFile($file);
  $tDef = \JJD\findDefinition($file);
  //displayArray($tDef, "parseFile--->{$file}");
  //echoArray($tDef);

    
  $prefixe = '';
  $h = 0;
  
  $newDef = array();
  $langArray = array();
  
  foreach($tDef as $key=>$def){
    //echo "--->{$def}<br>"; 
    $newDef = \JJD\parseDefinition(($def));
  //echoArray($newDef);
  $langArray[$newDef[1]] = $newDef[2];
  }
  return $langArray;
}

/***************************************************************************
Charge un fichiers de langues dans un tableau indexé
il faut parser ensuite la définition
****************************************************************************/
function languageFWJJD2Array($fileShortName){
global $xoopsConfig;
  
  $root =  JJD_PATH . "/language/"; 
  $fileFulName = $root . $xoopsConfig['language'] . "/" . $fileShortName . ".php";
//echo "<hr>lg = {$fileFulName}<hr>";
  if (!file_exists($fileFulName)){
    $fileFulName = $root . "english/common.php";
  }
  
  return \JJD\language2Array($fileFulName);
}
/**************************************************************
 *
 **************************************************************/ 

function findDefinition($fileFulName){
  $text = \JJD\FSO\loadTextFile($fileFulName);
  //echo "<pre>{$text}</pre>";
    
 //$p = '#$define[ ]*\((w)*[^)]#isU'; 
  //$p = '#(?s)(define[ ]*\()(.+?)[);]#isU';
  $p = '#(?s)define[ ]*\((.+?);#isU'; 
  $tp = array();
  
  $tp[] = '#(?is)';
  $tp[] = '';
  $tp[] = 'define\s*\(\s*';
  $tp[] = '(.*)';
  //$tp[] = '\'.*,';
  //$tp[] = '(.*)';    
  $tp[] = '\)\s*;';
  $tp[] = '#U';
  
  $p = implode('', $tp);
  //echo "<hr>{$p}<hr>";
 //$p = '#<\{[a-z ]*[\$]([a-z]*)[\} =<>]#isU'; 
  
 //$text = '<{$ggggg }>oooo<{if $tt==0}>oooo<{if $e>p}>ooo<{a}>ooo<{A}>ooo<{$Aa}>ooo<{$aaaaaA}>'; 
// $titre = eregi($p,$t,$r); 
 $def = preg_match_all($p, $text, $r); 
 //displayArray($r, "--------------------------------"); 
 
 return $r[1];
  
}

/**************************************************************
 *
 **************************************************************/ 

function parseDefinition($text){

   $text = trim($text);
   //$text = str_replace ("\n", '', $text);
   $text = str_replace (chr(13), '', $text); 
   $text = str_replace (chr(10), '', $text);   
   
  //$p = '[\'\"]\s*\.\s*[\'\"]';   
  $p = '#[\'\"]\s*[\.]\s*[\'\"]#isU';  
  $text = preg_replace($p, '', $text);   
  //echo "<hr><pre>=>{$text}</pre>";  
  
 //$p = '#$define[ ]*\((w)*[^)]#isU'; 
  //$p = '#(?s)(define[ ]*\()(.+?)[);]#isU';
  //$p = '#(?s)define[ ]*\((.+?);#isU'; 
  $tp = array();
  
  $tp[] = '#(?is)';
  $tp[] = '[\'\"]';
  $tp[] = '([\w]*)';
  $tp[] = '[\'\"]\s*,\s*';
  $tp[] = '[\'\"](.*)[\'\"]$\s*'; 
  //$tp[] = '[\'\"](.*)[\'\"]\s*\.\s*[\'\"](.*)[\'\"]$\s*';  
  
   
  //$tp[] = '\'.*,';
  //$tp[] = '(.*)';    
  $tp[] = '#';
  
  $p = implode('', $tp);
  //echo "<hr>{$p}<br>->{$text}<hr>";
  
 //$p = '#<\{[a-z ]*[\$]([a-z]*)[\} =<>]#isU'; 
  
 //$text = '<{$ggggg }>oooo<{if $tt==0}>oooo<{if $e>p}>ooo<{a}>ooo<{A}>ooo<{$Aa}>ooo<{$aaaaaA}>'; 
// $titre = eregi($p,$t,$r); 
 $def = preg_match_all($p, $text, $r); 
 
 $t = array();
 foreach($r as $key=>$item){
    $t[] = $item[0];
 }
 //displayArray($t, "--------------------------------"); 
 
 return $t;
  
}

