@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="col-md-8 offset-md-2">

      <div class="card">
        <div class="card-header">
          <h4>
            <i class="glyphicon glyphicon-edit"></i> 生成激活码
          </h4>
        </div>

        <div class="card-body">

          <form action="{{ route('codes.generate') }}" method="get" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('shared._error')

            <div class="form-group">
              <label for="name-field">设备码</label>
              <input class="form-control" type="text" name="id" id="name-field" value=""/>
            </div>
            <div class="form-group">
              <label for="email-field">套餐</label>
              <select name="type" id="type" class="form-control">
                <option value="1">1个月</option>
                <option value="2">1年</option>
                <option value="3">永久</option>
              </select>
            </div>

            @if ($code)
              <div class="form-group">
                <label for="code">激活码</label>
                <textarea id="code" class="form-control" style="white-space: pre-wrap;" rows="4">{{ $code }}</textarea>
              </div>
            @endif

            <div class="well well-sm">
              <button type="submit" class="btn btn-primary">确认</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

@endsection
