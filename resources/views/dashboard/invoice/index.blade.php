@extends('dashboard.index')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{ 'Invoice' }}</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">



                        @include('dashboard.layouts.messages')


                        <div class="x_content">
                            <form enctype="multipart/form-data" action="{{ aurl('Invoice') }}" method="post">
                                @csrf

                                <span class="section">{{ 'invoice' }}</span>


                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.FatworaType') }}</label>
                                    <div class="col-md-6 col-sm-6">

                                        @php
                                            $fatwora_types = [__('admin.visa'), __('admin.cache')];
                                        @endphp

                                        <select name="invoice_type" class="form-control">
                                            <option value="0">{{ __('admin.chooseFatworaType') }}</option>
                                            @foreach ($fatwora_types as $key => $type)
                                                <option value="{{ $key }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">phone<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-5">
                                        <input class="form-control" type="tel" id="phone" name="phone"
                                            value=" " required='required' data-validate-length-range="8,20" />
                                        <br>
                                        <button id="check" class="btn btn-primary">{{ __('admin.check') }}</button>
                                    </div>
                                </div>




                                <div class="field item form-group" id="nameDiv" style="display: none">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Customer Name<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-5">
                                        <input class="form-control" type="text" id="name" name="name"
                                            value=" " required='required' />
                                    </div>
                                </div>

                                <br> <br><br>

                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.barnches') }}</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="branch_id" class="form-control">
                                            <option value="0">{{ __('admin.branchs') }}</option>
                                            @foreach ($branchs as $key => $branch)
                                             <option value="{{ $branch->id }}">{{$branch->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.itemsTypes') }}</label>
                                    <div class="col-md-6 col-sm-6">

                                        <select name="item_id" class="form-control">
                                            <option value="0">{{ __('admin.itemsTypes') }}</option>
                                            @foreach ($items as $key => $item)
                                                <option value="{{ $item->id }}">{{ $item->itemsDetails[0]->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.Quantity') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-5">
                                        <input class="form-control" type="number" id="quantity" name="quantity"
                                            required='required' />
                                    </div>
                                </div>

                                <br>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type="submit" class="btn btn-primary">{{ __('admin.submit') }}</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">{{ __('admin.invoice_id') }}</th>
                            <th class="column-title">{{ __('admin.User Name') }}</th>
                            <th class="column-title">{{ __('admin.Price') }}</th>
                            <th class="column-title">{{ __('admin.Quantity') }}</th>
                            <th class="column-title">{{ __('admin.Total') }}</th>
                            <th class="column-title">{{ __('admin.discount_type') }}</th>
                            <th class="column-title">{{ __('admin.discount_value') }}</th>
                            <th class="column-title">{{ __('admin.ToatalAfterDisocount') }}</th>
                            <th class="column-title">{{ __('admin.Branch') }}</th>
                            <th class="column-title no-link last"><span class="nobr">{{ __('admin.action') }}</span></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($data as $key => $value)
                            <tr>
                                <td> {{ ++$key }}     </td>
                                <td> {{ $value->id }} </td>
                                <td> {{ $value->userDetails->name }}</td>
                                <td> {{ $value->price }}    </td>
                                <td> {{ $value->quantity }} </td>
                                <td> {{ $value->price * $value->quantity }} </td>
                                <td> {{ ($value->discount_type == 0)? __('admin.fixed'): __('admin.percentage') }} </td>
                                <td> {{ ($value->discount_type == 0)? $value->discount_value : $value->discount_value.' %'     }} </td>

                                @php
                                    $total = $value->price * $value->quantity;
                                    $priceAfterDiscount = ($value->discount_type == 0) ?  ($total - $value->discount_value )  : ($total - ($total * $value->discount_value / 100));
                                @endphp

                                <td> {{  $priceAfterDiscount }} </td>

                                 <td> 
                                         {{ $value->branchDetails->name_en }}
                                </td>

                                <td class="last">
                                    <a href="{{ aurl('generate_pdf/' . $value->id) }}" class="btn btn-info"> {{ __('admin.printPdf') }} </a>
                                </td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <!-- /page content -->

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

    <script>
        document.getElementById('check').onclick = function(e) {
            var phone = document.getElementById('phone').value;

            e.preventDefault();

            $.ajax({
                url: '{{ aurl('checkCustomer') }}',
                type: 'POST',
                data: {
                    phone: phone,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.status == 'success') {


                        if (data.data !== null) {
                            document.getElementById('name').value = data.data.name;
                        } else {

                            document.getElementById('name').value = '';
                        }

                        // make name visable
                        document.getElementById('nameDiv').style.display = 'block';

                    } else {
                        console.log('error');
                    }
                }
            });

        }
    </script>
@endsection
