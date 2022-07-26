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
              <form action="{{ aurl('Courses/' . $data[0]->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <span class="section">Edit Events</span>

                <input type="hidden" name="id" value="{{ $data[0]->id }}">
                @foreach ($data[0]->details as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $language->language }}">{{ __('admin.name_' . $language->language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="title_{{ $language->language }}"
                        value="{{ $language->title }}" id="first_event_name" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="details_{{ $language->language }}">{{ __('admin.details_' . $language->language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control"
                        id="details_{{ $language->language }}"
                        name="details_{{ $language->language }}">{{ $language->description }}</textarea>
                    </div>
                  </div>
                @endforeach

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.image') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file" class="form-control" name='image'>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.promovideo') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="radio" name='promo_type' id="url_promo"> URL
                    <input type="radio" name='promo_type' id="video_promo"> Video
                  </div>
                </div>


                <div class="field item form-group promo-box video_box" style="display: none;">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.promo_video') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file" class="form-control" name='promo_video'>
                  </div>
                </div>

                <div class="field item form-group promo-box url_box" style="display: none;">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.promo_video') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="url" class="form-control" name='promo_url'>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.slug') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='slug' value="{{ $data[0]->slug }}" id="slug"
                      readonly>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('admin.slug') }}</label>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      @foreach ($points['en'] as $point)
                        <input type="text" class="form-control mb-3" name='points_en[]'
                          value="{{ json_decode($point)->point }}">
                      @endforeach
                    </div>
                    <div class="col-md-6 col-sm-6">
                      @foreach ($points['ar'] as $point)
                        <input type="text" class="form-control mb-3" name='points_ar[]'
                          value="{{ json_decode($point)->point }}">
                      @endforeach
                    </div>
                  </div>
                </div>

                {{-- @foreach (languages() as $language)
                  @foreach (json_decode($data[0]['points_' . $language]) as $key => $point)
                    @if ($key == 0)
                      <div class="col-md-6 col-sm-6">
                        <input type="text" class="form-control" name='points[]' value="{{ $point }}">
                        <a id="addPoint" class="btn btn-primary "><i class="fa fa-plus text-white"></i></a>
                      </div>
                    @else
                      <div class="col-12 col-md-6 float-none d-block mx-auto mb-3 position-static">
                        <input type="text" class="form-control mx-auto" name="points[]" value="{{ $point }}">
                      </div>
                    @endif
                  @endforeach
                @endforeach --}}
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


  <!-- Include Date Range Picker -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

  <script src="https://cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>

  {{-- CKEditor --}}
  <script>
    $(document).ready(function() {
      CKEDITOR.replace('details_en');
      CKEDITOR.replace('details_ar');
    });
  </script>

  {{-- Generate Slug --}}
  {{-- <script>
    $('#first_event_name').on('keyup', function() {
      var title = Math.floor(Math.random() * 10223);
      $('#slug').val('event-name-' + title);
    });
  </script> --}}

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

  <script>
    $('#url_promo').on('click', function() {
      $(".promo-box").css('display', 'none');
      $('.url_box').css('display', 'flex');
    })

    $('#video_promo').on('click', function() {
      $(".promo-box").css('display', 'none')
      $('.video_box').css('display', 'flex');
    })
  </script>
@endsection
