@extends('dashboard.index')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Form Validation</h3>
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

            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Table design <small>Custom design</small></h2>


                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <p>
                            @include('dashboard.layouts.messages')
                        </p>

                        <div>


                            @php
                                if(session()->has('from') && session()->has('to') ){

                                    $from = session()->get('from');
                                    $to   = session()->get('to');

                                }else{

                                    $from = old('from');
                                    $to   = old('to');
                                }
                            @endphp
                            <form class="form-label-left input_mask" method="GET"
                                action="{{ aurl('Report/Statistics/Users/Generate') }}">

                                <div class="col-md-3 col-sm-3  ">
                                    <input type="date" class="form-control date" id="inputSuccess2" placeholder="Date From"
                                        name="from" value="{{ $from }}">
                                </div>

                                <div class="col-md-3 col-sm-3 ">
                                    <input type="date" class="form-control" id="inputSuccess3" placeholder="Date TO"
                                        name="to" value="{{$to }}">

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 col-sm-3  offset-md-3">
                                        <button type="submit" class="btn btn-success">GO</button>
                                    </div>
                                    @if (session()->has('reportData') && session()->has('data'))
                                    <div class="col-md-3 col-sm-3  offset-md-3">
                                        <a href="{{aurl('Report/Statistics/generate_pdf')}}"  class="btn btn-danger">{{__('admin.pdf')}}</a>
                                    </div>
                                    @endif

                                </div>
                            </form>
                        </div>



                        @if (session()->has('data'))
                            @php
                                $data = session()->get('data');
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">{{ __('admin.Title') }}</th>
                                            <th class="column-title">{{ __('admin.Statistics') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td>{{ __('logins') }}</td>
                                            <td>{{ $data['logins'] }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('LogOuts') }}</td>
                                            <td>{{ $data['logout'] }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('New Accounts') }}</td>
                                            <td>{{ $data['register'] }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Top Vists Country') }}</td>
                                            <td>
                                                @foreach ($data['countries'] as $country)
                                                    @php
                                                        $countryName = empty($country->country) ? __('no Name') : $country->country;
                                                    @endphp

                                                    {!! $countryName . ' || ' . $country->total . '<br>' !!}
                                                @endforeach

                                            </td>
                                        </tr>


                                        <tr>
                                            <td>{{ __('Top Active Users') }}</td>
                                            <td>
                                                @foreach ($data['topUsers'] as $key => $User)
                                                    {!! ++$key . '-' . $User->name . '<br>' !!}
                                                @endforeach

                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        @endif


                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- /page content -->
@endsection
