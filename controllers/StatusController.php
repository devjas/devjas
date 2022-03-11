<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\TourInfo;

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

        $deleted_tour = DB::table('user_tour_singers')
        ->join('tour_infos','tour_infos.id','=','user_tour_singers.blkn_tour_id')
        ->join('tour_ages','tour_ages.blkn_tour_id','=','user_tour_singers.blkn_tour_id')
        ->join('tour_contacts','tour_contacts.blkn_tour_id','=','user_tour_singers.blkn_tour_id')
        ->join('tour_locations','tour_locations.blkn_tour_id','=','user_tour_singers.blkn_tour_id')
        ->join('tour_approvals','tour_approvals.blkn_tour_id','=','user_tour_singers.blkn_tour_id')
        ->select(
            'tour_infos.blkn_tour_title',
            'tour_infos.blkn_covid_health_check',
            'tour_infos.blkn_from_date',
            'tour_infos.blkn_to_date',
            'tour_infos.blkn_tour_time',
            'tour_infos.blkn_food_availability',
            'tour_infos.blkn_drink_availability',
            'tour_infos.blkn_tour_description',
            'tour_infos.blkn_tour_approval',
            'tour_infos.blkn_tour_publishing',
            'tour_infos.blkn_tour_cancel',
            'tour_infos.blkn_tour_archives',
            'tour_infos.blkn_tour_image',
            'tour_ages.blkn_price_for_all_ages',
            'tour_ages.blkn_different_price',
            'tour_ages.blkn_adult_price',
            'tour_ages.blkn_children_price',
            'tour_ages.blkn_children_age_range',
            'tour_contacts.blkn_contact_first_name',
            'tour_contacts.blkn_contact_last_name',
            'tour_contacts.blkn_contact_phone',
            'tour_contacts.blkn_contact_email',
            'tour_contacts.blkn_phone_public_private',
            'tour_contacts.blkn_facebook_link',
            'tour_contacts.blkn_instagram_link',
            'tour_contacts.blkn_youtube_link',
            'tour_locations.blkn_name_of_place',
            'tour_locations.blkn_tour_address',
            'tour_locations.blkn_tour_city',
            'tour_locations.blkn_tour_state',
            'tour_locations.blkn_tour_zip',
            'tour_infos.id as tour_id',
            'tour_approvals.created_at as tour_approval_date',
            'tour_infos.created_at as tour_create_date',
            'tour_infos.updated_at as tour_update_date',
        )
        ->where('tour_infos.id', $id)
        ->first();


        $find_singers = DB::table('user_tour_singers')
        ->join('singers','singers.id', '=', 'user_tour_singers.blkn_singer_id')
        ->select(
            'singers.blkn_singer_firstname',
            'singers.blkn_singer_lastname',
            'singers.blkn_band_name',
            'singers.created_at as singer_create_date',
            'singers.updated_at as singer_update_date',
        )
        ->where('user_tour_singers.blkn_tour_id', $id)
        ->get();

        $s = [];
        foreach($find_singers as $singers) {
            $s[] = [
                'blkn_singer_firstname' => $singers->blkn_singer_firstname,
                'blkn_singer_lastname' => $singers->blkn_singer_lastname,
                'blkn_band_name' => $singers->blkn_band_name,
                'blkn_singer_create_date' => $singers->singer_create_date,
                'blkn_singer_update_date' => $singers->singer_update_date,
            ];
        }

        $deleted_tour_json_data = [
            'tour_infos' => [
                'tour_id' => $deleted_tour->tour_id,
                'blkn_tour_title' => $deleted_tour->blkn_tour_title,
                'blkn_covid_health_check' => $deleted_tour->blkn_covid_health_check,
                'blkn_from_date' => $deleted_tour->blkn_from_date,
                'blkn_to_date' => $deleted_tour->blkn_to_date,
                'blkn_tour_time' => $deleted_tour->blkn_tour_time,
                'blkn_food_availability' => $deleted_tour->blkn_food_availability,
                'blkn_drink_availability' => $deleted_tour->blkn_drink_availability,
                'blkn_tour_description' => $deleted_tour->blkn_tour_description,
                'blkn_tour_approval' => $deleted_tour->blkn_tour_approval,
                'tour_approval_date' => $deleted_tour->tour_approval_date,
                'blkn_tour_publishing' => $deleted_tour->blkn_tour_publishing,
                'blkn_tour_cancel' => $deleted_tour->blkn_tour_cancel,
                'blkn_tour_image' => $deleted_tour->blkn_tour_image,
                'tour_create_date' => $deleted_tour->tour_create_date,
                'tour_update_date' => $deleted_tour->tour_update_date,
                'tour_archived' => $deleted_tour->blkn_tour_archives,
            ],
            'tour_ages' => [
                'blkn_price_for_all_ages' => $deleted_tour->blkn_price_for_all_ages,
                'blkn_different_price' => $deleted_tour->blkn_different_price,
                'blkn_adult_price' => $deleted_tour->blkn_adult_price,
                'blkn_children_price' => $deleted_tour->blkn_children_price,
                'blkn_children_age_range' => $deleted_tour->blkn_children_age_range,
            ],
            'tour_contacts' => [
                'blkn_contact_first_name' => $deleted_tour->blkn_contact_first_name,
                'blkn_contact_last_name' => $deleted_tour->blkn_contact_last_name,
                'blkn_contact_phone' => $deleted_tour->blkn_contact_phone,
                'blkn_contact_email' => $deleted_tour->blkn_contact_email,
                'blkn_phone_public_private' => $deleted_tour->blkn_phone_public_private,
                'blkn_facebook_link' => $deleted_tour->blkn_facebook_link,
                'blkn_instagram_link' => $deleted_tour->blkn_instagram_link,
                'blkn_yourtube_link' => $deleted_tour->blkn_youtube_link,
            ],
            'tour_locations' => [
                'blkn_name_of_place' => $deleted_tour->blkn_name_of_place,
                'blkn_tour_address' => $deleted_tour->blkn_tour_address,
                'blkn_tour_city' => $deleted_tour->blkn_tour_city,
                'blkn_tour_state' => $deleted_tour->blkn_tour_state,
                'blkn_tour_zip' => $deleted_tour->blkn_tour_zip,
            ],
            'tour_singers' => $s,
            'tour_users' => [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
            ],
        ];

        $data_encoded = json_encode($deleted_tour_json_data);

        DB::table('deleted_tours')
        ->insert([
             'deleted_tour' => $data_encoded
        ]);


        $tour_info = TourInfo::findOrFail($id);
        $tour_info->delete();

        Session::flash('success', 'Tour deleted');
        return redirect('/tours');

    }
}
