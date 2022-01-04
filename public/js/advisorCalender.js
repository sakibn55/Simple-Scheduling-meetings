$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const currentDate = new Date();
    var AdvisorCalendar = $('#AdvisorCalendar').fullCalendar({
        editable: true,
        defaultView: 'agenda',
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
        allDaySlot: false,
        minTime: "9:00:00",
        events: '/advisor',
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {

            var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
            $.ajax({
                url: "/advisor/store",
                type: "POST",
                data: {
                    start: start,
                    end: end,
                    type: 'store'
                },
                success: function (response) {
                    AdvisorCalendar.fullCalendar('refetchEvents');
                }
            })

        },
        eventClick: function (event) {
            if (confirm("Are you sure you want to remove it?")) {
                var id = event.id;
                $.ajax({
                    url: "/advisor/delete",
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function (response) {
                        AdvisorCalendar.fullCalendar('refetchEvents');
                    }
                })
            }
        },
        editable: true,
        eventDrop: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var id = event.id;
            $.ajax({
                url: "/advisor/update",
                type: "POST",
                data: {
                    id: id,
                    start: start,
                    end: end,
                },
                success: function (response) {
                    AdvisorCalendar.fullCalendar('refetchEvents');
                }
            })
        },
        eventResize: function (event, delta) {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var id = event.id;
            $.ajax({
                url: "/advisor/update",
                type: "POST",
                data: {
                    id: id,
                    start: start,
                    end: end,
                },
                success: function (response) {
                    AdvisorCalendar.fullCalendar('refetchEvents');
                }
            })
        },

    });

});
