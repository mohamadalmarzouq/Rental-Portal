@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Edit {{ setText($module,true) }}</h3>
                    <div>
                        <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Name (required)</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                               value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Contact Number (required)</label>
                                        <input type="number" name="contact_number" id="contact_number"
                                               class="form-control" placeholder="Contact Number"
                                               value="{{ $data->contact_number }}" maxlength="10">
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Email ID</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               placeholder="Email ID" value="{{ $data->email }}">
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">National ID (required)</label>
                                        <input type="number" name="national_id" id="national_id"
                                               class="form-control" placeholder="National ID (optional)"
                                               value="{{ $data->national_id }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Age</label>
                                        <input type="number" min="1" name="age" id="age" class="form-control"
                                               placeholder="Age" value="{{ $data->age }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option {{ $data->gender == 'male' ? 'selected' : '' }}
                                                    value="male">Male
                                            </option>
                                            <option {{ $data->gender == 'female' ? 'selected' : '' }}
                                                    value="female">
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="" class="mb-1">Status</label>
                                    <select class="custom-select mr-0 font-weight-500" name="tenant_status_id"
                                            id="tenant_status_id">
                                        @foreach($statuses as $status)
                                            <option
                                                {{ $data->tenant_status_id == $status->id ? 'selected' : '' }}
                                                value="{{ $status->id }}">
                                                {{ $status->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_loader_wrap add position-relative d-flex align-items-center">
                                <div class="btn_loader">
                                    <div class="loader"></div>
                                </div>
                                <a class="btn btn-secondary mx-2 float-right" href="{{ url()->previous() }}">Cancel</a>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

        $('#type_id').on('change', function () {

            if ($(this).val() == 3) {
                $("#rental_div").css("display", "block");
            } else {
                $("#rental_div").css("display", "none");
            }

        });

    </script>

@endpush
