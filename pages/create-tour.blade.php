@extends('concert-back.backend-tpl')
@section('title') Create a new Tour @endsection
@section('content')
<div class="container-fluid">
	<form action="{{ route('tours.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row mb-3">
			<div class="col-12">
				<button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> SAVE TOUR</button>
				<button type="button" class="btn btn-danger" onclick="window.location.href = '/tours'"><i class="fas fa-times"></i> EXIT</button>
			</div>
		</div>
		
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Tour Information</h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-lg-7">
						<div class="row mb-3">
							<div class="col-12">
								<label class="mb-0"><span class="fw-500 dark-text">TOUR TITLE</span></label>
								<input type="text" name="tour_title" class="form-control form-control-sm rounded-0 border-dark" value="{{ old('tour_title') }}">
								@if($errors->has('tour_title'))
									<span class="text-danger fw-500">{{ $errors->first('tour_title') }}</span>
								@endif
							</div>
						</div>

						<div class="row mb-4">
							<div class="col-12" id="singerSelectContainer">
								<label class="mb-0"><span class="fw-500 dark-text">SELECT SINGERS</span></label>
								<p class="mb-0">You can select one or more singers for this tour.</p>
								<select name="singers_name[]" class="selectpicker" multiple data-live-search="false" data-style="btn-outline-secondary" data-width="100%" id="singerNameSelect">
								@foreach($singers as $singer)
								  	<option value="{{ $singer->id }}">
								  		
								  		{{ $singer->blkn_singer_firstname }} {{ $singer->blkn_singer_lastname }}
								  		@if($singer->blkn_singer_firstname && $singer->blkn_band_name || $singer->blkn_singer_lastname && $singer->blkn_band_name)
								  		-
								  		@endif
								  		{{ $singer->blkn_band_name }}
								  		
								  	</option>
								@endforeach
								</select>
								@if($errors->has('singers_name'))
									<span class="text-danger fw-500">{{ $errors->first('singer_firstname') }}</span>
								@endif
								<p class="mb-0">if a singer is not in the list above please add it here <a href="javascript::void();" class="" data-target="#addSingerModal" data-toggle="modal" onclick='addSingerClick();'>Add New Singer</a></p>
								<!-- <input type="hidden" name="tour_publishing" value="2"> -->
								<!-- <input type="hidden" name="tour_cancelling" value="2"> -->
							</div>
						</div>
						<div class="row">
							<div class="col-12 custom-cb">
								<p class="dark-text mb-1">Is Covid-19 Health Check provided at the enterance?</p>
								<label>
									<input type="radio" name="covid_health_check" value="1" {{ old('covid_health_check') === '1' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>YES</span><i class="fas fa-check-circle"></i></span>
								</label>
								<label>
									<input type="radio" name="covid_health_check" value="2" {{ old('covid_health_check') === '2' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>NO</span><i class="fas fa-check-circle"></i></span>
								</label>
								<br>
								@if($errors->has('covid_health_check'))
									<span class="text-danger fw-500">{{ $errors->first('covid_health_check') }}</span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Date</h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-auto mb-2 mb-lg-auto">
						<label class="mb-0"><span class="fw-500 dark-text">START DATE</span></label>
						<input type="text" name="from_date" class="form-control form-control-sm border-dark rounded-0" id="fromDate" autocomplete="off" value="{{ old('from_date') }}">
							@if($errors->has('from_date'))
								<span class="text-danger fw-500">{{ $errors->first('from_date') }}</span>
							@endif
					</div>
					<div class="col-12 col-sm-auto mb-2 mb-lg-auto">
						<label class="mb-0"><span class="fw-500 dark-text">TO DATE</span></label>
						<input type="text" name="to_date" class="form-control form-control-sm border-dark rounded-0" id="toDate" autocomplete="off" value="{{ old('to_date') }}">
					</div>
					<div class="col-12 col-sm-auto">
						<label class="mb-0"><span class="fw-500 dark-text">TIME</span></label>
						<input type="text" name="tour_time" class="form-control form-control-sm border-dark rounded-0" id="timePicker" value="{{ old('tour_time') }}">
							@if($errors->has('tour_time'))
								<span class="text-danger fw-500">{{ $errors->first('tour_time') }}</span>
							@endif
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Price</h5></div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-12 col-lg-7">
						<div class="row">
							<div class="col-12 col-sm-auto">
								<label class="mb-0"><span class="fw-500 dark-text">PRICE FOR ALL AGES</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
								    <span class="input-group-text rounded-0 border-success bg-success text-white pb-0 pt-0">$</span>
								  </div>
								  <input type="text" name="price_for_all_ages" class="form-control form-control-sm border-success rounded-0" id="priceForAllAges" value="{{ old('price_for_all_ages') }}">
								</div>
								@if($errors->has('price_for_all_ages'))
										<span class="text-danger fw-500">{{ $errors->first('price_for_all_ages') }}</span>
								@endif
							</div>
						</div>	
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-12 custom-cb">
						<label>
							<input type="checkbox" name="different_price" value="1" onchange="price.diffPrice(this);" {{ old('different_price') === '1' ? 'checked' : '' }}>
							<span class="custom-cb-span">
								<span>Children price is different from adult price</span>
								<i class="fas fa-check-circle"></i>
							</span>
						</label>
						@if($errors->has('different_price'))
							<span class="text-danger fw-500">{{ $errors->first('different_price') }}</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-lg-auto">
						<div class="card card-body ca-price">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-auto mb-2">
									<label class="mb-0"><span class="fw-500 dark-text">ADULT PRICE</span></label>
									<div class="input-group">
									  <div class="input-group-prepend">
									    <span class="input-group-text rounded-0 border-success bg-success text-white pt-0 pb-0">$</span>
									  </div>
									  <input type="text" name="adult_price" class="form-control form-control-sm border-success rounded-0" oninput="price.aPrice(this.value);" id="adultPrice" value="{{ old('adult_price') }}">
									</div>
									@if($errors->has('adult_price'))
										<span class="text-danger fw-500">{{ $errors->first('adult_price') }}</span>
									@endif
								</div>
							
								<div class="col-12 col-sm-12 col-md-auto mb-2">
									<label class="mb-0"><span class="fw-500 dark-text">CHILDREN AGE RANGE</span></label>
									<select name="children_age_range" id="cAgeRange" class="form-control form-control-sm rounded-0 form-select border-dark" onchange="price.childrenPriceRange(this);">
										<option value="0">Select One</option>
										<option value="1" {{ old('children_age_range') === '1' ? 'selected' : '' }}>15 and under</option>
										<option value="2" {{ old('children_age_range') === '2' ? 'selected' : '' }}>16 and under</option>
										<option value="3" {{ old('children_age_range') === '3' ? 'selected' : '' }}>17 and under</option>
										<option value="4" {{ old('children_age_range') === '4' ? 'selected' : '' }}>18 and under</option>
									</select>
									@if($errors->has('children_age_range'))
										<span class="text-danger fw-500">{{ $errors->first('children_age_range') }}</span>
									@endif
								</div>
								<div class="col-12 col-sm-12 col-md-auto children-price mb-3">
									<label class="mb-0"><span class="fw-500 dark-text children-price-label"></span></label>
									<div class="input-group">
									  <div class="input-group-prepend">
									    <span class="input-group-text rounded-0 border-success bg-success text-white pb-0 pt-0">$</span>
									  </div>
									  <input type="text" name="children_price" class="form-control form-control-sm border-success rounded-0" oninput="price.cPrice(this.value);" id="childrenPrice" value="{{ old('children_price') }}">
									</div>
									@if($errors->has('children_price'))
										<span class="text-danger fw-500">{{ $errors->first('children_price') }}</span>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Food & Drink</h5></div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-12">
						<label class="mb-1"><span class="fw-500 dark-text">IS FOOD AVAILABLE?</span></label>
					</div>
					<div class="col-12 col-lg-7">
						<div class="row">
							<div class="col-12 custom-cb">
								<label>
									<input type="radio" name="food_availability" value="1" {{ old('food_availability') === '1' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>YES</span><i class="fas fa-check-circle"></i></span>
								</label>
								<label>
									<input type="radio" name="food_availability" value="2" {{ old('food_availability') === '2' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>NO</span><i class="fas fa-check-circle"></i></span>
								</label>
							</div>
							@if($errors->has('food_availability'))
								<span class="text-danger fw-500">{{ $errors->first('food_availability') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label class="mb-1"><span class="fw-500 dark-text">IS DRINK AVAILABLE?</span></label>
					</div>
					<div class="col-12 col-lg-7">
						<div class="row">
							<div class="col-12 custom-cb">
								<label>
									<input type="radio" name="drink_availability" value="1" {{ old('drink_availability') === '1' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>YES</span><i class="fas fa-check-circle"></i></span>
								</label>
								<label>
									<input type="radio" name="drink_availability" value="2" {{ old('drink_availability') === '2' ? 'checked' : '' }}> 
									<span class="custom-cb-span"><span>NO</span><i class="fas fa-check-circle"></i></span>
								</label>
							</div>
							@if($errors->has('drink_availability'))
								<span class="text-danger fw-500">{{ $errors->first('drink_availability') }}</span>
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Location</h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-lg-7">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-12 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">NAME OF PLACE</span></label>
								<input type="text" name="name_of_place" class="form-control form-control-sm border-dark rounded-0" value="{{ old('name_of_place') }}">
								@if($errors->has('name_of_place'))
									<span class="text-danger fw-500">{{ $errors->first('name_of_place') }}</span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-lg-12 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">ADDRESS</span></label>
								<input type="text" name="tour_address" class="form-control form-control-sm border-dark rounded-0" value="{{ old('tour_address') }}">
								@if($errors->has('tour_address'))
									<span class="text-danger fw-500">{{ $errors->first('tour_address') }}</span>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-sm-12 col-md-5 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">CITY</span></label>
								<input type="text" name="tour_city" class="form-control form-control-sm border-dark rounded-0" value="{{ old('tour_city') }}">
								@if($errors->has('tour_city'))
									<span class="text-danger fw-500">{{ $errors->first('tour_city') }}</span>
								@endif
							</div>
							<div class="col-7 col-sm-7 col-md-5 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">STATE</span></label>
								<select id="" name="tour_state" class="form-control form-control-sm form-select border-dark rounded-0">
									<option value="0">Select State</option>
								  	<option value="AL" {{ old('tour_state') === 'AL' ? 'selected' : '' }}>Alabama</option>
									<option value="AK" {{ old('tour_state') === 'AK' ? 'selected' : '' }}>Alaska</option>
									<option value="AZ" {{ old('tour_state') === 'AZ' ? 'selected' : '' }}>Arizona</option>
									<option value="AR" {{ old('tour_state') === 'AR' ? 'selected' : '' }}>Arkansas</option>
									<option value="CA" {{ old('tour_state') === 'CA' ? 'selected' : '' }}>California</option>
									<option value="CO" {{ old('tour_state') === 'CO' ? 'selected' : '' }}>Colorado</option>
									<option value="CT" {{ old('tour_state') === 'CT' ? 'selected' : '' }}>Connecticut</option>
									<option value="DE" {{ old('tour_state') === 'DE' ? 'selected' : '' }}>Delaware</option>
									<option value="DC" {{ old('tour_state') === 'DC' ? 'selected' : '' }}>District Of Columbia</option>
									<option value="FL" {{ old('tour_state') === 'FL' ? 'selected' : '' }}>Florida</option>
									<option value="GA" {{ old('tour_state') === 'GA' ? 'selected' : '' }}>Georgia</option>
									<option value="HI" {{ old('tour_state') === 'HI' ? 'selected' : '' }}>Hawaii</option>
									<option value="ID" {{ old('tour_state') === 'ID' ? 'selected' : '' }}>Idaho</option>
									<option value="IL" {{ old('tour_state') === 'IL' ? 'selected' : '' }}>Illinois</option>
									<option value="IN" {{ old('tour_state') === 'IN' ? 'selected' : '' }}>Indiana</option>
									<option value="IA" {{ old('tour_state') === 'IA' ? 'selected' : '' }}>Iowa</option>
									<option value="KS" {{ old('tour_state') === 'KS' ? 'selected' : '' }}>Kansas</option>
									<option value="KY" {{ old('tour_state') === 'KY' ? 'selected' : '' }}>Kentucky</option>
									<option value="LA" {{ old('tour_state') === 'LA' ? 'selected' : '' }}>Louisiana</option>
									<option value="ME" {{ old('tour_state') === 'ME' ? 'selected' : '' }}>Maine</option>
									<option value="MD" {{ old('tour_state') === 'MD' ? 'selected' : '' }}>Maryland</option>
									<option value="MA" {{ old('tour_state') === 'MA' ? 'selected' : '' }}>Massachusetts</option>
									<option value="MI" {{ old('tour_state') === 'MI' ? 'selected' : '' }}>Michigan</option>
									<option value="MN" {{ old('tour_state') === 'MN' ? 'selected' : '' }}>Minnesota</option>
									<option value="MS" {{ old('tour_state') === 'MS' ? 'selected' : '' }}>Mississippi</option>
									<option value="MO" {{ old('tour_state') === 'MO' ? 'selected' : '' }}>Missouri</option>
									<option value="MT" {{ old('tour_state') === 'MT' ? 'selected' : '' }}>Montana</option>
									<option value="NE" {{ old('tour_state') === 'NE' ? 'selected' : '' }}>Nebraska</option>
									<option value="NV" {{ old('tour_state') === 'NV' ? 'selected' : '' }}>Nevada</option>
									<option value="NH" {{ old('tour_state') === 'NH' ? 'selected' : '' }}>New Hampshire</option>
									<option value="NJ" {{ old('tour_state') === 'NJ' ? 'selected' : '' }}>New Jersey</option>
									<option value="NM" {{ old('tour_state') === 'NM' ? 'selected' : '' }}>New Mexico</option>
									<option value="NY" {{ old('tour_state') === 'NY' ? 'selected' : '' }}>New York</option>
									<option value="NC" {{ old('tour_state') === 'NC' ? 'selected' : '' }}>North Carolina</option>
									<option value="ND" {{ old('tour_state') === 'ND' ? 'selected' : '' }}>North Dakota</option>
									<option value="OH" {{ old('tour_state') === 'OH' ? 'selected' : '' }}>Ohio</option>
									<option value="OK" {{ old('tour_state') === 'OK' ? 'selected' : '' }}>Oklahoma</option>
									<option value="OR" {{ old('tour_state') === 'OR' ? 'selected' : '' }}>Oregon</option>
									<option value="PA" {{ old('tour_state') === 'PA' ? 'selected' : '' }}>Pennsylvania</option>
									<option value="RI" {{ old('tour_state') === 'RI' ? 'selected' : '' }}>Rhode Island</option>
									<option value="SC" {{ old('tour_state') === 'SC' ? 'selected' : '' }}>South Carolina</option>
									<option value="SD" {{ old('tour_state') === 'SD' ? 'selected' : '' }}>South Dakota</option>
									<option value="TN" {{ old('tour_state') === 'TN' ? 'selected' : '' }}>Tennessee</option>
									<option value="TX" {{ old('tour_state') === 'TX' ? 'selected' : '' }}>Texas</option>
									<option value="UT" {{ old('tour_state') === 'UT' ? 'selected' : '' }}>Utah</option>
									<option value="VT" {{ old('tour_state') === 'VT' ? 'selected' : '' }}>Vermont</option>
									<option value="VA" {{ old('tour_state') === 'VA' ? 'selected' : '' }}>Virginia</option>
									<option value="WA" {{ old('tour_state') === 'WA' ? 'selected' : '' }}>Washington</option>
									<option value="WV" {{ old('tour_state') === 'WV' ? 'selected' : '' }}>West Virginia</option>
									<option value="WI" {{ old('tour_state') === 'WI' ? 'selected' : '' }}>Wisconsin</option>
									<option value="WY" {{ old('tour_state') === 'WY' ? 'selected' : '' }}>Wyoming</option>
								</select>
								@if($errors->has('tour_state'))
									<span class="text-danger fw-500">{{ $errors->first('tour_state') }}</span>
								@endif
							</div>
							<div class="col-5 col-sm-5 col-md-2 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">ZIP</span></label>
								<input type="text" name="tour_zip" class="form-control form-control-sm border-dark rounded-0" value="{{ old('tour_zip') }}">
								@if($errors->has('tour_zip'))
									<span class="text-danger fw-500">{{ $errors->first('tour_zip') }}</span>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Contact <small>(Optional)</small></h5></div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-12 col-md-12 col-lg-7">
						<div class="row mb-2">
							<div class="col-12 col-sm-6 mb-2 mb-sm-auto">
								<label class="mb-0"><span class="fw-500 dark-text">FIRST NAME</span></label>
								<input type="text" name="contact_first_name" class="form-control form-control-sm border-dark rounded-0" value="{{ old('contact_first_name') }}">
							</div>
							<div class="col-12 col-sm-6">
								<label class="mb-0"><span class="fw-500 dark-text">LAST NAME</span></label>
								<input type="text" name="contact_last_name" class="form-control form-control-sm border-dark rounded-0" value="{{ old('contact_last_name') }}">
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-sm-6 mb-2 mb-lg-auto">
								<label class="mb-0"><span class="fw-500 dark-text">PHONE#</span></label>
								<input type="text" name="contact_phone" class="form-control form-control-sm border-dark rounded-0" value="{{ old('contact_phone') }}">
							</div>
							<div class="col-12 col-sm-6">
								<label class="mb-0"><span class="fw-500 dark-text">E-MAIL</span></label>
								<input type="text" name="contact_email" class="form-control form-control-sm border-dark rounded-0" value="{{ old('contact_email') }}">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 custom-cb">
						<p class="dark-text mb-1">Set phone to public or private?</p>
						<label>
							<input type="radio" name="phone_public_private" value="1" {{ old('phone_public_private') === '1' ? 'checked' : '' }}> 
							<span class="custom-cb-span"><span>PUBLIC</span><i class="fas fa-check-circle"></i></span>
						</label>
						<label>
							<input type="radio" name="phone_public_private" value="2" {{ old('phone_public_private') === '2' ? 'checked' : '' }}> 
							<span class="custom-cb-span"><span>PRIVATE</span><i class="fas fa-check-circle"></i></span>
						</label>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Social Media <small>(Optional)</small></h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-7">
						<div class="row">
							<div class="col-12"><p class="dark-text">Paste Social Media links into appropriate fields below. Links should start with "https://" and not include an "iFrame".</p></div>
						</div>
						<div class="row">
							<div class="col-12 mb-2">
								<label class="mb-0"><span><i class="fab fa-facebook-square lead text-primary"></i> &nbsp;<span class="fw-500 dark-text">Facebook Link</span> <span class="fw-normal text-secondary">(Optional)</span></span></label>
								<input type="text"  name="facebook_link" class="form-control form-control-sm border-dark rounded-0" placeholder="Paste https:// link here" value="{{ old('facebook_link') }}">
							</div>
							<div class="col-12 mb-2">
								<label class="mb-0"><span><i class="fab fa-instagram-square lead dark-text"></i> &nbsp;<span class="fw-500 dark-text">Instagram Link</span> <span class="fw-normal text-secondary">(Optional)</span></span></label>
								<input type="text" name="instagram_link"  class="form-control form-control-sm border-dark rounded-0" placeholder="Paste https:// ink here" value="{{ old('instagram_link') }}">
							</div>
							<div class="col-12">
								<label class="mb-0"><span><i class="fab fa-youtube-square lead text-danger"></i> &nbsp;<span class="fw-500 dark-text">YouTube Link</span> <span class="fw-normal text-secondary">(Optional) Do not paste an iFrame</span></span></label>
								<input type="text" name="youtube_link"  class="form-control form-control-sm border-dark rounded-0" placeholder="Paste https:// link here" value="{{ old('youtube_link') }}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Media <small>(Optional)</small></h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-7">
						<div class="row">
							<div class="col-12 mb-2">
								<label class="mb-0"><span class="fw-500 dark-text">UPLOAD AN IMAGE</span></label><br>
								<input type="file" name="image_upload">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="card rounded-0 border-0">
			<div class="card-header pb-1 pt-1 rounded-0 border-0 bg-light-dark"><h5 class="mb-0 text-light">Description <small>(Optional)</small></h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-7">
						<label class="mb-0"><span class="fw-500 dark-text">TYPE DESCRIPTION</span></label>
						<textarea name="tour_description" id="" cols="30" rows="5" class="form-control border-dark rounded-0">{{ old('tour_description') }}</textarea>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-purple"><i class="fas fa-save"></i> SAVE TOUR</button>
						<button type="button" class="btn btn-danger" onclick="window.location.href = '/tours'"><i class="fas fa-times"></i> EXIT</button>
					</div>
				</div>
			</div>
		</section>
	</form>
</div>

<div class="modal fade" id="forAllAgesModal" tabindex="-1" role="dialog" aria-labelledby="priceForAllAgesModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-pink pt-1 pb-1">
        <h5 class="modal-title text-white" id="priceForAllAgesModal">Price For All Ages</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<h5 class="purple-text">Entered Price <span class="fw-900">$<span id="enteredPrice"></span></span></h5>
        <p class="fw-900 dark-text">Is price the same for all ages?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-purple same-price-modal" data-dismiss="modal" onclick="price.samePriceModal();">YES</button>
        <button type="button" class="btn btn-purple" data-dismiss="modal">NO</button>
      </div>
    </div>
  </div>
</div>
@endsection