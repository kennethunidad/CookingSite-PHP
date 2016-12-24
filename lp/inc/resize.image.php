<?php

function createImage($width,$height,$tmp,$path,$type){
		list($w,$h)=getimagesize($tmp);
		$ratio=max($width/$w,$height/$h);
		$h=ceil($height/$ratio);
		$x=($w-$width/$ratio)/2;
		$w=ceil($width/$ratio);
		$imgstring=file_get_contents($tmp);
		$image=imagecreatefromstring($imgstring);
		$ntmp=imagecreatetruecolor($width,$height);
		imagecopyresampled($ntmp,$image,
		0,0,
		$x,0,
		$width,$height,
		$w,$h);
		switch($type){
			    case 'image/jpeg':
      imagejpeg($ntmp, $path, 100);
      break;
    case 'image/png':
      imagepng($ntmp, $path, 0);
      break;
    case 'image/gif':
      imagegif($ntmp, $path);
      break;
    default:
      exit;
      break;
		}
		imagedestroy($image);
		imagedestroy($ntmp);
		return $path;
		
}

?>