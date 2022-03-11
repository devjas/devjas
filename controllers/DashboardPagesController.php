<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Singers;
use App\Models\UserTourSinger;
use DB;

class DashboardPagesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','verified']); // User must be loggedin and the E-Mail must be verified
    }

    public function getDashboard() {
        return View::make('concert-back.pages.tours.show-tours');
    }

    public function remove_singer_from_all_tours($singer_id) {
        
        $singer = Singers::findOrFail($singer_id)

        $singer->blkn_band_name ? $dash = ' - ' : $dash = '';

        UserTourSinger::where('blkn_singer_id', $singer_id)->delete();

        Session::flash('success', "<b>".$singer->blkn_singer_firstname . " " . $singer->blkn_singer_lastname . $dash . $singer->blkn_band_name.'</b>' . ' has been removed from all Tours. Now you can delete this singer.');
        return redirect()->back();

    }
}
