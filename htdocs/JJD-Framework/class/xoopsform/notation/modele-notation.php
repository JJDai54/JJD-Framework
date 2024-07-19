<?php
//  ------------------------------------------------------------------------ //

/* exemple url :
http://localhost:8101/x255fra/class/xoopsform/notation/notation.php?idModule=99&name=togodo&idParent=8&idChild=5&note=3
http://localhost:8101/x255fra/class/xoopsform/notation/notation.php?values=99_togodo_8_5_3

http://localhost:8101/x255fra/class/xoopsform/notation/notation.php?idModule=99&name=togodo&idParent=8&idChild=7&jsRootId=notation7&op=1&note=3

*/ 

//$t = print_r($_REQUEST,true);
//$t = print_r($HTTP_ENV_VARS,true);
// $t = print_r($GLOBALS,true);
// echo "<pre>{$t}</pre>";


$f = "mainfile.php";
  while (!file_exists($f)){
    $f = "../" . $f;
  }
include_once($f);

//saveComment($_GET);
//saveComment($p);
if (isset($_GET['values'])){
  $v = explode('|',  $_GET['values']);
  $p = array_combine ( array('idModule','name','idParent','idChild','jsRootId','op','note'), $v);
}else{
  $p = $_GET;
}
//saveComment($p);

$debug = true;
//----------------------------------------------
// The standard header for json data:
if (!$debug){
  header('Content-type: application/json; charset=utf-8');
}else{
  $t = print_r($_GET,true);
  echo "<pre>{$t}</pre>";
  $t = print_r($p,true);
  echo "<pre>{$t}</pre>";
}



//----------------------------------------------
function saveComment($p){
global $xoopsDB, $HTTP_SERVER_VARS;
  $tbl = $xoopsDB->prefix('jjd_notation');       
  //----------------------------------------
  $comment = substr($HTTP_SERVER_VARS['REQUEST_URI'], strlen($HTTP_SERVER_VARS['PHP_SELF']));
  
  $sql = "UPDATE {$tbl} SET comment ='{$comment}'" 
       . " WHERE idModule={$p['idModule']} AND name = '{$p['name']}'"
       . " AND idParent={$p['idParent']} AND idChild={$p['idChild']} ";
  if ($debug) echo "<hr>{$sql}<br>";
  $xoopsDB->queryf($sql);
}
/************************************************************
 *
 ************************************************************/ 
function getCurrentData($p){
// champs  idNotation idModule name idParent  idChild
//         noteCount noteSum  noteAverage
global $xoopsDB;
  
  $tbl = $xoopsDB->prefix('jjd_notation');
  $t = array();
  
  $sql = "SELECT noteCount,noteSum,noteAverage FROM {$tbl}"   
       . " WHERE idModule={$p['idModule']} AND name = '{$p['name']}'"
       . " AND idParent={$p['idParent']} AND idChild={$p['idChild']} ";
  if ($debug) echo "<hr>{$sql}<br>";
  $rst = $xoopsDB->query($sql);

  if ($xoopsDB->getRowsNum($rst) == 0){
      $noteCount   = 0;
      $noteSum     = 0;
      $noteAverage = 0;
  }else{
      list($noteCount,$noteSum,$noteAverage) = $xoopsDB->fetchRow($rst);
  }

  if ($debug) echo "<hr>{$sql}<br>";
  $xoopsDB->queryf($sql);

  $t['jsRootId'] = $p['jsRootId'];
  $t['noteCount'] = $noteCount;
  $t['noteSum'] = $noteSum;
  $t['noteAverage'] = round($noteAverage,1);
  $t['newNote'] = $p['note'];
  $t['message'] = '';
  //$t['message'] = 'Le message';
  
  return $t;


  
}
/************************************************************
 *
 ************************************************************/ 
function setNewNote($p){
// champs  idNotation idModule name idParent  idChild
//         noteCount noteSum  noteAverage
global $xoopsDB;
  
  $tbl = $xoopsDB->prefix('jjd_notation');
  $t = array();
  
  $sql = "SELECT idNotation,noteCount,noteSum FROM {$tbl}"   
       . " WHERE idModule={$p['idModule']} AND name = '{$p['name']}'"
       . " AND idParent={$p['idParent']} AND idChild={$p['idChild']} ";
  if ($debug) echo "<hr>{$sql}<br>";
  $rst = $xoopsDB->query($sql);

  if ($xoopsDB->getRowsNum($rst) == 0){
      $noteCount   = 1;
      $noteSum     = $p['note'];
      $noteAverage = $noteSum / $noteCount;
      
      $sql = "INSERT INTO {$tbl} (idModule,name,idParent,idChild,noteCount,noteSum,noteAverage)"
      . " VALUES({$p['idModule']}, '{$p['name']}', {$p['idParent']}, {$p['idChild']},"
      . " {$noteCount}, {$noteSum},{$noteAverage})";
  }else{
      list($idNotation,$noteCount,$noteSum) = $xoopsDB->fetchRow($rst);
      $noteCount  += 1;
      $noteSum    += $p['note'];
      $noteAverage = $noteSum / $noteCount;
      
      //----------------------------------------
      
      $sql = "UPDATE {$tbl} "
           . " SET noteCount = {$noteCount}, noteSum = {$noteSum},  noteAverage = {$noteAverage}"
           . " WHERE idNotation = {$idNotation}";
      
  }

  if ($debug) echo "<hr>{$sql}<br>";
  $xoopsDB->queryf($sql);

  $t['jsRootId'] = $p['jsRootId'];
  $t['noteCount'] = $noteCount;
  $t['noteSum'] = $noteSum;
  $t['noteAverage'] = round($noteAverage,1);
  $t['newNote'] = $p['note'];
  $t['message'] = '';
//   $t['message'] = 'Votre note (' .$p['note'] .') a bien été  enregistrée.' . "\n"
//                 . 'La nouvelle moyenne est de : ' . $t['noteAverage'];
  //$t['message'] = 'Le message';
  
  return $t;


  
}


//-----------------------------------------------------
//desactivation du mod debug sinon les mesage envoyé perturbe
//l'analyse par javascript du tableau json renvoye
//-----------------------------------------------------  
if (!$debug) {
  global $xoopsLogger;
  $xoopsLogger->renderingEnabled = false;
  error_reporting(0);
  $xoopsLogger->activated = false;
}
//-----------------------------------------------------
switch ($p['op']){
  case 1:   $t = setNewNote($p);      break;
  default:  $t = getCurrentData($p);  break;
}
$t['op'] = $p['op'];

echo json_encode($t);

//----------------------------------------------


?>
