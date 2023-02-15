<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="MCoders">
     <link rel="icon" href="{{ asset(get_option('logo_setting', true)->favicon ?? null) }}"/>
    <title>@hasSection('title')@yield('title') | @endif {{ config('app.name') }}</title>
    @include('layouts.user.partials.styles')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<script>
     $(document).ready(function () {
      $('.bank').selectize({
          sortField: 'text'
      });
  });
</script>

</head>
<body>
@yield('body')


</body>
</html>
