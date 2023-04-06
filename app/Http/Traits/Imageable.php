<?php

namespace App\Http\Traits;

trait Imageable
{
   
    public function storeImage($path, $file)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = uniqid().'.'.$fileExtension;

        $file->move($path, $fileName);

        $this->image = $fileName;
   
        $this->save();
    }

    public function restoreImage($path, $file)
    {


        if($this->getRawImageAttribute() != '' && $this->getRawImageAttribute() != null){
                         
            if( $file_old = $this->getRawImageAttribute()){
                unlink($file_old);
            }
                   
          
        }
        $this->storeImage($path, $file);

    }


}
