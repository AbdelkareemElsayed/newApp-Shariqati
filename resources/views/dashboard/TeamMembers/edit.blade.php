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
              <form action="{{ aurl('TeamMembers/' . $data->id) }}" method="post" novalidate
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <span class="section">{{ $title }}</span>
                @foreach (languages() as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $language }}">{{ __('admin.name_' . $language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="name_{{ $language }}" placeholder="John Doe"
                        value="{{ $data->toArray()['name_' . $language] }}" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="about_{{ $language }}">{{ __('admin.about_' . $language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control" id="desc_{{ $language }}" name="about_{{ $language }}"
                        placeholder="This category about....">{{ $data->toArray()['about_' . $language] }}</textarea>
                    </div>
                  </div>
                @endforeach

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Image</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file" class="form-control" name='image'>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.facebook') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='facebook_link'
                      value="{{ $data->facebook_link }}">
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.twitter') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='twitter_link' value="{{ $data->twitter_link }}">
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.linkedin') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='linkedin_link' value="{{ $data->linkedin_link }}">
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.youtube') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='youtube_link' value="{{ $data->youtube_link }}">
                  </div>
                </div>



                <div class="ln_solid">
                  <div class="form-group">
                    <br>

                    <div class="col-md-6 offset-md-3">
                      <button type='submit' class="btn btn-primary">Submit</button>
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


  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

  <script src="https://cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      CKEDITOR.replace('about_en');
      CKEDITOR.replace('about_ar');
    });
  </script>
@endsection
