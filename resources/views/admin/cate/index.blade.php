<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>2020年中国最大电子商城-分类管理</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">微商城</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="{{url('/brand')}}">商品品牌</a></li>
        <li class="active"><a href="{{url('/cate')}}">商品分类</a></li>
        <li><a href="{{url('/goods')}}">商品管理</a></li>
        <li><a href="{{url('/admin')}}">管理员管理</a></li>
      </ul>
    </div>
  </div>
</nav> 

<center><h2>分类管理 <a style="float:right;" href="{{url('/cate/create')}}" class="btn btn-success">添加</a></h2><hr/></center>

<table class="table table-striped">
	
	<thead>

		<tr>
			<th>分类ID</th>
			<th>分类名称</th>
			<th>是否显示</th>
			<th>是否导航显示</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
@foreach($cate as $v)
		<tr>
			<td>{{$v->cate_id}}</td>
			<td>{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</td>
			<td>{{$v->is_show?'√':'×'}}</td>
			<td>{{$v->is_nav_show?'√':'×'}}</td>
			<td><a href="{{url('/cate/edit/'.$v->brand_id)}}" class="btn btn-primary">编辑</a> | <a href="{{url('/cate/destroy/'.$v->brand_id)}}" class="btn btn-danger">删除</a></td>
		</tr>
@endforeach		
	</tbody>
</table>

</body>
</html>