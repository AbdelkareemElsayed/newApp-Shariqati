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

            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Table design <small>Custom design</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="{{ aurl('Blogs/create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>
                                    {{ __('admin.addBlog') }}</a>
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
                                        <th class="column-title"># </th>
                                        @foreach (languages() as $language)
                                            <th class="column-title">{{ __('admin.title_' . $language) }}</th>
                                            <th class="column-title">{{ __('admin.content_' . $language) }}</th>
                                        @endforeach
                                        <th class="column-title">{{ __('admin.image') }}</th>
                                        <th class="column-title no-link last"><span
                                            class="nobr">{{ __('admin.details') }}</span>
                                    </th>
                                        <th class="column-title no-link last"><span
                                                class="nobr">{{ __('admin.action') }}</span>
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
                                            @foreach ($value->content as $k => $content)
                                                <td class=" ">{!! $content->title !!} </td>
                                                <td class=" ">{!! Str::substr($content->content, 0, 49) !!} </td>
                                            @endforeach
                                            <td class=" "><img src="{{ asset('storage/' . $value->image) }}"
                                                    alt="" width="100">
                                            </td>
                                            <td>
                                                <a data-toggle="modal" data-target=".bs-example-modal-lg-details{{ $value->id }}"
                                                    class="btn btn-success">{{ trans('admin.details') }}</a>
                                            </td>
                                            <td class=" last">
                                                <a data-toggle="modal" data-target=".bs-example-modal-lg{{ $value->id }}"
                                                    class="btn btn-danger">{{ trans('admin.delete') }}</a>
                                                <a href="{{ aurl('StaticPages/' . $value->slug . '/edit') }}"
                                                    class="btn btn-info">{{ trans('admin.edit') }}</a> </a>
                                            </td>
                                        </tr>



                                        <div class="modal fade bs-example-modal-lg{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            {{ trans('admin.deleteCon') }}</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ aurl('StaticPages/' . $value->id) }}" method="post">
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



                                        {{-- Details Modal --}}
                                        <div class="modal fade bs-example-modal-lg-details{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            {{ trans('admin.deleteCon') }}</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                  

                                                        <div class="modal-body">
                                                            <h4>{{ trans('admin.StaticPageDetails') }}</h4>
                                                            <p>{{ trans('admin.tagTitle') ."  : ". $value->tag_title }}</p>
                                                            <p>{{ trans('admin.slug') ."  : ". $value->slug }}</p>
                                                     

                                                            @foreach (languages() as $key => $language)
                                                            <p>{{ __('admin.title_' . $language).' : '.$value->content[$key]->title }}</th>
                                                            <p>{!! __('admin.content_' . $language).' : '.$value->content[$key]->content !!}</th>
                                                            @endforeach
                                                            
                                                            <p> <a href="{{ asset('storage/' . $value->image) }}">{{trans('admin.showImage')}}</a> </p>
                                                            
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
