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

include_once (XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

	// load form
	$sform = new XoopsThemeForm($formcaption, "op", xoops_getenv('PHP_SELF'));

	if ($type == "add") {
		$prelabel = new XoopsFormLabel(_AMMGALL_FRMCAPSPREVIEW, "<a href=\"".XOOPS_UPLOAD_URL."/".$xoopsModule->getVar('dirname')."/".$_GET['file']."\" onclick=\"javascript:window.open('".XOOPS_UPLOAD_URL."/".$xoopsModule->getVar('dirname')."/".$_GET['file']."', 'preview', 'scrollbars=yes, resizable=yes, width=700, height=550'); return false;\">".$_GET['file']."</a>");
		$sform->addElement($prelabel);
		unset($prelabel);
	}
	
	// title
	if (!isset($imgtitle)) { $imgtitle = ""; }
	$title = new XoopsFormText(_AMMGALL_FRMCAPSDTTL, 'formdata[title]', 40, 255, $imgtitle);
	$sform->addElement($title);
	unset($title);
	
	// Gallery/category
	// new XoopsFormSelect($caption, $name, $value=null, $size=1, $multiple=false)
	// addOption($value, $name="")
	if (!isset($imgcat)) { $imgcat = ""; }
	$catselect = new XoopsFormSelect(_AMMGALL_FRMCAPSDCTGRY, 'formdata[catid]', $imgcat, '1', false);
	$catselect->addOption('0', _AMMGALL_FRMCAPSLCT);
	$sql = ("SELECT * FROM " . $xoopsDB->prefix("amminigall_categories") . " ORDER BY cat_name ASC");
	$result=$xoopsDB->query($sql);
	while($myrow = $xoopsDB->fetchArray($result)) {
		$cat_id    = $myrow['cat_id'];
		$cat_name  = $myrow['cat_name'];
		
		$catselect->addOption($cat_id, $cat_name);	
	} 
	$sform->addElement($catselect);
	
	// comments
	if (!isset($imgdesc)) { $imgdesc = ""; }
	$editor = new XoopsFormTextArea(_AMMGALL_FRMCAPSDESC, 'formdata[description]', $imgdesc, 8, 40); // rows, width
	$sform->addElement($editor);
	unset($editor);
	
	// weight
	if (!isset($imgsort)) { $imgsort = "0"; }
	$title = new XoopsFormText(_AMMGALL_FRMCAPSSORT, 'formdata[weight]', 5, 10, $imgsort);
	$sform->addElement($title);
	unset($title);
	
	$button_tray = new XoopsFormElementTray('', '');
	if ($type == "add") {
		$op = new XoopsFormHidden('op', 'savenew');
		$imgwidth = new XoopsFormHidden('formdata[img_width]', $imagesize[0]);
		$imgheight = new XoopsFormHidden('formdata[img_height]', $imagesize[1]);
		$imgfilesize = new XoopsFormHidden('formdata[img_filesize]', $imagefilesize);
		$imgfilename = new XoopsFormHidden('formdata[filename]', $_GET['file']);
	}
	if ($type == "edit") {
		$op = new XoopsFormHidden('op', 'saveedit');
	}
	$button_tray->addElement($op);
	$button_tray->addElement($imgwidth);
	$button_tray->addElement($imgheight);
	$button_tray->addElement($imgfilesize);
	$button_tray->addElement($imgfilename);

	$butt_create = new XoopsFormButton('', '', _AMMGALL_BUTSUBMIT, 'submit');
	//$butt_create->setExtra('onclick="this.form.elements.op.value=\'additem\'"');
	$button_tray->addElement($butt_create);

	$butt_clear = new XoopsFormButton('', '', _AMMGALL_BUTRESET, 'reset');
	$button_tray->addElement($butt_clear);

	$sform->addElement($button_tray);

	$sform->display();







?>