<?php
/* ----------------------------------------------------------------
DYNAMIC IMAGE RESIZING SCRIPT - V2
The following script will take an existing JPG image, and resize it
using set options defined in your .htaccess file (while also providing
a nice clean URL to use when referencing the images)
Images will be cached, to reduce overhead, and will be updated only if
the image is newer than it's cached version.

The original script is from Timothy Crowe's 'veryraw' website, with
caching additions added by Trent Davies:
http://veryraw.com/history/2005/03/image-resizing-with-php/

Further modifications to include antialiasing, sharpening, gif & png 
support, plus folder structues for image paths, added by Mike Harding
http://sneak.co.nz

For instructions on use, head to http://sneak.co.nz
---------------------------------------------------------------- */

// max_width and image variables are sent by htaccess
$max_height = 1000;
$image = filter_input(INPUT_GET, 'imgfile');
$width = filter_input(INPUT_GET, 'width');
$height = filter_input(INPUT_GET, 'height');
//$root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$root = '.';

if (strrchr($image, '/')) {
	$filename = substr(strrchr($image, '/'), 1); // remove folder references
} else {
	$filename = $image;
}
if (!is_file($image)) {
    $filename = '404.png';
    $image = imagecreate( 200, 80 );
    $background = imagecolorallocate( $image, 0, 0, 255 );
    $text_colour = imagecolorallocate( $image, 255, 255, 0 );
    $line_colour = imagecolorallocate( $image, 128, 255, 0 );
    imagestring( $image, 4, 30, 25, "404 image admedia", $text_colour );
    imagesetthickness ( $image, 5 );
    imageline( $image, 30, 45, 165, 45, $line_colour );
    imagepng($image, 'cache/' . $filename);
    $image = 'cache/' . $filename;
    
}
function Debug($content, $die = FALSE, $log = FALSE, $js = FALSE) {
    $get_debug = filter_input(INPUT_GET, 'debug');
    $cookie_debug = filter_input(INPUT_COOKIE, 'debug');
    if (isset($get_debug)) {
        $expire=time()+60*60*24*30;
        setcookie('debug',$get_debug, $expire);
    }
    if ($cookie_debug && $cookie_debug == 1) {
        if ($log) {
            $filename = $log . '_' . date('Y-m-d', time()) . '.log';
            $handle = fopen(JPATH_ROOT . '/logs/' . $filename, 'a');
            fwrite($handle, $content. "\n\r");
            fclose($handle);
        } else if ($js) {
            echo '<script type="text/javascript">console.log('.json_encode($content).')</script>';
        } else echo '<pre>'.print_r($content, TRUE).'</pre>';  
        if ($die) die();
    } else if ($cookie_debug == 0) setcookie("debug", "", time()-3600);
}
include_once 'SimpleImage.php';
if (is_file("cache/$width-$height-$filename")) {
    
    $img = new SimpleImage($root . "/cache/$width-$height-$filename");
    $info = $img->get_original_info();
    header("Content-type: " . $info['mime']);
    die(file_get_contents($root . "/cache/$width-$height-$filename"));
} 
try {
    $img = new SimpleImage($root. '/' .$image);
    $img->quality = 100;
    if ($width === 'auto') $img->fit_to_height($height);
    else if ($height === 'auto') $img->fit_to_width($width);
    else $img->best_fit($width, $height);
    $img->save("cache/$width-$height-$filename");
    $img->output();
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage();
}