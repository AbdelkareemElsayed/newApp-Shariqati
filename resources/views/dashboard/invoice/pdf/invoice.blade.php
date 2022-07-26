<p>
    Comapny Details . . .
    <br>
    {{ 'Company Name  : ' . $companyInfo[16]->value }}
    <br>
    {{ 'Tax Card  : ' . $companyInfo[17]->value }}
    <br>
    {{ 'Existing Tax Rate  : ' . $companyInfo[18]->value }}
    <br>
    {{ 'Company Rating  : ' . $companyInfo[19]->value }}
    <br>
    {{ 'is_value_added_tax : ' . ($companyInfo[20]->value == 1) ? 'تطبق ضريبة القيمة المضافة ' : 'لا تطبق ضريبة القيمة المضافة ' }}
    <br>
    {{ 'Phone  : ' . $companyInfo[21]->value }}

    {{-- Storage::url($data[22]->value) --}}

</p>

<p>
    {{ __('invoice_id') . ' : ' . $data[0]->id }}
</p>


<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class="headings">
                <th>{{ __('admin.item_id') }}</th>
                <th>{{ __('admin.item') }}</th>
                <th>{{ __('admin.User Name') }}</th>
                <th>{{ __('admin.Price') }}</th>
                <th>{{ __('admin.Quantity') }}</th>
                <th>{{ __('admin.total') }}</th>
                <th>{{ __('admin.discount_type') }}</th>
                <th>{{ __('admin.discount_value') }}</th>
                <th class="column-title">{{ __('admin.Branch') }}</th>
                <th>{{ __('admin.ToatalAfterDisocount') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $key => $value)
                <tr>
                    <td>{{ $value->items->itemsDetails[0]->id }}</td>
                    <td>{{ $value->items->itemsDetails[0]->title }}</td>
                    <td>{{ $value->userDetails->name }}</td>
                    <td>{{ $value->price }} </td>
                    <td>{{ $value->quantity }} </td>
                    <td>{{ $value->price * $value->quantity }} </td>
                    <td>{{ $value->discount_type == 0 ? __('admin.fixed') : __('admin.percentage') }} </td>
                    <td>{{ $value->discount_type == 0 ? $value->discount_value : $value->discount_value . ' %' }} </td>

                    @php
                        $total              = $value->price * $value->quantity;
                        $priceAfterDiscount = $value->discount_type == 0 ? $total - $value->discount_value : $total - ($total * $value->discount_value) / 100;
                    @endphp

                    <td> {{ $value->branchDetails->name_en }} </td>
                    <td> {{  $priceAfterDiscount }} </td>

                </tr>
            @endforeach



        </tbody>
    </table>
</div>
