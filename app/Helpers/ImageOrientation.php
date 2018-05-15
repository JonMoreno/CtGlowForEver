<?php
namespace App\Helpers;

class ImageOrientaion 
{
    /**
     * Orientate an image, based on its exif rotation state
     * 
     * @param  Intervention\Image\Image $image
     * @param  integer $orientation Image exif orientation
     * @return Intervention\Image\Image
     */
    public function orientate($image, $orientation)
    {
        switch ($orientation) {  
            case 1:
                return $image;
            case 2:
                return $image->flip('h');
            case 3:
                return $image->rotate(180);
            case 4:
                return $image->rotate(180)->flip('h');   
            case 5:
                return $image->rotate(-90)->flip('h');
            case 6:
                return $image->rotate(-90);

            case 7:
                return $image->rotate(-90)->flip('v');
            case 8:
                return $image->rotate(90);

            default:
                return $image;
        }
    }

}
