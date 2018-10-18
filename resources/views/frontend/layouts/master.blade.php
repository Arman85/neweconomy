<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" >
	<title>Neweconomy | @yield('title')</title>
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/sticky-footer.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/mystyles.css') }}">
	
	<!-- include Leaflet map css -->
	<link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">
	<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.Default.css" />

    <!-- jquery -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <!-- include Leaflet map js -->
    <!-- <script type='text/javascript' src='http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js'></script>
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/leaflet.markercluster.js'></script> -->

    <!--yandex maps -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <!-- <script src="{{ asset('assets/js/clusterer_icon_hover.js') }}" type="text/javascript"></script> -->
</head>
<body>
	@include('frontend.partials._header')

	@yield('content')

	@include('frontend.partials._footer')

	<script src="{{ asset('assets/js/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Other -->
	<script>
		$(document).ready(function (){
			@yield('scripts');

		});
	</script>
</body>
</html>