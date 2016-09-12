@extends('layout')
@section('action', 'order')
@section('content')
<link rel="stylesheet" type="text/css" href="http://www.bootcss.com/p/bootstrap-datetimepicker/bootstrap-datetimepicker/css/datetimepicker.css">
<script src="http://www.bootcss.com/p/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
{{-- <div class="alert alert-warning" role="alert">由于系统存在脏数据，统计起始日期为2016-06-29 09:00以后，默认为一天内的数据统计</div> --}}
<form class="form-inline" method="GET">
    <div class="form-group">
        <label class="control-label">时间范围</label>
        &nbsp;
        <input name="st" class="form-control form_datetime" style="width: 140px;" type="text" value="{{ $startT }}" readonly>
        ~
        <input name="et" class="form-control form_datetime" style="width: 140px;" type="text" value="{{ $endT }}" readonly>
        &nbsp;
    </div>
    <div class="form-group">
        <label class="control-label">appKey</label>
        &nbsp;
        <input name="ak" class="form-control" style="width: 100px;" type="text" value="{{ $appKey }}">
        &nbsp;
    </div>
    <div class="form-group">
        <label class="control-label">合约</label>
        &nbsp;
        <input name="iid" class="form-control" style="width: 100px;" type="text" value="{{ $iid }}">
        &nbsp;
    </div>
    <button type="submit" id="btn" class="btn btn-default">检索</button>
</form>
<br>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th> <th>appKey</th> <th>模型侧ID</th> <th>合约</th> <th>订单ID</th> <th>订单类型</th> <th>下单价</th> <th>成交均价</th> <th>下单(手)</th> <th>成交(手)</th> <th>类型</th> <th>下单时间</th> <th>成交(撤单)时间</th> <th>首次响应(ms)</th> <th>耗时</th> <th>详情</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $line)
            <tr>
                @foreach ($line as $i => $item)
                <td>{{ $item }}</td>
                @endforeach
                <td><a href="/orderLog?oids={{ $line[4] }}">查看</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<nav>
<ul class="pager">
    <li><a href="?p={{ $pre }}&st={{ $startT }}&et={{ $endT }}&iid={{ $iid }}">上页</a></li>
    <li><a href="?p={{ $next }}&st={{ $startT }}&et={{ $endT }}&iid={{ $iid }}">下页</a></li>
</ul>
</nav>
<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>
@stop
