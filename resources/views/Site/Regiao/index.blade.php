@extends('layouts.app')

@section('content')
					<div class="panel panel-default">
	                    
						<div class="panel-body">

		                	<div class="row">
			                	<div class="col-lg-9 col-md-7 col-sm-6 col-xs-12">
									
									<!-- Button Cadastro Região -->
									<a href="{{route('regiao.create')}}" class="btn btn-success">
										<i class="fa fa-plus"></i> | Cadastrar Região
									</a>
									<!-- END Button Cadastro Região -->
																
								</div>
			                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
		                        	<label class=" pull-right">Procurar:
		                            	<input id="searchTabela" type="search" class="form-control input-sm" onkeyup="searchTabelaFunction()" >
		                            </label>
		                        </div>
		                    </div>

							<div class="table-responsive">
								<table id="tabelaReunioes" class="table table-bordered table-hover table-striped">
									<thead align="center">
										<tr>
											<th>Regiões</th>
											<th>Opções</th>
										</tr>
									</thead>
									<tbody>
										@forelse($regioes as $regiao)
											<tr>
												<td>{{$regiao->nome}}</td>
												<td>
													<a href="{{route('regiao.edit', $regiao->id)}}"class="btn btn-warning btn-circle">
														<i class="fa fa-pencil" aria-hidden="true"></i> </a>
													<form  method="post" action="{{route('regiao.destroy', $regiao->id)}}" style="display:inline;">
														{!! method_field('DELETE') !!} {!! csrf_field() !!}
														<button type="submit" onClick="return confirm('Deseja realmente excluir a Região {{$regiao->nome}}?')" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
													</form>
											 	</td>
											</tr>
										@empty
										<b>Ainda não há regiões cadastradas.</b>
										@endforelse
									</tbody>
								</table>
								{!! $regioes->Links() !!}
								
							</div>
						</div>
					</div>
													 
		<!-- data-toggle="modal" data-target="#editModal"
		 div class="modal fade" id="editModal" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<!-- button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button - ->
							<h4 class="modal-title" id="myModalLabel">Editar</h4>
						</div>
						<div class="modal-body">
							<div class="main">
								Carregando...
							</div>
						</div>
						<!-- MODAL BODY - ->
						<div class="modal-footer">
							<!-- button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button - ->
						</div>
						<!-- MODAL FOOTER - ->
					</div>
				</div>
			</div -->
		
@endsection

 @push('scripts')
 <script>


function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaReunioes");
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



