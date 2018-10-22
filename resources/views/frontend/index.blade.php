@extends('frontend.layouts.master')

@section('title', 'Главная')

@section('content')
<div class="container-fluid">
	<div class="map-container">
		<div class="row">
			<div class="col-lg-12">
				<h1 style="text-align: center;">Карта  развития наукоемкой экономики в регионах Казахстана</h1>
				<div id="map"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	ymaps.ready(function () {
		var myMap = new ymaps.Map('map', {
		center: [48.548043,66.904544],
		zoom: 15
		}, {
		searchControlProvider: 'yandex#search'
		}),
		clusterer = new ymaps.Clusterer({
		preset: 'islands#invertedVioletClusterIcons',
		clusterHideIconOnBalloonOpen: false,
		geoObjectHideIconOnBalloonOpen: false
		});

		/**
		* Кластеризатор расширяет коллекцию, что позволяет использовать один обработчик
		* для обработки событий всех геообъектов.
		* Будем менять цвет иконок и кластеров при наведении.
		*/
		clusterer.events
		// Можно слушать сразу несколько событий, указывая их имена в массиве.
		.add(['mouseenter', 'mouseleave'], function (e) {
		var target = e.get('target'),
		type = e.get('type');
		if (typeof target.getGeoObjects != 'undefined') {
		// Событие произошло на кластере.
		if (type == 'mouseenter') {
		target.options.set('preset', 'islands#invertedPinkClusterIcons');
		} else {
		target.options.set('preset', 'islands#invertedVioletClusterIcons');
		}
		} else {
		// Событие произошло на геообъекте.
		if (type == 'mouseenter') {
		target.options.set('preset', 'islands#pinkIcon');
		} else {
		target.options.set('preset', 'islands#violetIcon');
		}
		}
		});

		var getPointData = function (balloonContentBody, clusterCaption) {
		    return {
		    balloonContentBody: 'балун <strong>метки ' + balloonContentBody + '</strong>',
		    clusterCaption: 'метка <strong>' + clusterCaption + '</strong>'
		    };
		},

		getPointOptions = function () {
		return {
		preset: 'islands#violetIcon'
		};
		},

		points = [
			
				{{--@foreach($businesses as $business)
					[
						{{ $business->latitude.','.$business->longitude }}
					],
				@endforeach--}}

				@foreach($businesses as $business)
		            {
		                balloonContentBody: {{ $business->name }}
		                clusterCaption: {{ $business->name }},
		                coordinates: '{{ $business->latitude.','.$business->longitude }}'
		            },
		       
		        @endforeach
			
		],
		geoObjects = [];

		{{--for(var i = 0, len = points.length; i < len; i++) {
		geoObjects[i] = new ymaps.Placemark(points[i], getPointData(i), getPointOptions());
		}--}}

		for(var i = 0, len = points.length; i < len; i++) {
	      geoObjects[i] = new ymaps.Placemark(
	         points[i].coordinates, 
	         getPointData(points[i].balloonContentBody, points[i].clusterCaption), 
	         getPointOptions()
	      );
	    }

		clusterer.add(geoObjects);
		myMap.geoObjects.add(clusterer);

		myMap.setBounds(clusterer.getBounds(), {
		checkZoomRange: true
		});
	});

@endsection