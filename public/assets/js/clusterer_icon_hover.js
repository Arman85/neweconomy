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

    var getPointData = function (index) {
            return {
                balloonContentBody: 'балун <strong>метки ' + index + '</strong>',
                clusterCaption: 'метка <strong>' + index + '</strong>'
            };
        },
        getPointOptions = function () {
            return {
                preset: 'islands#violetIcon'
            };
        },
        points = [
            [42.327619, 69.587306], [42.312587, 69.588851], [42.315390, 69.551085], [42.310294, 69.590396], [42.370284, 69.616609], [42.372066, 69.586911], [42.346476, 69.616437], [42.362646, 69.647164], [42.324873, 69.542084], [42.329013, 69.553929], [42.332771, 69.546805], [42.325319, 69.539423], [42.306895, 69.599471], [42.300906, 69.612603], [42.301097, 69.595180], [42.309825, 69.586854], [42.330857, 69.648361], [42.341491, 69.640121], [42.332958, 69.635229], [42.322959, 69.640550], [42.379395, 69.626682], [42.381877, 69.641445], [42.371376, 69.629772], [42.379840, 69.615953],[43.237732, 76.946970], [43.243317, 76.936756], [43.236226, 76.930491], [43.229009, 76.938730],[43.287396, 76.872307], [43.278241, 76.875912], [43.277864, 76.861664], [43.286769, 76.859432],[51.128384, 71.431348], [51.127466, 71.424868], [51.132948, 71.428344], [51.133704, 71.438429],[51.132663, 71.402176], [51.122348, 71.405266], [51.137253, 71.381920], [51.144327, 71.396769],[50.298064, 57.159779], [50.306970, 57.147076], [50.280487, 57.207175], [50.266625, 57.191725]
        ],
        geoObjects = [];

    for(var i = 0, len = points.length; i < len; i++) {
        geoObjects[i] = new ymaps.Placemark(points[i], getPointData(i), getPointOptions());
    }

    clusterer.add(geoObjects);
    myMap.geoObjects.add(clusterer);

    myMap.setBounds(clusterer.getBounds(), {
        checkZoomRange: true
    });
});