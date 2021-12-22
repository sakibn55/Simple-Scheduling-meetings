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

    var calendar = $('#calendar').fullCalendar({
        editable: true,
        defaultView: 'agendaWeek',
        initialView: 'listWeek',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: data,
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {

            let dataAvailable = [];
            var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
            $.ajax({
                url: "/advisor/avaibility",
                type: "GET",
                success: function (response) {
                    for (let i = 0; i < response.length; i++) {
                        let avaibility = {
                            'start': response[i].start,
                            'end': response[i].end
                        };
                        dataAvailable.push(avaibility);
                    }
                    dataAvailable.forEach(function (item, index, array) {
                        var result = dateCheck(item.start, item.end, start, end); //return boolean
                        if (result) {
                            $('#start').val(start);
                            $('#end').val(end);
                            $('#reminderAddModal').modal('show');
                        }
                    })
                }
            })
        },
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
                    $('#rangeUpdate').val(response.range);
                    $('#startUpdate').val(response.start);
                    $('#endUpdate').val(response.end);
                    $('#UpdateID').val(response.id);
                    $('#UpdateReminderForm').attr('action', '/reminder/' + slug);

                }
            })
            $('#reminderUpdateModal').modal("show");
        },
        editable: true,
        eventDrop: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var slug = event.slug;
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
        },
        eventResize: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var slug = event.slug;
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
        },

    });
});
