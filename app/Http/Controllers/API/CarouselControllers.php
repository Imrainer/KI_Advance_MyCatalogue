<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Photo_Carousel;
use App\Helpers\Api;
use Illuminate\Support\Str;

class CarouselControllers extends ApiController
{
      // <!--MENAMPILKAN CAROUSEL--!>
      public function index()
      {   $carousel = Photo_Carousel::get();
  
          return Api::createApi(200, 'success', $carousel);
      }
  
      // <!--MENAMPILKAN CAROUSEL BY ID--!>
      public function byId($uuid)
      {   $carousel = Photo_Carousel::where('id', $uuid)->first();
  
          if (!$carousel) {
              return Api::createApi(404, 'carousel not found');
          }
  
          $carousel->created_at_formatted = date('Y-m-d H:i:s', strtotime($carousel->created_at));
          $carousel->updated_at_formatted = date('Y-m-d H:i:s', strtotime($carousel->updated_at));
  
          return Api::createApi(200, 'success', $carousel);
      }

       // <!--MEMBUAT CAROUSEL--!>

      public function create(Request $request)
        {    $validatedData = $request->validate([
                'photo' => 'nullable|image|max:3072'
            ]);
        
            $carousel = [
                'catalogue_id' => $request->catalogue_id,
            ];
        
            if ($request->file('photo')) {
                $photo = $request->file('photo')->store('catalogue-carousel_picture');
                $carousel['photo'] = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' .  $photo;
            }
        
            $carousel['id'] = Str::uuid()->toString();
            
            Photo_Carousel::create($carousel);
            return Api::createApi(200, 'successfully created carousel', $carousel);
        }
        

    
    // <!---MENGEDIT CATALOGUE--!>
    public function edit(Request $request, $uuid)
    {   
    }

    // <!---MENGHAPUS CATALOGUE--!>
    public function delete(Request $request, $id)
    {   
        $carousel = Photo_Carousel::findOrFail($id);
    
        $carousel->delete();

        return Api::createApi(200, 'carousel successfully deleted');
    }

}
