 <!-- print messgae -->

 <!--  1-success message ...  -->
 @if(session()->has('message'))
 <div class="alert alert-success">
 <p>{{session()->get('message')}}</p>
 </div>
 @endif
 
  <!-- 2-error message ...  -->
 @if(session()->has('error_message'))
 <div class="alert alert-danger">
 <p>{{session()->get('error_message')}}</p>
 </div>
 @endif
 
 <!--  Forms error messages ..... -->
 @if ($errors->all())
 <div class="alert alert-danger">
 @foreach ($errors->all() as $error)
  <li>{{ $error }}</li>
 @endforeach
 </div>
 @endif