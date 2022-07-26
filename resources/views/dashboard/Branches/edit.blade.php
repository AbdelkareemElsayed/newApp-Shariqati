@extends('dashboard.index')

@php

$name = 'name';

$name .= Title() == 'ar' ? '_ar' : '';

@endphp

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{ trans('admin.settings') }}</h3>
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
                            <form action="{{ url('admin/Branches/'.$data->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <span class="section">{{ __('admin.settings') }}</span>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_en">{{ __('admin.name_en') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="name_en" placeholder="Name En"
                                            value="{{ $data->name_en }}" />
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_en">{{ __('admin.name_ar') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="name_ar" placeholder="الاسم"
                                            value="{{ $data->name_ar }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_en">{{ __('admin.email') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="email" placeholder="{{ __('email') }}"
                                            value="{{ $data->email }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="whatsapp">{{ __('admin.phone') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="tel" class="form-control" name="phone" placeholder="010xx"
                                            value="{{ $data->phone }}" />
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="location">{{ __('admin.location') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="location"
                                            placeholder="https:://maps.google.com/" value="{{ $data->location }}" />
                                    </div>
                                </div>

                                <div>
                                    <h3>{{ trans('admin.SocialLinks') }}</h3>
                                </div>
                                <hr>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="facebook">{{ __('admin.facebook') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="facebook"
                                            placeholder="https:://facebook.com/" value="{{ $data->facebook }}" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="whatsapp">{{ __('admin.whatsapp') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="tel" class="form-control" name="whatsapp"
                                            placeholder="https:://whatsapp.com/" value="{{ $data->whatsapp }}" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="instagram">{{ __('admin.instagram') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="instagram"
                                            placeholder="https:://instagram.com/" value="{{ $data->instagram }}" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="linkedin">{{ __('admin.linkedin') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="linkedin"
                                            placeholder="https:://linkedin.com/" value="{{ $data->linkedin }}" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="twitter">{{ __('admin.twitter') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="twitter"
                                            placeholder="https:://twitter.com/" value="{{ $data->twitter }}" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="tiktok">{{ __('admin.tiktok') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="tiktok"
                                            placeholder="https:://tiktok.com/" value="{{ $data->tiktok }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="snapchat">{{ __('admin.snapchat') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="url" class="form-control" name="snapchat"
                                            placeholder="https:://snapchat.com/" value="{{ $data->snapchat }}" />
                                    </div>
                                </div>


                                <div>
                                    <h3>{{ trans('admin.Address info') }}</h3>
                                </div>
                                <hr>

                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.selectCountry') }}
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" name="country_id" id="company_id">
                                            <option>Choose option</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    @if ($country->id == $data->country_id) selected @endif>
                                                    {{ $country->$name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group states">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.selectState') }}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control state_id  statesContent" name="state_id">
                                            <option>Choose option</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    @if ($state->id == $data->state_id) selected @endif>{{ $state->$name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group cities" s>
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.selectCity') }}</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control cityContent" name="city_id">
                                            <option>Choose option</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if ($city->id == $data->city_id) selected @endif>{{ $city->$name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_ar">{{ __('admin.streetName') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="streetName" placeholder="15 X Street"
                                            value="{{ $data->streetName }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_ar">{{ __('admin.buildNumber') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="buildNumber" placeholder="13 Sector A"
                                            value="{{ $data->buildNumber }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_ar">{{ __('admin.Common Places') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="commomPlaces" placeholder="Tahrier Square"
                                            value="{{ $data->commomPlaces }}" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title_ar">{{ __('admin.address Additional Info') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="address_additional" placeholder="Cairo, Egypt"
                                            value="{{ $data->address_additional }}" />
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit' class="btn btn-primary">{{ __('admin.submit') }}</button>
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
    @include('dashboard.layouts.location.loadstatesScript')
@endsection
