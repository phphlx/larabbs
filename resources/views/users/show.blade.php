@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
      <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
      <div class="card-body">
        <h5><strong>个人简介</strong></h5>
        <p>{{ $user->introduction }}</p>
        <hr>
        <h5><strong>注册于</strong></h5>
        <p>{{ $user->created_at->diffForHumans() }}</p>
        <hr>
        <h5><strong>最后活跃</strong></h5>
        <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 用户发布的内容 --}}
    <div class="card ">
      <div class="card-body">
        @if($user->qrcode)
          <a href="{{ route('images.show', $user->qrcode) }}" target="_blank">查看登录二维码</a>
          <hr>
        @endif
        <form action="{{ route('images.store') }}" method="post"
              accept-charset="UTF-8"
              enctype="multipart/form-data">
          @method('post')
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="type" value="qrcode">

          @include('shared._error')

          <div class="form-group mb-4">
            <label for="" class="avatar-label">上传 / 更新二维码</label>
            <input type="file" name="qrcode" class="form-control-file">
          </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary" onclick="return check(this.form)">保存</button>
          </div>
        </form>
      </div>
    </div>

    </div>
</div>
@stop
@section('scripts')
  <script>
    function check(form) {
      if ($('input[name=qrcode]').val()) {
        return true;
      } else {
        return false;
      }
    }
  </script>
@endsection
