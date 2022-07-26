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
              <form action="{{ aurl('Blogs/' . $blog[0]->slug) }}" method="post" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $blog[0]->id }}">
                <span class="section">Edit Blog</span>


                @foreach ($blog[0]->content as $k => $content)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="title_{{ $content->language }}">{{ __('admin.title_' . $content->language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="title_{{ $content->language }}" placeholder="News"
                        value="{{ $content->title }}" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="content_{{ $content->language }}">{{ __('admin.content_' . $content->language) }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control" name="content_{{ $content->language }}" placeholder="This category about...."
                        resize="none">{!! $content->content !!}</textarea>
                    </div>
                  </div>
                @endforeach


                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="content_ar">{{ __('admin.keywords') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <textarea style="resize: none;" class="form-control" name="keywords"
                      placeholder="html,css,js,...">{{ old('keywords') }}</textarea>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.image') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file" class="form-control" name='image'>
                    <img src="{{ Storage::url($blog[0]->image) }}" alt="" width="100px">
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.category') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <select name="category_id" class="form-control">
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                          {{ $category->id == $blog[0]->category_id ? 'selected' : '' }}>
                          {{ $category->description[0]->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.slug') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" name='slug' value="{{ $blog[0]->slug }}" readonly>
                  </div>
                </div>

                <input type="hidden" name="id" value="{{ $blog[0]->id }}">
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                    <button type='submit' class="btn btn-primary">Submit</button>
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
      CKEDITOR.replace('content_en');
      CKEDITOR.replace('content_ar');
    });
  </script>
@endsection
