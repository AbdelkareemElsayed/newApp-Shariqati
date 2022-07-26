<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

<script>
    //onchange get zones agains country
    $(document).on('change', '.state_id', function(e) {

        var state_id = $(this).val();

        $.ajax({
            url: "{{ aurl('Location/CitiesJSON')}}",
            dataType: 'json',
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "state_id": state_id,
            },
            success: function(data) {
                if (data.data.length > 0) {
                    var i;
                    var showData = [];
                    for (i = 0; i < data.data.length; ++i) {
                        showData[i] = "<option value='" + data.data[i].id + "'>" + data.data[i].name + "</option>";
                    }
                    $('.cities').show();

                } else {
                    $('.cities').hide();
                }
                $(".cityContent").html(showData);
            }
        });

    });
</script>