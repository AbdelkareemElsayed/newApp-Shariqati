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
            <h2>{{ $title }} <small>{{ $title }}</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{ aurl('Data/Files/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                  {{ __('admin.addFile') }}</a>

              <li><a href="{{ aurl('AccessRequests') }}" class="btn btn-primary"><i class="fa fa-eye"></i>
                  {{ __('admin.accessRequests') }}</a>
              </li>
              {{-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                    class="fa fa-wrench"></i></a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Settings 1</a>
                  <a class="dropdown-item" href="#">Settings 2</a>
                </div>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li> --}}
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
                    <th class="column-title">#</th>
                    <th class="column-title">{{ __('admin.folder_name') }}</th>
                    <th class="column-title">{{ __('admin.managePermissions ') }}</th>
                    <th class="column-title no-link last"><span class="nobr">{{ __('admin.action') }}</span>
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
                      <td class=" ">{{ $value->name }}</td>
                      <td class=" ">
                        <a data-toggle="modal" data-target=".bs-permissions-modal-lg{{ $value->id }}"
                          class="btn btn-primary">{{ trans('admin.manageAccess') }}</a>
                      </td>
                      <td class=" last">
                        <a data-toggle="modal" data-target=".bs-example-modal-lg{{ $value->id }}"
                          class="btn btn-danger">{{ trans('admin.delete') }}</a>
                      </td>
                    </tr>



                    <div class="modal fade bs-permissions-modal-lg{{ $value->id }}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span>
                            </button>
                          </div>

                          <form action="{{ aurl('Files/Permissions/' . $value->id) }}" method="post">
                            @csrf

                            <div class="modal-body">
                              <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3  label-align">Users</label>
                                <div class="col-md-6 col-sm-6">
                                  @foreach ($customers as $customer)
                                    <input type="checkbox" name='users[]' value="{{ $customer->id }}"
                                      {{ filePermissions($value->id, $customer->id) ? 'checked' : '' }}>
                                    <label class="form-label">{{ $customer->name }}</label>
                                  @endforeach
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">{{ trans('admin.confirm') }}</button>
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>

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

                          <form action="{{ aurl('Data/Files/' . $value->id) }}" method="post">
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
@endsection
