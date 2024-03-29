<?php
namespace JJD\FSO;

/*              JJD - Frameworks
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/***************************************************************************
*
*****************************************************************************/
function  loadTextFile($f){

  if (!is_readable($f)){return '';}
  
  $fp = fopen($f,'rb');
  $taille = filesize($f);
  $text = fread($fp, $taille);
  fclose($fp);
  
  
  return $text;
  
}

/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File($fullName, $content, $mod = 0777){
  $fullName = str_replace('//', '/', $fullName);  
  
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
}

/* ***********************

************************** */
function getFilePrefixedBy($dirname, 
                           $extensions = null, 
                           $prefix = '', 
                           $addBlanck = false, 
                           $delPrefixAnExt=false, 
                           $fullName = false)
{
    
    $dirList = \XoopsLists::getFileListByExtension($dirname, $extensions, '');
 //echo "<hr>getFilePrefixedBy : {$dirname}<hr>" ;  
    $lgPrfix = strlen($prefix);
    if ($lgPrfix > 0){
    $files = array();
        foreach($dirList as $key=>$name){
            if(substr($name, 0, strlen($prefix)) == $prefix){
                if ($delPrefixAnExt) {
                  $h = strrpos($name, '.');
                  $name = substr($name, $lgPrfix, $h - $lgPrfix);
                }
                if ($fullName){
                    $files[$name] = $dirname .'/' . $name;
                }else{
                    $files[$name] = $name;
                }
              }
        }
    }else{
        if ($fullName){
            foreach($dirList as $name){
            $files[$name] = $dirname .'/' . $name;
            }
        }else{
            $files = $dirList;
        }
    }
    if ($addBlanck) {
        $blank = array('' => '');
        return array_merge($blank, $files);
    }else{
        return $files;
    }

}
/****************************************************************************
 *
 ****************************************************************************/
function getFolder ($folder, $extention = '', $fullName = true){

    if (!(substr($folder,-1) == '/')) $folder.='/';
    $lg = strlen($folder);    
    //echo "<hr>{$folder}<hr>";
    $folder = str_replace('//','/',$folder);
    $f = array();
    //$f[] = '';
    //-------------------------------------------
    
    if ($extention == ''){
    
          //foreach (glob("{$folder}*.*", GLOB_ONLYDIR) as $filename) {
          $td = glob($folder.'*', GLOB_ONLYDIR);
          //displayArray($td,"----- getFolder -----"); 
          foreach ($td as $filename) {          
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            //if (is_dir($folder.$filename)) $f[] = $folder.$filename;       
  
            if ($fullName){
              $f[] = $filename;            
            }else{
              $f[] = substr($filename,$lg);            
            }
                         
          }
    
    }else{
      //construction du tableu des extention
    //if (!substr($extention,0,1) == "."){$extention = ".".$extention; }      
    $extention = strtolower($extention);      
    $extention = str_replace ('.','', $extention);
    $t = explode(';', $extention); 
    //-------------------------------------------------
 
      for ($h=0; $h < count($t); $h++){
          $patern = "{$folder}*.{$t[$h]}";  
          //echo "<hr>$extention<br>$patern<hr>";   
          foreach (glob($patern) as $filename) {
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            $f[] = basename ($filename);          
          }
        
      }
    
    }

      
    //displayArray($f, '----fichiers-----'.$folder);
    return $f;
}

/**********************************************************************
 * 
 **********************************************************************/
