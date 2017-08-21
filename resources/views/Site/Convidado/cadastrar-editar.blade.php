@extends('layouts.app')

@section('content')
	
	<div class="row">
		@if ( isset($convidado) )
		<form class="form" method="post" action="{{route('convidado.edit', $convidado->id)}}">
			{!! method_field('PUT') !!}
		@else
		<form method="POST" action="{{route($destinyForm)}}">
		@endif
			{!! csrf_field() !!}
			<input type="text" class="hide" name="var_Auxiliar" value="{{$var_Auxiliar or ''}}">

				<div class="col-lg-6">
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i> Nome</span>
						<input type="text" class="form-control" placeholder="Nome do convidado" name="nome" required="required" autofocus value="{{$convidado->nome or old('nome')}}">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-at"></i> E-mail</span>
						<input type="email" class="form-control" placeholder="E-mail do usuário" name="email" value="{{$convidado->email or old('email')}}">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-mobile"></i> Celular</span>
						<input type="text" class="form-control"  data-inputmask="'mask': '(99) 9 9999-9999'" name="celular" value="{{$convidado->celular or old('celular')}}">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-birthday-cake"></i>Aniversário</span>
						<input type="date" class="form-control" name="data_nascimento" value="{{$convidado->data_nascimento or old('data_nascimento')}}">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-area-chart"></i> Gênero</span>
						<select class="form-control"  name="genero">
								<option value=" "></option>
								
								<option @if(isset($convidado)&&$convidado->genero=='M'){{'selected'}} @endif value="M">Masculino</option>
								<option @if(isset($convidado)&&$convidado->genero=='F'){{'selected'}} @endif value="F">Feminino</option>
						</select>
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i>Discipulador</span>
						<input type="text" class="form-control" placeholder="Nome Responsável" name="discipulador" value="{{$convidado->discipulador or old('discipulador')}}">
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-area-chart"></i> Região</span>
						<select class="form-control"  name="Regiaos_idRegiaos">
							@foreach($regioes as $regiao)
								@if(isset($convidado->Regiaos_idRegiaos) && $convidado->Regiaos_idRegiaos == $regiao->id)
									<option selected value="{{$regiao->id}}">{{$regiao->nome}}</option>
								@else
									<option value="{{$regiao->id}}">{{$regiao->nome}}</option>
								@endif
							@endforeach
						</select>
					</div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-book"></i> Obs.:</span>
						<textarea class="form-control" disabled rows="3" placeholder="Observações" name="Observacao"></textarea>
					</div>
					<div class="form-group input-group">
						<button type="reset" class="btn btn-default" >Limpar</button> 
						<button type="submit" class="btn btn-success">Enviar</button>
					</div>
				</div>
			</form>
		</div>

@endsection

@push('scripts')
<!-- jquery.inputmask -->
<script src="{{url('Gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
@endpush