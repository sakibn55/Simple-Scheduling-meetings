$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const dateCheck = (from, to, start, end) => {
        let fDate, lDate, startDate, endDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        startDate = Date.parse(start);
        endDate = Date.parse(end);
        if ((endDate <= lDate && startDate >= fDate)) return true
        return false;
    }

    const dateEQCheck = (from, to, start, end) => {
        let fDate, lDate, startDate, endDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        startDate = Date.parse(start);
        endDate = Date.parse(end);
        if (startDate == fDate) {
            return true;
        } else if (endDate == lDate) {
            return true;
        } else if (endDate <= lDate && startDate >= fDate) {
            return true
        } else if (lDate <= endDate && fDate >= startDate) {
            return true
        }
        return false;
    }
    var currentDate = new Date();
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        defaultView: 'agendaWeek',
        initialView: 'listWeek',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        visibleRange: function (currentDate) {
            return {
                start: currentDate.clone().subtract(1, 'days'),
                end: currentDate.clone().add(5, 'days') // exclusive end, so 3
            };
        },
        allDaySlot:false,
        minTime: "9:00:00",
        events: data,
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            let $advisor_email = $('#advisor_email').val();
            let dataAvailable = [];
            let reminders = [];
            var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
            let $advisor_available = false;
            let $remindersAlreadyBooked = false;
            $.ajax({
                url: "/advisor/avaibility/" + $advisor_email,
                type: "GET",
                success: function (response) {

                    let $advisors = response.advisor;
                    let $reminders = response.advisor_reminder;
                    for (let i = 0; i < $advisors.length; i++) {
                        let avaibility = {
                            'start': $advisors[i].start,
                            'end': $advisors[i].end,
                        };
                        dataAvailable.push(avaibility);
                    }

                    for (let i = 0; i < $reminders.length; i++) {
                        let avaibility = {
                            'start': $reminders[i].start,
                            'end': $reminders[i].end,
                        };
                        reminders.push(avaibility);
                    }

                    dataAvailable.forEach(function (item, index, array) {

                        var result = dateCheck(item.start, item.end, start, end); //return boolean

                        if (result) {
                            $advisor_available = true;
                        }

                    });

                    reminders.forEach(function (item, index, array) {
                        var result = dateEQCheck(item.start, item.end, start, end); //return boolean
                        if (result) {
                            $remindersAlreadyBooked = true;
                        }
                    });

                    if ($advisor_available && !$remindersAlreadyBooked) {
                        $('#start').val(start);
                        $('#end').val(end);
                        $('#reminderAddModal').modal('show');
                    }

                }
            })
        },
        editable: true,
        eventClick: function (event) {
            var slug = event.slug;

            $.ajax({
                url: "/reminder/" + slug,
                type: "GET",

                success: function (response) {

                    $('#titleUpdate').val(response.title);
                    $('#descriptionUpdate').val(response.description);
                    $('#location_title_update').val(response.location_title);
                    $('#lattitudeUpdate').val(response.lattitude);
                    $('#longitudeUpdate').val(response.longitude);
                    $('#startUpdate').val(response.start);
                    $('#endUpdate').val(response.end);
                    $('#UpdateSlug').val(response.slug);
                    $('#UpdateReminderForm').attr('action', '/reminder/' + slug);

                    $('#reminderUpdateModal').modal("show");
                    calendar.fullCalendar('refetchEvents');
                    // //mapbox update
                    var longitudeUpdate = $('#longitudeUpdate').val();
                    var lattitudeUpdate = $('#lattitudeUpdate').val();

                    const map_update = new mapboxgl.Map({
                        container: 'map_update', // Container ID
                        style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
                        center: [longitudeUpdate, lattitudeUpdate], // Starting position [lng, lat]
                        zoom: 12, // Starting zoom level
                    });

                    const markerUpdate = new mapboxgl.Marker() // initialize a new marker
                        .setLngLat([longitudeUpdate, lattitudeUpdate]) // Marker [lng, lat] coordinates
                        .addTo(map_update);

                    const geocoderUpdate = new MapboxGeocoder({
                        // Initialize the geocoder
                        accessToken: mapboxgl.accessToken, // Set the access token
                        mapboxgl: mapboxgl, // Set the mapbox-gl instance
                        marker: true // Do not use the default marker style
                    });
                    // Add the geocoder to the map
                    map_update.addControl(geocoderUpdate);
                    // After the map style has loaded on the page,
                    // add a source layer and default styling for a single point
                    map_update.on('load', () => {
                        map_update.addSource('single-point', {
                            type: 'geojson',
                            data: {
                                type: 'FeatureCollection',
                                features: []
                            }
                        });

                        map_update.addLayer({
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
                        geocoderUpdate.on('result', (event) => {
                            map.getSource('single-point').setData(event.result.geometry);
                            let cord = event.result.geometry.coordinates;
                            $('#lattitudeUpdate').val(cord[1]);
                            $('#longitudeUpdate').val(cord[0]);
                        });
                    });

                }

            })

        },
        editable: true,
        droppable: true,
        eventDrop: function (event, delta, revertFunc) {

            let $advisor_email = $('#advisor_email').val();
            let dataAvailable = [];
            let reminders = [];
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            let $advisor_available = false;
            let $remindersAlreadyBooked = false;
            var slug = event.slug;
            $.ajax({
                url: "/advisor/avaibility/" + $advisor_email,
                type: "GET",
                success: function (response) {

                    let $advisors = response.advisor;
                    let $reminders = response.advisor_reminder;
                    for (let i = 0; i < $advisors.length; i++) {
                        let avaibility = {
                            'start': $advisors[i].start,
                            'end': $advisors[i].end,
                        };
                        dataAvailable.push(avaibility);
                    }

                    for (let i = 0; i < $reminders.length; i++) {
                        let avaibility = {
                            'start': $reminders[i].start,
                            'end': $reminders[i].end,
                        };
                        reminders.push(avaibility);
                    }

                    dataAvailable.forEach(function (item, index, array) {

                        var result = dateCheck(item.start, item.end, start, end); //return boolean

                        if (result) {
                            $advisor_available = true;
                        }

                    });

                    reminders.forEach(function (item, index, array) {
                        var result = dateEQCheck(item.start, item.end, start, end); //return boolean
                        if (result) {
                            $remindersAlreadyBooked = true;
                        }
                    });

                    if ($advisor_available && !$remindersAlreadyBooked) {
                        $.ajax({
                            url: "/reminder/" + slug,
                            type: "PUT",
                            data: {
                                start: start,
                                end: end,
                                slug: slug,
                                type: 'update'
                            },
                            success: function (response) {
                                calendar.fullCalendar('refetchEvents');
                            }
                        })
                    } else {
                        revertFunc();
                    }

                }
            })

        },
        eventResize: function (event, delta) {
            let $advisor_email = $('#advisor_email').val();
            let dataAvailable = [];
            let reminders = [];
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var slug = event.slug;
            let $advisor_available = false;
            let $remindersAlreadyBooked = false;
            $.ajax({
                url: "/advisor/avaibility/" + $advisor_email,
                type: "GET",
                success: function (response) {

                    let $advisors = response.advisor;
                    let $reminders = response.advisor_reminder;
                    for (let i = 0; i < $advisors.length; i++) {
                        let avaibility = {
                            'start': $advisors[i].start,
                            'end': $advisors[i].end,
                        };
                        dataAvailable.push(avaibility);
                    }

                    for (let i = 0; i < $reminders.length; i++) {
                        let avaibility = {
                            'start': $reminders[i].start,
                            'end': $reminders[i].end,
                        };
                        reminders.push(avaibility);
                    }

                    dataAvailable.forEach(function (item, index, array) {

                        var result = dateCheck(item.start, item.end, start, end); //return boolean

                        if (result) {
                            $advisor_available = true;
                        }

                    });

                    reminders.forEach(function (item, index, array) {
                        var result = dateEQCheck(item.start, item.end, start, end); //return boolean
                        if (result) {
                            $remindersAlreadyBooked = true;
                        }
                    });

                    if ($advisor_available && !$remindersAlreadyBooked) {
                        $.ajax({
                            url: "/reminder/" + slug,
                            type: "PUT",
                            data: {
                                start: start,
                                end: end,
                                slug: slug,
                                type: 'update'
                            },
                            success: function (response) {
                                calendar.fullCalendar('refetchEvents');
                            }
                        })
                    } else {
                        revertFunc();
                    }
                }
            })

        },

    });
});
