<?php
// $Id: article.php,v 1.4 2008/07/28 17:17:31 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@sirium.net                                               //
//	About:  This file is part of the AM MiniGall module for Xoops v2.        //
//                                                                           //
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// includes
include ('../../../include/cp_header.php');
if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include ("../language/".$xoopsConfig['language']."/main.php");
} else {
	include ("../language/english/main.php");
}
include_once("../include/functions.inc.php");
include_once("../class/files.class.php");
$file = new files();
//include_once (XOOPS_ROOT_PATH . "/class/xoopstree.php");
//include_once (XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

$myts =& MyTextSanitizer::getInstance(); 

//---------------------------------------------------------------------------//
//
if (!isset($_REQUEST['op'])) {
xoops_cp_header();
amminigall_adminmenu(0, _AMMGALL_NAVINDEX);
?>

<p>Please note that this is a pre-alpha "proof of concept" release to see
how things go before I go any further with it.</p>

<p><b>Install:</b><br />
At the moment, to make this module work, you will have to edit one of
your original XOOPs files (and re-edit it when iot's updated). There
may be a way to do this in a nicer way, but I don't know just yet.

<p>First, MAKE A BACKUP of <i>xoops_root/class/module.textsanitizer.php</i> and then 
open it in a text editor... </p>

<p>Around line 405, between:
<code>
<pre>
        if ($br != 0) {
            $text = $this->nl2Br($text);
        }
</pre>
</code>        
And:
<code>
<pre>       
        $text = $this->codeConv($text, $xcode);
        return $text;
</pre>
</code>

Add the following lines:
<code>
<pre>
        include_once (XOOPS_ROOT_PATH."/modules/amminigall/display.php");
        $amminigall = new gallery();
        $text = $amminigall->display($text);
</pre>
</code>
</p> 

<p>Use the gallery tag, for example - <b>{gallery|1}</b> - to display 
in a module's page (you can copy the tag from the gallery list in the 
gallery page).</p> 


<?php
xoops_cp_footer();
} // if

?>