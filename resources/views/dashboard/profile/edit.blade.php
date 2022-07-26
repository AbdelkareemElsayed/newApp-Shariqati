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
                              <form action="{{ aurl('Profile/Update/'.auth('admin')->user()->id) }}" method="post" novalidate
                                  enctype="multipart/form-data">

                                  @csrf
                                  @method('put')

                                  <span class="section">Personal Info</span>
                                  <div class="field item form-group">
                                      <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span
                                              class="required">*</span></label>
                                      <div class="col-md-6 col-sm-6">
                                          <input class="form-control" name="name" value="{{ $data->name }}"
                                              placeholder="ex. John f. Kennedy" required="required" />
                                      </div>
                                  </div>

                                  <div class="field item form-group">
                                      <label class="col-form-label col-md-3 col-sm-3  label-align">email<span
                                              class="required">*</span></label>
                                      <div class="col-md-6 col-sm-6">
                                          <input class="form-control" name="email" value="{{ $data->email }}"
                                              class='email' required="required" type="email" />
                                      </div>
                                  </div>


                                  <div class="form-group" style="text-align:center">
                                      <input type="checkbox" name="changePassword" />
                                      <label> Change Password ??</label>
                                  </div>



                                  <div class="field item form-group">
                                      <label class="col-form-label col-md-3 col-sm-3  label-align">New Password<span
                                              class="required">*</span></label>
                                      <div class="col-md-6 col-sm-6">
                                          <input class="form-control" type="password" id="password1" name="password" />

                                          <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()">
                                              <i id="slash" class="fa fa-eye-slash"></i>
                                              <i id="eye" class="fa fa-eye"></i>
                                          </span>
                                      </div>
                                  </div>



                                  <div class="field item form-group">
                                      <label class="col-form-label col-md-3 col-sm-3  label-align">phone<span
                                              class="required">*</span></label>
                                      <div class="col-md-6 col-sm-6">
                                          <input class="form-control" type="tel" class='tel' name="phone"
                                              value="{{ $data->phone }}" required='required'
                                              data-validate-length-range="8,20" />
                                      </div>
                                  </div>


                                  <div class="field item form-group">
                                      <label class="col-form-label col-md-3 col-sm-3  label-align">Image</label>
                                      <div class="col-md-6 col-sm-6">
                                          <input type="file"  name='image'>
                                      </div>
                                  </div>
                                  <div style="text-align:center">
                                      <img src="{{ asset('storage/' . $data->image) }}" alt="AdminImage" width="100px"
                                          height="100px">
                                  </div>

                              
                                  <input type="hidden" name="role_id" value="{{$data->role_id}}">
                                  <input type="hidden" name="id" value="{{$data->id}}">
                                  
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
