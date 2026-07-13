<div class="invoice-box" id="invoice-box" style="width: 800px;
            margin: auto;
            padding: 20px 30px 10px;
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;">
    <table cellpadding="0" cellspacing="0" style="width: 100%;
            line-height: inherit;
            text-align: left;">
        <tr class="top">
            <td colspan="2" style=" padding: 5px;
                    vertical-align: top;">
                <table>
                    <tr>
                        <td class="title" style="font-size: 45px;
                                line-height: 45px;
                                color: #333;">
                            <img src="{{ asset('assets/img/logo.png') }}" style="width:100%; max-width:200px;"
                                 alt="">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="2" style=" padding: 5px;
                    vertical-align: top; padding-top: 30px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding-bottom: 40px;
                                vertical-align: top;">
                            <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                                <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Name: </h6>
                            </label>
                            <span>{{ $data->tenant->name }}</span><br>
                            <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                                <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Email: </h6>
                            </label>
                            <span>{{ $data->tenant->email }}</span><br>
                            <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                                <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Mobile
                                    Number: </h6>
                            </label>
                            <span>{{ $data->tenant->contact_number }}</span>
                        </td>
                        <td style=" padding: 5px;
                                vertical-align: top; text-align: right;">
                            <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                                <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Start Date: </h6>
                            </label>
                            <span>{{ date('F jS, Y', strtotime($data->start_date)) }}</span><br>
                            <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                                <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">End Date: </h6>
                            </label>
                            <span>{{ $data->end_date?date('F jS, Y', strtotime($data->end_date)): date('F jS, Y', strtotime(now()))}}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td style="background: #eee;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold; padding: 8px 5px 6px 5px;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Amount</h6>
                </label>
            </td>
            <td style="background: #eee;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold;text-align: right; padding: 8px 5px 6px 5px;">
                <span>{{ addCommaForNumeric($data->total_amount) }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Invoice Type</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span>{{ $data->type->name }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Lease</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span>{{ isset($data->lease->lease_name) ? $data->lease->lease_name : '-' }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Property</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span>{{ $data->property->name }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Unit</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span>{{ $data->unit->number }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Payment Method</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span>{{ $data->payment_method->name }}</span>
            </td>
        </tr>
        <tr class="details">
            <td style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Status</h6>
                </label>
            </td>
            <td style=" padding: 5px;
                    vertical-align: top; text-align: right;">
                <span class="non-active">{!! $data->status->status !!}  </span>
            </td>
        </tr>
        <tr class="item">
            <td colspan="2" style=" padding: 5px;
                    vertical-align: top;">
                <label for="inputEmail" style="font-size: 16px; margin-bottom: 0; font-weight: 600;">
                    <h6 style="font-size: 16px; margin-bottom: 0; font-weight: 600;">Description</h6>
                </label>
                <p>{{ $data->description }}</p>
            </td>
        </tr>
    </table>
</div>
