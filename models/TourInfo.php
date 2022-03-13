<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourInfo extends Model
{
    
    use HasFactory, SoftDeletes;
    
    public function tour_ages() {
        return $this->hasOne(TourAge::class, 'blkn_tour_id');
    }

    public function tour_locations() {
        return $this->hasOne(TourLocation::class, 'blkn_tour_id');
    }

    public function tour_contacts() {
        return $this->hasOne(TourContact::class, 'blkn_tour_id');
    }

    public function getBlknFromDateAttribute($value) {
        return Carbon::parse($value)->format('m/d/Y');
    } 

    public function getBlknToDateAttribute($value) {
        return Carbon::parse($value)->format('m/d/Y');
    } 

    public function getDeletedAtAttribute($value) {
        return Carbon::parse($value)->format('m/d/Y');
    } 
    
}
