@extends('dashboard.index')

@section('content')
  <!-- page content -->
  <div class="right_col"
    role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ $title }}</h3>
        </div>
      </div>


      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">

            @include('dashboard.layouts.messages')


            <div class="x_content">
              <form action="{{ aurl('Products/Attributes/' . session('attribute_id') . '/Options') }}"
                method="post"
                enctype="multipart/form-data">
                @csrf

                <span class="section">Add New Attribute Option</span>


                @foreach (languages() as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $language }}">Name
                      {{ $language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="name_{{ $language }}"
                        placeholder="News"
                        value="{{ old('name_' . $language) }}" />
                    </div>
                  </div>
                @endforeach
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                    <button type='submit'
                      class="btn btn-primary">{{ __('admin.submit') }}</button>
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
