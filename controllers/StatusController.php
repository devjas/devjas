<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\TourInfo;
use App\Models\UserTourSinger;
use App\Models\DeletedTour;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->tour_publishing) {
            
            TourInfo::where('id', $id)->update(['blkn_tour_publishing' => $request->tour_publishing]);
            
            $get_publishing_status = $request->tour_publishing == 1 ? '<span class="fw-500"><i class="fas fa-check"></i>&nbsp; Tour PUBLISHED</span>' : '<span class="fw-500"><i class="fas fa-exclamation-triangle"></i>&nbsp; Tour UNPUBLISHED</span>';
            $status_option = $request->tour_publishing == 1 ? 'success' : 'error';
            
            Session::flash($status_option, $get_publishing_status);
            
        } else if($request->tour_cancelling) {
            
            TourInfo::where('id', $id)->update(['blkn_tour_cancel' => $request->tour_cancelling]);
            
            $get_cancelling_status = $request->tour_cancelling == 1 ? '<span class="fw-500"><i class="fas fa-exclamation-triangle"></i>&nbsp; Tour CANCELLED</span>' : '<span class="fw-500"><i class="fas fa-check"></i>&nbsp; Tour RESUMED</span>';
            $status_option = $request->tour_cancelling == 1 ? 'error' : 'success';
            
            Session::flash($status_option, $get_cancelling_status);
            
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        TourInfo::find($id)->delete();

        Session::flash('success', 'Tour deleted');
        return redirect('/tours');

    }
}
