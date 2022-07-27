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
                            <form action="{{ aurl('MicroItemsLevel/' . $data[0]->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <span class="section">Edit BusinessItems</span>

                                <input type="hidden" name="id" value="{{ $data[0]->id }}">

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="title">{{ __('admin.title') }}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="title" value="{{ $data[0]->title }}"
                                            id="item_title" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="details">{{ __('admin.details') }}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" id="details" name="content">{{ $data[0]->content }}</textarea>
                                    </div>
                                </div>



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
            CKEDITOR.replace('details');
         });
    </script>

@endsection
