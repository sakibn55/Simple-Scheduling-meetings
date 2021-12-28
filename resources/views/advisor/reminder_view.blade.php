@extends('app')
@section('title') {{ $data->title }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 mt-5 ml-auto mr-auto ">
                <div class="card border-info">
                    <div class="card-header text-white bg-info">
                        <h3>{{ $data->title }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Student: </strong><a
                                href="/profile/{{ $data->student->email }}">{{ $data->student->name }}</a></p>
                        <p>
                            <strong>Description: </strong>{{ $data->description }}
                        </p>

                        <p>
                            <strong>Start: </strong>{{ $data->start }} <br>
                            <span class="text-info">
                                {{ \Carbon\Carbon::parse($data->start)->diffForHumans() }}
                            </span>
                        </p>
                        <p>
                            <strong>End: </strong>{{ $data->end }} <br>
                            <span class="text-info">
                                {{ \Carbon\Carbon::parse($data->end)->diffForHumans() }}
                            </span>
                        </p>
                        <p>
                            <strong>Location title: </strong>{{ $data->location_title }}
                        </p>
                        <p><a target="_blank"
                                href="https://www.google.ca/maps/place/{{ $data->lattitude }},{{ $data->longitude }}">Find
                                In Google Map</a></p>
                        <p>

                        <div id="map"></div>
                        </p>
                        <p>
                            <strong>Status: </strong>
                            @if ($data->status)
                                <button class="btn btn-success">Confirmed</button>
                            @else
                                <button class="btn btn-info">Not Confirmed</button>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script>
        mapboxgl.accessToken = '{{ env('map_box_api_key') }}';
        const map = new mapboxgl.Map({
            container: 'map', // Container ID
            style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
            center: [{{ $data->longitude }}, {{ $data->lattitude }}], // Starting position [lng, lat]
            zoom: 12, // Starting zoom level
        });

        const marker = new mapboxgl.Marker() // initialize a new marker
            .setLngLat([{{ $data->longitude }}, {{ $data->lattitude }}]) // Marker [lng, lat] coordinates
            .addTo(map);

        const geocoder = new MapboxGeocoder({
            // Initialize the geocoder
            accessToken: mapboxgl.accessToken, // Set the access token
            mapboxgl: mapboxgl, // Set the mapbox-gl instance
            marker: false // Do not use the default marker style
        });
        // Add the geocoder to the map
        map.addControl(geocoder);
        // After the map style has loaded on the page,
        // add a source layer and default styling for a single point
        map.on('load', () => {
            map.addSource('single-point', {
                type: 'geojson',
                data: {
                    type: 'FeatureCollection',
                    features: []
                }
            });

            map.addLayer({
                id: 'point',
                source: 'single-point',
                type: 'circle',
                paint: {
                    'circle-radius': 10,
                    'circle-color': '#448ee4'
                }
            });

            // Listen for the `result` event from the Geocoder
            // `result` event is triggered when a user makes a selection
            //  Add a marker at the result's coordinates
            geocoder.on('result', (event) => {
                map.getSource('single-point').setData(event.result.geometry);
                let cord = event.result.geometry.coordinates;
                $('#lattitude').val(cord[1]);
                $('#longitude').val(cord[0]);
            });
        });
    </script>
@endsection
