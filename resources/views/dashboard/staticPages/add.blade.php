@extends('dashboard.index')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Form Validation</h3>
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
                            <form action="{{ aurl('StaticPages') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <span class="section"  >{{ trans('admin.addStaticPage') }}</span>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="Tagtitle">{{ trans('admin.Tagtitle') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="tag_title" placeholder="tag_title"
                                            value="{{ old('tag_title') }}" />
                                    </div>
                                </div>


                                @foreach (languages() as $language)
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="title_{{ $language }}">{{ __('admin.title_' . $language) }}<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" name="title_{{ $language }}"
                                                placeholder="News" value="{{ old('title_' . $language) }}" />
                                        </div>
                                    </div>


                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="content_{{ $language }}">{{ __('admin.content_' . $language) }}<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea class="form-control" id="desc_{{ $language }}" name="content_{{ $language }}"
                                                placeholder="{{ trans('admin.staticContentPlaceholder') }}....">{{ old('content_' . $language) }}</textarea>
                                        </div>
                                    </div>
                                @endforeach


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="content_ar">{{ __('admin.keywords') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea style="resize: none;" class="form-control" name="keywords"
                                            placeholder="html,css,js,...">{{ old('keywords') }}</textarea>
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.image') }}</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" class="form-control" name='image'>
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit'
                                            class="btn btn-primary">{{ trans('admin.submit') }}</button>
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
