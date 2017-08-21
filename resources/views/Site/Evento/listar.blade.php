@extends('layouts.app') 

@section('content')
<div class="panel panel-default">

	<div class="panel-body">

		<div class="row">
			<div class="col-lg-9 col-md-7 col-sm-6 col-xs-12">

				<!-- Button Cadastro Evento -->
				@can('evento_create')
				<a href="{{route('evento.create')}}"
					class="btn btn-success"> <i class="fa fa-plus"></i> | Cadastrar
					Evento
				</a>
				@endcan
				<!-- END Button Cadastro Evento -->

			</div>
			<div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
				<label class=" pull-right">Procurar: <input id="searchTabela"
					type="search" class="form-control input-sm"
					onkeyup="searchTabelaFunction()">
				</label>
			</div>
		</div>

		<div class="table-responsive">
			<table id="tabelaEventos"
				class="table table-bordered table-hover table-striped">
				<thead align="center">
					<tr>
						<th>Evento</th>
						<th>Data Evento</th>
						<th>Vagas</th>
						<th>#</th>
						<th>Presença</th>
					</tr>
				</thead>
				<tbody>
					@forelse($eventos as $evento) 
					<tr>
						<td>{{ $evento->Nome }}</td>
						<td>@if(isset($evento->Inicio)){{
								\Carbon\Carbon::createFromFormat('Y-m-d', $evento->Inicio)->format('d/m/Y')
						}}@endif</td>
						<td>{{ $evento->Quantidade_Vagas }}</td>
						<td><a
							href="{{route('evento.show', $evento->id)}}"
							class="btn btn-primary btn-circle"><i class="fa fa-search"></i></a>
							<a
							href="{{route('evento.edit', $evento->id)}}"
							class="btn btn-warning btn-circle"><i class="fa fa-pencil"></i></a>
							<form  method="post" action="{{route('evento.destroy', $evento->id)}}" style="display:inline;">
								{!! method_field('DELETE') !!} {!! csrf_field() !!}
								<button type="submit" onClick="return confirm('Deseja realmente excluir o evento {{$evento->Nome}} ?')" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
							</form>
						</td>
						<td><a href="{{route('evento.presenca', $evento->id)}}"
							class="btn btn-info btn-circle"><i class="fa fa-check"></i></a>
						</td>
					</tr>
					@empty
						<b>Não há Eventos Cadastrados e/ou Disponíveis.</b>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
{{ $eventos->links() }}
@endsection

@push('scripts')
<script>
function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaEventos");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
@endpush