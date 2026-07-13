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
                                        <label for="" class="mb-1">Title</label>
                                        <input class="form-control" type="text" name="title" placeholder="Enter title"
                                               value="{{ $data->title }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Select Widget Type</label>
                                        <select class="form-control" id="widget_type_selected" name="slug">
                                            <option value="">
                                                Select Type
                                            </option>
                                            @foreach($types as $type)
                                                <option {{ $data->type_id == $type->id ? 'selected' : '' }}
                                                        value="{{ $type->id }}">
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
                                               value="{{ $data->icon }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Select Role</label>
                                        <select class="form-control select2" name="role_ids[]" multiple id="role-id">
                                            @foreach($roles as $role)
                                                <option {{ in_array($role->id , $widget_roles) ? 'selected' : ''  }}
                                                        value="{{ $role->id }}">
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
                                        <textarea rows="3" placeholder="Enter query" name="query" id="query"
                                                  class="form-control">{{ $data->query }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="module">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Select Module</label>
                                        <input class="form-control" type="text" name="module" placeholder="Enter Icon"
                                               value="{{ $data->module }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Status</label>
                                        <select class="form-control" name="status_id" id="status_id">
                                            @foreach($statuses as $status)
                                                <option {{ $data->status_id == $status->id ? 'selected' : ''  }}
                                                        value="{{ $status->id }}">
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Select Method</label>
                                        <input class="form-control" type="text" name="method" placeholder="Enter Icon"
                                               value="{{ $data->method }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class=" text-right">
                                        <a class="btn btn-secondary mx-2" href="{{ route($module.'.show') }}">Cancel</a>
                                        <button class="btn btn-primary btn-rounded btn-lg float-right" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
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

        $('#type_id').on('change', function () {

            if ($(this).val() == 3) {
                $("#rental_div").css("display", "block");
            } else {
                $("#rental_div").css("display", "none");
            }

        });

    </script>

@endpush
