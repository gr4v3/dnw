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
if (!function_exists('namelize')) {
    function namelize($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }
}
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }


// if not logged redirect to login.php
$cookiednwauth = filter_input(INPUT_COOKIE, 'dnw-auth');
if (!$cookiednwauth) {
    header('location: /admin/login.php');
}



$form = filter_input(INPUT_GET, 'form');
if (!empty($form)) {
    $page = filter_input(INPUT_GET, 'page');
    
    if ($page === 'history') {
        
        $text = filter_input(INPUT_POST, 'text');
        file_put_contents('../pages/history', '<article>' . $text . '</article>');

    } else if ($page === 'media') {
        $album = filter_input(INPUT_POST, 'album', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        if (!empty($_FILES['files'])) {
            $files = $_FILES['files'];
            $root = getcwd();
            
            
            if (!empty($album)) {
                $albumname = $album['name'];
                $gallery_folder = $root . '/../gallery/' . $album['name'];
            } else {
                $galleries = folder($root . '/../gallery');
                $albumname = 'album' . count($galleries->folders);
                $gallery_folder = $root . '/../gallery/' . $albumname;
            }
            
            
            if (!is_dir($gallery_folder)) mkdir($gallery_folder, 0755);
            foreach($files['name'] as $index => $item) {
                $name_exploded = explode('.', $files['name'][$index]);
                $name_extension = array_pop($name_exploded);
                $new_name = namelize(implode('', $name_exploded)) . '.' . $name_extension;
                move_uploaded_file($files['tmp_name'][$index], $gallery_folder . '/' . $new_name);
                
                $album['file'][$new_name] = 'Escreve uma descrição da foto aqui';
            }
            
            header('location: /admin/pages/album.php?index='.$albumname.'&mode=edit');
            
        }
        
        
        if (!empty($album)) {
            $name = $album['name'];
            file_put_contents("../gallery/$name/.info", json_encode($album));
        }
        
        
        
    } else if ($page === 'contacts') {
        
        $text = filter_input(INPUT_POST, 'text');
        file_put_contents('../pages/contacts', '<article>' . $text . '</article>');

    }
    
    
    die($page . ' submited!');
}