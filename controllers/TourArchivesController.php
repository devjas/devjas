<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Models\TourArchives;
use App\Models\TourInfo;

class TourArchivesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archives = TourArchives::join('tour_infos', 'tour_infos.id', '=', 'tour_archives.blkn_tour_id')
        ->join('tour_locations', 'tour_locations.blkn_tour_id', '=', 'tour_archives.blkn_tour_id')
        ->select(
            'tour_infos.blkn_tour_title',
            'tour_infos.blkn_from_date',
            'tour_infos.blkn_to_date',
            'tour_archives.created_at',
            'tour_locations.blkn_tour_city',
            'tour_locations.blkn_tour_state',
            DB::raw(
                'tour_infos.id as tour_id'
            )
        )
        ->where([
            'tour_archives.blkn_user_id' => Auth::id(),
            'tour_infos.blkn_tour_archives' => 1
        ])
        ->orderBy('tour_archives.created_at', 'desc')
        ->paginate(10);
        return View::make('concert-back.pages.archives.tour-archives')->withArchives($archives);
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
        if($request->tour_archive) {
            TourInfo::findOrFail($id)->update(['blkn_tour_archives' => $request->tour_archive]);
            $tour_archives = new TourArchives;
            $tour_archives->blkn_user_id = Auth::id();
            $tour_archives->blkn_tour_id = $id;
            $tour_archives->save();

            Session::flash('success', '<i class="fas fa-archive"></i> &nbsp; Tour ARCHIVED');
            return redirect('/tours');
        }
    }

    public function restore_archived_tour(Request $request, $id) {
        if($request->restore_archive) {
            TourInfo::findOrFail($id)->update(['blkn_tour_archives' => $request->restore_archive]);
            TourArchives::where(['tour_archives.blkn_user_id' => Auth::id(),'tour_archives.blkn_tour_id' => $id])->delete();
            Session::flash('success', '<i class="fas fa-archive"></i> &nbsp; Tour RESTORED');
            return redirect('/archives');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TourInfos::findOrFail($id)->delete();
        Session::flash('success', 'Archive and a Tour successfuly deleted.');
        return redirect('/archives');

    }
}
