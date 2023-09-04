<?php


namespace App\Utils;

use App\Constants\ProductConstants;
use Illuminate\Support\Facades\Storage;

class Helper{

    public static function getDirNameThisYear(){
        return date('Y');
    }

    public static function getDirNameThisMonth(){
        return date('m');
    }

    public static function getFileNameForToday(){
        return date('d');
    }

    public static function getFileFullNameForToday(){
        return self::getFileNameForToday() . ProductConstants::File_Extension;
    }

    public static function getFileFullPathForToday(){
        return ProductConstants::Storage_Base_Folder_Name . '/' . self::getDirNameThisYear() .'/'. self::getDirNameThisMonth() .'/'. self::getFileFullNameForToday();
    }

    public static function checkIfTodayFileExists(){
       return Storage::disk('public')->exists(self::getFileFullPathForToday());
    }

    public static function getAllDirectoriesInDirectories(Array $directories){
        $newDirectoriesArray = [];
        foreach($directories as $directory){
            if(!Storage::exists('public/' . $directory)){
                continue;
            }
            $newDirectoriesArray[] = self::getAllDirectoriesInDirectory($directory);
        }
       return $newDirectoriesArray;
    }

    public static function getAllDirectoriesInDirectory(String $directory){
        if(Storage::missing('public/' . $directory)){
            return [];
        }
       return Storage::disk('public')->directories($directory);
    }

    public static function getAllfilesInDirectory(String $directory){
        if(!Storage::exists('public/' . $directory)){
            return [];
        }
       return Storage::disk('public')->files($directory);
    }
}


?>