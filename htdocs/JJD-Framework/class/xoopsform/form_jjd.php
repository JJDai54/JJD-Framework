<?php
//  ------------------------------------------------------------------------ //

class Form_JJD extends XoopsFormElement  
{

  function load_js($file, $suffix = '.min'){
    global $xoTheme;
    $mini = str_replace('.js', $suffix  . '.js',$file);
      if(file_exists(XOOPS_ROOT_PATH . $mini)){
        $xoTheme->addScript(XOOPS_URL . $mini);
      }else{

        $xoTheme->addScript(XOOPS_URL . $file);
      }

  
  }
}



?>
