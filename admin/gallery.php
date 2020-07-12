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
amminigall_adminmenu(3, _AMMGALL_NAVGALLERY);

?>

<table border="0" cellpadding="0" cellspacing="1" class="outer">
  <tr>
    <th colspan="6" class="tblhead">Categorys/galleries*</th>
  </tr>
  <tr>
    <td class="head" style="width: 20px; text-align: center;">id*</td>
    <td class="head" style="text-align: center;">Name*</td>
    <td class="head" style="text-align: center;">Display tag*</td>
    <td class="head">order*</td>
    <td class="head"></td>
    <td class="head"></td>
  </tr>
  
<?php

	$rowclass = "";
	$sql = "SELECT * FROM " . $xoopsDB->prefix("amminigall_categories") . " ";
	$result=$xoopsDB->query($sql);

		if ($xoopsDB->getRowsNum($result) > 0) {
			while($row = $xoopsDB->fetchArray($result)) {
				$cat_id			= $row['cat_id'];
				$cat_name		= $row['cat_name'];
				$cat_sortorder	= $row['cat_sortorder'];
			
				//$row_colour = ($row_count % 2) ? $colour1 : $colour2;
				$rowclass = ($rowclass == 'odd') ? 'even' : 'odd';
			
				//echo $cat_name;
				echo '<tr>' . "\n";
				echo '<td class="'.$rowclass.'" style="width: 20px; text-align: center;">'. $cat_id .'</td>' . "\n";
				echo '<td class="'.$rowclass.'">'. $cat_name .'</td>' . "\n";
				echo '<td class="'.$rowclass.'" style="text-align: center;">{gallery|'. $cat_id .'}</td>' . "\n";
				echo '<td class="'.$rowclass.'" style="width: 40px; text-align: center;">'. $cat_sortorder .'</td>';
				echo '<td class="'.$rowclass.'" style="width: 40px; text-align: center;"><a href="'. $_SERVER['PHP_SELF'] .'?op=edit&amp;id='. $cat_id .'"><img src="../images/edit3.png" width="16" height="16" alt="" /></a></td>' . "\n";
				echo '<td class="'.$rowclass.'" style="width: 40px; text-align: center;"><a href="'. $_SERVER['PHP_SELF'] .'?op=del&amp;id='. $cat_id .'"><img src="../images/del3.png" width="16" height="16" alt="" /></a></td>' . "\n";
				echo '</tr>' . "\n";
			
				//$row_count++; 

			} // end while
		} else {
			echo "<tr><td colspan=\"6\" class=\"odd\"><p style=\"text-align: center; font-weight: bold;\">There are no categories/images to display.*</p></td></tr>";
		}
		echo "</table><br />";

		$type = "add";
		$formcaption = "Add category/gallery*";

		include_once("catform.inc.php");




xoops_cp_footer();
} // if

//---------------------------------------------------------------------------//
// Save new data.
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "savenew") {

	if(isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }
		else { $formdata = ""; }

		#echo "<pre>";
		#print_r($formdata);
		#echo "</pre>";
	
		$cat_desc	= $myts->addSlashes($formdata['description']);
		$cat_title	= $formdata['title'];
		
			$sql = "INSERT INTO ".$xoopsDB->prefix("amminigall_categories")." VALUES (
				NULL,
				'$cat_title',
				'$cat_desc',
				0,
				1
				)";

				if ($xoopsDB->query($sql)) {
					redirect_header("gallery.php", 2, _AMMGALL_GALLADDED);
				} else {
					redirect_header("gallery.php", 2, _AMMGALL_GALLADDFAIL);
				}	
	
} // if

//---------------------------------------------------------------------------//
//
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "edit") {
xoops_cp_header();
amminigall_adminmenu(3, _AMMGALL_NAVGALLERY);

	$sql = "SELECT * FROM " . $xoopsDB->prefix("amminigall_categories") . " WHERE cat_id=".intval($_GET['id'])." LIMIT 1 ";
	$result=$xoopsDB->query($sql);

		if ($xoopsDB->getRowsNum($result) > 0) {
			while($row = $xoopsDB->fetchArray($result)) {
				$cat_id		= $row['cat_id'];
				$cat_name	= $myts->htmlSpecialChars($row['cat_name']);
				$cat_desc	= $myts->htmlSpecialChars($row['cat_description']);
				
				
			}
		}


	$type = "edit";
	$formcaption = "Edit category/gallery*";

	include_once("catform.inc.php");

xoops_cp_footer();
}

//---------------------------------------------------------------------------//
// Save edited data.
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "saveedit") {

	if(isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }
		else { $formdata = ""; }

		echo "<pre>";
		print_r($formdata);
		echo "</pre>";
	
		$cat_id		= intval($formdata['cat_id']);
		$cat_desc	= $myts->addSlashes($formdata['description']);
		$cat_title	= $formdata['title'];
		
			$sql = "UPDATE ".$xoopsDB->prefix("amminigall_categories")." SET
				cat_id = '$cat_id',
				cat_name = '$cat_title',
				cat_description = '$cat_desc',
				cat_sortorder = 0,
				cat_showme = 1
				WHERE cat_id=".intval($cat_id)." ";

				if ($xoopsDB->query($sql)) {
					redirect_header("gallery.php", 2, _AMMGALL_GALLUP);
				} else {
					redirect_header("gallery.php", 2, _AMMGALL_GALLUPFAIL);
				}	

} // if

//---------------------------------------------------------------------------//
// Save edited data.
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "del") {
#xoops_cp_header();
#amminigall_adminmenu(3, _AMMGALL_NAVGALLERY);

	if (isset($_REQUEST['id'])) { $id = intval($_REQUEST['id']); }
		else { $id = ""; }

		/**
		 * Confirm deletion.
		 */
		if (!isset($_REQUEST['subop'])) {
			xoops_cp_header();
			xoops_confirm(array('op' => 'del', 'id' => $id, 'subop' => 'delok'), 'gallery.php', _AMMGALL_GALLCONFIRM);
			xoops_cp_footer();
		}
		/**
		 * Delete
		 */
		if (isset($_REQUEST['subop'])) {

			$sql = sprintf("DELETE FROM %s WHERE cat_id = %u", $xoopsDB->prefix("amminigall_categories"), $id);

			if ($xoopsDB->query($sql)) {
				redirect_header("gallery.php", 2, _AMMGALL_GALLDEL);
			} else {
				redirect_header("gallery.php", 2, _AMMGALL_GALLDELFAIL);
			} //
				
		}

#xoops_cp_footer();
}



?>