<?php

namespace App\Models;


use App\Constants\ProductConstants;
use App\Utils\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product 
{
    use HasFactory;

    public function allProducts($sortByDate = false, $indexByDate = false){
            $yearsDirs = Helper::getAllDirectoriesInDirectory(ProductConstants::Storage_Base_Folder_Name);
            $allProjects = $this->preparingAllProductsToDisplay($yearsDirs, $sortByDate,  $indexByDate);
            return $allProjects;

    }

    private function preparingAllProductsToDisplay($yearsDirs, $sortByDate = false, $indexByDate = false){
            $productsArray = [];
            if($sortByDate){
                $yearsDirs = array_reverse($yearsDirs, true);
            }
            foreach($yearsDirs as $key => $year){
                if($indexByDate){
                    $fileName =  basename($year);
                }else{
                    $fileName = $key;
                }
                $productsArray[$fileName] = $this->getAllProductsPerYear($year , $sortByDate, $indexByDate);
            }
            
            return $productsArray;
    }

    public function getAllProductsPerYear($year, $sortByDate = false, $indexByDate = true){
            $productsYearArray = [];
            $yearMonthsDirs = Helper::getAllDirectoriesInDirectory($year);
            if($sortByDate){
                $yearMonthsDirs = array_reverse($yearMonthsDirs, true);
            }
            foreach($yearMonthsDirs as $key => $month){
                if($indexByDate){
                    $fileName =  basename($month);
                }else{
                    $fileName = $key;
                }
                $productsYearArray[$fileName] = $this->getAllProductsPerMonth($month, $sortByDate, $indexByDate);
            }

            return $productsYearArray;
     }


    public function getAllProductsPerMonth($month, $sortByDate = false, $indexByDate = false){
            $productsMonthArray = [];
            $monthFiles = Helper::getAllfilesInDirectory($month);
            if($sortByDate){
                    $monthFiles = array_reverse($monthFiles, true);
                }
            foreach($monthFiles as $key => $file){
                    if($indexByDate){
                        $fileName = pathinfo($file, PATHINFO_FILENAME);
                    }else{
                        $fileName = $key;
                    }
                $productsMonthArray[$fileName] = $this->getAllDecodedProductsFromFile($file, $sortByDate);
            }

            return $productsMonthArray;
    }

    public function getAllDecodedProductsFromFile($file, $sortByDate = false){
            $fileData = Storage::disk('public')->get($file);
            $fileData = json_decode($fileData, true);
            if($sortByDate){
                $fileData = array_reverse($fileData, true);
            }

            return $fileData;  
    }
    
   public static function create($data){
            $fileDataArray = [];
            $publicDir = Storage::disk('public');
            if(Helper::checkIfTodayFileExists()){
                $file = $publicDir->get(Helper::getFileFullPathForToday());
                $fileDataArray = json_decode($file, true);
            }else{
               $file = Helper::getFileFullPathForToday();
            }
            $index = self::getIndexForNewProduct($fileDataArray);
            $newProduct = self::preparingNewProductForFile($data);
            $fileDataArray[$index] = $newProduct;
            if($publicDir->put(Helper::getFileFullPathForToday(), json_encode($fileDataArray))){
                return true;
            }

            return false;

   }
   
   private static function preparingNewProductForFile(Array $data){
            $newProduct = [
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
                'created_at' => time()
            ];
            
            return $newProduct;
   }

   private static function getIndexForNewProduct($fileDataArray){
            $keys = array_keys($fileDataArray);
            $lastItem = last($keys);
            if(!$lastItem){
                return 1;
            }

            return $lastItem += 1;
   }

   public static function update($fullPathWithName, $id, $arrayData){
            $fileData = Storage::disk('public')->get($fullPathWithName);
            $fileData = json_decode($fileData, true);
            $product = $fileData[$id];
            $updatedProduct = self::preparingUpdatedProductForFile($product ,$arrayData);
            $fileData[$id] = $updatedProduct;
            if(Storage::disk('public')->put($fullPathWithName , json_encode($fileData))){
                return true;
            }

            return false;

   }

   private static function preparingUpdatedProductForFile(Array $product, Array $data){
 
            $product['name'] = $data['name'];
            $product['quantity'] = $data['quantity'];
            $product['price'] = $data['price'];
        
            return $product;
   }

   public static function find($fullPathWithName, $id){
            $fileData = Storage::disk('public')->get($fullPathWithName);
            $fileData = json_decode($fileData, true);
            if(isset($fileData[$id])){
            return $fileData[$id];
            }

            return null;
    }

}
