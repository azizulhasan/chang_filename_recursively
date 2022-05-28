<?php
/**
 * @param path of dir
 */
function listFolderFiles($dir){
    $ffs = scandir($dir);
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    if (count($ffs) < 1)
        return;

    foreach($ffs as $ff){
        if(is_dir($dir.'/'.$ff)) {
            if($ff != 'vendor'){
                listFolderFiles($dir.'/'.$ff);
            }
        }else{
            $newName = str_replace('woo-invoice', 'challan', $ff);
            rename($dir.'/'.$ff, $dir.'/'.$newName);
        }
    }
}

listFolderFiles('plugin');
?>