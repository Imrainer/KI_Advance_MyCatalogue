<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Helpers\Api;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Str;

class ProvinceControllers extends ApiController
{
     // <!---Menampilkan Province--!>
    public function read(Request $Request)
    {
       $province = Province::get();
     
       return Api::createApi(200, 'successfully', $province);
    }

    // <!---Membuat City--!>
    public function create(Request $request)
    {   $province=[
            'province'=>$request->province,
        ];
        $province['id'] = Str::uuid()->toString();

        Province::create($province);
        return Api::createApi(200, 'successfully created ', $province);
    }
     
    // <!--MENAMPILKAN Province BY ID--!>
    public function byId($uuid)
    {   $province = Province::where('id', $uuid)->first();

        if (!$province) {
            return Api::createApi(404, 'province not found');
        }

        return Api::createApi(200, 'success', $province);
    }

      // <!---Mengedit Province--!>
      public function edit(request $request, $id)
      {
        $data = Province::find($id);
        $data->update([
            'province' =>($request->input('province')),
        ]);
        
        return Api::createApi(200, 'successfully updated', $data);
       
      }
      
    // <!---Menghapus Province--!>
     public function delete(request $request, $id)
     {  
        $data = Province::find($id);
        $data->delete($id);
        
        return Api::createApi(200, 'successfully deleted', $data);
     }

}
