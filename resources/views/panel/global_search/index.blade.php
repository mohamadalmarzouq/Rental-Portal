@if($search_results)
    <div>
        <ul>
            @foreach($search_results as $key_index => $result_index)
                <li>
                    <span><b>{{ setText($key_index) }}</b></span>
                @foreach($result_index as $key => $value)

                    <li><a onclick="view({{ $value['id'] }},'{{ $key_index }}','{{ setText($key_index,true) }}')"
                           href="javascript:;">{{ $value['value'] }}</a>
                    </li>
                @endforeach
                <hr>
                </li>
            @endforeach
        </ul>
    </div>
@endif
