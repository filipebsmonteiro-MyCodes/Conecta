@extends('layouts.app')

@section('content')
	
	<div class="row">
		@if ( isset($regiao) )
		<form id="edit" class="form" method="post" action="{{route('regiao.update', $regiao->id)}}">
			{!! method_field('PUT') !!}
		@else
		<form method="POST" action="{{route('regiao.store')}}">
		@endif
			{!! csrf_field() !!}
			<div class="col-lg-6">
				<div class="form-group input-group">
					<span class="input-group-addon">Região</span>
					<input type="text" class="form-control" placeholder="Nome da região" name="nome" autofocus value="{{$regiao->nome or old('nome')}}">
				</div>
				<div class="form-group input-group">
					<button type="reset" class="btn btn-default">Limpar</button>
					<button type="submit" class="btn btn-success">Enviar</button>
				</div>
			</div>
		</form>
	</div>

@endsection