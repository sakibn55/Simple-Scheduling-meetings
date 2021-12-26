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
    const currentDate = new Date();
    var calendar = $('#calendar').fullCalendar({
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
                    $('#UpdateSlug').val(response.slug);
                    $('#UpdateReminderForm').attr('action', '/reminder/' + slug);

                }
            })
            $('#reminderUpdateModal').modal("show");
        },
        editable: true,
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
