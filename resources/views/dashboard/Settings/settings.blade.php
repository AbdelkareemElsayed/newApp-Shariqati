@extends('dashboard.index')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>{{ trans('admin.settings') }}</h3>
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
              <form action="{{ url('admin/Settings') }}" method="post" enctype="multipart/form-data">
                @csrf
                <span class="section">{{ __('admin.settings') }}</span>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="title_en">{{ __('admin.site_title') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="title" placeholder="Application"
                      value="{{ $data[0]->value != null ? $data[0]->value : '' }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="content_en">{{ __('admin.site_description') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <textarea class="form-control" name="description"
                      placeholder="This app is all about....">{{ $data[1]->value != null ? $data[1]->value : '' }}</textarea>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="content_ar">{{ __('admin.keywords') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <textarea class="form-control" name="keywords" placeholder="html,css,js,..."
                      style="resize: none;">{{ $data[2]->value != null ? $data[2]->value : '' }}</textarea>
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.logo') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <input type="file" class="form-control" name='logo'>
                  </div>
                  <img src="{{ Storage::url($data[3]->value) }}" width="100" alt="">
                </div>


                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="title_ar">{{ __('admin.address') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="address" placeholder="Cairo, Egypt"
                      value="{{ $data[4]->value != null ? $data[4]->value : '' }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="location">{{ __('admin.location') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="location" placeholder="https:://maps.google.com/"
                      value="{{ $data[5]->value != null ? $data[5]->value : '' }}" />
                  </div>
                </div>


                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="facebook">{{ __('admin.facebook') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="facebook" placeholder="https:://facebook.com/"
                      value="{{ $data[6]->value != null ? $data[6]->value : '' }}" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="whatsapp">{{ __('admin.whatsapp') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="whatsapp" placeholder="https:://whatsapp.com/"
                      value="{{ $data[7]->value != null ? $data[7]->value : '' }}" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="instagram">{{ __('admin.instagram') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="instagram" placeholder="https:://instagram.com/"
                      value="{{ $data[8]->value != null ? $data[8]->value : '' }}" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="linkedin">{{ __('admin.linkedin') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="linkedin" placeholder="https:://linkedin.com/"
                      value="{{ $data[9]->value != null ? $data[9]->value : '' }}" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="twitter">{{ __('admin.twitter') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="twitter" placeholder="https:://twitter.com/"
                      value="{{ $data[10]->value != null ? $data[10]->value : '' }}" />
                  </div>
                </div>
                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="tiktok">{{ __('admin.tiktok') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="tiktok" placeholder="https:://tiktok.com/"
                      value="{{ $data[11]->value != null ? $data[11]->value : '' }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="snapchat">{{ __('admin.snapchat') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="snapchat" placeholder="https:://snapchat.com/"
                      value="{{ $data[12]->value != null ? $data[12]->value : '' }}" />
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="languages">{{ __('admin.languages') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    @foreach (\App\Models\dashboard\Languages\language::all() as $language)
                      <input type="checkbox" name="languages[]" value={{ $language->code }}
                        {{ $data[14]->value != null && in_array($language->code, json_decode($data[14]->value)) ? 'checked' : '' }}>{{ $language->name }}
                    @endforeach
                  </div>
                </div>

                <div class="field item form-group">
                  <label class="col-form-label col-md-3 col-sm-3  label-align"
                    for="debug">{{ __('admin.EnableDebugMode') }}<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6">
                    <input type="checkbox" name="debug" {{ $data[13]->value != 0 ? 'checked' : '' }} }}>
                  </div>
                </div>

                <span class="section">{{ __('admin.Company Info') }}</span>

                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="twitter">{{ __('admin.companyname') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="company_name" placeholder="X company "
                         value="{{ $data[15]->value != null ? $data[15]->value : '' }}" />
                    </div>
                  </div>


                  <div class="field item fom-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="twitter">{{ __('admin.commercial_register') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="commercial_register" placeholder="X commercial Register "
                         value="{{ $data[16]->value != null ? $data[16]->value : '' }}" />
                    </div>
                  </div>


                  <div class="field item fom-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="twitter">{{ __('admin.tax_card') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="tax_card" placeholder="X tax card "
                         value="{{ $data[17]->value != null ? $data[17]->value : '' }}" />
                    </div>
                  </div>


                  <div class="field item fom-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="twitter">{{ __('admin.existing_tax_rate') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="existing_tax_rate" placeholder="X Existing Tax Rate "
                         value="{{ $data[18]->value != null ? $data[18]->value : '' }}" />
                    </div>
                  </div>



                  <div class="field item fom-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="twitter">{{ __('admin.company_rating') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="company_rating" placeholder="X Company  Rating "
                         value="{{ $data[19]->value != null ? $data[19]->value : '' }}" />
                    </div>
                  </div>



                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="debug">{{ __('admin.is_value_added_tax') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input type="checkbox" name="is_value_added_tax" {{ $data[20]->value != 0 ? 'checked' : '' }} }}>
                    </div>
                  </div>


                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align"
                      for="whatsapp">{{ __('admin.phone') }}<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" name="phone" placeholder="010xxx"
                        value="{{ $data[21]->value != null ? $data[21]->value : '' }}" />
                    </div>
                  </div>
                    
                  
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">{{ __('admin.invoice_waterMark') }}</label>
                        <div class="col-md-6 col-sm-6">
                          <input type="file" class="form-control" name='invoice_waterMark'>
                        </div>
                        <img src="{{ Storage::url($data[22]->value) }}" width="100" alt="">
                    </div>


                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                    <button type='submit' class="btn btn-primary">{{ __('admin.submit') }}</button>
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
