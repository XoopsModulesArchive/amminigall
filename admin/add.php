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

//----------------------------------------------------------------------------//

if (!isset($_REQUEST['op'])) {
xoops_cp_header();
amminigall_adminmenu(2, _AMMGALL_NAVADD);

?>
<table border="0" cellpadding="0" cellspacing="1" class="outer">
  <tr>
    <th colspan="5" class="tblhead">Add image to gallery*</th>
  </tr>
  <tr>
    <td class="head">Filename*</td>
    <td class="head">Dimensions*</td>
    <td class="head">Size*</td>
    <td class="head">&nbsp;</td>
    <td class="head">&nbsp;</td>
  </tr>
<?php

	// row backround colour stuff
	$rowclass = "";

	// read dir for images
	$hook = opendir(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname'));

	while (($file = readdir($hook))!==false) {
		// Only deal with filenames with .jpg, .gif and .png extensions
		if (eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*\.(jpg|gif|png)$", $file)) {
			// Send to function to check is already in DB.
			if (!match_filename($file)) {

				// get image's file size in bytes
				$imagefilesize = round(filesize(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/".$file)/1024, 2)."Kb";
				
				// get image dimensions
				$imagesize = getimagesize(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/".$file);
				$imagedimensions = $imagesize[0] . "x" . $imagesize[1];
				
				// row colours thingy
				//$row_colour = ($row_count % 2) ? $colour1 : $colour2;
				$rowclass = ($rowclass == 'odd') ? 'even' : 'odd';

				//echo $file ." ". $imagefilesize . " <br />";

				echo "<tr>\n";
				echo "<td class=\"".$rowclass."\"><a href=\"". $_SERVER['PHP_SELF'] ."?op=detail&amp;file=". $file ."\">". $file ."</a></td>\n";
				echo "<td class=\"".$rowclass."\">". $imagedimensions ."</td>\n";
				echo "<td class=\"".$rowclass."\">". $imagefilesize ."</td>\n";
				//echo "<td style=\"background-color: ". $row_colour ."; text-align: center;\"><a href=\"". $_SERVER['PHP_SELF'] ."?op=preview&amp;file=". $file ."&amp;w=".$imagesize[0]."&amp;h=".$imagesize[1]."\" target=\"_blank\">preview</a></td>\n";
				echo "<td class=\"".$rowclass."\"><a href=\"javascript:spawn_window('". GALLERY_IMAGE_URL ."/". $file ."', 'preview', 'scrollbars=yes, resizable=yes, width=700, height=550')\">preview*</a></td>\n";
				echo "<td class=\"".$rowclass."\"><a href=\"". $_SERVER['PHP_SELF'] ."?f=imgdel&amp;file=". $file ."\">del*</a></td>\n";
				echo "</tr>\n";
				
				// increment row count
				//$row_count++; 

			} // end if
		} // if
	} // while


	// close dir
	closedir($hook);






echo "</table>";


xoops_cp_footer();
} // if


//----------------------------------------------------------------------------//
// detail add
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "detail") {
xoops_cp_header();
amminigall_adminmenu(2, _AMMGALL_NAVADD);

	// get image's file size in bytes
	$imagefilesize = round(filesize(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/".$_GET['file']));

	// get image dimensions
	$imagesize = getimagesize(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/".$_GET['file']);

	
	$formcaption = _AMMGALL_TTLADDIMG;
	$type = "add";
	include_once("imgform.inc.php");
	


xoops_cp_footer();
} // if

//----------------------------------------------------------------------------//
// detail add
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "savenew") {

	if(isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }
		else { $formdata = ""; }

		#echo "<pre>";
		#print_r($formdata);
		#echo "</pre>";
	
		$img_filename_photo	= $formdata['filename'];
		$img_photo_width	= $formdata['img_width'];
		$img_photo_height	= $formdata['img_height'];
		$img_filesize_bytes	= $formdata['img_filesize'];
		$img_title			= $myts->addSlashes($formdata['description']);
		$img_catid			= $formdata['catid'];
		$img_description	= $myts->addSlashes($formdata['description']);
		$img_weight			= $formdata['weight'];
	
	
		// call thumbnail class
		include_once("../class/image_thumbnail.class.php");
		$thumbnail = new thumbnails();
		$thumbdata = $thumbnail->create(XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/", XOOPS_UPLOAD_PATH."/".$xoopsModule->getVar('dirname')."/thumbs/", $img_filename_photo, 180 );

	    if ($thumbdata) {

			$img_thumb_width	= $thumbdata['thumbwidth'];
			$img_thumb_height	= $thumbdata['thumbheight'];
			$img_filename_thumb	= $thumbdata['thumbnail'];
		
			$sql = "INSERT INTO ".$xoopsDB->prefix("amminigall_images")." VALUES (
				NULL,
				'$img_catid',
				'$img_title',
				'$img_filename_photo',
				'$img_filename_thumb',
				NULL,
				NULL,
				'$img_description',
				'$img_thumb_width',
				'$img_thumb_height',
				'$img_photo_width',
				'$img_photo_height',
				'$img_filesize_bytes',
				NOW(),
				0,
				1,
				0,
				'$img_weight')";

				if ($xoopsDB->query($sql)) {
					redirect_header("add.php", 2, _AMMGALL_PHOTOADDED);
				} else {
					redirect_header("add.php", 2, _AMMGALL_PHOTOADDFAIL);
				}
	 	  
			} else {
				redirect_header("add.php", 2, _AMMGALL_PHOTONOTADDED);
			}
	

} // if




?>