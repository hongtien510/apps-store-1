<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author root
 */
class App_Utils_Util {

    public static function hashFileName($filename, $time) {
        $name = $filename;
        $type = '';
        $split = strrpos($filename, ".");
        if ($split == true) {
            $name = substr($filename, 0, $split);
            $name = md5($name);
            $type = substr($filename, $split);
        }
        $fileondisk = $name . "_" . $time . $type;
        return array($fileondisk, substr($type, 1));
    }

    public static function uploadFile($file) {
        $time = time();
        $date = date("Y-m-d H", $time);
        $arr = split("[-,:, ]", $date);
        $str = implode("/", $arr);

        $rs = self::hashFileName($file['name'], $time);
        $nameondisk = $rs[0];
        $type = strtolower($rs[1]);

        $path = $str . '/' . $nameondisk;

        if (true) { // chech file type
            if (!is_dir(PATH_UPLOAD . '/' . $str))
                mkdir(PATH_UPLOAD . '/' . $str, 0775, true);

            $success = App_Utils_Util::resizeImage($file['tmp_name'], PATH_UPLOAD . '/' . $path);
//            $success = move_uploaded_file($file['tmp_name'], PATH_UPLOAD . '/' . $path);

            if ($success) {
                return $path;
            }
        }
        return '';
    }

    public static function resizeImage($file, $path) {
        $imageInfo = getimagesize($file);
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $extension = $imageInfo[2];

        /*
         * 
         */
        $new_width = $width;
        $new_height = $height;

        if ($new_width > IMAGE_WIDTH) {
            $new_width = IMAGE_WIDTH;
            $new_height = ($new_width * $height) / $width;
        }
        if ($new_height > IMAGE_HEIGHT) {
            $new_height = IMAGE_HEIGHT;
            $new_width = ($new_height * $width) / $height;
        }

        if ($extension == IMAGETYPE_JPEG) {
            $src = imagecreatefromjpeg($file);
        } else if ($extension == IMAGETYPE_PNG) {
            $src = imagecreatefrompng($file);
        } else {
            $src = imagecreatefromgif($file);
        }

        $tmp1 = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $result = imagejpeg($tmp1, $path);
        imagedestroy($src);
        imagedestroy($tmp1);
        return $result;
    }

}
