@extends('layouts.app')

@section('content')

			<div class="panel panel-default">
			
				<div class="panel-body">
				
                	<div class="row">
	                	<div class="col-lg-9 col-md-7 col-sm-6 col-xs-12">
							
							<!-- Button Cadastro Convidado -->
							@can('convidado_create')
							<a href="{{route('convidado.create')}}" class="btn btn-success">
								<i class="fa fa-plus"></i> | Cadastrar Convidado
							</a>
							@endcan
							<!-- END Button Cadastro Convidado -->
							
							<!-- Button Apresentar Convidado -->
							@can('convidado_show')
							<a href="{{route('convidado.show', 1)}}" class="btn btn-primary">
								<i class="fa fa-bullhorn"></i> | Apresentar Convidados
							</a>
							@endcan
							<!-- END Button Apresentar Convidado -->
														
						</div>
	                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                        	<label class=" pull-right">Procurar:
                            	<input id="searchTabela" type="search" class="form-control input-sm" onkeyup="searchTabelaFunction()" >
                            </label>
                        </div>
                    </div>
                    
					<div class="table-responsive">
						<table id="tabelaConvidados" class="table table-bordered table-hover table-striped">
							<thead align="center">
								<tr>
									<th>Nome</th>
									<th>Aniversário</th>
									<th>Telefone</th>
									<th>Primeira Visita</th>
									<th>Opções</th>
								</tr>
							</thead>
							<tbody>
							@forelse($convidados as $convidado)
									<tr>
										<td>{{$convidado->nome}}</td>
										<td>{{$convidado->data_nascimento}}</td>
										<td>{{$convidado->celular}}</td>
										<td>{{$convidado->created_at->format('d/ m/ Y ')}}</td>
										<td>
											@can('convidado_presenca')
												<a href="{{route('convidado.presenca', $convidado->id)}}" class="btn btn-info btn-circle"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
											@endcan
											@can('convidado_update')
												<a href="{{route('convidado.edit', $convidado->id)}}" class="btn btn-warning btn-circle"><i class="fa fa-edit" aria-hidden="true"></i></a>
											@endcan
										</td>
									</tr>
							
							@empty
								<p><b>Ainda Não há Nenhum Convidado Cadastrado!</b></p>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		{{ $convidados->links() }}
@endsection

 @push('scripts')
 <script>
function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaConvidados");
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