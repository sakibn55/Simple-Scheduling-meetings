<div id="reminderUpdateModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Your Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="UpdateReminderForm" action="/reminder" method="POST">
                <div class="modal-body">

                    @csrf
                    {{ method_field('PUT') }}
                    <input type="hidden" name="slug" id="UpdateSlug">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="titleUpdate" name="title" placeholder="Enter Title"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="descriptionUpdate" name="description" rows="3"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location_title">Location Title</label>
                        <input type="text" class="form-control" id="location_title_update" name="location_title"
                            placeholder="Enter Location Title" required>
                    </div>

                    <div id="map_update"></div>

                    <input type="hidden" class="form-control" id="lattitudeUpdate" name="lattitude">
                    <input type="hidden" class="form-control" id="longitudeUpdate" name="longitude">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Changes</button>
                </div>

        </div>
    </div>
    </form>
</div>
</div>
