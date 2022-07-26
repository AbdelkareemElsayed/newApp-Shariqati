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

        {{-- <div class="title_right">
                    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div> --}}
      </div>


      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">


            @include('dashboard.layouts.messages')


            <div class="x_content">
              <form action="{{ aurl('Products/Attributes/' . $data[0]->id) }}"
                method="post"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <input type="hidden"
                  name="id"
                  value="{{ $data[0]->id }}">
                <span class="section">Edit Category</span>

                @foreach ($data[0]->description as $description)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $description->language }}">Name
                      {{ $description->language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="name_{{ $description->language }}"
                        placeholder="News"
                        value="{{ $description->name }}" />
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
