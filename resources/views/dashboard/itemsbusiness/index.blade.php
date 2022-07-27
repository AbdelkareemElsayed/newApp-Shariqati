@extends('dashboard.index')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>  بنود الاعمال الرئيسية   </h3>
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
            <h2> بنود الاعمال الرئيسية  </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a href="{{ aurl('BusinessItems/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                  أضافة بند عمل</a>
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
                    <th class="column-title">{{ 'العنوان' }}</th>
                    <th class="column-title">{{  'المحتوي' }}</th>

                     <th class="column-title">{{ 'عرض الاعمال الفرعية' }}</th>

                    <th class="column-title no-link last"><span class="nobr">{{ 'التحكم' }}</span>
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


                        <td class=" ">{{ $value->title }}</td>
                        <td class=" ">{!! $value->content !!}</td>


                      <td>
                        <a href="{{ aurl('LoadBusinessItemsUnits/' . $value->id  ) }}"
                            class="btn btn-info">{{ 'عرض الاعمال الفرعية' }}</a>
                       </td>


                      <td class=" last">
                        <a data-toggle="modal" data-target=".bs-example-modal-lg{{ $value->id }}"
                          class="btn btn-danger">حذف</a>
                        <a href="{{ aurl('BusinessItems/' . $value->id . '/edit') }}"
                          class="btn btn-info">{{  'تعديل' }}</a> </a>
                      </td>
                    </tr>

                    <div class="modal fade bs-example-modal-lg{{ $value->id }}" tabindex="-1" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">حذف العنصر</h4>
                            <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">×</span>
                            </button>
                          </div>

                          <form action="{{ aurl('BusinessItems/' . $value->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <div class="modal-body">
                              <h4>تأكيد حذف العنصر</h4>
                              <p>{{ 'حذف العنصر رقم : ' . $value->id }}</p>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">تأكيد</button>
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">غلق</button>
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
