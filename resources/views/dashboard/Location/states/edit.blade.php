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
                        <div class="x_title">
                            <h2>Form validation <small>sub title</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                        aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Settings 1</a>
                                        <a class="dropdown-item" href="#">Settings 2</a>
                                    </div>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>


                        @include('dashboard.layouts.messages')

                        <div class="x_content">
                            <form action="{{ aurl('Location/States/' . $data->id) }}" method="post" novalidate
                                enctype="multipart/form-data">

                                @csrf
                                @method('put')

                                <span class="section">{{ trans('admin.state_edit') }}</span>
                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.namne_en') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="name" value="{{ $data->name }}"
                                            placeholder="ex. John f. Kennedy" required="required" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label
                                        class="col-form-label col-md-3 col-sm-3  label-align">{{ trans('admin.namne_ar') }}<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="name_ar" value="{{ $data->name_ar }}"
                                            placeholder="ex. John f. Kennedy" required="required" />
                                    </div>
                                </div>


                                <div class="ln_solid">
                                    <div class="form-group">
                                        <br>

                                        <div class="col-md-6 offset-md-3">
                                            <button type='submit'
                                                class="btn btn-primary">{{ trans('admin.save') }}</button>
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
@endsection
