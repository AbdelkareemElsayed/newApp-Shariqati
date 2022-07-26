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
              <form action="{{ aurl('Products/Images') }}"
                method="post"
                enctype="multipart/form-data">
                @csrf

                <span class="section">Add New Images</span>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Images</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file"
                      class="form-control"
                      name='images[]'
                      multiple>
                  </div>
                </div>

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
