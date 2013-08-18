<?php
/**
 * resize_image_djzm.php
 *
 * 生成一个白底的图片(假定200x200)，将原始图片保持长宽比缩小后较长的一边刚好和白底一样长。
 * 然后将处理后的图片放到白底的中间
 *
 * author   liuzhengyi@ppstream.com
 * since    2013-06-20
 *
 */
    function resizeimage($src_file, $dst_file, $newwidth=200, $newheight=200){
        $type_arr = array( 1 => 'gif', 2 => 'jpeg', 3 => 'png',);
        list($width, $height, $type) = getimagesize($src_file);
        // todo check $newwidth and $newheight
        if(!array_key_exists($type, $type_arr)) {
            exit('image type not support');
        }
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $back = imagecolorallocate($thumb, 255, 255, 255);
        imagefilledrectangle($thumb, 0, 0, $newwidth, $newheight, $back);
        switch($type_arr[$type]) {
            case 'gif':
                $source = imagecreatefromgif($src_file);
                break;
            case 'jpeg':
                $source = imagecreatefromjpeg($src_file);
                break;
            case 'png':
                $source = imagecreatefrompng($src_file);
                break;
            default:
                exit('not support type');
                break;
        }

        // resize image
        //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        if($width > $height) {
            $dst_w = $newwidth;
            $dst_h = $dst_w*$height/$width;
            $dst_x = 0;
            $dst_y = ($newheight - $dst_h)/2;
        } else {
            $dst_h = $newheight;
            $dst_w = $dst_h*$width/$height;
            $dst_x = ($newwidth- $dst_w)/2;
            $dst_y = 0;
        }
        imagecopyresized($thumb, $source, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $width, $height);
        switch($type_arr[$type]) {
            case 'gif':
                imagegif($thumb, $dst_file);
                break;
            case 'jpeg':
                imagejpeg($thumb, $dst_file);
                break;
            case 'png':
                imagepng($thumb, $dst_file);
                break;
            default:
                break;
        }
    }

/*
$resizeimage = new m;
$src_file = '210x280.jpg';
$src_file = 'http://s1.ppsimg.com/baike/book/cover/1/43171.jpg';
$src_file = 'http://s1.ppsimg.com/baike/book/cover/1/74383.jpg';
$src_file = 'http://f.hiphotos.baidu.com/album/pic/item/8644ebf81a4c510f548968bc6159252dd52aa5c3.jpg';
$src_file = 'gougou.jpg';
$src_file = 'maomi.jpg';
$src_file = 'shaoyao.jpg';
$src_file = 'maomi.jpg';
$src_file = '210x280.jpg';
//$src_file = 'hehua.jpg';
//$resizeimage->resizeimage($src_file, 'test.jpg');
//$resizeimage->resizeimage($src_file, 'test.jpg');
*/
?>
