@push('custom-head')
    <link href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
          rel="stylesheet">
@endpush

<table id="datatable-{{ $module }}" class="table table-padded module-table">
    <thead>
    <tr>
        @foreach(json_decode($data_table_columns) as $column)
            <th>{{ ucfirst(str_replace('_',' ',$column->name)) }}</th>
        @endforeach
    </tr>
    </thead>
</table>

@php

    $route_name_for_listing = json_decode(json_encode($route_name_for_listing),true);

    if(is_array($route_name_for_listing)) {
        $route = route($route_name_for_listing['route'] , [$route_name_for_listing['key'] => $route_name_for_listing['value']]);
    } else {
        $route = route($route_name_for_listing);
    }

@endphp

@push('custom-scripts')

    <script src="{{ asset('assets/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>

    <script>
        $(function () {

           var columns = [];

            let table = $('#datatable-{{ $module }}').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: '{!! $route !!}',
                paging : {{ isset($paging) ? $paging : 'true' }},
                ordering : {!! isset($ordering) ? $ordering : 'false' !!},
                columns: {!! $data_table_columns !!},
                "fnInitComplete": function (oSettings, json) {
                    if (typeof afterDatatable == 'function') {
                        afterDatatable();
                    }
                },
                columnDefs: [
                    {
                        render: function (data, type, row) {
                            var mod = "invoices"

                            var numCols = $('#datatable-{{ $module }} thead th').length;
                            if(numCols>4){
                                columns = [2,3,4];
                            }
                            else{
                                columns = [];
                            }
                            if("{{$module}}"=="invoices")
                            {
                                if (data.length > 15) {
                                    var trimmedString = data.substring(0, 6);
                                    return trimmedString + '...';
                                }
                            }
                            if(data==null || data==""){
                                return " ";
                            }
                            return data;
                            //return trimmedString + '...';

                        },
                        targets: columns
                    }
                ],





            });

            $('#search').keyup(function () {
                table.search(this.value).draw();
            });

            table.search('').columns().search('').draw();
        });
    </script>
@endpush
