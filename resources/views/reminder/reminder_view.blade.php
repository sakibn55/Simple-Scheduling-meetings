@extends('app')
@section('title')
    Make An Appointment
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="text-center text-primary m-4">Make an Appointment</h1>
                    <form action="/reminder" class="form-inline mb-2" method="GET">
                        @csrf
                        <div class="col">
                            <select name="advisor_email" class="custom-select" id="advisor_email">
                                @foreach ($advisors as $item)
                                    <option @if (request('advisor_email') == $item->email) selected @endif value="{{ $item->email }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="card border-info">
                        <div class="card-body" id="reminderBook">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <!-- Modal -->
                    @include('include.reminderAddModal')

                    @include('include.reminderUpdateModal')
                </div>
            </div>
        </div>

    </section>


@endsection


@section('script')
    <script>
        var data = {!! $data !!};
    </script>

    <script>
        mapboxgl.accessToken = '{{ env('map_box_api_key') }}';
        const map = new mapboxgl.Map({
            container: 'map', // Container ID
            style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
            center: [-73.569496, 45.506392], // Starting position [lng, lat]
            zoom: 12, // Starting zoom level
        });

        const marker = new mapboxgl.Marker() // initialize a new marker
            .setLngLat([-73.569496, 45.506392]) // Marker [lng, lat] coordinates
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
    <script src="{{ asset('js/studentCalender.js') }}"></script>
@endsection
