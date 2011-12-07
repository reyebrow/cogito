<?php
/*
Dynamic Dummy Image Generator - DummyImage.com
Copyright (c) 2011 Russell Heimlich

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

$x = strtolower($_GET["x"]); //GET the query string from the URL. x would = 600x400 if the url was http://dummyimage.com/600x400
$x_pieces = explode('/',$x);

include("color.class.php"); //To easily manipulate colors between different formats.

//Find the background color which is always after the 2nd slash in the url.
$bg_colorhex = explode('.',$x_pieces[1]);
$bg_colorhex = $bg_colorhex[0];
if (!$bg_colorhex || !ctype_xdigit($bg_colorhex) ) {
	$bg_colorhex = 'ccc'; //defaults to gray if no background color is set.
}
$background = new color();
$background->set_hex($bg_colorhex);

//Find the foreground color which is always after the 3rd slash in the url.
$fg_colorhex = explode('.',$x_pieces[2]);
$fg_colorhex = $fg_colorhex[0];
if (!$fg_colorhex) {
	$fg_colorhex = '000'; //defaults to black if no foreground color is set.
}
$foreground = new color();
$foreground->set_hex($fg_colorhex);

//Determine the file format. This can be anywhere in the URL.
//default to png
$file_format = 'png';
preg_match_all('/(png|jpg|jpeg)/', $x, $result);
if (isset($result[0][0]) ) {
    $file_format = $result[0][0];
}


//Find the image dimensions
if( substr_count($x_pieces[0], ':') > 1 ) {
	die('Too many colons in the dimension paramter! There should be 1 at most.');
}
if( strstr($x_pieces[0], ':') && !strstr($x_pieces[0], 'x') ) {
	die('To calculate a ratio you need to provide a height!');
}
$dimensions = explode('x',$x_pieces[0]); //dimensions are always the first paramter in the URL.

$width = preg_replace('/[^\d:\.]/i', '',$dimensions[0]); //Filters out any characters that are not numbers, colons or decimal points.
$height = $width;
if ($dimensions[1]) {
	$height = preg_replace('/[^\d:\.]/i', '',$dimensions[1]); //Filters out any characters that are not numbers, colons or decimal points.
}

if( $width < 1 || $height < 1 ) {
	die("Too small of an image!"); //If it is too small we kill the script.
}

//If one of the dimensions has a colon in it, we can calculate the aspect ratio. Chances are the height will contain a ratio, so we'll check that first.
if( preg_match ( '/:/' , $height) ) {
	$ratio = explode(':', $height);
	//If we only have one ratio value, set the other value to the same value of the first making it a ratio of 1.
	if ( !$ratio[1] ) {
		$ratio[1] = $ratio[0];
	}
	if ( !$ratio[0] ) {
		$ratio[0] = $ratio[1];
	}
	$height = ( $width * $ratio[1]) / $ratio[0];
	
} else if( preg_match ( '/:/' , $width) ) {
	$ratio = explode(':', $width);
	//If we only have one ratio value, set the other value to the same value of the first making it a ratio of 1.
	if ( !$ratio[1] ) {
		$ratio[1] = $ratio[0];
	}
	if ( !$ratio[0] ) {
		$ratio[0] = $ratio[1];
	}
	$width = ($height * $ratio[0]) / $ratio[1];
}

//Special Raised Eyebrow Stuff
if( preg_match ( '/reland/' , $x) ) {
  $re_special = 'reland';
}
elseif( preg_match ( '/video/' , $x) ) {
  $re_special = 'video';
}
elseif( preg_match ( '/bust/' , $x) ) {
  $re_special = 'bust';
}
else {
  $re_special = "";
}

$area = $width * $height;
if ($area >= 16000000 || $width > 9999 || $height > 9999) { //Limit the size of the image to no more than an area of 16,000,000.
	die("Too big of an image!"); //If it is too big we kill the script.
}

//Let's round the dimensions to 3 decimal places for aesthetics
$width = round($width, 3);
$height = round($height, 3);

$text_angle = 0; //I don't use this but if you wanted to angle your text you would change it here.

$font = "HelveticaLight.ttf"; // If you want to use a different font simply upload the true type font (.ttf) file to the same directory as this PHP file and set the $font variable to the font file name. I'm using the M+ font which is free for distribution -> http://www.fontsquirrel.com/fonts/M-1c

//RE Landscape
$img = imageCreate($width,$height); //Create an image.

$bg_color = imageColorAllocate($img, $background->get_rgb('r'), $background->get_rgb('g'), $background->get_rgb('b')); 

if (isset($_GET['text'])) {
	$_GET['text'] = preg_replace("#(0x[0-9A-F]{2})#e", "chr(hexdec('\\1'))", $_GET['text']); 
	$lines = substr_count($_GET['text'], '|');
	$text = preg_replace('/\|/i', "\n", $_GET['text']);
}
else {
	$lines = 1;
	if ($re_special==""){
	 $text = $width." x ".$height; //This is the default text string that will go right in the middle of the rectangle. &#215; is the multiplication sign, it is not an 'x'.	
	}
	else {
	 $text = " ";
  }
}

//Ric Ewing: I modified this to behave better with long or narrow images and condensed the resize code to a single line. 
//$fontsize = max(min($width/strlen($text), $height/strlen($text)),5); //scale the text size based on the smaller of width/8 or hieght/2 with a minimum size of 5.

$fontsize = max(min($width/strlen($text)*1.15, $height*0.5) ,5);

$fontsize = $fontsize > 60 ? 60 : $fontsize;

$textBox = imagettfbbox_t($fontsize, $text_angle, $font, $text); //Pass these variable to a function that calculates the position of the bounding box.

$textWidth = ceil( ($textBox[4] - $textBox[1]) * 1.07 ); //Calculates the width of the text box by subtracting the Upper Right "X" position with the Lower Left "X" position.

$textHeight = ceil( (abs($textBox[7])+abs($textBox[1])) * 1 ); //Calculates the height of the text box by adding the absolute value of the Upper Left "Y" position with the Lower Left "Y" position.

$textX = ceil( ($width - $textWidth)/2 ); //Determines where to set the X position of the text box so it is centered.
$textY = ceil( ($height - $textHeight)/2 + $textHeight ); //Determines where to set the Y position of the text box so it is centered.

$bordersize = $width > $height? $height* 0.1: $width*0.1;

//Special RE stuff
switch ($re_special) {
  case 'reland':
    $img = CroppedThumbnail('RE_landscape.png',$width,$height);
    $img = addBorderpng($img,$bordersize,$bg_colorhex);
    break;
  case 'video':
    $img = CroppedThumbnail('video.png',$width,$height);
    $img = addBorderpng($img,$bordersize,$bg_colorhex);
    break;
  case 'bust':
    $img = CroppedThumbnail('sil.png',$width,$height);
    break;
  default :
    imageFilledRectangle($img, 0, 0, $width, $height, $bg_color); //Creates the rectangle with the specified background color. http://us2.php.net/manual/en/function.imagefilledrectangle.php
    break;
}
   $fg_color = imageColorAllocate($img, $foreground->get_rgb('r'), $foreground->get_rgb('g'), $foreground->get_rgb('b')); 
   if ( function_exists('imagettftext') ) { 
    	imagettftext($img, $fontsize, $text_angle, $textX, $textY, $fg_color, $font, $text);	 //Create and positions the text http://us2.php.net/manual/en/function.imagettftext.php
		}

$offset = 60 * 60 * 24 * 14; //14 Days
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr); //Set a far future expire date. This keeps the image locally cached by the user for less hits to the server.
header('Cache-Control:	max-age=120');
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time() - $offset) . " GMT");
header('Content-type: image/'.$file_format); //Set the header so the browser can interpret it as an image and not a bunch of weird text.

//Create the final image based on the provided file format.
switch ($file_format) {
    case 'gif':
		imagegif($img);
    	break;
    case 'png':
	   imagepng($img);
        break;
	case 'jpg':
		imagejpeg($img);
		break;
	case 'jpeg':
		imagejpeg($img);
		break;
}


imageDestroy($img);//Destroy the image to free memory.


function LoadPNG($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefrompng($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a blank image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}


function addBorderpng($im, $border=1, $color='eee' ){

    $width=imagesx($im);
    $height=imagesy($im);
    $img_adj_width=$width-(2*$border); 
    $img_adj_height=$height-(2*$border);
    
    $newimage=imagecreatetruecolor($width,$height);


    $bg_color = new color();
    $bg_color -> set_hex($color);

    $background = imageColorAllocate($newimage, $bg_color->get_rgb('r'), $bg_color->get_rgb('g'), $bg_color->get_rgb('b')); 
    
    imagefilledrectangle($newimage,0,0,$width,$height,$background);
     imagecopyresampled($newimage,$im,$border,$border,0,0,$img_adj_width,$img_adj_height,$width,$height);
    imagedestroy($im);

    return $newimage;
}



function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
    //getting the image dimensions  
    list($width_orig, $height_orig) = getimagesize($imgSrc);   
    $myImage = imagecreatefrompng($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
    
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
    
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
    
    $process = imagecreatetruecolor(round($new_width), round($new_height)); 
    
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
}

 //Ruquay K Calloway http://ruquay.com/sandbox/imagettf/ made a better function to find the coordinates of the text bounding box so I used it.
function imagettfbbox_t($size, $text_angle, $fontfile, $text){
    // compute size with a zero angle
    if ( function_exists('imagettfbbox') ) {
    	$coords = imagettfbbox($size, 0, $fontfile, $text);
    }
    else {
    	$coords = $size;
    }
    
    
	// convert angle to radians
    $a = deg2rad($text_angle);
    
	// compute some usefull values
    $ca = cos($a);
    $sa = sin($a);
    $ret = array();
    
	// perform transformations
    for($i = 0; $i < 7; $i += 2){
        $ret[$i] = round($coords[$i] * $ca + $coords[$i+1] * $sa);
        $ret[$i+1] = round($coords[$i+1] * $ca - $coords[$i] * $sa);
    }
    return $ret;
}
?>