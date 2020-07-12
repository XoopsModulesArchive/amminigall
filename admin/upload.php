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

//$myts =& MyTextSanitizer::getInstance(); 

//----------------------------------------------------------------------------//

if (!isset($_REQUEST['op'])) {
xoops_cp_header();
amminigall_adminmenu(1, _AMMGALL_NAVUPLOAD);


/**
 * Upload form.
 */
include_once (XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

$sform = new XoopsThemeForm(_AMMGALL_TTLUPLOADIMG, "op", xoops_getenv('PHP_SELF'));
$sform->setExtra('enctype="multipart/form-data"');

// IMAGE UPLOAD
$max_size = 5000000;
$image_file_box = new XoopsFormFile(_AMMGALL_CAPUPLOADIMG, "imagefile", $max_size);
$image_file_box->setExtra( " size ='50'") ;
//$image_file_box->setDescription(_AM_SSECTION_IMAGE_UPLOAD_ITEM_DSC);
$sform->addElement($image_file_box);


$button_tray = new XoopsFormElementTray('', '');
$hidden = new XoopsFormHidden('op', 'uploadfile');
$button_tray->addElement($hidden);

$butt_create = new XoopsFormButton('', '', _AMMGALL_BUTSUBMIT, 'submit');
//$butt_create->setExtra('onclick="this.form.elements.op.value=\'additem\'"');
$button_tray->addElement($butt_create);

$butt_clear = new XoopsFormButton('', '', _AMMGALL_BUTRESET, 'reset');
$button_tray->addElement($butt_clear);

$sform->addElement($button_tray);

$sform->display();


xoops_cp_footer();

} // if


//---------------------------------------------------------------------------//
// Process uploaded image.
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "uploadfile") {
//xoops_cp_header();


/*	if (isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }

	$sourcefile = $_FILES['imagefile']['tmp_name'];
	$destinationfile = "";
	//print_r($_FILES['imagefile']);
*/			
//	if (($sourcefile != 'none') && ($sourcefile != '' )) {
//		$imagesize = getimagesize($sourcefile);
		//echo "ok so far<br>";
		//print_r($imagesize);


		// Create main photo dir.
		$file->createDir(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname'), 0777);
		if ($file->getErrors()) {
			redirect_header("upload.php", 2, _AMMGALL_NOPHOTODIR);
		}
		// Create thumbnail dir.
		$file->createDir(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/thumbs/", 0777);
		if ($file->getErrors()) {
			redirect_header("upload.php", 2, _AMMGALL_NOTHUMBDIR);
		}
		//echo $file->getErrors();

		/**
		 * Upload
		 * TODO: Check for existing files.
		 * TODO: Do proper success/error reporting
		 */
		include_once (XOOPS_ROOT_PATH.'/class/uploader.php');
		$allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
		$maxfilesize = 5000000;
		$maxfilewidth = 12000;
		$maxfileheight = 12000;
		$uploader = new XoopsMediaUploader(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname'), $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
		//$uploader->setTargetFileName("something.jpg");
		//$uploader->setTargetFileName($_POST['xoops_upload_file'][0]);
		//if ($uploader->fetchMedia($_FILES['imagefile']['name'])) {
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			if (!$uploader->upload()) {
				echo $uploader->getErrors();
			} else {
				echo '<h4>File uploaded successfully!</h4>';
				echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
				echo 'Full path: ' . $uploader->getSavedDestination();
			}
		} else {
			echo $uploader->getErrors();
		}		


} // if







?>