@extends('layouts.app')

@section('content')
<form method="post">
	{!! csrf_field() !!}
	@include('Site.Celula.gerenciar.participantes')
	<button type="submit" class="btn btn-round btn-success" onClick="return confirm('Deseja realmente Restaurar Participantes ?');"
				formaction="{{route('celula.restore')}}">Restaurar Participantes</button>
</form>
@endsection