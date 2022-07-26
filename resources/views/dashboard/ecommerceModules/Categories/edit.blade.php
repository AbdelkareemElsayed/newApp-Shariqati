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
              <form action="{{ aurl('Categories/' . $category[0]->slug) }}"
                method="post"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <input type="hidden"
                  name="id"
                  value="{{ $category[0]->id }}">
                <span class="section">Edit Category</span>

                @foreach ($category[0]->description as $language)
                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="name_{{ $language->language }}">Name
                      {{ $language->language }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control"
                        name="name_{{ $language->language }}"
                        placeholder="News"
                        value="{{ $language->name }}" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="description_{{ $language->language }}">Descreiption {{ $language->language }}<span
                        class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <textarea class="form-control"
                        name="description_{{ $language->language }}"
                        placeholder="This category about....">{{ $language->description }}</textarea>
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
                        <option value="{{ $category->id }}"
                          {{ $category[0]->parent_id == $category->id ? 'selected' : '' }}>
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
                  <p><img src="{{ asset('storage/' . $category[0]->image) }}"
                      alt=""
                      width="100px"
                      height="100px"></p>

                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">Slug</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text"
                      class="form-control"
                      name='slug'
                      value="{{ $category[0]->slug }}"
                      readonly>
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
@endsection
