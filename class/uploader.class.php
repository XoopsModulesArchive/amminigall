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

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}


class mediaUploader {


	function mediaUploader($uploadDir, $allowedMimeTypes, $maxFileSize=0, $maxWidth=null, $maxHeight=null) {
		//
		
		if (is_array($allowedMimeTypes)) {
			$this->allowedMimeTypes =& $allowedMimeTypes;
		}

		$this->uploadDir = $uploadDir;

		$this->maxFileSize = intval($maxFileSize);

		if (isset($maxWidth)) {
            $this->maxWidth = intval($maxWidth);
        }
        if (isset($maxHeight)) {
            $this->maxHeight = intval($maxHeight);
        }
        
	}
	
	function fetchMedia() {
		//
	}
	
	
}



?>