@extends('layouts.app')
@section('title', '首页')

@section('content')
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="jumbotron text-center">
          {{--          <h1>裂变系统会员专用平台</h1>--}}
        </div>
        <div class="card-body">
          @guest()
            <div class="btn-group d-flex justify-content-center" role="group" aria-label="...">
              <a href="{{ route('register') }}">
                <button type="button" class="btn btn-outline-primary">注册
                </button>
              </a>
              <a href="{{ route('login') }}">
                <button type="button" class="btn btn-outline-primary ml-1">登录
                </button>
              </a>
            </div>
          @endguest
          @auth()
            <a href="{{ route('users.show', auth()->id()) }}">去个人中心</a>
          @endauth
        </div>
      </div>
    </div>
  </div>
@stop
