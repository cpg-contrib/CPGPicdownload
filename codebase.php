<?PHP
/**************************************************
  Coppermine Photo Gallery 1.4.9
  *************************************************
  CPGPicdownload Plugin 1.1
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
***************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

if (defined('DISPLAYIMAGE_PHP')){
  //  $thisplugin->add_filter('file_data','cpgpicdownload_file_data');
    $thisplugin->add_filter('file_info','cpgpicdownload_file_info');
}


$thisplugin->add_action('page_start','cpgpicdownload_pluginmgr');
$thisplugin->add_action('plugin_configure','cpgpicdownload_configure');

function cpgpicdownload_file_data($CURRENT_PIC_DATA) {
    global $CONFIG;
    $button = <<<EOT
      <a class="admin_menu" href="index.php?file=CPGPicdownload/picture&pid={$CURRENT_PIC_DATA['pid']}" title="Download">Download</a>
EOT;
    switch ($CONFIG['cpgpicdownload']) {
    	case 'admin':
    		if (!USER_IS_ADMIN) $button='';
    	case 'registered':
    		if (USER_ID == 0) $button='';
    }

    $CURRENT_PIC_DATA['menu'] = $button . $CURRENT_PIC_DATA['menu'];
    return $CURRENT_PIC_DATA;
}

function cpgpicdownload_file_info($info)
{
    global $CURRENT_PIC_DATA;
    $button = <<<EOT
    <a href="index.php?file=CPGPicdownload/picture&pid={$CURRENT_PIC_DATA['pid']}"><img src="plugins/CPGPicdownload/download5.gif" border= "0" alt="Download"/></a>
EOT;

	return array_merge(array('Download'=>$button),$info);
}

function cpgpicdownload_pluginmgr() {
    global $CONFIG;
    if (!isset($CONFIG['cpgpicdownload'])) cpgpicdownload_configure();
    if (isset($_GET['cpgpicdownload']) && GALLERY_ADMIN_MODE){
        switch ($_GET['cpgpicdownload']) {
        	case 'admin':
        		$setting='admin';
        		break;
        	case 'registered':
        		$setting="registered";
        		break;
        	default:
          //case 'anonymous':
                $setting="anonymous";
        		break;
        }
        $sql="UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '$setting' WHERE name = 'cpgpicdownload';";
        $CONFIG['cpgpicdownload']=$setting;
        cpg_db_query($sql);
    }
}

function cpgpicdownload_configure()
{
    global $CONFIG;
    if (!isset($CONFIG['cpgpicdownload'])){
        $setting='anonymous';
    	$sql="INSERT INTO {$CONFIG['TABLE_CONFIG']} VALUES ('cpgpicdownload','$setting');";
    	$CONFIG['cpgpicdownload']=$setting;
        cpg_db_query($sql);
        //The link is in the picture info now, lets make sure its on by default.
    	$sql="UPDATE {$CONFIG['TABLE_CONFIG']} SET value = 1 WHERE name = 'display_pic_info';";
        cpg_db_query($sql);
    }
}

?>
