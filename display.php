<?php


class gallery {
#class gallery extends MyTextSanitizer {

	function display($text) {
    
		#$text = "<p><i>test text and stuff</i></p>";
      
	  	#$stuff = "<p><i>test text and stuff</i></p>";
	  	
		if (preg_match("/\{gallery\|\d\}/", $text, $matches)) {
			$matches = preg_replace("/\{|\}/", '', $matches[0]);
			$matches = explode("|", $matches);
			#print_r($matches[1]);
			#print_r($matches[0]);
			#print_r($matches);
		}
	  	
		#$stuff = $gallery->gallery($matches[1]);
		$stuff = $this->galldata($matches['1']);
      
		$text = preg_replace("/\{gallery\|\d\}/", $stuff, $text);
      
		#echo $text;
      
		return $text;
  
	}


	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	function galldata($id=0) {
		global $xoopsDB, $xoopsModule; //, $amcmsConfig;

		//$display = "wibble " .$id;
		$display = "";
		
		$sql = "SELECT * FROM " . $xoopsDB->prefix("amminigall_images") . " WHERE img_catid = '".intval($id)."' AND img_showme = '1' ORDER by img_weight ASC, img_date_added DESC";
		$result=$xoopsDB->query($sql);

		$numresults=$xoopsDB->query($sql);
		$number_of_images = $xoopsDB->getRowsNum($result);
		$numrows = $number_of_images;
		
			
			$columns = 3; //TODO: set in prefs $amcmsConfig['columns'];  
			$colcount = 1;
			//$display .= "<div class=\"imgblockcontainer\">";
			// TODO: make user add the JS/CSS to theme header
			$display .= '
	<script type="text/javascript" src="/modules/amminigall/include/lightbox2/js/prototype.js"></script>
	<script type="text/javascript" src="/modules/amminigall/include/lightbox2/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="/modules/amminigall/include/lightbox2/js/lightbox.js"></script>
	<link rel="stylesheet" href="/modules/amminigall/include/lightbox2/css/lightbox.css" type="text/css" media="screen" />
			';
			$display .= "<table border=\"0\" style=\"width: auto; margin-left: auto; margin-right: auto;\"><tr>";
			if ($xoopsDB->getRowsNum($result) > 0) {
				while($row = $xoopsDB->fetchArray($result)) {
			
					//$img_id				= $row['img_id'];
					//$img_filename_photo	= $row['img_filename_photo'];
					//$img_filename_thumb	= $row['img_filename_thumb'];
					//$img_thumb_width	= $row['img_thumb_width'];
					//$img_thumb_height	= $row['img_thumb_height'];
					//$img_title			= $textSanitizer->prepText4Display($row['img_title']);
					//$img_photo_width	= $row['img_photo_width'];
					//$img_photo_height	= $row['img_photo_height'];
					//$img_filesize_bytes	= $row['img_filesize_bytes'];
					//$img_date_added		= $row['img_date_added'];
				
					// TODO: do something about module dir name for cloning? (needs to be hard coded as called from various modules)
					$display .= "<td valign=\"top\"><a href=\"".XOOPS_UPLOAD_URL."/amminigall/".$row['img_filename_photo']."\" rel=\"lightbox[".$id."]\" title=\"".$row['img_title']."\"><img src=\"".XOOPS_UPLOAD_URL."/amminigall/thumbs/". $row['img_filename_thumb'] ."\" width=\"".$row['img_thumb_width']."\" height=\"".$row['img_thumb_height']."\" alt=\"".$row['img_title']."\" border='0' /></a></td>";
				
					#$colcount++;
					if  ($colcount == $columns) {
						//$display .= "<!-- </tr><tr>--><br />";
						$display .= "</tr>\n<tr>\n";
						$colcount = 0; 
					}
					$colcount++;
				}
			} else {
				$display .= "<p style=\"text-align: center;\">Sorry, there are currently no images to display.*</p>";
			}
			//$display .= "</div>";
			$display .= "</tr></table>";
		

		return $display;
	}
	
	
}



?>