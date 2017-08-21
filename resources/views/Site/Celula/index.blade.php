@extends('layouts.app') 

@section('content')

<div class="panel panel-default">

	<div class="panel-body">
	
		<!-- Submenu -->
		<ul class="nav nav-tabs">
			@can('rede_list')
			<li role="presentation" >
				<a href="{{route('rede.index')}}" role="button" 
					aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-paw"></i> | Rede
				</a>
	  		</li>
	  		@endcan
			<li role="presentation" class="active">
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
				
				@can('celula_create')
				<!-- Button Cadastro Celula -->
				<a href="{{route('celula.create')}}" class="btn btn-success">
					<i class="fa fa-plus"></i> | Cadastrar Célula
				</a>
				<!-- END Button Cadastro Celula -->
				@endcan
				
			</div>
			<div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
				<label class=" pull-right">Procurar:
					<input id="searchTabela" type="search" class="form-control input-sm" onkeyup="searchTabelaFunction()" >
				</label>
			</div>
		</div>
		
		<div class="table-responsive">
			<table id="tabelaCelulas" class="table table-bordered table-hover table-striped">
				<thead align="center">
					<tr>
						<th>Células</th>
						<th>Gerenciar</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
					@forelse($celulas as $celula)
					<tr>
						<td>
							{{$celula->Nome}}
						</td>
						<td>
							
							<a href="{{route('celula.gerenciar', $celula->id)}}" class="btn btn-info btn-circle"
								 data-toggle="tooltip" data-placement="left" title="" data-original-title="Gerenciar Presença / Liderança / Multiplicação da Célula."><i class="fa fa-cog"></i></a>
							@can('convidado_create')	 
							<a href="{{route('celula.createConvidado', $celula->id)}}" class="btn btn-info btn-circle"
								 data-toggle="tooltip" data-placement="left" data-original-title="Cadastrar um Novo Visitante na Célula."><i class="fa fa-pencil-square-o"></i></a>
							@endcan
							@can('celula_reciclar')
							<a href="{{route('celula.reciclar', $celula->id)}}" class="btn btn-success btn-circle"
								 data-toggle="tooltip" data-placement="left" title="" data-original-title="Reciclar Visitante e/ou Membros da Célula."><i class="fa fa-recycle"></i></a>
							@endcan
						</td>
						<td>
							@can('celula_show')
							<a href="{{route('celula.show', $celula->id)}}" class="btn btn-primary btn-circle"><i class="fa fa-search"></i></a>
							@endcan
							@can('celula_update')
							<a href="{{route('celula.edit', $celula->id)}}" class="btn btn-warning btn-circle"><i class="fa fa-pencil"></i></a>
							@endcan
							@can('celula_delete')
							<form  method="post" action="{{route('celula.destroy', $celula->id)}}"  style="display:inline;">
								{!! method_field('DELETE') !!} {!! csrf_field() !!}
								<button type="submit" onClick="return confirm('Deseja realmente excluir a Celula {{$celula->Nome}} ?')" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
							</form>
							@endcan
						</td>
					</tr>
					@empty
						<b>Ainda não há Células cadastradas.</b>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
{{ $celulas->links() }}
@endsection 

@push('scripts')
<script>
function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaCelulas");
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