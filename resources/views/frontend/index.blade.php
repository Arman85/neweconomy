@extends('frontend.layouts.master')

@section('title', 'Главная')

@section('content')
<div class="container-fluid">
	<div class="map-container">
		<div class="row">
			<div class="col-lg-12">
				<h1 style="text-align: center;">Карта показателей эффективности</h1>

				<div>
					<label for="selectYear"><strong>Год:&nbsp;</strong></label>
					<select name="currentYear" id="selectYear">
						@foreach (App\Models\IndicatorForRegion::availableYears() as $year)
							<option value="{{ $year }}" @if ($currentYear == $year) selected="selected" @endif>{{ $year }}</option>
						@endforeach
					</select>

					<span style="width: 20px; display: inline-block;"></span>

					<label for="selectRegionId"><strong>Регион:&nbsp;</strong></label>
					<select name="currentRegionId" id="selectRegionId">
						@foreach ([-1 => 'Все регионы'] + App\Models\Region::dropdown() as $id => $name)
							<option value="{{ $id }}" @if ($currentRegionId == $id) selected="selected" @endif>{{ $name }}</option>
						@endforeach
					</select>
				</div>

				<!-- Tab links -->
				<div class="tab">
					<button class="tablinks active" onclick="openTab(event, 'map')">Карта</button>
					<button class="tablinks" onclick="openTab(event, 'regions')">Регионы</button>
					<button class="tablinks" onclick="openTab(event, 'list')">Компании</button>
				</div>
				
				<!-- Map -->
				<div id="map" class="tabcontent" style="display: block"></div>
				
				<!-- Regions -->
				<div id="regions" class="tabcontent">
					<div class="listContent">
						<h3 class="third-title">Список показателей регионов</h3>

						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
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
									@foreach ($indicatorForRegions as $indicator)
										<tr>
											<td>{{ $indicator->region->name }}</td>
											<td><strong>{{ $indicator->ef_fin }}</strong></td>
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

				<!-- Businesses -->
				<div id="list" class="tabcontent">
					<div class="listContent">
						<h3 class="third-title">Список показателей организаций</h3>

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
											<td><strong>{{ $indicator->ef_fin }}</strong></td>
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
			zoom: 5,
			controls: ['zoomControl']
		}, 
		
		{
			searchControlProvider: 'yandex#search'
		}),
		

		clusterer = new ymaps.Clusterer({
			preset: 'islands#invertedVioletClusterIcons',
			clusterHideIconOnBalloonOpen: false,
			geoObjectHideIconOnBalloonOpen: false
		});


		var objectManager = new ymaps.ObjectManager();

		//console.log(indicatorsMap);

	    // Загрузим регионы.
	    ymaps.borders.load('KZ', {
	        lang: 'ru',
	        quality: 2
	    }).then(function (result) {
	        var features = result.features.map(function (feature) {
	        	//console.log(feature);
	        	//console.log(feature.properties.name + " " + feature.properties.iso3166);

	        	feature.id = feature.properties.iso3166;

	        	var strokeColor = "#111"
	        	if (indicatorsMap[feature.id] != undefined) {
	        		//console.log('Not undefined!');
	        		
	        		if (indicatorsMap[feature.id] > 1.0) {
		        		strokeColor = "#32CD32";
		        	} else if (indicatorsMap[feature.id] == 1.0) {
		        		strokeColor = "#FFFF00";
		        	} else {
		        		strokeColor = "#DC143C";
	        		}
	        	}

	        	feature.options = {
	        		fillColor: strokeColor,
	        		fillOpacity: 0.05,
	        		strokeColor: strokeColor,
	        		strokeOpacity: 0.5,
	        		//strokeWidth: 2
	        	};

	        	//console.log(feature.options);

	        	if (feature.id == "KZ-BAY" || indicatorsMap[feature.id] == 0.0) {
	        		feature.options.fillOpacity = 0.0;
	        		feature.options.strokeOpacity = 0.0;
	        	}

	        	// place marker


	        	return feature;
	    	});



	    	// TODO: Almaty, Shymkent, and Astana - only filled markers

	    	objectManager.add(features);
	    	myMap.geoObjects.add(objectManager);
	    });

	    //console.log(regionIndicators);
	    for (var i in regionIndicators) {
	    	
        	var indicator = regionIndicators[i];
			//console.log(indicator.region.lat);

			var className = 'redStretchyIcon';
			if (indicator.ef_fin == 1.0) {
				className = 'yellowStretchyIcon';	
			} else if (indicator.ef_fin > 1.0) {
				className = 'greenStretchyIcon';
			}

        	var marker = new ymaps.Placemark(
        		[indicator.region.lat, indicator.region.lng], 
        		{
        			iconContent: indicator.ef_fin,
        			balloonContent: indicator.region.name
        		}, 
        		{
        			preset: 'islands#' + className, 	
        		}
        	);
        	myMap.geoObjects.add(marker);
		}




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

		/*myMap.setBounds(clusterer.getBounds(), {
			checkZoomRange: true
		});*/
	});


	var createChipsLayout = function (calculateSize) {
		// Создадим макет метки.
	    var Chips = ymaps.templateLayoutFactory.createClass(
	        '<div class="placemark"></div>',
	        {
	            build: function () {
	                Chips.superclass.build.call(this);
	                var map = this.getData().geoObject.getMap();
	                if (!this.inited) {
	                    this.inited = true;
	                    // Получим текущий уровень зума.
	                    var zoom = map.getZoom();
	                    // Подпишемся на событие изменения области просмотра карты.
	                    map.events.add('boundschange', function () {
	                        // Запустим перестраивание макета при изменении уровня зума.
	                        var currentZoom = map.getZoom();
	                        if (currentZoom != zoom) {
	                            zoom = currentZoom;
	                            this.rebuild();
	                        }
	                    }, this);
	                }
	                var options = this.getData().options,
	                    // Получим размер метки в зависимости от уровня зума.
	                    size = calculateSize(map.getZoom()),
	                    element = this.getParentElement().getElementsByClassName('placemark')[0],
	                    // По умолчанию при задании своего HTML макета фигура активной области не задается,
	                    // и её нужно задать самостоятельно.
	                    // Создадим фигуру активной области "Круг".
	                    circleShape = {type: 'Circle', coordinates: [0, 0], radius: size / 2};
	                // Зададим высоту и ширину метки.
	                element.style.width = element.style.height = size + 'px';
	                // Зададим смещение.
	                element.style.marginLeft = element.style.marginTop = -size / 2 + 'px';
	                // Зададим фигуру активной области.
	                options.set('shape', circleShape);
	            }
	        }
	    );

	    return Chips;
	};



	//
	// CODE
	//

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