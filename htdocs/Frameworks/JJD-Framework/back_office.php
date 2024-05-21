<?php

// +-----------------------------------------------------------------------+
// | Copyright (c) 2014, Charles Dezert                                    |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Jean-Jacques DELALANDRE <jjdelalandre@orange.fr>                           |
// |                                      |
// +-----------------------------------------------------------------------+
//
// $Id: .php,v 1.2 2004/09/18 19:25:55 dawilby Exp $
define('JJD_FW_FOLDER', basename(dirname(__FILE__)));

//echo "<hr>" . JJD_FW_FOLDER . "<hr>";
define('JJD_PATH', XOOPS_ROOT_PATH . '/Frameworks/' . JJD_FW_FOLDER);
define('JJD_PATH_XFORMS', JJD_PATH . '/class/xoopsform');
define('JJD_PATH_CSS', JJD_PATH . '/css');
//echo"<hr>JJD_PATH => " . JJD_PATH . "<br>JJD_PATH_XFORMS => " . JJD_PATH_XFORMS . "<hr>";

define('JJD_URL', XOOPS_URL . '/Frameworks/' . JJD_FW_FOLDER);
define('JJD_ICO16', JJD_URL . "/images/icons/16");
define('JJD_ICO32', JJD_URL . "/images/icons/32");


//echo __FILE__."<hr>";
define  ("XOOPS_JJD_PATH", XOOPS_ROOT_PATH ."/modules/jjd_tools/_xoops_plus");
define  ("XOOPS_JJD_URL", XOOPS_URL . "/modules/jjd_tools/_xoops_plus");


global $xoopsConfig;
//---------------------------------------------------------------------

/*********************************************************************
 *                  functions du back office
 * *******************************************************************/
include_once (JJD_PATH . "/include/constantes.php");
include_once (JJD_PATH . "/include/globales-functions.php");
include_once (JJD_PATH . "/include/fw-functions.php");
include_once (JJD_PATH . "/include/fso.php");
include_once (JJD_PATH . "/include/date-functions.php");
include_once (JJD_PATH . "/include/xform-functions.php");


/*********************************************************************
 *                  fichiers de langues
 * constante de langue générique de l'admin (Definition tout module, new,add,edit,...)
 * *******************************************************************/
loadLanguageFWJJD('admin');
loadLanguageFWJJD('main');
loadLanguageFWJJD('common');


/*********************************************************************
 *                  xoopsform du back office
 * *******************************************************************/
include_once (XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
require_once (XOOPS_ROOT_PATH . '/class/template.php');
//------------------------------------------------------------------

//include_once ($xform . '/grouppermform.php');
include_once (JJD_PATH_XFORMS . '/formLineBreak.php');

include_once (JJD_PATH_XFORMS . '/formimg.php');
include_once (JJD_PATH_XFORMS . '/formnumber.php');

/*
include_once (JJD_PATH_XFORMS . '/admintable/formadmintable.php');
include_once (JJD_PATH_XFORMS . '/spin_map/formspinmap.php');
include_once (JJD_PATH_XFORMS . '/checkboxbin/formBinCheckbox.php');
include_once (JJD_PATH_XFORMS . '/breakLine/formBreakLine.php');
include_once (JJD_PATH_XFORMS . '/editlist/formeditlist.php');
include_once (JJD_PATH_XFORMS . '/alphabarre/formalphabarre.php');
include_once (JJD_PATH_XFORMS . '/notation/formnotation.php');
include_once (JJD_PATH_XFORMS . '/formimage.php');
include_once (JJD_PATH_XFORMS . '/loadimages/formloadimages.php');
include_once (JJD_PATH_XFORMS . '/chosen/formchosen.php');
include_once (JJD_PATH_XFORMS . '/formElementTable.php');

include_once (JJD_PATH_XFORMS . '/formSelectCategory.php');
include_once (JJD_PATH_XFORMS . '/selectfile/formselectfile.php');
include_once (JJD_PATH_XFORMS . '/datalist/formdatalist.php');
include_once (JJD_PATH_XFORMS . '/themeformjjd.php');
include_once (JJD_PATH_XFORMS . '/formselectsystab.php');
include_once (JJD_PATH_XFORMS . '/formbuttontray.php');
include_once (JJD_PATH_XFORMS . '/FormFileCheckBox.php');
*/





?>


