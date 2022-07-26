@extends('dashboard.index')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{ $title }}</h3>
                </div>
            </div>


            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">

                        @include('dashboard.layouts.messages')


                        <div class="x_content">
                            <form action="{{ aurl('Products') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <span class="section">Add New Product</span>

                                @foreach (languages() as $language)
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="name_{{ $language }}">Name
                                            {{ $language }}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" name="name_{{ $language }}" placeholder="News"
                                                value="{{ old('name_' . $language) }}" />
                                        </div>
                                    </div>

                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="description_{{ $language }}">Description
                                            {{ $language }}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea class="form-control" name="description_{{ $language }}" placeholder="News">{{ old('description_' . $language) }}</textarea>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="category_id">Category
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="categories_id[]" class="form-control" id="categories_id" multiple>
                                            {{-- <option value="none">{{ __('admin.chooseCategory') }}</option> --}}
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->parent_id > 0 ? '-' : '' }}{{ $category->description->firstWhere('language', session('lang'))->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="manufacturers_id">Manufacturer
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="manufacturers_id" class="form-control" id="manufacturers_id">
                                            <option value="none">{{ __('admin.chooseManufacturer') }}</option>
                                            @foreach ($manufacturers as $manufacturer)
                                                <option value="{{ $manufacturer->id }}">
                                                    {{ $manufacturer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="price">Price
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="price"   value="{{old('price')}}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity">Quantity
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="quantity"  value="{{old('quantity')}}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="min_order">Minimum
                                        Order
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="min_order"  value="{{old('min_order')}}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="max_order">Maximum
                                        Order
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="max_order"   value="{{old('max_order')}}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity">Is featured?
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" name="is_feature" value="1">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_status">Is
                                        available?
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" name="product_status"
                                            value="1">
                                    </div>
                                </div>


                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_status">
                                        {{ __('admin.isFlashed') }}
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" id="isFlashe" name="isFlashe" >
                                    </div>
                                </div>


                                <div id="flashsale" style="display:none">


                                    @php
                                        $flashType = [__('admins.number'), __('admins.percentage')];
                                    @endphp
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                            for="manufacturers_id">{{ __('admin.FlashType') }}
                                            <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="type" class="form-control" id="FlashType" value="{{old('type')}}">
                                                <option value="none">{{ __('admin.chooseFlashType') }}</option>
                                                @foreach ($flashType as $key => $value)
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                            for="min_order">{{ __('admin.value') }} <span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" class="form-control" name="value" value="{{old('value')}}">
                                        </div>
                                    </div>


                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                            for="min_order">{{ __('admin.start') }} <span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="date" class="form-control" name="start" value="{{old('start')}}">
                                        </div>
                                    </div>



                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                            for="min_order">{{ __('admin.end') }} <span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="date" class="form-control" name="end"   value="{{old('end')}}">
                                        </div>
                                    </div>

                                </div>





                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit'
                                            class="btn btn-primary">{{ __('admin.submit') }}</button>
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

    <script src="https://cdn.ckeditor.com/4.18.0/basic/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('description_en');
            CKEDITOR.replace('description_ar');



            // isFlashe check
            $('#isFlashe').click(function() {

                if ($('#isFlashe').prop("checked")) {

                    $('#flashsale').show();

                } else {
                    $('#flashsale').hide();
                }

            });




        });
    </script>
@endsection
