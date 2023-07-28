<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Models\Catalogue;
use App\Models\Review;
use App\Models\Province;
use App\Models\City;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CatalogueControllers extends ApiController
{   
    // <!--MENAMPILKAN CATALOGUE SESUAI USER YANG LOGIN--!>
    public function index()
    {   $catalogue = Catalogue::with('photoCarousel')->get();
    
        $formattedCatalogue = $catalogue->map(function ($catalogue) {
           
            $favorite = $catalogue->favorite === 1 ? true : false;
            $catalogue->favorite = $favorite;

            $catalogue->created_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->created_at));
            $catalogue->updated_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->updated_at));

            $photo = $catalogue->photo_thumbnail;
            if ($photo === null) {
                $catalogue->photo_thumbnail= null;
            } else {
                $catalogue->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $photo;
            }

        $categoryName = Categories::where('id', $catalogue->categories_id)->value('category');
        $catalogue->categories_name = $categoryName;

        $provinceName = Province::where('id', $catalogue->province_id)->value('province');
        $catalogue->province_name = $provinceName;

        $CityName = City::where('id', $catalogue->city_id)->value('city');
        $catalogue->city_name = $CityName;

            return $catalogue;
        });

        return Api::createApi(200, 'success', $catalogue);
    }

    // <!--MENAMPILKAN CATALOGUE BY ID--!>
    public function byId($uuid)
    {   $catalogue = Catalogue::with('photoCarousel','Review')->first();

        if (!$catalogue) {
            return Api::createApi(404, 'catalogue not found');
        }
        
        $favorite = $catalogue->favorite === 1 ? true : false;
        $catalogue->favorite = $favorite;

        $catalogue->created_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->created_at));
        $catalogue->updated_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->updated_at));

        $photo = $catalogue->photo_thumbnail;
        if ($photo === null) {
            $catalogue->photo_thumnail = null;
        } else {
            $catalogue->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $photo;
        }

        $categoryName = Categories::where('id', $catalogue->categories_id)->value('category');
        $catalogue->categories_name = $categoryName;

        $provinceName = Province::where('id', $catalogue->province_id)->value('province');
        $catalogue->province_name = $provinceName;

        $CityName = City::where('id', $catalogue->city_id)->value('city');
        $catalogue->city_name = $CityName;

        $reviews = $catalogue->Review->map(function ($review) {
            $user = $review->user;
            $review->user_name = $user->name;
            $review->user_photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $user->photo; 
            return $review;
        });
    
        $catalogue->review = $reviews;

        return Api::createApi(200, 'success', $catalogue);
    }

    public function filterByProvince($provinceId)
    {   $catalogue = Catalogue::where('province_id', $provinceId)->with('photoCarousel')->get();

        $formattedCatalogue = $catalogue->map(function ($catalogue) {
           
            $favorite = $catalogue->favorite === 1 ? true : false;
            $catalogue->favorite = $favorite;

            $catalogue->created_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->created_at));
            $catalogue->updated_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->updated_at));

            $photo = $catalogue->photo_thumbnail;
            if ($photo === null) {
                $catalogue->photo_thumbnail= null;
            } else {
                $catalogue->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $photo;
            }

        $categoryName = Categories::where('id', $catalogue->categories_id)->value('category');
        $catalogue->categories_name = $categoryName;

        $provinceName = Province::where('id', $catalogue->province_id)->value('province');
        $catalogue->province_name = $provinceName;

        $CityName = City::where('id', $catalogue->city_id)->value('city');
        $catalogue->city_name = $CityName;

            return $catalogue;
        });

        return Api::createApi(200, 'success', $catalogue);
    }

    public function filterByCity($cityId)
    {   $catalogue = Catalogue::where('city_id', $cityId)->with('photoCarousel')->get();
    
        $formattedCatalogue = $catalogue->map(function ($catalogue) {
           
            $favorite = $catalogue->favorite === 1 ? true : false;
            $catalogue->favorite = $favorite;

            $catalogue->created_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->created_at));
            $catalogue->updated_at_formatted = date('Y-m-d H:i:s', strtotime($catalogue->updated_at));

            $photo = $catalogue->photo_thumbnail;
            if ($photo === null) {
                $catalogue->photo_thumbnail= null;
            } else {
                $catalogue->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $photo;
            }

        $categoryName = Categories::where('id', $catalogue->categories_id)->value('category');
        $catalogue->categories_name = $categoryName;

        $provinceName = Province::where('id', $catalogue->province_id)->value('province');
        $catalogue->province_name = $provinceName;

        $CityName = City::where('id', $catalogue->city_id)->value('city');
        $catalogue->city_name = $CityName;

            return $catalogue;
        });

        return Api::createApi(200, 'success', $catalogue);
    }


    // <!---MEMBUAT CATALOGUE---!>
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'photo_thumbnail' => 'nullable|image|max:3072'
            ]);

        $catalogues=[
            'name'=>$request->name,
            'detail_content'=>$request->detail_content,
            'categories_id'=>$request->categories_id,
            'price'=>$request->price,
            'faciity_information'=>$request->facility_information,
            'province_id'=>$request->province_id,
            'city_id'=>$request->city_id,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
            'photo_thumbnail' => null,
        ];

        if ($request->file('photo_thumbnail')) {
            $photo_thumbnail = $request->file('photo_thumbnail')->store('catalogue-thumbnail_picture');
            $catalogues['photo_thumbnail'] = $photo_thumbnail;
    }

        $catalogues['id'] = Str::uuid()->toString();
        
        Catalogue::create($catalogues);
        return Api::createApi(200, 'successfully created catalogue', $catalogues);
    }

    // <!---MENGEDIT CATALOGUE--!>
    public function edit(Request $request, $uuid)
    {   
        $catalogue = Catalogue::findOrFail($uuid);
        $validatedData = $request->validate([
            'photo_thumbail' => 'nullable|image|max:3072'
            ]);
       
        if ($request->file('photo_thumbnail')) {
            $photo_thumbnail = $request->file('photo_thumbnail')->store('catalogue-thumbnail_picture');
        } else {
            $photo_thumbnail = $catalogue['photo-thumbnail'];
        }

        if ($request->input('name')) {
            $name = $request->input('name');
        } else {
            $name = $catalogue['name'];
        }

        if ($request->input('detail_content')) {
            $detail_content = $request->input('detail_content');
        } else {
            $detail_content = $catalogue['detail_content'];
        }

        if ($request->input('categories_id')) {
            $categories_id = $request->input('categories_id');
        } else {
            $categories_id = $catalogue['categories_id'];
        }

        if ($request->input('price')) {
            $price = $request->input('price');
        } else {
            $price = $catalogue['price'];
        }
        
        if ($request->input('facility_information')) {
            $facility_information = $request->input('facility_information');
        } else {
            $facility_information = $catalogue['facility_information'];
        }

        
        if ($request->input('province_id')) {
            $province_id = $request->input('province_id');
        } else {
            $province_id = $catalogue['province_id'];
        }

    
        if ($request->input('city_id')) {
            $city_id = $request->input('city_id');
        } else {
            $city_id = $catalogue['city_id'];
        }
        
        $catalogue->update([
            'name'=>$name,
            'detail_content'=>$detail_content,
            'categories_id'=>$categories_id,
            'photo_thumbnail' => $photo_thumbnail,
            'price'=>$price,
            'facility_information'=>$facility_information,
            'province_id'=>$province_id,
            'city_id'=>$city_id,
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
        $catalogue = Catalogue::findOrFail($id);
    
        $catalogue->delete();

        return Api::createApi(200, 'catalogue successfully deleted');
    }

     // <!---MENGFAVORIT CATALOGUE--!>
     public function favorite($uuid)
     {         
         $catalogue = Catalogue::findOrFail($uuid);
 
         $catalogue->update([
            'favorite'=>1,
         ]);

         $favorite = $catalogue->favorite === 1 ? true : false;
          $catalogue->favorite = $favorite;

         if($catalogue['photo']) {
            $catalogue->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/'.$catalogue['photo'];
        } else {
            $catalogue->photo = null;
        }
 
         return Api::createApi(200, 'successfully favorited note', $catalogue);
     }

      // <!---MENGUNFAVORIT CATALOGUE--!>
      public function unfavorite($uuid)
      {
          $catalogue = Catalogue::findOrFail($uuid);
  
          $catalogue->update([
             'favorite'=>null
          ]);
          
          $favorite = $catalogue->favorite === 1 ? true : false;
          $catalogue->favorite = $favorite;

          if($catalogue['photo']) {
            $catalogue->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/'.$catalogue['photo'];
            } else {
            $catalogue->photo = null;
            }
        
        return Api::createApi(200, 'successfully unfavorited note', $catalogue);

      }

}
