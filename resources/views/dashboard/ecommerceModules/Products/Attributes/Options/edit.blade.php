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
              <form action="{{ aurl('Products/Attributes/' . session('attribute_id') . '/Options/' . $data[0]->id) }}"
                method="post"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <input type="hidden"
                  name="option_id"
                  value="{{ $data[0]->id }}">
                <span class="section">Edit Category</span>

                @foreach ($data[0]->value as $value)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $value->language }}">Name
                      {{ $value->language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="name_{{ $value->language }}"
                        placeholder="News"
                        value="{{ $value->name }}" />
                    </div>
                  </div>
                @endforeach

                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                    <button type='submit'
                      class="btn btn-primary">Submit</button>
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
