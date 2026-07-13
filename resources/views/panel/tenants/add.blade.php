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
                                <label for="" class="mb-1 tx-medium">Name (required)</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Contact Number (required)</label>
                                <input type="number" name="contact_number" id="contact_number" class="form-control"
                                       placeholder="Contact Number" maxlength="10">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Email ID</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email ID"
                                >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">National ID (required)</label>
                                <input type="number" name="national_id" id="national_id" class="form-control"
                                       placeholder="National ID">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Age</label>
                                <input type="number" min="1" name="age" id="age" class="form-control"
                                       placeholder="Age">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                    <!--   <div class="col-12">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Residence Type</label>
                                <select name="type_id" id="type_id" class="form-control">
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->
                    </div>
                    {{--<div class="text-right submitBtn">
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>--}}
                    <div class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
                        <div class="btn_loader">
                            <div class="loader"></div>
                        </div>
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')

<script type="text/javascript">

   $(document).ready(function(){
        $('#contact_number').on('input', function() {
            var maxLength = 10;
            if ($(this).val().length > maxLength) {
                $(this).val($(this).val().slice(0, maxLength));
            }
        });
    });

</script>

@endpush
