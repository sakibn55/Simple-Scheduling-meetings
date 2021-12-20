<div id="advisorAddModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Set Reminder</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="/advisor/store" method="POST">
            <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="start">Start</label>
                        <input type="text" class="form-control datetimepicker" id="start" name="start"
                         required>
                    </div>

                    <div class="form-group">
                        <label for="end">End</label>
                        <input type="text" class="form-control" id="end" name="end"
                         required>
                    </div>
                    <div class="form-check">
                        <input type="hidden" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                          Available
                        </label>
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
