<?php
function determine_memory_size($size) {
	$unit = array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
function delete_dir($path) {
    return is_file($path) ? @unlink($path) : array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}
function dir_to_jstree_array($dir) {
    $listDir = array(
        'data' => basename($dir),
        'attr' => array ('rel' => 'folder'),
        'metadata' => array ('id' => $dir),
        'children' => array()
    );
    $files = array();
    $dirs = array();
    if ($handler = opendir($dir)) {
        while (($sub = readdir($handler)) !== FALSE) {
            if ($sub != "." && $sub != "..") {
                if (is_file($dir."/".$sub)) {
                    $extension = pathinfo($dir."/".$sub, PATHINFO_EXTENSION);
                    $files []= $sub;
                } elseif (is_dir($dir."/".$sub)) {
                    $dirs []= $dir."/".$sub;
                }
            }
        }
        foreach ($dirs as $d) {
            $listDir['children'][] = dir_to_jstree_array($d);
        }
        foreach ($files as $file) {
            $listDir['children'][] = $file;
        }
        closedir($handler);
    }
    return $listDir;
}
function profiler($data = array()) {
	$html = '<div class="profiler"><span>Profiler</span><table>';
	foreach ($data as $key => $value) {
		$html .= '<tr><td><b>' . $key . '</b></td><td align="right">' . $value . '</td></tr>';
	}
	$html .= '</table></div>';
	return $html;
}
?>