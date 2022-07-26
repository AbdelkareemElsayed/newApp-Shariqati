@extends('dashboard.index') 

@section('content')



    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{$title}}</h3>
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
                            <form  action="{{aurl('Roles/'.$data->id)}}" method="post" novalidate enctype="multipart/form-data">
                                
                                @csrf 
                                @method('put')
                                
                                <span class="section">{{trans('admin.roles')}}</span>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.title_en')}}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="title_en"    value="{{$data->roleDataGenralLang[0]->title}}"  placeholder="{{trans('admin.title_en_enter')}}" required="required" />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">{{trans('admin.title_ar')}}<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="title_ar"  value="{{$data->roleDataGenralLang[1]->title}}" placeholder="{{trans('admin.title_ar_enter')}}" required="required" />
                                    </div>
                                </div>
 
                                <hr>
                                <span class="section">{{trans('admin.Permissions')}}</span>
                            
                                @foreach ($modules as $module )

                                <div class="field item form-group">
                                   <label class="control-label col-md-3 col-sm-3 label-align">{{$module->title_en}}</label>
                                   <input type="hidden" name="module_id[]" value="{{$module->id}}">
                                   <div class="col-md-9 col-sm-9 ">
                                       <div class="">
                                           <label>
                                               <input type="checkbox" class="js-switch" name="show{{$module->id}}" {{ CheckPermission($data->permissions,$module->id,['is_show' => 1]) }} /> {{trans('admin.show')}}
                                           </label><br>
                                           <label>
                                               <input type="checkbox" class="js-switch" name="create{{$module->id}}"  {{ CheckPermission($data->permissions,$module->id,['is_create' => 1]) }} /> {{trans('admin.create')}}
                                           </label><br>
                                           <label>
                                               <input type="checkbox" class="js-switch" name="update{{$module->id}}"  {{ CheckPermission($data->permissions,$module->id,['is_update' => 1]) }}/> {{trans('admin.update')}}
                                           </label><br>
                                           <label>
                                               <input type="checkbox" class="js-switch"  name="delete{{$module->id}}"  {{ CheckPermission($data->permissions,$module->id,['is_delete' => 1]) }}/> {{trans('admin.delete')}}
                                           </label>
                                       </div>
                                   </div>
                                </div>

                                @endforeach

                                <div class="ln_solid">
                                    <div class="form-group">
                                        <br>

                                        <div class="col-md-6 offset-md-3">
                                            <button type='submit' class="btn btn-primary">{{trans('admin.save')}}</button>
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