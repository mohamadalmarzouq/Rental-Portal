@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        @include('auth.includes.flash_mesages')
        {{--        <div class="row"> --}}
        {{--            <div class="col-12"> --}}
        {{--                <div class="d-flex align-items-center justify-content-between mg-b-20"> --}}
        {{--                    <h3 class="m-0 tx-27 tx-bold">Notification Settings</h3> --}}
        {{--                </div> --}}
        {{--                <div class="card card-body flex-row justify-content-between"> --}}
        {{--                    <form class="w-100" method="POST" --}}
        {{--                          action="{{ route('update_notification',['id' => $data->id]) }}" --}}
        {{--                          enctype="multipart/form-data"> --}}
        {{--                        @csrf --}}
        {{--                        <div class="row"> --}}
        {{--                            <div class="col-sm-2"> --}}
        {{--                                <label for="" class="mb-1 tx-medium">Notification On/Off</label> --}}
        {{--                                <div class="w-100 mb-4 mt-2 position-relative"> --}}
        {{--                                    <input type="hidden" name="notification_enable" value="0"/> --}}
        {{--                                    <input type="checkbox" --}}
        {{--                                           {{ $data->notification_enable ? 'checked' : '' }} name="notification_enable" --}}
        {{--                                           value="1"/> --}}
        {{--                                </div> --}}
        {{--                            </div> --}}
        {{--                        </div> --}}
        {{--                        <!-- <div class="text-right submitBtn mt-3"> --}}
        {{--                            <button class="btn btn-primary download-btn" type="submit">Submit</button> --}}
        {{--                        </div> --> --}}
        {{--                    </form> --}}
        {{--                </div> --}}
        {{--            </div> --}}



        <div class="col-12 mg-y-60">
            <div class="d-flex align-items-center justify-content-between mg-b-20">
                <h3 class="m-0 tx-27 tx-bold">Settings</h3>
            </div>
            <div class="card card-body flex-row justify-content-between">
                <div class="col-md-6">
                <form class="w-100" method="POST" action="{{ route('update_notification', ['id' => $data->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-2 col-md-4">
                            <label for="" class="mb-1 tx-medium">Notification On/Off</label>
                            <div class="w-100 mb-4 mt-2 position-relative">
                                <input type="hidden" name="notification_enable" value="0" />
                                <input type="checkbox" {{ $data->notification_enable ? 'checked' : '' }}
                                    name="notification_enable" value="1" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Grace Period</label>
                            <select name="grace_period" id="grace_period"class="form-control border">
                                <option value="">Select Day</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value={{ $i }} {{ $data->grace_period == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Due Date</label>

                            <select name="due_date" id="due_date"class="form-control border">
                                <option value="">Select Day</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value={{ $i }} {{ $data->due_date == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Over Due Date</label>

                            <select name="over_due_date" id="over_due_date"class="form-control border" disabled>
                                <option value="{{ $data->over_due_date }}">{{ $data->over_due_date }}</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Company Name</label>
                            <input type="text" maxlength="120" value="{{old('company_name', $data->company_name)}}" name="company_name" id="company_name" class="form-control border">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Company Address</label>
                            <input type="text" name="company_address" value="{{old('company_address', $data->company_address)}}" id="company_address" class="form-control border">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium">Upload Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control border">
                        </div>
                    </div>
                    {{-- <div class="row">
                            <div class="col-sm-2 ">
                                <label for="" class="tx-medium">Overdue Days</label>
                                <input type="number" name="overdue_days" value="{{$data->overdue_days?$data->overdue_days:0}}" id="overdue_days" class="form-control"
                                       placeholder="Overdue Days"
                                       >

                            </div>
                        </div> --}}

                    <div class="text-right submitBtn mt-4">
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>
                </form>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-2 col-md-4 ">
                            <label for="" class="mb-1 tx-medium"></label>
                            <img class="rounded-circle" style="height: 140px;width:150px" src="{{ getUserAvatar(auth()->user()->id) }}"
                                 class="rounded-circle" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{--            <div class="col-12 mg-y-60"> --}}
        {{--                <div class="d-flex align-items-center justify-content-between mg-b-20"> --}}
        {{--                    <h3 class="m-0 tx-27 tx-bold">Overdue Amount</h3> --}}
        {{--                </div> --}}
        {{--                <div class="card card-body flex-row justify-content-between"> --}}
        {{--                    <form class="w-100" method="POST" --}}
        {{--                          action="{{ route('update_notification',['id' => $data->id]) }}" --}}
        {{--                          enctype="multipart/form-data"> --}}
        {{--                        @csrf --}}
        {{--                        <div class="row"> --}}
        {{--                            <div class="col-sm-2 "> --}}
        {{--                                <label for="" class="mb-1 tx-medium">Overdue Amount</label> --}}
        {{--                                <!-- <div class="w-100 mb-4 mt-2 position-relative"> --}}
        {{--                                    <input type="hidden" name="notification_enable" value="0"/> --}}
        {{--                                    <input type="checkbox" --}}
        {{--                                    {{ $data->notification_enable ? 'checked' : '' }} name="notification_enable" --}}
        {{--                                    value="1"/> --}}
        {{--                                </div> --> --}}
        {{--                                <select name="series" id="series"class="form-control border"> --}}
        {{--                                    <option value="">Select Day</option> --}}
        {{--                                    @for ($i = 1; $i <= 30; $i++) --}}
        {{--                                        <option value="">{{$i}}</option> --}}
        {{--                                    @endfor --}}
        {{--                                </select> --}}
        {{--                            </div> --}}
        {{--                        </div> --}}
        {{--                        <!-- <div class="text-right submitBtn mt-3"> --}}
        {{--                            <button class="btn btn-primary download-btn" type="submit">Submit</button> --}}
        {{--                        </div> --> --}}
        {{--                    </form> --}}
        {{--                </div> --}}
        {{--                <div class="text-right submitBtn mt-4"> --}}
        {{--                    <button class="btn btn-primary download-btn" type="submit">Submit</button> --}}
        {{--                </div> --}}
        {{--            </div> --}}
        {{--        </div> --}}
        <!--/// first row end here ///-->
    </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript">
        $('#grace_period').on('change', function() {
            var gracePeriod = parseInt($('#grace_period').find(":selected").val());
            var dueDate = parseInt($('#due_date').find(":selected").val());
            $('#over_due_date').html(`<option value="${gracePeriod+dueDate}">${gracePeriod+dueDate}</option>`);
        });

        $('#due_date').on('change', function() {
            var gracePeriod = parseInt($('#grace_period').find(":selected").val());
            var dueDate = parseInt($('#due_date').find(":selected").val());
            $('#over_due_date').html(`<option value="${gracePeriod+dueDate}">${gracePeriod+dueDate}</option>`);
        });
    </script>
@endpush
