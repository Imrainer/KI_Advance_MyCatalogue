<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Helpers\Api;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Str;


class CityControllers extends ApiController
{
     // <!---Menampilkan City--!>
    public function read(Request $Request)
    {
       $city = City::get();
     
       return Api::createApi(200, 'successfully', $city);
    }

    // <!---Membuat City--!>
    public function create(Request $request)
    {   $city=[
            'city'=>$request->city,
            'province'=>$request->province,
        ];
        $city['id'] = Str::uuid()->toString();

        City::create($city);
        return Api::createApi(200, 'successfully created ', $city);
    }
     
    // <!--MENAMPILKAN City BY ID--!>
    public function byId($uuid)
    {   $city = City::where('id', $uuid)->first();

        if (!$city) {
            return Api::createApi(404, 'city not found');
        }

        return Api::createApi(200, 'success', $city);
    }

      // <!---Mengedit City--!>
      public function edit(request $request, $id)
      {
        $data = City::find($id);
        $data->update([
            'city' =>($request->input('city')),
            'province'=>($request->input('province'))
        ]);
        
        return Api::createApi(200, 'successfully updated', $data);
       
      }
      
    // <!---Menghapus City--!>
     public function delete(request $request, $id)
     {  
        $data = City::find($id);
        $data->delete($id);
        
        return Api::createApi(200, 'successfully deleted', $data);
     }

}
