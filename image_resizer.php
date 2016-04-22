<?php
// Function for resizing jpg, gif, or png image files, only JPGs used by site
function img_resize($target, $newcopy, $width, $height, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($width / $height) > $scale_ratio) {
        $width = $height * $scale_ratio;
    } else {
        $height = $width / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){
        $img = imagecreatefromgif($target);
    } else if($ext =="png"){
        $img = imagecreatefrompng($target);
    } else {
        $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($width, $height);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $width, $height, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}
?>