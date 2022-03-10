@extends('concert-front.front-tpl')
@section('meta-keywords') Balkan Koncerti | Balkan Music | Uzivo Muzika | Live Music | Balkan Music Schedule @endsection
@section('meta-description') Find out where your favorite singer is performin next @endsection
@section('title') Welcome to Live Balkan Music @endsection
@section('content')
@include('concert-front.sections.showcase-section')

@include('concert-front.modules.upcoming-four-pl')
<section class="container-fluid tour-section bg-dark">
	<div class="row">
		<div class="col-12 col-md-12 col-lg-4 order-2 order-md-2 order-lg-1">
			<div class="row">
				<div class="col-12 col-sm-4 col-md-4 col-lg-12 tour-img">
					<div class="row">
						<div class="col-12 p-0">
							<img src="/images/tour-img-ilda.jpg" alt="Be the first one to find our which singer is coming near your state">
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-4 col-lg-6 p-0 tour-img">
					<div class="col-12 p-0">
						<img src="/images/tours-image.jpg" alt="Be the first one to find our which singer is coming near your state">
					</div>
				</div>
				<div class="col-6 col-sm-4 col-md-4 col-lg-6 p-0 tour-img">
					<div class="col-12 p-0">
						<img src="/images/tours-image-2.jpg" alt="Be the first one to find our which singer is coming near your state">
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-8 pt-5 pb-5 order-1 order-md-1 order-lg-3">
			<div class="row h-100">
				<div class="col-12 col-md-6 offset-md-3 align-self-center pt-5 pb-5 text-center text-md-start">
					<h1 class="text-light display-5 fw-bold mb-3">Balkan Live Music Performances in the USA!</h1>
					<h4 class="text-light mb-5 fw-normal">Visit us on a regular basis to find out which singers are coming to or near your state</h4>
					<a href="{{ route('tour-list') }}" class="btn btn-pink btn-lg">VIEW TOURS</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="container-fluid pt-5 pb-5 live-music-location">
	<div class="pt-5 live-music-content">
		<div class="row live-music-content justify-content-end">
			<div class="col-md-12 col-lg-6">
				@include('concert-front.modules.balkan-live-pl')
			</div>
			<div class="col-md-12 col-lg-6">
				@include('concert-front.modules.upcoming-two-pl')
			</div>
		</div>
	</div>
</section>
<section class="container-fluid pt-5 pb-5 bg-light-dark">
	<div class="pt-5 pb-5 text-center">
		<div class="row mb-5">
			<div class="col-12">
				<h1 class="display-4 fw-normal text-light">Fans</h1>
				<h3 class="text-light fs-2 fw-normal">Subscribe to get reminders when singers schedule their tours</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-12"><a href="#" class="btn btn-purple btn-lg">START HERE</a></div>
		</div>
	</div>
</section>
<section class="container-fluid pt-5 pb-5 smca">
	<div class="container">
		<div class="pt-5 pb-5 text-center">
			<div class="row mb-5">
				<div class="col-12">
					<h1 class="display-4 fw-bold text-c-dark">Sponsors & Musicians</h1>
					<h3 class="fs-2 fw-normal">Create your account today. It's FREE and easy!</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12"><a href="{{ route('user-register') }}" class="btn btn-purple btn-lg">START HERE</a></div>
			</div>
		</div>
	</div>
</section>
@endsection 