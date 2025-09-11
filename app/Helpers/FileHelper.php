<?php

namespace App\Helpers;

class FileHelper
{
    public static function formatFileSize($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public static function getFileExtension($filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public static function isValidImageUrl($url)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        
        return in_array($extension, $imageExtensions);
    }

    public static function isValidVideoUrl($url)
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        
        return in_array($extension, $videoExtensions) || 
               strpos($url, 'youtube.com') !== false || 
               strpos($url, 'youtu.be') !== false ||
               strpos($url, 'vimeo.com') !== false;
    }
}