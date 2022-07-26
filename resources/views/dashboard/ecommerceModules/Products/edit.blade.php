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
                            <form action="{{ aurl('Products/' . $data->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <span class="section">Edit Product</span>

                                @foreach (languages() as $language)
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="name_{{ $language }}">Name
                                            {{ $language }}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" name="name_{{ $language }}" placeholder="News"
                                                value="{{ $data->content->firstWhere('language', $language)->title }}" />
                                        </div>
                                    </div>

                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align"
                                            for="description_{{ $language }}">Description
                                            {{ $language }}<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <textarea class="form-control" name="description_{{ $language }}" placeholder="News">{{ $data->content->firstWhere('language', $language)->content }}</textarea>
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
                                        <select name="category_id" class="form-control" id="category_id">
                                            <option value="none">{{ __('admin.chooseCategory') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                                    {{ $category->description->firstWhere('language', session('lang'))->name }}
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
                                                <option value="{{ $manufacturer->id }}"
                                                    {{ $manufacturer->id == $data->manufacturers_id ? 'selected' : '' }}>
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
                                        <input type="text" class="form-control" name="price"
                                            value="{{ $data->price }}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity">Quantity
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="quantity"
                                            value="{{ $data->quantity }}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="min_order">Minimum
                                        Order
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="min_order"
                                            value="{{ $data->min_order }}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="max_order">Maximum
                                        Order
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="max_order"
                                            value="{{ $data->max_order }}">
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity">Is featured?
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" name="is_feature" value="1"
                                            {{ $data->is_feature ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_status">Is
                                        available?
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" name="product_status"
                                            value="1" {{ $data->products_status ? 'checked' : '' }}>
                                    </div>
                                </div>





                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_status">
                                        {{ __('admin.isFlashed') }}
                                        <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="checkbox" class="form-checkbox" id="isFlashe" name="isFlashe"
                                            {{ $data->isFlashe == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>

                                @if ($data->isFlashe == 1)
                                    <div id="flashsale" style="display:{{ $data->isFlashe == 1 ? 'block' : 'none' }}">


                                        @php
                                            $flashType = [__('admins.number'), __('admins.percentage')];
                                        @endphp
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="manufacturers_id">{{ __('admin.FlashType') }}
                                                <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select name="type" class="form-control" id="FlashType">
                                                    <option value="none">{{ __('admin.chooseFlashType') }}</option>
                                                    @foreach ($flashType as $key => $value)
                                                        <option value="{{ $key }}"
                                                            @if ($data->flashsale->type == $key) selected @endif>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="min_order">{{ __('admin.value') }} <span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" class="form-control" name="value"
                                                    value="{{ $data->flashsale->value }}">
                                            </div>
                                        </div>


                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="min_order">{{ __('admin.start') }} <span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="date" class="form-control" name="start"
                                                    value="{{ date('Y-m-d', $data->flashsale->start) }}">
                                            </div>
                                        </div>



                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="min_order">{{ __('admin.end') }} <span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="date" class="form-control" name="end"
                                                    value="{{ date('Y-m-d', $data->flashsale->end) }}">
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    <div id="flashsale" style="display:none">


                                        @php
                                            $flashType = [__('admins.number'), __('admins.percentage')];
                                        @endphp
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="manufacturers_id">{{ __('admin.FlashType') }}
                                                <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select name="type" class="form-control" id="FlashType"
                                                    value="{{ old('type') }}">
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
                                                <input type="text" class="form-control" name="value"
                                                    value="{{ old('value') }}">
                                            </div>
                                        </div>


                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="min_order">{{ __('admin.start') }} <span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="date" class="form-control" name="start"
                                                    value="{{ old('start') }}">
                                            </div>
                                        </div>



                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                for="min_order">{{ __('admin.end') }} <span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="date" class="form-control" name="end"
                                                    value="{{ old('end') }}">
                                            </div>
                                        </div>

                                    </div>
                                @endif


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
