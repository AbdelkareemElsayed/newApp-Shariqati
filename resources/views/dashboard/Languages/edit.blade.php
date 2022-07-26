@extends('dashboard.index')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ $title }}</h3>
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
              <form action="{{ aurl('Languages/' . $data->id) }}" method="post" enctype="multipart/form-data"
                novalidate>
                @csrf
                @method('put')

                <span class="section">{{ __('admin.add_new_language') }}</span>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align" for="name">{{ __('admin.name') }}<span
                      class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="name" placeholder="English" value="{{ $data->name }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align" for="code">{{ __('admin.code') }}<span
                      class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="code" placeholder="en" value="{{ $data->code }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align" for="icon">{{ __('admin.icon') }}</label>

                  <div class="col-md-6 col-sm-6">
                    <input type="file" name="icon" class="form-control" />
                    <img src="{{ asset($data->icon) }}" alt="" width="100">
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
@endsection
