<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TourInfo;

class TourContact extends Model
{
    use HasFactory;

    public function tour_infos() {
        return $this->belongsTo(TourInfo::class);
    }
}
