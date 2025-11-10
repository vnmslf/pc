<?php
namespace Tools;
/**
 * Class ImgHelper
 */
class ImgHelper
{
    public static function getWebpUrl($defaultImgUrl) {
        $new_extension = 'webp';
        $filename_from_url = parse_url($defaultImgUrl);
        $info = pathinfo($filename_from_url['path']);
        return $info['dirname'].'/'.$info['filename'].'.'.$new_extension;
    }

    public static function webpConvert2($file, $compression_quality = 80) {
        if (!file_exists($file)) {
            return false;
        }
        $file_type = exif_imagetype($file);
        $output_file = self::getWebpUrl($file);
        if (file_exists($output_file)) {
            return $output_file;
        }
        if (function_exists('imagewebp')) {
            switch ($file_type) {
                case '1':
                    $image = imagecreatefromgif($file);
                    break;
                case '2':
                    $image = imagecreatefromjpeg($file);
                    break;
                case '3':
                    $image = imagecreatefrompng($file);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
                case '6':
                    $image = imagecreatefrombmp($file);
                    break;
                case '15':
                    return false;
                    break;
                case '16':
                    $image = imagecreatefromxbm($file);
                    break;
                default:
                    return false;
            }
            $result = imagewebp($image, $output_file, $compression_quality);
            if (false === $result) {
                return false;
            }
            imagedestroy($image);
            return $output_file;
        } elseif (class_exists('Imagick')) {
            $image = new Imagick();
            $image->readImage($file);
            if ($file_type === "3") {
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($compression_quality);
                $image->setOption('webp:lossless', 'true');
            }
            $image->writeImage($output_file);
            return $output_file;
        }
        return false;
    }

    public static function webpConvert3($file, $compression_quality) {
        if (!file_exists($file)) {
            return false;
        }
        $file_type = exif_imagetype($file);
        $output_file = self::getWebpUrl($file);
        if (file_exists($output_file)) {
            $dir = pathinfo($output_file, PATHINFO_DIRNAME);
            $name = pathinfo($output_file, PATHINFO_FILENAME);
            $destination = $dir.DIRECTORY_SEPARATOR.$name.'.webp';
            $im = imagecreatefromstring(file_get_contents($file));
            //pre($file);
            imagewebp($im, $destination, $compression_quality);
            imagedestroy($im);
            return $destination;
        }
        if (function_exists('imagewebp')) {
            switch ($file_type) {
                case '1':
                    $image = imagecreatefromgif($file);
                    break;
                case '2':
                    $image = imagecreatefromjpeg($file);
                    break;
                case '3':
                    $image = imagecreatefrompng($file);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
                case '6':
                    $image = imagecreatefrombmp($file);
                    break;
                case '15':
                    return false;
                    break;
                case '16':
                    $image = imagecreatefromxbm($file);
                    break;
                default:
                    return false;
            }
            $result = imagewebp($image, $output_file, $compression_quality);
            if (false === $result) {
                return false;
            }
            imagedestroy($image);
            return $output_file;
        } elseif (class_exists('Imagick')) {
            $image = new Imagick();
            $image->readImage($file);
            if ($file_type === "3") {
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($compression_quality);
                $image->setOption('webp:lossless', 'true');
            }
            $image->writeImage($output_file);
            return $output_file;
        }
        return false;
    }

    
    public static function resizeImg($imgUrl, $w, $h) {
        $imgPath = self::getImgPath($imgUrl);
        $imgPath = str_replace('//', '/', $imgPath);

        if (!file_exists($imgPath)) {
            return false;
        }

        $resizedImgUrl = self::getResizedImgUrl($imgUrl, $w);
        $resizedImgPath = self::getImgPath($resizedImgUrl);

        if (file_exists($resizedImgPath)) {
            return $resizedImgUrl;
        }

        $info = getimagesize($imgPath);
        $width = $info[0];
        $height = $info[1];
        $type = $info[2];

        switch ($type) {
            case 1:
                $img = imageCreateFromGif($imgPath);
                imageSaveAlpha($img, true);
                break;
            case 2:
                $img = imageCreateFromJpeg($imgPath);
                break;
            case 3:
                $img = imageCreateFromPng($imgPath);
                imageSaveAlpha($img, true);
                break;
        }

        /*if (empty($w)) {
            $w = ceil($h / ($height / $width));
        }
        if (empty($h)) {
            $h = ceil($w / ($width / $height));
        }*/
        if ($w < $h) {
            $w = ceil($h / ($height / $width));
        } else {
            $h = ceil($w / ($width / $height));
        }

        $tmp = imageCreateTrueColor($w, $h);
        if ($type == 1 || $type == 3) {
            imagealphablending($tmp, true);
            imageSaveAlpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
            imagefill($tmp, 0, 0, $transparent);
            imagecolortransparent($tmp, $transparent);
        }

        $tw = ceil($h / ($height / $width));
        $th = ceil($w / ($width / $height));
        if ($tw < $w) {
            imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);
        } else {
            imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);
        }

        $img = $tmp;

        switch ($type) {
            case 1:
                imageGif($img, $resizedImgPath);
                break;
            case 2:
                imageJpeg($img, $resizedImgPath, 90);
                break;
            case 3:
                imagePng($img, $resizedImgPath);
                break;
        }
        imagedestroy($img);

        return $resizedImgUrl;
    }
    protected static function getImgPath($imgUrl) {
        return $_SERVER['DOCUMENT_ROOT'].$imgUrl;
    }
    protected static function getResizedImgUrl($imgUrl, $w) {
        $filename_from_url = parse_url($imgUrl);
        $info = pathinfo($filename_from_url['path']); // dirname, basename, extension, filename
        //return $info['dirname'].'/'.$info['filename'].'-'.$w.'.'.$info['extension'];
        return $info['dirname'].$info['filename'].'-'.$w.'.'.$info['extension'];
    }
}
