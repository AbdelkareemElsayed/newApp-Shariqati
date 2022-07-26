@extends('dashboard.index')

@section('content')
    @php

    $name = 'name';
    $location = 'name';

    $name .= Title() == 'ar' ? '_ar' : '_en';
    $location .= Title() == 'ar' ? '_ar' : '';

    @endphp

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
                            <li><a href="{{ aurl('Branches/create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>
                                    {{ __('admin.addBranch') }}</a>
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
                                        <th class="column-title">{{ trans('admin.name') }} </th>
                                        <th class="column-title">{{ trans('admin.email') }} </th>
                                        <th class="column-title">{{ trans('admin.phone') }} </th>
                                        <th class="column-title">{{ trans('admin.whatsapp') }} </th>
                                        <th class="column-title">{{ trans('admin.show social') }} </th>
                                        <th class="column-title">{{ trans('admin.show Address') }} </th>
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
                                            <td class=" ">{{ $value->$name }} </td>
                                            <td class=" ">{{ $value->email }} </td>
                                            <td class=" ">{{ $value->phone }} </td>
                                            <td class=" ">{{ $value->whatsapp }} </td>


                                            <td>
                                                <a data-toggle="modal"
                                                    data-target=".bs-example-modal-lg-details-social{{ $value->id }}"
                                                    class="btn btn-success">{{ trans('admin.details') }}</a>
                                            </td>


                                            <td>
                                                <a data-toggle="modal"
                                                    data-target=".bs-example-modal-lg-details-address{{ $value->id }}"
                                                    class="btn btn-success">{{ trans('admin.details') }}</a>
                                            </td>

                                            <td class=" last">
                                                <a data-toggle="modal"
                                                    data-target=".bs-example-modal-lg{{ $value->id }}"
                                                    class="btn btn-danger">{{ trans('admin.delete') }}</a>
                                                <a href="{{ aurl('Branches/' . $value->id . '/edit') }}"
                                                    class="btn btn-info">{{ trans('admin.edit') }}</a> </a>
                                            </td>
                                        </tr>



                                        <div class="modal fade bs-example-modal-lg{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            {{ __('delete confirmation') }}</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ aurl('Branches/' . $value->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')

                                                        <div class="modal-body">
                                                            <h4>{{ trans('admin.deleteCon') }}</h4>
                                                            <p>{{ trans('admin.deleteMessageModal') . $value->id }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit"
                                                                class="btn btn-danger">{{ trans('admin.confirm') }}</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>



                                        {{-- Details  social Modal --}}
                                        <div class="modal fade bs-example-modal-lg-details-social{{ $value->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            {{ trans('admin.social Branch Details') }}</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h4></h4>
                                                        <p>{{ __('admin.facebook' . ':') }} <a
                                                                href="{{ $value->facebook }}">{{ $value->facebook }}</a>
                                                        </p>
                                                        <p>{{ __('admin.linkedin' . ':') }} <a
                                                                href="{{ $value->linkedin }}">{{ $value->linkedin }}</a>
                                                        </p>
                                                        <p>{{ __('admin.instagram' . ':') }} <a
                                                                href="{{ $value->instagram }}">{{ $value->instagram }}</a>
                                                        </p>
                                                        <p>{{ __('admin.twitter' . ':') }} <a
                                                                href="{{ $value->twitter }}">{{ $value->twitter }}</a></p>
                                                        <p>{{ __('admin.tiktok' . ':') }} <a
                                                                href="{{ $value->tiktok }}">{{ $value->tiktok }}</a></p>
                                                        <p>{{ __('admin.snapchat' . ':') }} <a
                                                                href="{{ $value->snapchat }}">{{ $value->snapchat }}</a>
                                                        </p>
                                                        <p></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('admin.close') }}</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>



                                        {{-- Details  Address Modal --}}
                                        <div class="modal fade bs-example-modal-lg-details-address{{ $value->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            {{ trans('admin.Address Details') }}</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>



                                                    <div class="modal-body">
                                                        <h4></h4>

                                                        <p>{{ __('location') . ' : ' }}<a
                                                                href="{{ $value->location }}">{{ __('show') }}</a></p>
                                                        <p>{{ __('streetName') . ' : ' . $value->streetName }}</p>
                                                        <p>{{ __('buildNumber') . ' : ' . $value->buildNumber }}</p>
                                                        <p>{{ __('commomPlaces') . ' : ' . $value->commomPlaces }}</p>
                                                        <p>{{ __('address_additional') . ' : ' . $value->address_additional }}
                                                        </p>

                                                        <p>{{ __('country') . ' : ' . $value->GetCountry->$location }}</p>
                                                        <p>{{ __('state') . ' : ' . $value->Getstate->$location }}</p>
                                                        <p>{{ __('city') . ' : ' . $value->GetCity->$location }}</p>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('admin.close') }}</button>
                                                    </div>


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
