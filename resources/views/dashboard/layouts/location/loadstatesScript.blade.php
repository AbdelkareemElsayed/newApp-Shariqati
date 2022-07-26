<script>
    //onchange get zones agains country
    $(document).on('change', '#company_id', function(e) {

        var country_id = $(this).val();

        $.ajax({
            url: "{{ aurl('Location/LoadStateJSON')}}",
            dataType: 'json',
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "countryId": country_id,
            },
            success: function(data) {
                if (data.data.length > 0) {
                    var i;
                    var showData = [];
                    for (i = 0; i < data.data.length; ++i) {
                        showData[i] = "<option value='" + data.data[i].id + "'>" + data.data[i].name + "</option>";
                    }
                    $('.states').show();

                } else {
                    $('.states').hide();
                }
                $(".statesContent").html(showData);
            }
        });

    });
</script>
