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

      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Table design <small>Custom design</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{ aurl('Customer/Files/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                  {{ trans('admin.addFile') }}</a>
              </li>
            </ul>

            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            <p>
              @include('dashboard.layouts.messages')
            </p>

            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    {{-- <th>
                            <input type="checkbox" id="check-all" class="flat">
                          </th> --}}
                    <th class="column-title"># </th>
                    <th class="column-title">{{ trans('admin.file') }} </th>
                    <th class="column-title">{{ trans('admin.download') }} </th>
                    <th class="column-title">{{ trans('admin.reply') }} </th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>

                  </tr>
                </thead>

                <tbody>
                  @foreach ($data as $key => $value)
                    @php
                      $pointer = $key % 2 == 0 ? 'even pointer' : 'odd pointer';
                    @endphp

                    <tr class="{{ $pointer }}">
                      <td class=" ">{{ ++$key }}</td>
                      <td class=" ">{{ $value->title }} </td>
                      <td class=" ">
                        <a data-toggle="modal" data-target=".bs-download-modal-lg{{ $value->id }}"
                          class="btn btn-primary">{{ trans('admin.download') }}</a>
                      </td>

                      <td>
                        <a data-toggle="modal" data-target=".bs-reply-modal-lg{{ $value->id }}"
                          class="btn btn-primary">{{ trans('admin.reply') }}</a>
                      </td>
                      <td class=" last">
                        <a data-toggle="modal" data-target=".bs-example-modal-lg{{ $value->id }}"
                          class="btn btn-danger">{{ trans('admin.delete') }}</a>

                      </td>
                    </tr>

                    {{-- Reply Modal --}}
                    <div class="modal fade bs-reply-modal-lg{{ $value->id }}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span>
                            </button>
                          </div>
                     
                          <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Upload File</h5>
                                    </div>

                                    <div class="card-body">
                                        <div id="upload-container" class="text-center">
                                            <button id="browseFile" class="btn btn-primary">Brows File</button>
                                        </div>
                                        <div class="progress mt-3" style="height: 25px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                          {{-- <form action="{{ aurl('Customer/Files/') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $value->id }}">

                            <div class="modal-body">
                              <span class="section">File Info</span>
                              <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3  label-align">Title<span
                                    class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                  <input class="form-control" name="title" value="{{ old('title') }}"
                                    placeholder="ex. John f. Kennedy" required="required" />
                                </div>
                              </div>

                              <div class="field item form-group">
                                <label
                                  class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.file') }}<span
                                    class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                  <input class="form-control" name="file" value="{{ old('file') }}" class='file'
                                    required="required" type="file" />
                                </div>
                              </div>

                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                            </div>
                          </form> --}}

                        </div>
                      </div>
                    </div>

                    {{-- Download Modal --}}
                    <div class="modal fade bs-download-modal-lg{{ $value->id }}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span>
                            </button>
                          </div>

                          <form action="{{ aurl('Customers/File/Download') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $value->id }}">

                            <div class="modal-body">
                              <span class="section">File Info</span>
                              <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3  label-align">Delete file after
                                  download?<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                  <input type="checkbox" name="deleteOld" value="1" />
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">{{ trans('admin.download') }}</button>
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div class="modal fade bs-example-modal-lg{{ $value->id }}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span>
                            </button>
                          </div>

                          <form action="{{ aurl('Customer/Files/' . $value->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <div class="modal-body">
                              <h4>{{ trans('admin.deleteCon') }}</h4>
                              <p>{{ trans('admin.deleteMessageModal') . $value->id }}</p>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">{{ trans('admin.confirm') }}</button>
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>
                  @endforeach


                </tbody>
              </table>
            </div>


          </div>
        </div>
      </div>


    </div>
  </div>
  <!-- /page content -->
  @include('dashboard.layouts.uploads.upload_customer')

@endsection
