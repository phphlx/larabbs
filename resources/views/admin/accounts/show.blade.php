@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="box box-solid">
  <div class="box-body table-responsive no-padding">
    <table class="table table-hover grid-table">
            <tr>
        <th>id</th>
        <th>账户id</th>
        <th>趋势</th>
        <th>开始金额</th>
        <th>结束金额</th>
        <th>高点</th>
        <th>差值</th>
        <th>低点</th>
        <th>开始时间</th>
        <th>结束时间</th>
        </tr>
      <tbody>
      @foreach($histories as $history)
      <tr>
        <td>{{ $history->id }}</td>
        <td>{{ $history->account_id }}</td>
        <td>{{ $history->trend }}</td>
        <td>{{ $history->start_value }}</td>
        <td>{{ $history->end_value }}</td>
        <td>{{ $history->high }}</td>
        <td>{{ $history->diff }}</td>
        <td>{{ $history->low }}</td>
        <td>{{ $history->created_at }}</td>
        <td>{{ $history->updated_at }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
  <div class="box-body">
    <p>总和：{{ $account->total_diff }}</p>
  </div>
  <div class="box-footer clearfix">
    {{ $histories->links('components.pagination') }}
  </div>
