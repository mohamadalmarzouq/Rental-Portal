<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <thead>
    <tr>
        @foreach(json_decode($columns) as $column)
            <th style="border: 1px solid black; padding: 7px 10px; text-align: left;">{{ ucfirst(str_replace('_',' ',$column->title)) }}</th>
        @endforeach
    </tr>
    </thead>
    @foreach($data as $row)
        <tr>
            @foreach(json_decode($columns) as $column)
                <td style="padding: 7px 10px; border: 1px solid black;">{!! getSingleRelationDataForPDF($row , $column->name) !!}</td>
            @endforeach
        </tr>
    @endforeach

</table>
