<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $table = "catalogue";

    protected $fillable = [
        'id',  'name', 'detail_content','categories_id','favorite','photo_thumbnail','photos_id','price','facility_information','province_id','city_id','longitude','latitude'
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public function categories() {
        return $this->belongsTo(Categories::class, 'categories_id');
    } 

    public function province() {
        return $this->belongsTo(Province::class, 'province_id');
    } 

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    } 

    public function photoCarousel()
    {
        return $this->hasMany(Photo_Carousel::class);
    }

    public function Review()
    {
        return $this->hasMany(Review::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('YmdHis', strtotime($value));
    }
}