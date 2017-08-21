@extends('layouts.app') @section('content')
<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="x_panel">
			<div class="x_title">
				<h2>Visitantes</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table table-striped">
					<tbody>
						@forelse ($convidados as $convidado)
						<tr>
							<td>{{$convidado->nome}}</td>
						</tr>
						@empty
						<p>
							<b>Ainda Não há Nenhum Convidado Hoje!</b>
						</p>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6">
		<div class="x_panel">
			<div class="x_title">
				<h2>Aniversariantes</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Dia</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($aniversariantes as $aniversariante)
						<tr>
							<td>{{$aniversariante->first_name}}</td>
							<td>{{
									DateTime::createFromFormat('Y-m-d', $aniversariante->birthday)->format('d/m')
								}}</td>
						</tr>
						@empty
						<p>
							<b>Não há Nenhum aniversariante para a Semana!</b>
						</p>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
