<?php
namespace JJD;
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

//echo "<hr>JJD-FRamework is charged<hr>";


define('JJD_FW', basename(dirname(__FILE__)));
echo "<hr>" . JJD_FW . "<hr>";exit;
define('JJD_PATH', XOOPS_ROOT_PATH . '/Frameworks/' . JJD_FW);

global $xoopsConfig;
//---------------------------------------------------------------------

/*********************************************************************
 *                  functions du back office
 * *******************************************************************/
include_once ("include/constantes.php");
include_once (JJD_PATH . "/include/globales-functions.php");
include_once (JJD_PATH . "/include/fw-functions.php");
include_once (JJD_PATH . "/include/fso.php");
include_once (JJD_PATH . "/include/date-functions.php");
include_once (JJD_PATH . "/include/xform-functions.php");
include_once (JJD_PATH . "/include/language-functions.php");

/*********************************************************************
 *                  classe du back office
 * *******************************************************************/
include_once (JJD_PATH . "/class/About.php");

/*********************************************************************
 *                  fichiers de langues
 * constante de langue générique de l'admin (Definition tout module, new,add,edit,...)
 * *******************************************************************/
loadLanguageFWJJD('admin');
loadLanguageFWJJD('main');
loadLanguageFWJJD('common');


?>


