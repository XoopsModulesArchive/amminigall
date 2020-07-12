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

class files {
	
	/**
	 * Define variables.
	 */
	var $errors = array();
	
	/**
	 * Makes directory, and chmod it.
	 *
	 * @param unknown_type $file
	 * @param unknown_type $mode
	 * @return 
	 */
	function createDir($file, $mode=0777, $autocreate=0) {

		//echo $file;
		/**
		 * Check XOOPS's upload path exists.
		 */
		if (@is_writable(XOOPS_UPLOAD_PATH)) {
			// Check module's upload dir exists.
			if (!$this->checkFileExists($file, 1)) {
				// Try and create, and chmod.
				if ($this->mkDir($file, $mode)) {
					$this->chmodDir($file, $mode);
				} else {
					$this->setError("I was unable to create the file/directory: ".$this->sanitizePath($file));
				}
			} else {
				// If it's there, check if it's writable.
				if (!$this->checkWritable($file, 1)) {
					//echo "mod";
					$this->chmodDir($file, $mode);
				} 
			}
		} else {
			$this->setError("The XOOPS upload directory cannot be written to. Please make sure that it exists and can be written to by the server.");
			return false;
		}
	} // func

	/**
	* chmod a directory/file
	*/
	function chmodDir($path=false, $chmod="0755") {
		if (@chmod($path, $chmod)) {
			return true;
		} else {
			$this->setError("Unable to chmod file/directory: ".$this->sanitizePath($path));
			return false;
		}
	} // chmod	
	
	
	/**
	 * Check if directory/file exists, report yes or no.
	 * @param string $path 
	 * @param bool $quiet
	 */
	function checkFileExists($path=false, $quiet=0) {
		if (@file_exists($path)) {
			return true;
		} else {
			if (!$quiet) {
				$this->setError("File or Directory does not exist: ".$this->sanitizePath($path));
			}
			return false;
		}
	}
	
	/**
	 * Check if directory/file is writable, report yes or no.
	 */
	function checkWritable($path=false, $quiet=0) {
		if (@is_writable($path)) {
			return true;
		} else {
			if (!$quiet) {
				$this->setError("File or Directory is not writable: ".$this->sanitizePath($path));
			}
			return false;
		}
	}
	
	/**
	 * Create a directory
	 */
	function mkDir($path=false, $chmod=0755) {
		if (@mkdir($path, $chmod)) {
			return true;
		} else {
			$this->setError("Unable to create directory: ".$this->sanitizePath($path));
			return false;
		}
	}
	
	
	
	
	/**
	 * Sets errors to return.
	 *
	 * @param string $error
	 */
	function setError($error) {
		$this->errors[] = trim($error);
	}

	/**
	 * Get generated errors
	 * @param    bool    $ashtml Format using HTML?
	 * @return    array|string    Array of array messages OR HTML string
	 */
	function &getErrors($ashtml = true) {
		if (!$ashtml) {
			return $this->errors;
		} else {
			$ret = '';
			if (count($this->errors) > 0) {
				$ret = '<h4>Errors returned:</h4>';
				foreach ($this->errors as $error) {
					$ret .= $error.'<br />';
				}
			}
			return $ret;
		}
	} // getError
	
	
	/**
	 * Remove root path from output
	 * Borrowed from class/logger.php
	 */
	function sanitizePath( $path ) {
		$path = str_replace( 
			array( '\\', XOOPS_ROOT_PATH, str_replace( '\\', '/', realpath( XOOPS_ROOT_PATH ) ) ),
			array( '/', '', '' ),
			$path
		);		
		return $path;
	}
	
	
} // class







?>