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
            <h2> {{ trans('admin.admins') }} <small>{{ trans('admin.show') }}</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{ aurl('TeamMembers/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                  {{ __('admin.addMemeber') }}</a>
              </li>
            </ul>

            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            <p>
              @include('dashboard.layouts.messages')
            </p>



            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr class="headings">
                    {{-- <th>
                            <input type="checkbox" id="check-all" class="flat">
                          </th> --}}
                    <th class="column-title"># </th>
                    @foreach (languages() as $language)
                      <th class="column-title">{{ trans('admin.name_' . $language) }} </th>
                      <th class="column-title">{{ trans('admin.about_' . $language) }} </th>
                    @endforeach
                    <th class="column-title">{{ trans('admin.image') }} </th>
                    <th class="column-title">{{ trans('admin.socialLinks') }}</th>

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
                      <td class=" ">{{ $value->name_en }} </td>
                      <td class=" ">{!! $value->about_en !!} </td>
                      <td class=" ">{{ $value->name_ar }} </td>
                      <td class=" ">{!! $value->about_ar !!} </td>

                      <td class=" "> <img src="{{ asset('storage/' . $value->image) }}"
                          alt="{{ $value->name_en }}"
                          width="100px" height="100px"> </td>
                      <td>
                        <a href="{{ $value->facebook_link }}" class=""><i class="fa fa-facebook-official"
                            aria-hidden="true"></i>
                        </a>
                        <a href="{{ $value->twitter_link }}" class=""><i class="fa fa-twitter-square"
                            aria-hidden="true"></i>
                        </a>
                        <a href="{{ $value->linkedin_link }}" class=""><i class="fa fa-linkedin-square"
                            aria-hidden="true"></i>
                        </a>
                        <a href="{{ $value->youtube_link }}" class=""><i class="fa fa-youtube-square"
                            aria-hidden="true"></i>
                        </a>
                      </td>

                      <td class=" last">

                        <a data-toggle="modal" data-target=".bs-example-modal-lg{{ $value->id }}"
                          class="btn btn-danger">{{ trans('admin.delete') }}</a>


                        <a href="{{ aurl('TeamMembers/' . $value->id . '/edit') }}"
                          class="btn btn-info">{{ trans('admin.edit') }}</a> </a>
                      </td>
                    </tr>



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

                          <form action="{{ aurl('TeamMembers/' . $value->id) }}" method="post">
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
