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

        <div class="title_right">
          <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group">
              <input type="text"
                class="form-control"
                placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default"
                  type="button">Go!</button>
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
              <form action="{{ aurl('Categories') }}"
                method="post"
                enctype="multipart/form-data">
                @csrf

                <span class="section">Add New Category</span>


                @foreach (languages() as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_en">Name
                      {{ $language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="name_{{ $language }}"
                        placeholder="News"
                        value="{{ old('name_' . $language) }}" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="description_en">Descreiption
                      {{ $language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control desc_{{ $language }}"
                        name="description_{{ $language }}"
                        placeholder="This category about...."
                        resize="none">{{ old('description_' . $language) }}</textarea>
                    </div>
                  </div>
                @endforeach

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="description_en">Parent Categoroy
                    <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <select name="parent_id"
                      class="form-control">
                      <option value="0">{{ __('admin.pickParentCategory') }}</option>
                      <option value="0">{{ __('admin.hasNoParent') }}</option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                          {{ $category->description->firstWhere('language', session('lang'))->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Image</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file"
                      class="form-control"
                      name='image'>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Slug</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text"
                      class="form-control"
                      name='slug'
                      value="{{ old('slug') }}">
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





  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
    crossorigin="anonymous"></script>

  <script src="https://cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      CKEDITOR.replace('description_en');
      CKEDITOR.replace('description_ar');
    });
  </script>

  <script>
    $(document).ready(function() {
      $.ajax({
        url: "{{ url('admin/generate-slug') }}",
        method: "GET",
        success: function(data) {
          $('input[name=slug]').val(data);
        }
      })
    })
  </script>
@endsection