function isFolder($path, $bCreate = false, $m = 0777){
//echo "===>isFolder<br />{$path}<br />";
if ($path=='') return false;
 $m = 0777;
 
  $path = str_replace('\\', '/', $path.'/');
  $path = str_replace('//', '/', $path);  
  $r = false;
  $om = umask ( $m);    
  
 
  if (is_dir($path)) {
    $r = true;              
    addHtmlIndex2folder ($path);
  }else{
    if ($bCreate){ 
      //$b = mkdir ($path,0777, true);


      //$b = @mkdir ($path, $m, true);  
      $b = false;
      $pp = 0;    
      if (!$b) {
        $h=1;
        //$h = strpos ($path, "/", $h+1);
        $h = strlen(XOOPS_ROOT_PATH);
        $i = strlen(XOOPS_ROOT_PATH);
        while (!$h===false) {
          $pp ++;
          $h = strpos ($path, "/", $h+1);
          if ($h===false) break;
          $sb = substr($path,0, $h);
          //echo "--->{$path}<br>{$h}<br>{$sb}<br>";
            $sb .= '/';
           //echo "===>{$pp}-{$h}-{$i}-isFolder-Impossible de creer le dossier :<br />{$sb}<br />dans :<br />{$path}<br />" ;                       
            if (!is_dir($sb)){
                try 
                {
                  $b = mkdir ($sb, $m);
                  if (!$b) die ("===>{$pp}-{$h}-{$i}-isFolder-Impossible de creer le dossier :<br />{$sb}<br />dans :<br />{$path}<br />") ;                       
                  chmod($sb, $m);                
                  addHtmlIndex2folder ($sb); 
                }
                catch(Exception $e)
                {
                  //echo "===>isFolder<br />{$path}<br />{$sb}<br /><br />";
                }
                 
            }else{
                //chmod($sb, $m);
            }
        }
    
      $r = true;    
    }
   
  }  
  

//echo sprintf("<hr>%1\$s<br>%2\$o-%3\$o<hr>" , $path, $om, $m);
//   if ($r){
//     if (substr($path, -1, 1) == '/') {
//       $pss = substr($path,0,-1);
//       setChmod($pss , $m);
//     }
//   } 
  if ($r) setChmod($path, $m);

  }    
  return $r;
}
/**********************************************************************
 * 
 **********************************************************************/
function addHtmlIndex2folder($sRoot, $browseSubfolder = false){
    
    if (!is_dir($sRoot)) return false;
    //echo "\n<hr>addHtmlIndex2folder<br>{$sRoot}<hr>\n";
    $fileIndex = $sRoot . '/index.html';
    $fileIndex = str_replace ('//', '/', $fileIndex);
    

    if (!is_file($fileIndex)){
        //echo "\n<hr>addHtmlIndex2folder<br>{$fileIndex}<hr>\n";    
        $content = "<script>history.go(-1);</script>";
        saveTexte2File2($fileIndex,  $content, 0666);
    } 

    if($browseSubfolder){
         $folders = \XoopsLists::getDirListAsArray($sRoot);
         foreach($folders AS $key=>$ubfolder)
            addHtmlIndex2folder($sRoot .'/' . $ubfolder);
    }
}
/**********************************************************************
 * 
 **********************************************************************/
function setChmod(&$path, $m = 0777){

//   if (substr($path, -1, 1) == '/') {
//     $pss = substr($path,0,-1);
//     setChmod($pss , $m);
//   }
//if($m==511) $m=0777;
 //$m=0777;   
  if (!is_dir($path)) return false;
  $ok = @chmod($path , $m);  
  if (!$ok){
    //echo "{$path} : new chmod = {$m}<br>";
  }
  
  $t = getFolder($path);
  //displayArray($t,"----------setChmod------------------");  
  foreach($t as $key => $item) {
  //for ($h=0; $h <= count($t); $h++){
    //echo "<hr>setChmod<br>{$item}<hr>";
    chmod($item , $m);  
  } 

}
function setChmodRecursif($chemin, $m = 0777){
    $lstat    = lstat($chemin);
    $mtime    = date('d/m/Y H:i:s', $lstat['mtime']);
    $filetype = filetype($chemin);
     
    // Affichage des infos sur le fichier $chemin
    //echo "$chemin   type: $filetype size: $lstat[size]  mtime: $mtime\n";
    chmod($chemin, $m); 
    // Si $chemin est un dossier => on appelle la fonction explorer() pour chaque �l�ment (fichier ou dossier) du dossier$chemin
    if( is_dir($chemin) ){
        $me = opendir($chemin);
        while( $child = readdir($me) ){
            if( $child != '.' && $child != '..' ){
                setChmodRecursif( $chemin.DIRECTORY_SEPARATOR.$child );
            }
        }
    }
}

