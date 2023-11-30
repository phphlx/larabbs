<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="{{ $qun->share_desc }}"/>
  <link rel="shortcut icon" type="text/css" href="{{ $qun->share_img }}">
  <link rel="apple-touch-icon" href="{{ $qun->share_img }}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $qun->share_title }}</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>
    #share {
      margin-top: 30vh;
    }

    #share p {
      margin: 10px 0;
    }

    #bottom {
      position: fixed;
      bottom: 10px;
      left: 0;
      width: 100%;
      color: darkgrey;
    }

    #hidden {
      position: fixed;
      bottom: -30px;
      left: 0;
    }
  </style>
</head>

<body>
<div class="container">
  <div class="row clearfix">
    <div class="col-md-12 column text-center" id="share">
      <img alt="140x140" src="/images/wechat.png" width="100px"/>
      <p>正在跳转到微信...</p>
      <p>如未自动打开微信请点击</p>
      <a href="{{ $link }}">
        <button type="button" class="btn btn-default btn-success">打开微信</button>
      </a>
    </div>
  </div>

  <div class="row clearfix no-gutters" id="bottom">
    <div class="col-md-12 column text-center">
      <div>如果打开失败, 请
        <button type="button" class="btn btn-sm btn-success" id="copy">复制链接</button>
        到手机微信打开
      </div>
    </div>
  </div>

  <div id="hidden">
    <input type="text" value="{{ route('quns.show', $qun) }}?program={{ $program }}" id="value" readonly>
  </div>
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script>
  $(function () {
    $('#copy').click(function () {
      $('#value').select();
      document.execCommand('copy');
      window.getSelection().removeAllRanges();
      $('#copy').text('已复制，粘贴发送到手机微信聊天记录打开').css('color', 'gold');
    })

    setTimeout(() => {
      location.href = '{{ $link }}'
    }, 3000)
  })

</script>
</body>
</html>
