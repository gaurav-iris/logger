<?php
App::uses('AppController', 'Controller');

class ToolsController extends AppController{
    
    var $cacheDir = 'cache';
    var $uploadDir = 'uploads';
    public function getimage($slug,$h='',$w=''){
        $this->loadModel('Screenshot');
        $this->Screenshot->recursive = -1;
        $screenshot = $this->Screenshot->findBySlug($slug);
        if($screenshot){
            header("Content-type: image/jpeg");
//            $image=imagecreatefromjpeg(WWW_ROOT.$screenshot['Screenshot']['path'].$screenshot['Screenshot']['image']);
//            imagejpeg($image);
//            print_r($screenshot);
            $file = $this->resize(WWW_ROOT.$screenshot['Screenshot']['path'].$screenshot['Screenshot']['image'], $h,$w);
//            echo WWW_ROOT.$file;
            imagepng(imagecreatefrompng(WWW_ROOT.$file));
            exit;
        }
    }
        
   function resize($path, $dst_w, $dst_h, $htmlAttributes = array(), $return = false) { 
         
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type 
         
//        $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.IMAGES_URL; 
     
        $url = $path; 
        
        list($w, $h, $type) = getimagesize($url);
        $r = $w / $h;
        $dst_r = $dst_w / $dst_h;
        
        if ($r > $dst_r) {
            $src_w = $h * $dst_r;
            $src_h = $h;
            $src_x = ($w - $src_w) / 2;
            $src_y = 0;
        } else {
            $src_w = $w;
            $src_h = $w / $dst_r;
            $src_x = 0;
            $src_y = ($h - $src_h) / 2;
        }

        $relfile = $this->cacheDir.'/'.$dst_w.'x'.$dst_h.'_'.basename($path); // relative file 
        $cachefile = WWW_ROOT.$relfile;
         
        if (file_exists($cachefile)) {
            if (@filemtime($cachefile) >= @filemtime($url)) {
                $cached = true;
            } else {
                $cached = false;
            }
        } else { 
            $cached = false; 
        } 
         
        if (!$cached) {
            $image = call_user_func('imagecreatefrom'.$types[$type], $url); 
            if (function_exists("imagecreatetruecolor")) {
                $temp = imagecreatetruecolor($dst_w, $dst_h); 
                imagecopyresampled($temp, $image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h); 
            } else { 
                $temp = imagecreate ($dst_w, $dst_h); 
                imagecopyresized($temp, $image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h); 
            } 
            call_user_func("image".$types[$type], $temp, $cachefile); 
            imagedestroy($image); 
            imagedestroy($temp); 
        }

        return $relfile;
    }
    
    public function upload(){
        $name = $_SERVER['HTTP_X_FILE_NAME'];
        $path = $this->getUploadDir();
        $dest = $path['destination'] . $name;
        file_put_contents($dest, (file_get_contents('php://input')));
        
        die(json_encode(array('file'=>$path['folder'].$name)));
    }
    
    public function getUploadDir(){
        $year = date('Y');
        $month = date('m');
        $root = WWW_ROOT;
        $upload_path =  $this->uploadDir;
        $folder = $this->uploadDir . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR;
        $upload_folder = $root . $folder;
        if(!is_dir($upload_folder))
        mkdir($upload_folder,0777,true);
        return array(
            'root'=>$root,
            'uploads'=>$upload_path,
            'folder'=>$folder,
            'destination'=>$upload_folder
        );
    }
}
