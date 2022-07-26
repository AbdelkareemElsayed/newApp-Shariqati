<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script><!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>
<!-- Resumable JS -->
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<script type="text/javascript">
let browseFile = $('#browseFile');
let resumable = new Resumable({
    target: "{{ aurl('Customer/Files') }}",
    query: {
        _token: '{{ csrf_token() }}'
    }, // CSRF token
    fileType: ['mp4', 'zip'],
    headers: {
        'Accept': 'application/json'
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
});

resumable.assignBrowse(browseFile[0]);

resumable.on('fileAdded', function(file) { // trigger when file picked
    showProgress();
    resumable.upload() // to actually start uploading.
});

resumable.on('fileProgress', function(file) { // trigger when file progress update
    updateProgress(Math.floor(file.progress() * 100));
});

resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
    response = JSON.parse(response)
    $('.card-footer').show();
});

resumable.on('fileError', function(file, response) { // trigger when there is any error
    alert('file uploading error.')
});


let progress = $('.progress');

function showProgress() {
    progress.find('.progress-bar').css('width', '0%');
    progress.find('.progress-bar').html('0%');
    progress.find('.progress-bar').removeClass('bg-success');
    progress.show();
}

function updateProgress(value) {
    progress.find('.progress-bar').css('width', `${value}%`)
    progress.find('.progress-bar').html(`${value}%`)
}

function hideProgress() {
    progress.hide();
}
</script>
