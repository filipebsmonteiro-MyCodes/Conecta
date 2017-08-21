@extends('layouts.app') 

@section('content')
<form method="post" action="{{route('membro.search')}}">
	{!! csrf_field() !!}
	<!-- IF USADO PARA RETORNO DO MÉTODO SEARCH MEMBRO -->
	@if ( isset($rede) )
		<input type="text" class="hide" name="route" value="rede.edit" />
		<input type="text" class="hide" name="id" value="{{$rede->id}}" />
	@else
		<input type="text" class="hide" name="route" value="rede.create" />
		<input type="text" class="hide" name="id" value="0" />
	@endif
	<!-- Alterar o Valor do campo para Editar -->
	<div class="input-group">
		<input type="text" class="form-control" name="nome" placeholder="Busque Supervisor(a)" /> 
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary">Buscar</button>
		</span>
	</div>
</form>

@if ( isset($rede) )
	<form class="form" method="post" action="{{route('rede.update', $rede->id)}}">
	{!! method_field('PUT') !!} 
@else
	<form method="POST" action="{{route('rede.store')}}">
@endif 
	{!! csrf_field() !!}

		<div class="form-group input-group">
			<span class="input-group-addon">Nome da Rede</span>
			<input type="text" required class="form-control" placeholder="Digite o Nome da Rede" 
					name="Nome" value="{{$rede->Nome or old('Nome')}}" />
		</div>
		
		@if(isset($rede->Supervisor))
			<h3>Supervisor(a):</h3>
			<h4>{{$rede->Supervisor.' '.$rede->SupervisorSN}}</h4>
			<input type="radio" checked class="hide" name="Users_idSupervisor" value="{{$rede->Users_idSupervisor}}">
		@endif
		
		
		
		<button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Instruções
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" style="background-color: #e7e7e7;">
			<li>1. Busque o Supervisor/Líder da Rede por Nome OU Sobrenome OU Apelido</li>
			<li class="separator"></li>
			<li>2. Digite o Nome da Nova Rede.</li>
			<li class="separator"></li>	
			<li>3. Selecione o(a) Supervisor(a).</li>
			<li class="separator"></li>	
			<li>4. Clique em Criar Rede.</li>
		</ul>
		
		@if (isset($users)) 
		<div class="table-responsive">
			<table id="tabelaSupervisores"
				class="table table-bordered table-hover table-striped">
				<thead align="center">
					<tr>
						<th>Opções</th>
						<th>Primeiro Nome</th>
						<th>Sobrenome</th>
						<th>Apelido</th>
					</tr>
				</thead>
				<tbody>
					@foreach ( $users as $supervisor )
					<tr>
						<td>
							<div class="radio">
								<label class="">
									<div class="iradio_flat-green">
										<input type="radio" class="flat" name="Users_idSupervisor"
											value="{{$supervisor->id}}">
										<ins class="iCheck-helper"></ins>
									</div>
								</label>
							</div>
						</td>
						<td>{{$supervisor->first_name}}</td>
						<td>{{isset($supervisor->last_name) ? $supervisor->last_name : ''}}</td>
						<td>{{isset($supervisor->nickname) ? $supervisor->nickname : ''}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
		<div class="form-group input-group">
			<button type="reset" class="btn btn-default">Limpar</button>
			<button type="submit" class="btn btn-success">Enviar</button>
		</div>
	</form>
	
@endsection

@push('scripts')
<!-- iCheck >
<script src="{{url('Gentelella/vendors/iCheck/icheck.min.js')}}"></script -->
@endpush