<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered set_modal_width" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header border-0">
                <h6 class="modal-title tx-20 tx-bold" id="exampleModalLabel2">Add New {{ setText($module,true) }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route($module.'.add') }}" id="addForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control"
                                       placeholder="Bank Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Account Title</label>
                                <input type="text" name="account_title" id="account_title" class="form-control"
                                       placeholder="Account Title">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Account Number</label>
                                <input type="text" name="account_number" id="account_number" class="form-control"
                                       placeholder="Account Number">
                            </div>
                        </div>
                    </div>
                    <div class="text-right submitBtn mt-3">
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
