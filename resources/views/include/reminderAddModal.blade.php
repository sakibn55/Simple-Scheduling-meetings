<div id="reminderAddModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Set Reminder</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/reminder" method="POST">
            <div class="modal-body">

                    @csrf
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                    </div>

                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location_title">Location Title</label>
                        <input type="text" class="form-control" id="location_title" name="location_title" placeholder="Enter Location Title" required>
                    </div>

                    <div class="form-group">
                        <label for="lattitude">Location lattitude</label>
                        <input type="text" class="form-control" id="lattitude" name="lattitude" placeholder="Enter Location lattitude" required>
                    </div>

                    <div class="form-group">
                        <label for="longitude">Location longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter Location longitude" required>
                    </div>

                    <div class="form-group">
                        <label for="range">Location range</label>
                        <input type="text" class="form-control" id="range" name="range" placeholder="Enter Location range" required>
                    </div>

                    <div class="form-group">
                        <label for="start">Start</label>
                        <input type="text" class="form-control datetimepicker" id="start" name="start"
                         required>
                    </div>

                    <div class="form-group">
                        <label for="end">End</label>
                        <div class='input-group date' id="datetimepicker">
                            <input type='text' class="form-control" id="end" name="end"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
          </div>
    </div>
</div>
