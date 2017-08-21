@extends('layouts.app') 

@section('content')

<div class="panel panel-default">

	<div class="panel-body">
	
		<!-- Submenu -->
		<ul class="nav nav-tabs">
			<li role="presentation" class="active">
				<a href="{{route('rede.index')}}" role="button" 
					aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-paw"></i> | Rede
				</a>
	  		</li>
			<li role="presentation" >
				<a href="{{route('celula.index')}}" role="button" 
					aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-leaf"></i> | Célula
				</a>
	  		</li>
		</ul>
		<br>
		<!-- END Submenu -->
	
		<div class="row">
			<div class="col-lg-9 col-md-7 col-sm-6 col-xs-12">

				@can('rede_create')
				<!-- Button Cadastro Celula -->
				<a href="{{route('rede.create')}}" class="btn btn-success"> <i
					class="fa fa-plus"></i> | Cadastrar Rede
				</a>
				<!-- END Button Cadastro Celula -->
				@endcan

			</div>
			<div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
				<label class=" pull-right">Procurar: <input id="searchTabela"
					type="search" class="form-control input-sm"
					onkeyup="searchTabelaFunction()">
				</label>
			</div>
		</div>

		<div class="table-responsive">
			<table id="tabelaRedes"
				class="table table-bordered table-hover table-striped">
				<thead align="center">
					<tr>
						<th>Redes</th>
						<th>Supervisor(a)</th>
						<!-- th>Gerenciar</th -->
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					@forelse ( $redes as $rede )
					<tr>
						<td>{{$rede->Nome}}</td>
						<td>{{$rede->first_name}}</td>
						<!-- td><a href="#"
							class="btn btn-info btn-circle" data-toggle="tooltip"
							data-placement="left" title=""
							data-original-title="Gerenciar Presença / Liderança / Fechamento de Células."><i
								class="fa fa-cog"></i></a></td -->
						<td>
							@can('rede_show')
							<a href="{{ route('rede.show', $rede->id) }}"
							class="btn btn-primary btn-circle"><i class="fa fa-search"></i></a>
							@endcan
							@can('rede_update')
							<a href="{{route('rede.edit', $rede->id)}}"
							class="btn btn-warning btn-circle"><i class="fa fa-pencil"></i></a>
							@endcan
							@can('rede_delete')
							<form  method="post" action="{{route('rede.destroy', $rede->id)}}"  style="display:inline;">
								{!! method_field('DELETE') !!} {!! csrf_field() !!}
								<button type="submit" onClick="return confirm('Deseja realmente excluir a Rede {{$rede->Nome}} ?')" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
							</form>
							@endcan
						</td>
					</tr>
					@empty
						<b>Ainda não há Redes cadastradas.</b>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection 

@push('scripts')
<script>
function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaRedes");
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
