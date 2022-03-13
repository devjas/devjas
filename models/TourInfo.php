<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourInfo extends Model
{
    use HasFactory, SoftDeletes;
    
    public function getBlknFromDateAttribute($value) {
        return Carbon::parse($value)->format('m/d/Y');
    } 

    public function getBlknToDateAttribute($value) {
        return Carbon::parse($value)->format('m/d/Y');
    } 
}
