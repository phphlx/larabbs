<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>扫码登录</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>
    #share {
      margin-top: 30vh;
    }

    #share p {
      margin: 10px 0;
    }
  </style>
</head>

<body>
<div class="container">
  <div class="row clearfix">
    <div class="col-md-12 column text-center" id="share">
      <img alt="140x140" src="{{ $image->path }}" width="300px"/>
      <p class="h4">请使用手机微信扫码</p>
      <p>更新时间: {{ $image->updated_at }}</p>
    </div>
  </div>
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script>
  $(function () {
    setTimeout(() => {
      location.href = ''
    }, 6000)
  })

</script>
</body>
</html>
