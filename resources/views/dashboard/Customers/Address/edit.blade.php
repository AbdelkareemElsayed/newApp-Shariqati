@extends('dashboard.index')

@section('content')
    @php

    $name = 'name';

    $name .= Title() == 'ar' ? '_ar' : '';

    @endphp


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

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Form validation <small>sub title</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                        aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Settings 1</a>
                                        <a class="dropdown-item" href="#">Settings 2</a>
                                    </div>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>


                        @include('dashboard.layouts.messages')


                        <div class="x_content">
                            <form action="{{ aurl('Address/'.$data->id) }}" method="post" novalidate enctype="multipart/form-data">

                                @csrf
                                @method('put')


                                <span class="section">{{trans('admin.addressInfo')}}</span>
                               
                               
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.Fulladdress')}}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="fulladdress"  value="{{$data->fulladdress}}" placeholder="{{trans('admin.addressHint')}}" required="required" />
                                    </div>
                                </div>
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.location')}}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input  type="url"  class="form-control" name="location"  value="{{$data->location }}" placeholder="{{trans('admin.LocationHint')}}" required="required" />
                                    </div>
                                </div>

                              
                                 <input type="hidden" name="country_id" value="{{$data->country_id}}">

                                {{-- <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.selectCountry') }}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" required name="country_id">
                                            <option>Choose option</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"  @if(() == $country->id) selected @endif>{{ $country->$name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div> --}}

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.selectState')}}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control state_id" required name="state_id">
                                            <option>Choose option</option>
                                            @foreach ($states as $state )
                                            <option value="{{$state->id}}"  @if($state->id == $data->state_id) selected @endif>{{$state->$name}}</option>     
                                            @endforeach     
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group cities"  >
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.selectCity')}}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control cityContent"  name="city_id">
                                            <option>Choose option</option>
                                            @foreach ($cities as $city )
                                            <option value="{{$city->id}}"   @if($city->id == $data->city_id)selected @endif >{{$city->$name}}</option>     
                                            @endforeach    
                                             
                                        </select>
                                    </div>
                                </div>

                    

                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.isDefault') }}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="checkbox" name="is_default" @if($data->is_default) checked @endif>
                                    </div>
                                </div>



                                <div class="ln_solid">
                                    <div class="form-group">
                                        <br>

                                        <div class="col-md-6 offset-md-3">
                                            <button type='submit' class="btn btn-primary">{{trans('admin.save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->


@include('dashboard.layouts.location.loadCityScript')
@endsection
