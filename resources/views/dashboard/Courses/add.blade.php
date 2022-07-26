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
              <form action="{{ aurl('Courses') }}"
                method="post"
                enctype="multipart/form-data">
                @csrf

                <span class="section">Add New Course</span>

                @foreach (languages() as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name{{ $language }}">{{ __('admin.title_' . $language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="title_{{ $language }}"
                        value="{{ old('title_' . $language) }}"
                        id="course_title" />
                    </div>
                  </div>


                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="details_{{ $language }}">{{ __('admin.details_' . $language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control"
                        id="details_{{ $language }}"
                        name="details_{{ $language }}">{{ old('details_' . $language) }}</textarea>
                    </div>
                  </div>
                @endforeach

                 <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.price') }}</label>
                    <div class="col-md-6 col-sm-6">
                      <input type="number" class="form-control" name='price'>
                    </div>
                  </div>


                    <a id="addPoint"
                      class="btn btn-primary "><i class="fa fa-plus text-white"></i></a>
                  </div>
                </div>

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


  <!-- Include Date Range Picker -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
    defer></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
    defer></script>

  <script src="https://cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>

  {{-- CKEditor --}}
  <script>
    $(document).ready(function() {
      @foreach (languages() as $language)
        {{ "CKEDITOR.replace(details_$language)" }}
      @endforeach
    });
  </script>

  {{-- Generate Slug --}}
  <script>
    $('#course_title').on('keyup', function() {
      let unedited = $('#course_title').val();
      var title = unedited.replaceAll(' ', '_') + '_' + Math.floor(Math.random() * 10223);
      $('#slug').val(title.toLowerCase());
    });
  </script>

  <script>
    $(function() {
      $('input[name="datetime"]').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        timePicker24Hour: true,
        locale: {
          format: 'YYYY/MM/DD HH:mm'
        }
      });
    });
  </script>



@endsection
