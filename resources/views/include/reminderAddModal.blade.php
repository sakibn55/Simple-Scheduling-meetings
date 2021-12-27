<div id="reminderAddModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Make An Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/reminder" method="POST">
                <div class="modal-body">

                    @csrf

                    <input type="hidden" class="form-control" value="@if (request('advisor_email') !== null){{ request('advisor_email') }}@endif" name="advisor_email">


                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location_title">Location Title</label>
                        <input type="text" class="form-control" id="location_title" name="location_title"
                            placeholder="Enter Location Title" required>
                    </div>
                    <div id="map"></div>

                    {{-- hidden fields will autocomplete --}}
                    <input type="hidden" class="form-control" id="lattitude" name="lattitude" value="45.580467">
                    <input type="hidden" class="form-control" id="longitude" name="longitude" value="-73.705079">
                    <input type='hidden' class="form-control" id="end" name="end" />
                    <input type="hidden" class="form-control" id="start" name="start">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
