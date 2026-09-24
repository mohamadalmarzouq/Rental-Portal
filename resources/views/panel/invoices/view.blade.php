@extends('panel.master')

@section('main')
    {{-- <div class="invoice-box" id="invoice-box" style="width: 800px;
            margin: auto;
            padding: 20px 30px 10px;
            border: 1px solid #eee;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;"> --}}
    @push('custom-head')
        <style>
            .invoice-box {
                width: 800px;
                margin: auto;
                /* border: 1px solid #eee; */
                background: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            }

            .box-padding {
                padding: 20px 30px;
            }

            table tr th {
                text-align: right;
            }
        </style>
    @endpush
    <div class="invoice-box mb-5">
        <div class="box-padding">
            <div class="d-flex align-items-center border-bottom pb-4">
                <img src="{{ auth()->user()->logo ? asset(auth()->user()->logo) : 'https://sandbox4.cubix.co/staging/rent-portal/public/assets/img/logo.png' }}"
                    class="img-fluid" width="200" alt="" />
                <h6 class="mb-0 pl-5 ml-5 font-weight-bold">
                    {{ auth()->user()->company_name ? auth()->user()->company_name : 'Real Estate Portal' }}</h6>
            </div>
            <div class="row mt-5 justify-content-between">
                <div class="col">
                    <div><strong>Invoice no:</strong> INV-{{ $data->id ?? 'N/A' }}</div>
                </div>
                <div class="col text-right">
                    <div><strong>Date:</strong> {{ date('d/m/Y', strtotime($data->created_at)) }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div><strong>Company Address:</strong> {{ auth()->user()->company_address ?? '' }}</div>
                </div>
            </div>
            <!-- <div class="row mt-5">
                      <div class="col-12 p-4 shadow-sm">
                        <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                          Received from
                        </h5>
                        <table class="table table-borderless">
                          <thead class="bg-light">
                            <tr>
                              <th scope="col" class="text-left">Name</th>
                              <th scope="col" class="text-left">Property</th>
                              <th scope="col" class="text-left">Unit no</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>User input</td>
                              <td>200</td>
                              <td>200</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div> -->
            <div class="row mt-5">
                <div class="col-12 p-4 shadow-sm">
                    <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                        Billed to
                    </h5>
                    <div class="w-100 mb-2">
                        @if ($data->tenant)
                            <strong>Name:</strong> {{ $data->tenant->name ?? '' }}
                        @endif
                    </div>
                    <div class="w-100 mb-2"><strong>Property:</strong> {{ $data->invoice_property ?? '' }}</div>
                    <div class="w-100"><strong>Unit no:</strong> {{ $data->invoice_unit ?? '' }}</div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 p-4 shadow-sm">
                    <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                        Description
                    </h5>
                    <table class="table table-borderless">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (count($data->invoice_extras))
                    @foreach ($data->invoice_extras as $invoiceExt)
                    <tr>
                    <td>{{ date('M',strtotime($invoiceExt->created_at)) }}</td>
                    <td class="text-right">{{ number_format($invoiceExt->amount,3) }}</td>
                    </tr>
                    @endforeach
                 @else --}}
                            @php
                                $invoice_total = $data->invoice_extras->sum('amount');
                                if (!$invoice_total) {
                                    $invoice_total = $data->total_amount;
                                }
                            @endphp
                            <tr>
                                <td>{{ date('M', strtotime($data->created_at)) }}</td>
                                <td class="text-right">{{ number_format($invoice_total) }}</td>
                            </tr>
                            {{-- @endif --}}
                        </tbody>
                    </table>
                    <div class="col">
                        <div class="border-top pt-3 d-flex justify-content-between">
                            <strong>Total</strong>
                            <div class="px-3 py-1 rounded-sm bg-light">{{ addCommaForNumeric($invoice_total) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row mt-5">
                      <div class="col-12 p-4 shadow-sm">
                        <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                          Payment method
                        </h5>
                        <table class="table table-borderless">
                          <thead class="bg-light">
                            <tr>
                              <th scope="col" class="text-left">Method</th>
                              <th scope="col" class="text-left">Cheque no</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Cheque</td>
                              <td>12345</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div> -->
            <div class="row mt-4">
                <div class="col-12 p-4 shadow-sm">
                    <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                        Authorized signatory
                    </h5>
                    <div class="row">
                        <div class="col-12 mt-4 mb-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>---------------------------------------</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer bg-light py-3 mt-4">
            <div class="container">
                <div class="row justify-content-center">
                    @if ($data->tenant)
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-envelope mr-2"></i>
                            {{ $data->tenant->name ?? '' }}
                        </div>
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-phone mr-2"></i>
                            {{ $data->tenant->email ?? '' }}
                        </div>
                        <div class="col-4 text-center">
                            <i class="fa-solid fa-mobile-button mr-2"></i>
                            {{ $data->tenant->contact_number ?? '' }}
                        </div>
                    @endif

                </div>
            </div>
        </footer>
    </div>
    {{-- </div> --}}
@endsection
