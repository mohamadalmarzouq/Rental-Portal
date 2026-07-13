<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered set_modal_width" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title mt-1" id="exampleModalLabel2">Add New {{ setText($module,true) }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route($module.'.add') }}" id="addForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="report_id" value="{{ $report_id }}">
                        <input type="hidden" name="user_id" value="{{ Auth()->user()->id }}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Schedule Date</label>
                                <input type="date" name="schedule_date" id="schedule_date"
                                       class="form-control datetimepicker"
                                       placeholder="Schedule Date"
                                       value="{{ !isset($data->schedule_date) ?: $data->schedule_date }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Schedule Time</label>
                                <input type="time" name="schedule_time" id="schedule_time"
                                       class="form-control"
                                       placeholder="Schedule Time"
                                       value="{{ !isset($data->schedule_time) ?: $data->schedule_time }}">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
