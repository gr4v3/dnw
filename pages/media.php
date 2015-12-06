<?php
function folder($path = NULL) {
    if (empty($path)) return FALSE;
    $content = new stdClass;
    $content->folders = array();
    $content->files = array();
    $content->info = new stdClass;
    $content->info->description = '';
    $content->info->files = array();
    $content->info->deleted = FALSE;
    if ($handle = opendir($path)) {
        /* This is the correct way to loop over the directory. */
        while (false !== ($entry = readdir($handle))) {
            if (!in_array($entry, array('..','.','index.html'))) {
                if (is_dir($path.'/'.$entry)) {
                    $content->folders[$entry] = folder($path.'/'.$entry);
                } else if (is_file($path.'/'.$entry)) {
                    if (preg_match('/\.(png|jpg|gif|jpeg|tif)/i', $entry)) {
                        $content->files[] = $entry;
                    } else $content->files[$entry] = file_get_contents($path.'/'.$entry);
                } 
            }
        }
        if (!isset($content->files['.info'])) {
            file_put_contents($path . '/.info', json_encode($content->info));
        } else if (!empty($content->files['.info'])) {
            $content->info = json_decode($content->files['.info']);
            unset($content->files['.info']);
        }
        
    }
    return $content;
}
function Debug($content = '') { 
    echo '<pre>'.print_r($content, TRUE).'</pre>';
}
$gallery = folder('../gallery');

$media = array('<div class="gallery container-fluid">');
foreach($gallery->folders as $index => $folder) {
    $album = array('<div data-content="'.$folder->info->description.'" class="album col-xs-12 col-md-3 col-lg-4" align="center">');
    $files_reversed = array_reverse($folder->files);
    foreach($folder->files as $img) {
        $label = isset($folder->info->file->{$img})?$folder->info->file->{$img}:'';
        $album[] = '<div class="item"><label>'.$label.'</label><div class="img" style="background-image:url(/img-360-auto/gallery/'.$index.'/'.$img.');"></div></div>';
    }
    $album[] = '</div>';
    $media[] = implode('', $album);
}
$media[] = '</div>';
die(implode('', $media));
