<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\User;
use App\Models\TourInfo;
use Carbon\Carbon;
use App\Models\Singer;
use App\Models\UserTourSinger;

class TourController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'verified', 'userblocked']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        return View::make('concert-back.pages.tours.show-tours');
    }

    public function publish_update(Request $request, $id) {
        return $request->tour_publishing;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('concert-back.pages.tours.create-tour');
    }
    
    /**
     * Validate edit and newly created tours
     */
    public function validateTour() {
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
        if($request->different_price) {
            $adult_price = 'required';
            $children_price = 'required';
            $children_age_range = 'required|not_in:0';
            $price_for_all_ages = '';

            $req_different_price = $request->different_price;
            $req_adult_price = $request->adult_price;
            $req_children_price = $request->children_price;
            $req_children_age_range = $request->children_age_range;
            $req_price_for_all_ages = '';
        } else {
            if(empty($request->price_for_all_ages) && empty($request->adult_price)) {
                $price_for_all_ages = '';
                $adult_price = '';
                $children_price = '';
                $children_age_range = '';
            } else {
                $price_for_all_ages = 'required';
            }
            
            $adult_price = '';
            $children_price = '';
            $children_age_range = '';

            $req_price_for_all_ages = $request->price_for_all_ages;
            $req_different_price = 2;
            $req_adult_price = '';
            $req_children_price = '';
            $req_children_age_range = '';
        }

        $validator = Validator::make($request->all(), array(
            'tour_title' => 'required',
            'singers_name' => 'required|not_in:0',
            'covid_health_check' => 'required',
            'from_date' => 'required',
            'tour_time' => 'required',
            'price_for_all_ages' => $price_for_all_ages,
            'adult_price' => $adult_price,
            'children_price' => $children_price,
            'children_age_range' => $children_age_range,
            'food_availability' => 'required',
            'drink_availability' => 'required',
            'name_of_place' => 'required',
            'tour_address' => 'required',
            'tour_city' => 'required',
            'tour_state' => 'required|not_in:0',
            'tour_zip' => 'required'
        ));



        if($validator->fails()) {
            Session::flash('error', 'Something went wrong');
            return redirect('tours/create')->withErrors($validator)->withInput();
        }

        // 1 is YES | 2 is NO

        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        if($request->to_date) {
            $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        } else {
            $to_date = '';
        }

        if($request->image_upload) {
            $img_file = $request->image_upload;
            $path = '/singer-images/';
            $img = date('YmdHis')."_".$img_file->getClientOriginalName();
            $move = $img_file->move(public_path($path), $img);
            $path_img_upload = $path.$img;
        } else {
            $path_img_upload = '';
        }

        $add_tour = DB::table('tour_infos')
        ->insertGetId([
            'blkn_tour_title' => $request->tour_title,
            'blkn_covid_health_check' => $request->covid_health_check,
            'blkn_from_date' => $from_date,
            'blkn_to_date' => $to_date,
            'blkn_tour_time' => $request->tour_time,
            'blkn_food_availability' => $request->food_availability,
            'blkn_drink_availability' => $request->drink_availability,
            'blkn_tour_description' => $request->tour_description,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s'),
            'blkn_tour_approval' => 2, // 2 is for "NO"
            'blkn_tour_publishing' => 2, // 2 is for "NO"
            'blkn_tour_cancel' => 2, // 2 is for "NO"
            'blkn_tour_archives' => 2, // 2 is for "NO"
            'blkn_tour_blocking' => 2, // 2 is for "NO"
            'blkn_tour_image' => $path_img_upload,
        ]);

        DB::table('tour_ages')
        ->insert([
            'blkn_tour_id' => $add_tour,
            'blkn_different_price' => $req_different_price,
            'blkn_price_for_all_ages' => $request->price_for_all_ages,
            'blkn_adult_price' => $request->adult_price,
            'blkn_children_price' => $request->children_price,
            'blkn_children_age_range' => $request->children_age_range,
        ]);

        DB::table('tour_locations')
        ->insert([
            'blkn_tour_id' => $add_tour,
            'blkn_name_of_place' => $request->name_of_place,
            'blkn_tour_address' => $request->tour_address,
            'blkn_tour_city' => $request->tour_city,
            'blkn_tour_state' => $request->tour_state,
            'blkn_tour_zip' => $request->tour_zip,
        ]);

        if($request->phone_public_private) {
            $blkn_phone_public_private = $request->phone_public_private;
        } else {
            $blkn_phone_public_private = 2;
        }
        
        DB::table('tour_contacts')
        ->insert([
            'blkn_tour_id' => $add_tour,
            'blkn_contact_first_name' => $request->contact_first_name,
            'blkn_contact_last_name' => $request->contact_last_name,
            'blkn_contact_phone' => $request->contact_phone,
            'blkn_contact_email' => $request->contact_email,
            'blkn_phone_public_private' => $blkn_phone_public_private,
            'blkn_facebook_link' => $request->facebook_link,
            'blkn_instagram_link' => $request->instagram_link,
            'blkn_youtube_link' => $request->youtube_link,
        ]);

        $singers_array = collect($request->singers_name);
        foreach($singers_array as $singers) {
            DB::table('user_tour_singers')
            ->insert([
                'blkn_user_id' => Auth::id(),
                'blkn_tour_id' => $add_tour,
                'blkn_singer_id' => $singers,
            ]);
        }

        Session::flash('success', '<b>Success!</b> Each Tour must be reviewed and approved by an Administrator. Please check back often to see your Tour status.');
        return redirect('tours');
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
        $editTour = DB::table('user_tour_singers')
        ->join('tour_ages', 'tour_ages.blkn_tour_id', '=', 'user_tour_singers.blkn_tour_id')
        ->join('tour_contacts', 'tour_contacts.blkn_tour_id', '=', 'user_tour_singers.blkn_tour_id')
        ->join('tour_infos', 'tour_infos.id', '=', 'user_tour_singers.blkn_tour_id')
        ->join('tour_locations', 'tour_locations.blkn_tour_id', '=', 'user_tour_singers.blkn_tour_id')
        ->join('singers', 'singers.id', '=', 'user_tour_singers.blkn_singer_id')
        ->select(
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
            'tour_infos.blkn_tour_title',
            'tour_infos.blkn_covid_health_check',
            'tour_infos.blkn_from_date',
            'tour_infos.blkn_to_date',
            'tour_infos.blkn_tour_time',
            'tour_infos.blkn_food_availability',
            'tour_infos.blkn_drink_availability',
            'tour_infos.blkn_tour_description',
            'tour_infos.blkn_tour_publishing',
            'tour_infos.blkn_tour_cancel',
            'tour_locations.blkn_name_of_place',
            'tour_locations.blkn_tour_address',
            'tour_locations.blkn_tour_city',
            'tour_locations.blkn_tour_state',
            'tour_locations.blkn_tour_zip',
            DB::raw(
                'tour_infos.id as tour_id'
            )
        )
        ->where([
            'user_tour_singers.blkn_tour_id' => $id,
            'user_tour_singers.blkn_user_id' => Auth::id()
        ])
        ->first();

        $all_singers = DB::table('user_singers')
        ->join('singers', 'singers.id', '=', 'user_singers.blkn_singer_id')
        ->select('singers.id', 'user_singers.blkn_singer_id', 'singers.blkn_singer_firstname', 'singers.blkn_singer_lastname', 'user_singers.blkn_user_id', 'singers.blkn_band_name')
        ->where([
            'user_singers.blkn_user_id' => Auth::id()
        ])
        ->get();

        $uts_singer_id = DB::table('user_tour_singers')->where('blkn_tour_id', $id)->pluck('blkn_singer_id')->toArray();
        
        $singer_options = '';
        foreach($all_singers as $as) {
            if(in_array($as->blkn_singer_id, $uts_singer_id)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            if($as->blkn_singer_firstname && $as->blkn_band_name || $as->blkn_singer_lastname && $as->blkn_band_name) {
                $dash = ' - ';
            } else {
                $dash = '';
            }
            if($as->blkn_singer_firstname || $as->blkn_singer_lastname || $as->blkn_band_name) {
                $singer_options .= '<option value="'.$as->id.'"'.$selected.'>'.$as->blkn_singer_firstname." ".$as->blkn_singer_lastname.$dash.$as->blkn_band_name.'</option>';
            } else {
                $singer_options .= '<option value="'.$as->id.'"'.$selected.'>'.$as->blkn_band_name.'</option>';
            }
            
        }
        return View::make('concert-back.pages.tours.edit-tour', compact('editTour', 'singer_options'));
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
        if($request->different_price) {
            $adult_price = 'required';
            $children_price = 'required';
            $children_age_range = 'required|not_in:0';
            $price_for_all_ages = '';

            $req_different_price = $request->different_price;
            $req_adult_price = $request->adult_price;
            $req_children_price = $request->children_price;
            $req_children_age_range = $request->children_age_range;
            $req_price_for_all_ages = '';
        } else {
            $price_for_all_ages = 'required';
            $adult_price = '';
            $children_price = '';
            $children_age_range = '';

            $req_price_for_all_ages = $request->price_for_all_ages;
            $req_different_price = 2;
            $req_adult_price = '';
            $req_children_price = '';
            $req_children_age_range = '';
        }
        $validator = Validator::make($request->all(), array(
            'tour_title' => 'required',
            'singers_name' => 'required|not_in:0',
            'covid_health_check' => 'required',
            'from_date' => 'required',
            'tour_time' => 'required',
            'price_for_all_ages' => $price_for_all_ages,
            'adult_price' => $adult_price,
            'children_price' => $children_price,
            'children_age_range' => $children_age_range,
            'food_availability' => 'required',
            'drink_availability' => 'required',
            'name_of_place' => 'required',
            'tour_address' => 'required',
            'tour_city' => 'required',
            'tour_state' => 'required|not_in:0',
            'tour_zip' => 'required'
        ));
        
        if($validator->fails()) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // 1 is YES | 2 is NO

        $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
        if($request->to_date) {
            $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        } else {
            $to_date = '';
        }

        $add_tour = DB::table('tour_infos')
        ->where('id', $id)
        ->update([
            'blkn_tour_title' => $request->tour_title,
            'blkn_covid_health_check' => $request->covid_health_check,
            'blkn_from_date' => $from_date,
            'blkn_to_date' => $to_date,
            'blkn_tour_time' => $request->tour_time,
            'blkn_food_availability' => $request->food_availability,
            'blkn_drink_availability' => $request->drink_availability,
            'blkn_tour_description' => $request->tour_description,
            'updated_at' => date('Y-m-d H:m:s'),
            // 'blkn_tour_publishing' => $request->tour_publishing,
            // 'blkn_tour_cancel' => $request->tour_cancelling,
        ]);

        DB::table('tour_ages')
        ->where('blkn_tour_id', $id)
        ->update([
            'blkn_different_price' => $req_different_price,
            'blkn_price_for_all_ages' => $request->price_for_all_ages,
            'blkn_adult_price' => $request->adult_price,
            'blkn_children_price' => $request->children_price,
            'blkn_children_age_range' => $request->children_age_range,
        ]);

        DB::table('tour_locations')
        ->where('blkn_tour_id', $id)
        ->update([
            'blkn_name_of_place' => $request->name_of_place,
            'blkn_tour_address' => $request->tour_address,
            'blkn_tour_city' => $request->tour_city,
            'blkn_tour_state' => $request->tour_state,
            'blkn_tour_zip' => $request->tour_zip,
        ]);

        if($request->phone_public_private) {
            $blkn_phone_public_private = $request->phone_public_private;
        } else {
            $blkn_phone_public_private = 2;
        }
        
        DB::table('tour_contacts')
        ->where('blkn_tour_id', $id)
        ->update([
            'blkn_contact_first_name' => $request->contact_first_name,
            'blkn_contact_last_name' => $request->contact_last_name,
            'blkn_contact_phone' => $request->contact_phone,
            'blkn_contact_email' => $request->contact_email,
            'blkn_phone_public_private' => $blkn_phone_public_private,
            'blkn_facebook_link' => $request->facebook_link,
            'blkn_instagram_link' => $request->instagram_link,
            'blkn_youtube_link' => $request->youtube_link,
        ]);

        $get_all_singers = DB::table('user_tour_singers')
        ->select('blkn_singer_id')
        ->where('blkn_tour_id', $id)
        ->get();

        $singers_id_array = collect($request->singers_name); // requested singer ids

        $pluck_singer_id = DB::table('user_tour_singers')->where('blkn_tour_id', $id)->pluck('blkn_singer_id')->toArray();
        
        foreach($singers_id_array as $singer_ids) {
            if(!in_array($singer_ids, $pluck_singer_id)) { // If requested $singer_ids is not in user_tour_singers table, insert.
                DB::table('user_tour_singers')
                ->insert([
                    'blkn_user_id' => Auth::id(),
                    'blkn_tour_id' => $id,
                    'blkn_singer_id' => $singer_ids,
                ]);
            }
            DB::table('user_tour_singers')
            ->whereNotIn('blkn_singer_id', $singers_id_array) // If blkn_singer_id is not in $singers_id_array. remove it.
            ->where('blkn_tour_id', $id)
            ->delete();
        }

        Session::flash('success', 'Tour Updated Successfuly!');
        return redirect('tours');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
