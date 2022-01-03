$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.myAlert').on('closed.bs.alert', function (e) {

        var id = this.attributes['notification-id'].value;
        $.ajax({
            url: "/notification/read",
            type: "POST",
            data: {
                id: id,
            },
            success: function (response) {
                getNotifications();
            }
        })



    })

    $('.myAlertMessage').on('click', function (e) {
        var id = this.attributes['notification-id'].value;
        $.ajax({
            url: "/notification/read",
            type: "POST",
            data: {
                id: id,
            },
            success: function (response) {
                //console.log('sucess');
            }
        })
        window.location.href = '/advisor/appointment/' + this.attributes['data-slug'].value;
    });

    $('.myAlertSTDMessage').on('click', function (e) {
        var id = this.attributes['notification-id'].value;
        $.ajax({
            url: "/notification/read",
            type: "POST",
            data: {
                id: id,
            },
            success: function (response) {
                //console.log('sucess');
            }
        })
        window.location.href = '/appointment/' + this.attributes['data-slug'].value;
    });

    function getNotifications(){
        $.ajax({
            url: "/notifications",
            type: "GET",
            data: {
            //
            },
            success: function (response) {
                $('.countNotification').text(response);
            }
        })
    }
});
