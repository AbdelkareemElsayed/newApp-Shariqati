<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}"">

  <title>Gentelella Alela! | </title>

  <!-- Bootstrap -->
  <link href=" {{ url('/dbAssets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ url('/dbAssets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ url('/dbAssets/vendors/nprogress/nprogress.css') }}" rel="stylesheet" )>
  <!-- bootstrap-wysiwyg -->
  <link href="{{ url('/dbAssets/vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="{{ url('/dbAssets/build/css/custom.min.css') }}" rel="stylesheet">

  {{-- jQuery --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

  <!-- Include Required Prerequisites -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <style>
    .card-footer, .progress {
        display: none;
    }
</style>
</head>
