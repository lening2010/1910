
@foreach($brand as $v)
		<tr>
			<td>{{$v->brand_id}}</td>
			<td>{{$v->brand_name}}</td>
			<td>{{$v->brand_url}}</td>
			<td>@if($v->brand_logo)<img src="{{env('UPLOADS_URL')}}{{$v->brand_logo}}" width=50>@endif</td>
			<td>{{$v->brand_desc}}</td>
			<td><a href="{{url('/brand/edit/'.$v->brand_id)}}" class="btn btn-primary">编辑</a> | <a href="{{url('/brand/destroy/'.$v->brand_id)}}" class="btn btn-danger">删除</a></td>
		</tr>
@endforeach	
		<tr><td colspan="6" align="center">{{ $brand->appends(['brand_name' => $brand_name])->links() }}</td></tr>	
