<?php

/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

if (JJD_DEBUG) echo "<hr>========= " . __FILE__. " =================<hr>";

/*******************************************************
 *
 *******************************************************/
function echoArray($t, $title='', $bExit = false){
    
  if(is_string($t)) return echoGPF($arr = 'GPF', $title = '',  $bolExit = false);
  
  $tr = print_r($t,true);
  if ($title==''){
    echo "<code><pre>{$tr}</pre></code><hr>";
  }else{
    echo "<hr>{$title}<hr><code><pre>{$tr}</pre></code>";
  }
  if ($bExit) exit();
}

/*******************************************************
 *
 *******************************************************/
function displayArray($t, $title = "", $bExit = false){
  echoArray($t, $title,$bExit);  
}

/**
*
**/
function echoGPF($arr = 'GPF' ,$title = '',  $bolExit = false)
{
   $arr = strtoupper($arr);
   echo "<hr>";
   if ($title) echo "message : {$title}<br>";
   if (strPos($arr,'G') !== false) echo "_GET   : <pre>" . print_r($_GET, true)   . "</pre><hr>";
   if (strPos($arr,'P') !== false) echo "_POST  : <pre>" . print_r($_POST, true)  . "</pre><hr>";
   if (strPos($arr,'F') !== false) echo "_FILES : <pre>" . print_r($_FILES, true) . "</pre><hr>";

   if($bolExit) exit($title);
   return true;
}



/***************************************************************************
Renvoie la valeur d'un bit précisé par un index dans la valeur binaire
****************************************************************************/
function isBitOk($bitIndex, $binValue){
  $b = pow(2, $bitIndex);
  $v = (($binValue &  $b) <> 0 ) ? 1 : 0;
  return $v;


}

/**
 * Returns an array of boolean
 * @$valueBin  int binaire
 * @return array
 */
function convert_bin_to_array($valueBin, $nbMaxBits = 32)  
{      
    $tBin = array();                                  
    for($h = 0; $h < $nbMaxBits; $h++) {
        $tBin[$h] =     (($valueBin & pow(2,$h))  != 0);
    }

//echo "<hr><pre>" .  print_r($tBin, true) . "</pre><hr>";        
     
    return $tBin;
}

/***************************************************************************
Charge les fichiers de langues
****************************************************************************/
function loadLanguageFWJJD($file){
global $xoopsConfig;
  // au cas ou un autre module tenterais de charger les constantes de langue  
  if(defined ('_CO_JJD_MONTH_DAY_FR')) return true;
  
  $root =  JJD_PATH . "/language/"; 
  $lang = $root . $xoopsConfig['language'] . "/" . $file . ".php";
//echo "<hr>lg = {$lang}<hr>";
  if (!file_exists($lang)){
    $lang = $root . "english/common.php";
  }
//echo "<hr>lg = {$lang}<hr>";
  return include_once ($lang);
  
}

function load_js($file, $suffix = '.min'){
global $xoTheme;
    $mini = str_replace('.js', $suffix  . '.js',$file);
      if(file_exists(XOOPS_ROOT_PATH . $mini)){
        $xoTheme->addScript(XOOPS_URL . $mini);
      }else{

        $xoTheme->addScript(XOOPS_URL . $file);
      }
}


/***************************************************************************
renvoi la liste des colonnes d'un tables en excluant certains champ
****************************************************************************/
function getColoumnsFromTable($name, $strFldExclude = '', $asArray = false){
global $xoopsDB;

    $arrExclus = explode(',', $strFldExclude);
    $sql = 'SHOW COLUMNS FROM '. $xoopsDB->prefix($name) . ';';
    $rst = $xoopsDB->query($sql);
    $fldArr = array();
    while ($row = $xoopsDB->fetchArray($rst)){
    //echoArray($row);
        if(!in_array($row['Field'], $arrExclus)) $fldArr[] = $row['Field'];
    } 
    if($asArray){
        return $fldArr;
    }else{
        return implode(',', $fldArr);
    }
}


?>
