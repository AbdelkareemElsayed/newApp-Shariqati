@extends('dashboard.index')
@section('content')
  <div class="right_col"
    role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ $title }}</h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{ $title }} <small>{{ $title }}</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{ aurl('Products/create') }}"
                  class="btn btn-primary"><i class="fa fa-plus"></i>
                  {{ __('admin.addProduct') }}</a>
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
                    <th class="column-title">{{ __('admin.price') }}</th>
                    <th class="column-title">{{ __('admin.quantity') }}</th>
                    <th class="column-title">{{ __('admin.productImages') }}</th>
                    <th class="column-title">{{ __('admin.productAttributes') }}</th>
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
                      @foreach (languages() as $language)
                        <td class=" ">
                          {{ $value->content->firstWhere('language', $language)->title }}
                        </td>
                        <td class=" ">
                          {!! substr($value->content->firstWhere('language', $language)->content, 0, 20) !!}
                        </td>
                      @endforeach
                      <td class="column-title"><img src="{{ asset('storage/'.$value->image) }}"
                          width="100"></td>
                      <td class="column-title">{{ $value->price }}</td>
                      <td class="column-title">{{ $value->quantity }}</td>
                      <td class="column-title"><a href="{{ aurl('Products/' . $value->id . '/Images') }}"
                          class="btn btn-primary">{{ __('admin.productImages') }}</a></td>
                      <td class="column-title"><a href="{{ aurl('Products/' . $value->id . '/ManageAttributes') }}"
                          class="btn btn-primary">{{ __('admin.productAttributes') }}</a></td>
                      <td class=" last">
                        <a data-toggle="modal"
                          data-target=".bs-example-modal-lg{{ $value->id }}"
                          class="btn btn-danger">{{ trans('admin.delete') }}</a>
                        <a href="{{ aurl('Products/' . $value->id . '/edit') }}"
                          class="btn btn-info">{{ trans('admin.edit') }}</a> </a>
                      </td>
                    </tr>

                    <div class="modal fade bs-example-modal-lg{{ $value->id }}"
                      tabindex="-1"
                      role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title"
                              id="myModalLabel">
                              {{ __('admin.removeRaw') }}</h4>
                            <button type="button"
                              class="close"
                              data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                          </div>

                          <form action="{{ aurl('Products/' . $value->id) }}"
                            method="post">
                            @csrf
                            @method('delete')

                            <div class="modal-body">
                              <h4>{{ trans('admin.deleteCon') }}</h4>
                              <p>{{ trans('admin.deleteMessageModal') . ' :  ' . $value->id }}
                              </p>
                            </div>
                            <div class="modal-footer">
                              <button type="submit"
                                class="btn btn-danger">{{ trans('admin.confirm') }}</button>
                              <button type="button"
                                class="btn btn-secondary"
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
