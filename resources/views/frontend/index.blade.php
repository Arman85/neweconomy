@extends('frontend.layouts.master')

@section('title', 'Главная')

@section('content')
<div class="container-fluid">
	<div class="map-container">
		<div class="row">
			<div class="col-lg-12">
				<h1 style="text-align: center;">Hello world</h1>
				<!-- Tab links -->
				<div class="tab">
					<button class="tablinks active" onclick="openTab(event, 'map')">Карта</button>
					<button class="tablinks" onclick="openTab(event, 'list')">Список</button>
				</div>
				<!-- Tab content -->
				<div id="map" class="tabcontent" style="display: block"></div>
				<div id="list" class="tabcontent">
					<div class="listContent">
						<h3 class="third-title">Список показателей регионов</h3>
						<select name="" id="">Год:
							<option value="2018">2018</option>
							<option value="2017">2017</option>
						</select>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Эффективность научно-исследовательской деятельности для региона</th>
										<th>Эффективность передачи знаний в экономику</th>
										<th>Эффективность реализованных инновационных проектов</th>
										<th>Инновационный потенциал 1</th>
										<th>Инновационный потенциал 2</th>
										<th>Инновационная активность 1</th>
										<th>Инновационная активность 2</th>
										<th>Регион</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
										<td>Данные</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
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
		}, 
		
		{
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
		    balloonContentBody: '<strong> Компания:  </strong>' + balloonContentBody,
		    clusterCaption: 'метка <strong>' + clusterCaption + '</strong>'
		    };
		},

		getPointOptions = function () {
			return {
			preset: 'islands#violetIcon'
			};
		},

		points = [

			@foreach($businesses as $business)
		    	{
		            balloonContentBody: '{{ $business->name }}' + '<br><hr>' + '{!! $business->description !!}' + '<br><hr>',

		            clusterCaption: "{{ $business->name }}",

		            coordinates: [
		            	{{ $business->latitude.','.$business->longitude }}
		            ],
		    	},
		       
		    @endforeach
			
		],

		geoObjects = [];

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