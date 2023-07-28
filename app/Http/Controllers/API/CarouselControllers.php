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
      {   $carousel = Carousel::where('id', $uuid)->first();
  
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
        $carousel = Catalogue::findOrFail($uuid);
        $validatedData = $request->validate([
            'carousel' => 'nullable|image|max:3072'
            ]);
       
        if ($request->file('carousel')) {
            $carousel = $request->file('carousel')->store('catalogue-carousel_picture');
        } else {
            $carousel = $carousel['carousel'];
        }

        if ($request->input('catalogue_id')) {
            $catalogue_id = $request->input('catalogue_id');
        } else {
            $catalogue_id = $catalogue['catalogue_id'];
        }
        
        $catalogue->update([
            'carousel'=>$carousel,
            'catalogue_id'=>$catalogue_id,
        ]);

        if($catalogue['photo_thumbnail']) {
            $catalogue->photo_thumbnail= 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/'.$catalogue['photo_thumbnail'];
        } else {
            $catalogue->photo_thumbnail = null;
        }

        return Api::createApi(200, 'successfully updated catalogue', $catalogue);

    }

    // <!---MENGHAPUS CATALOGUE--!>
    public function delete(Request $request, $id)
    {   
        $carousel = Carousel::findOrFail($id);
    
        $carousel->delete();

        return Api::createApi(200, 'carousel successfully deleted');
    }

}
