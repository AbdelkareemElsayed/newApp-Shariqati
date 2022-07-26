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
                            <form action="{{ aurl('Manufactures/' . $data[0]->slug) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{ $data[0]->id }}">
                                <span class="section">{{ $title }}</span>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                                        for="name">{{ __('admin.name') }}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="{{ __('admin.manufacture_name') }}" required="required"
                                            value="{{ $data[0]->name }}" />
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.image') }}</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" class="form-control" name='image'>
                                    </div>
                                <p><img src="{{ asset('storage/' . $data[0]->image) }}" alt="" width="100px" height="100px"></p>
                                </div>

                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.slug') }}</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name='slug'
                                            value="{{ $data[0]->slug }}" readonly>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{ $data[0]->id }}">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit' class="btn btn-primary">{{ __('admin.save') }}</button>
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