/**********************************************************************
 * 
 **********************************************************************/
function buildPath($path){
    
    $b = isFolder($path, true);
    return $path;    

}
/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File2($fullName, $content, $mod = 0000){
  $fullName = str_replace('//', '/', $fullName);  
  
  if (!is_dir(dirname($fullName))) return false;
  if (file_exists($fullName)){
    chmod($fullName, 0777);
  }
  
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
  //if (isFolder(dirname($fullName), true)){
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
   // }else{
   //   return false;
   // }
    
}
//=================================================
/***************************************************************************
*
*****************************************************************************/
function query($sql, $prefix_module='', $lang=''){
global $xoopsDB;

  $sql = buildSql($sql, $prefix_module, $lang);
  $rst = $xoopsDB->query($sql);
  
  return $rst;

}

/***************************************************************************
*
*****************************************************************************/
function queryF($sql, $prefix_module='', $lang=''){
global $xoopsDB;

  $sql = buildSql($sql, $prefix_module, $lang);
  $rst = $xoopsDB->queryF($sql);
  
  return $rst;

}

/***************************************************************************
*
*****************************************************************************/
function executeSql($sql, $prefix_module='', $lang=''){
global $xoopsDB;


  $sql = buildSql($sql, $prefix_module, $lang);
  $xoopsDB->query($sql);
  
  return true;

}
/***************************************************************************
*
*****************************************************************************/
function buildSql($sql, $prefix_module='', $lang1='', $lang2=''){
global $xoopsDB, $xoopsConfig;
  
//   if ($lang1 == '')
//     $lang = "set @lang='{$xoopsConfig['language']}';\n";

    $lang  = "SET @lang  ='{$xoopsConfig['language']}';\n";
    $lang .= "SET @lang1 = " . (($lang1=="") ? "'{$xoopsConfig['language']}';\n": "'$lang1';\n");
    $lang .= "SET @lang2 = " . (($lang1=="") ? "'english';\n": "'$lang2';\n");
    


  
  $sql = str_replace('#',$xoopsDB->prefix($prefix_module) ,$sql);
  $sql = $lang . $sql;

  
  //echo "<hr>{$sql}<hr>";
  return $sql;

}

///////////////////////////////////////////////////////
// fichiers SQL  
///////////////////////////////////////////////////////

/***************************************************************************
*
*****************************************************************************/
function executeSqlFile($f){
global $xoopsDB;
echo("executeSqlFile : {$f}<br>");
  if (!is_readable($f)){return false;}
  
  $fp = fopen($f,'rb');
  $taille = filesize($f);
  $content = fread($fp, $taille);
  fclose($fp);
  
  $content = sprintf($content, $xoopsDB->prefix());
  echo "<hr>{$content}<hr>";  
  
  $t = explode(';', $content);
  foreach ($t as $sql){
    $sql = trim($sql);
    if ($sql != ''){
      $xoopsDB->queryF($sql . ';');
    echo "<hr>===>executeSqlFile :<br>{$sql}";
    }
  }
//jexit;  
  return true;
  
}
/***************************************************************************
*
*****************************************************************************/
function sanityseSqlFile($input){

  return $input;
 
  $search = array(
    '@\--[\s\S]*?\--',          // Strip single-line comments -- ???? --
    '@/\#\#[\s\S]*?\#\#',          // Strip single-line comments ## ???? ##
    '(?m)^-^-.*$',          // Strip single-line comments ## ???? ##
    '@/\*[\s\S]*?\*/@'         // Strip multi-line comments
  );
  $output = preg_replace($search, '', $input);
  return $output;

}

/***************************************************************************
*
*****************************************************************************/
function executeSqlFileDirect($f){
global $xoopsDB;

  if (!is_readable($f)){return false;}
  
  $fp = fopen($f,'rb');
  $taille = filesize($f);
  $sql = fread($fp, $taille);
  fclose($fp);
  
  
  $sql = sprintf($sql, $xoopsDB->prefix());
  jecho($sql);
  $xoopsDB->queryF($sql);
  
  return true;
  
}


?>