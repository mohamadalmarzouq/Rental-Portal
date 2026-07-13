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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Title</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title" value="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Select Widget Type</label>
                                <select class="form-control" id="widget_type_selected" name="type_id">
                                    <option value="">
                                        Select Type
                                    </option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Select Icon</label>
                                <input class="form-control" type="text" name="icon" placeholder="Select Icon"
                                       value="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1">Select Role</label>
                                <select class="form-control select2" name="role_ids[]" multiple id="role-id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="query-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1">Query</label>
                                <textarea rows="3" placeholder="Enter query" name="query" id="description"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="module">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1">Select Module</label>
                                <input class="form-control" type="text" name="module" placeholder="Enter Icon"
                                       value="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1">Select Method</label>
                                <input class="form-control" type="text" name="method" placeholder="Enter Icon"
                                       value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class=" text-right">
                                <button class="btn btn-primary btn-rounded btn-lg float-right" type="submit">Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
