<?php
App::uses('AppModel', 'Model');
class Tool extends AppModel{
    

    var $helpers = array('Html');
    
    var $cacheDir = 'c'; // relative to IMAGES_URL path
    
    function resize($path, $width='', $height=false,  $crop = false,  $autocrop = false,$cropvars = array()) {
        
        $aspect = false;
        
        $dir = substr(md5(substr($path,0,strripos($path,DIRECTORY_SEPARATOR))),0,6);
        
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
        
        
        //$url = $fullpath.$path;
        $url = WWW_ROOT . $path;
        
        
        if (!($size = getimagesize($url))) 
            return; // image doesn't exist

        
        $ratio = $size[0]/$size[1];
        if(!$height){
            $height = round((float)$ratio*(float)$width);
        }
        if(!$width){
            $width = $ratio*$height;
        }      
        
        if($autocrop)
        {
            $multiplier = 1.0;
            while(($width*$multiplier<$size[0]) && ($height*$multiplier<$size[1]))
            {
                $multiplier += .01;
            }
            
            // make SURE we don't run over
            $multiplier -= .01;
            
            $cropw = floor($width * $multiplier);
            $croph = floor($height * $multiplier);
            
            //echo("$cropw $croph $width $height $multiplier $size[0] $size[1] <br />");
            ///die();
            
            $xindent = ($size[0] - $cropw)/2.0;
            $yindent = ($size[1] - $croph)/2.0;
            
            $startx = floor($xindent);
            $endx = $size[0] - ceil($xindent);
            
            $starty = floor($yindent);
            $endy = $size[1] - ceil($yindent);
            
            //echo("$xindent, $yindent -> leads to: $startx, $starty start and $endx, $endy end");
            //die();
            
            $cropvars = array($startx, $starty, $endx, $endy);
        }
        
        if(($width > $size[0] || $height > $size[1]) && $autocrop)
        {
            
            $multiplier = 1.0;
            while(($width*$multiplier>=$size[0]) || ($height*$multiplier>=$size[1]))
            {
                $multiplier -= .01;
            }
            
            $cropw = floor($width * $multiplier);
            $croph = floor($height * $multiplier);
            
            //echo("$cropw $croph $width $height $multiplier $size[0] $size[1] <br />");
            ///die();
            
            $xindent = ($size[0] - $cropw)/2.0;
            $yindent = ($size[1] - $croph)/2.0;
            
            $startx = floor($xindent);
            $endx = $size[0] - ceil($xindent);
            
            $starty = floor($yindent);
            $endy = $size[1] - ceil($yindent);
            
            //echo("$xindent, $yindent -> leads to: $startx, $starty start and $endx, $endy end");
            //die();
            
            $cropvars = array($startx, $starty, $endx, $endy);
            
        }
        
        // check that user supplied full start and stop coordinates
        if(sizeof($cropvars)==4) 
        {
            if($cropvars[0] > $size[0] || $cropvars[1] > $size[1] || $cropvars[2] > $size[0] || $cropvars[3] > $size[1] || $cropvars[0] < 0 || $cropvars[1] < 0 || $cropvars[2] < 0 || $cropvars[3] < 0)
            {
                $crop = false;
            }
        }
        else
        {
            $crop = false;
        }
        
        // temporarily set size to this for aspect checking
        if($crop)
        {
            $tempsize = array($size[0], $size[1]);
            $size[0] = $cropvars[2]-$cropvars[0];
            $size[1] = $cropvars[3]-$cropvars[1];
        }
        
        if ($aspect) { // adjust to aspect
            if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
                $width = ceil(($size[0]/$size[1]) * $height);
            else 
                $height = ceil($width / ($size[0]/$size[1]));
        }
        
        // set size back
        if($crop)
        {
            $size[0] = $tempsize[0];
            $size[1] = $tempsize[1];
        }
        
        if($crop)
        {
            $cropstring = $cropvars[0] . $cropvars[1] . $cropvars[2] . $cropvars[3] . '_';
        }
        else
        {
            $cropstring = '';
        }
        if(!is_dir(WWW_ROOT.$this->cacheDir.'/'.$dir)){
            mkdir(WWW_ROOT.$this->cacheDir.'/'.$dir,0777,true);
        }
        $relfile = $this->cacheDir.'/'.$dir.'/'.$width.'x'.$height.'_'.$cropstring.basename($path); // relative file
        $cachefile = WWW_ROOT.$this->cacheDir.'/'.$dir.DS.$width.'x'.$height.'_'.$cropstring.basename($path);  // location on server
        
        if (file_exists($cachefile)) {
            $csize = getimagesize($cachefile);
            $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
            if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
                $cached = false;
        } else {
            $cached = false;
        }
        
        if (!$cached) {
            $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
        } else {
            $resize = false;
        }
        
        if ($resize) {
            $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
            
            if($crop){
                if (function_exists("imagecreatetruecolor") && ($tempcrop = imagecreatetruecolor ($cropvars[2]-$cropvars[0], $cropvars[3]-$cropvars[1]))) {
                imagecopyresampled ($tempcrop, $image, 0, 0, $cropvars[0], $cropvars[1], $cropvars[2]-$cropvars[0], $cropvars[3]-$cropvars[1], $cropvars[2] - $cropvars[0], $cropvars[3]-$cropvars[1]);
              } else {
                $temp = imagecreate ($cropvars[2]-$cropvars[0], $cropvars[3]-$cropvars[1]);
                imagecopyresized ($tempcrop, $image, 0, 0, $cropvars[0], $cropvars[1], $cropvars[2]-$cropvars[0], $cropvars[3]-$cropvars[1], $size[0], $size[1]);
            }
            
            $image = $tempcrop;
            $size[0] = $cropvars[2] - $cropvars[0];
            $size[1] = $cropvars[3] - $cropvars[1];
            }
            
            
            
                
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
                imagealphablending( $temp, false );
            imagesavealpha( $temp, true );
                imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
              } else {
                $temp = imagecreate ($width, $height);
                imagealphablending( $temp, false );
            imagesavealpha( $temp, true );
                imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            }
            if($types[$size[2]]=="jpeg"){
                imagejpeg($temp, $cachefile, 90);
            }if($types[$size[2]]=="png"){
                imagepng($temp,$cachefile,9);
            }else{
                call_user_func("image".$types[$size[2]], $temp, $cachefile);
            }
            imagedestroy ($image);
            imagedestroy ($temp);
        }         
        return $relfile;
    }
    
    //resize and crop image by center
        function crop($source_file, $max_width, $max_height, $quality = 80){
            $imgsize = getimagesize($source_file);
            $width = $imgsize[0];
            $height = $imgsize[1];
            $mime = $imgsize['mime'];
            $dir = substr(md5(substr($source_file,0,strripos($source_file,DIRECTORY_SEPARATOR))),0,6);
            if(!is_dir(WWW_ROOT.$this->cacheDir.'/'.$dir)){
                mkdir(WWW_ROOT.$this->cacheDir.'/'.$dir,0777,true);
            }
//            $dst_dir = $this->cacheDir.$source_file;
            $dst_dir = $this->cacheDir.'/'.$dir.'/'.$max_width.'x'.$max_height.'_'.basename($source_file); // relative file
            if(file_exists(WWW_ROOT . $dst_dir)){
                return $dst_dir;
            }
            switch($mime){
                case 'image/gif':
                    $image_create = "imagecreatefromgif";
                    $image = "imagegif";
                    break;

                case 'image/png':
                    $image_create = "imagecreatefrompng";
                    $image = "imagepng";
                    $quality = 7;
                    break;

                case 'image/jpeg':
                    $image_create = "imagecreatefromjpeg";
                    $image = "imagejpeg";
                    $quality = 80;
                    break;

                default:
                    return false;
                    break;
            }

            $dst_img = imagecreatetruecolor($max_width, $max_height);
            $src_img = $image_create($source_file);

            $width_new = $height * $max_width / $max_height;
            $height_new = $width * $max_height / $max_width;
            //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
            if($width_new > $width){
                //cut point by height
                $h_point = (($height - $height_new) / 2);
                //copy image
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
            }else{
                //cut point by width
                $w_point = (($width - $width_new) / 2);
                imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
            }

            $image($dst_img, $dst_dir, $quality);

            if($dst_img)imagedestroy($dst_img);
            if($src_img)imagedestroy($src_img);
            return $dst_dir;
        }
}
