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

$name='CPGPicdownload';
$description='Adds a link to the intermediate image page to download the full size picture.';
$author='Donnoman@donovanbray.com from <a href="http://cpg-contrib.org" target="_blank">cpg-contrib.org</a> and Jared Hatfield';
$version='1.1';

$install_info=<<<EOT
    <form method="get" action="pluginmgr.php"style="margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;display:inline">
    <label for="CPGPicdownload">Available to:</label>
    <select name="CPGPicdownload" class="listbox_lang" onchange="if (this.options[this.selectedIndex].value) window.location.href='pluginmgr.php?cpgpicdownload=' + this.options[this.selectedIndex].value;">
EOT;
    global $CONFIG;

    if (!isset($CONFIG['cpgpicdownload'])) {
    	$CONFIG['cpgpicdownload']='anonymous';
    }
    foreach (array('anonymous','registered','admin') as $value) {
        $selected='';
        $display=ucfirst($value);
        if ($CONFIG['cpgpicdownload']==$value) {
            $selected='selected="selected"';
        }
        $install_info.=<<<EOT
    	<option value="$value" $selected>$display</option>
EOT;
    }
$install_info.=<<<EOT
    </select>
    </form>
EOT;

?>