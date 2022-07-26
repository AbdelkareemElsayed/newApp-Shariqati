<!-- footer content -->
<footer>
  <div class="pull-right">
    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>



<script src="{{ url('/dbAssets/vendors/validator/multifield.js') }}"></script>
<script src="{{ url('/dbAssets/vendors/validator/validator.js') }}"></script>

<!-- Javascript functions	-->
<script>
  function hideshow() {
    var password = document.getElementById("password1");
    var slash = document.getElementById("slash");
    var eye = document.getElementById("eye");

    if (password.type === 'password') {
      password.type = "text";
      slash.style.display = "block";
      eye.style.display = "none";
    } else {
      password.type = "password";
      slash.style.display = "none";
      eye.style.display = "block";
    }

  }
</script>

<script>
  // initialize a validator instance from the "FormValidator" constructor.
  // A "<form>" element is optionally passed as an argument, but is not a must
  var validator = new FormValidator({
    "events": ['blur', 'input', 'change']
  }, document.forms[0]);
  // on form "submit" event
  document.forms[0].onsubmit = function(e) {
    var submit = true,
      validatorResult = validator.checkAll(this);
    console.log(validatorResult);
    return !!validatorResult.valid;
  };
  // on form "reset" event
  document.forms[0].onreset = function(e) {
    validator.reset();
  };
  // stuff related ONLY for this demo page:
  $('.toggleValidationTooltips').change(function() {
    validator.settings.alerts = !this.checked;
    if (this.checked)
      $('form .alert').remove();
  }).prop('checked', false);
</script>

<!-- jQuery -->
<script src="{{ url('/dbAssets/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ url('/dbAssets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('/dbAssets/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ url('/dbAssets/vendors/nprogress/nprogress.js') }}"></script>
<!-- validator -->
<!-- <script src="{{ url('/dbAssets/vendors/validator/validator.js') }}"></script> -->


<!-- Custom Theme Scripts -->
<script src="{{ url('/dbAssets/build/js/custom.min.js') }}"></script>

{{-- Firebase --}}
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script>
  const firebaseConfig = {
    apiKey: "AIzaSyD8cvkZJ0Ul5x6vj4qSfGVqF1sErG8DYuw",
    authDomain: "dashboard-b7729.firebaseapp.com",
    projectId: "dashboard-b7729",
    storageBucket: "dashboard-b7729.appspot.com",
    messagingSenderId: "300221351761",
    appId: "1:300221351761:web:7323a2cf5c027cb99eb570"
  };

  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  messaging
    .requestPermission()
    .then(function() {
      return messaging.getToken()
    })
    .then(function(response) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('store-token') }}",
        type: 'POST',
        data: {
          token: response
        },
        dataType: 'JSON',
        success: function(response) {
          console.log('Token updated');
        },
        error: function(error) {
          console.log(error);
          // alert(error);
        },
      });
    })
    .catch(function(error) {
      console.log(error);
      // alert(error);
    });

  messaging.onMessage(function(data) {
     //location.reload()

    // console.log(data);
// increase badge number
    var badge = document.getElementById("messages");
    badge.innerHTML = parseInt(badge.innerHTML) + 1;

    // $('#messages').append('<div class="alert alert-success alert-dismissible fade in" role="alert">' +
    //   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
    //   '<span aria-hidden="true">×</span>' +
    //   '</button>' +
    //   '<strong>' + data.notification.title + '</strong>' +
    //   '<br>' + data.notification.body +
    //   '</div>');


  });
</script>

</body>

</html>
