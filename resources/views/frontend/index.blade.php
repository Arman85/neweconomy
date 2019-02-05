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

						<label for="selectYear"><strong>Год:&nbsp;</strong></label>
						<select name="currentYear" id="selectYear">
							@foreach (App\Models\Indicator::availableYears() as $year)
								<option value="{{ $year }}" @if ($currentYear == $year) selected="selected" @endif>{{ $year }}</option>
							@endforeach
						</select>

						<label for="selectRegionId"><strong>Регион:&nbsp;</strong></label>
						<select name="currentRegionId" id="selectRegionId">
							@foreach ([-1 => 'Все регионы'] + App\Models\Region::dropdown() as $id => $name)
								<option value="{{ $id }}" @if ($currentRegionId == $id) selected="selected" @endif>{{ $name }}</option>
							@endforeach
						</select>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Компания</th>
										<th>Регион</th>
										<th>ЭФ - эффективность финансирования</th>
										<th>ИФ - статьи с импакт фактором</th>
										<th>П - количество патентов</th>
										<th>АС - количество авторских свид.</th>
										<th>И - количество созданных инноваций</th>
										<th>З - сумма затрат</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($indicators as $indicator)
										<tr>
											<td>{{ $indicator->business->name }}</td>
											<td>{{ $indicator->business->region->name }}</td>
											<td>{{ $indicator->ef_fin }}</td>
											<td>{{ $indicator->if }}</td>
											<td>{{ $indicator->p }}</td>
											<td>{{ $indicator->as }}</td>
											<td>{{ $indicator->i }}</td>
											<td>{{ $indicator->z }}</td>
										</tr>
									@endforeach
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
		zoom: 6
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
		            balloonContentBody: '{{ $business->name }}' + '<br><hr>' + '{!! $business->description !!}' + '<br><hr>' + 'ЭФ: ' + "{{ $business->indicators->first()->ef_fin }} (" + currentYear + ' г)',

		            clusterCaption: '{{ $business->name }}',

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


	var currentYear = {{ $currentYear }};
	var currentRegionId = {{ $currentRegionId }};
	console.log(currentYear, currentRegionId);

	// check year
	$('#selectYear').change(function(e) {
		console.log(this.value);

		currentYear = this.value;
		refreshPage();
	});

	// check region
	$('#selectRegionId').change(function(e) {
		console.log(this.value);

		currentRegionId = this.value;
		refreshPage();
	});

	function refreshPage() {
		location.href = '/?currentYear=' + currentYear + '&currentRegionId=' + currentRegionId;
	}

@endsection