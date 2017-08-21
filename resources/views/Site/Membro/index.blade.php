@extends('layouts.app')

@section('content')


			<div class="panel panel-default">
			
				<div class="panel-body">
				
                	<div class="row">
	                	<div class="col-lg-9 col-md-7 col-sm-6 col-xs-12">
							
							<!-- Button Cadastro Membro -->
							<a href="{{route('membro.create')}}" class="btn btn-success">
								<i class="fa fa-plus"></i> | Cadastrar Membro
							</a>
							<!-- END Button Cadastro Membro -->
							
							<!-- Button Apresentar Membro -->
							<a href="#" class="btn btn-primary" 
								onclick="alert('Funcionalidade Em Construção!');">
								<i class="fa fa-filter"></i> | Filtar Membros do ROL
							</a>
							<!-- END Button Apresentar Membro -->
														
						</div>
	                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                        	<label class=" pull-right">Procurar:
                            	<input id="searchTabela" type="search" class="form-control input-sm">
                            </label>
                        </div>
                    </div>
                    
					<div class="table-responsive">
						<table id="tabelaMembros" class="table table-bordered table-hover table-striped">
							<thead align="center">
								<tr>
									<th>Nome</th>
									<th>Telefone</th>
									<th>Celular</th>
									<th>Opções</th>
								</tr>
							</thead>
							<tbody>
							@forelse($membros as $membro)
									<tr>
										<td>{{$membro->first_name}} {{$membro->last_name}}</td>
										<td>{{$membro->phone}}</td>
										<td>{{$membro->mobile}}</td>
										<td>
											<a href="{{route('membro.show', $membro->id)}}" class="btn btn-primary btn-circle"><i class="fa fa-search" aria-hidden="true"></i></a>
											@can('membro_update')
												<a href="{{route('membro.edit', $membro->id)}}" class="btn btn-warning btn-circle">
												<i class="fa fa-edit" aria-hidden="true"></i></a>
											@endcan
											@can('membro_delete')
												<form  method="post" action="{{route('membro.destroy', $membro->id)}}"  style="display:inline;">
													{!! method_field('DELETE') !!} {!! csrf_field() !!}
													<button type="submit" onClick="return confirm('Deseja realmente excluir o Membro {{$membro->first_name}} ?')" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
												</form>
											@endcan
										</td>
									</tr>
							
							@empty
								<p><b>Ainda Não há Nenhum Membro Cadastrado!</b></p>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		{{ $membros->links() }}
		
@endsection

@push('scripts')
<script src="{{url('Gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.js')}}"></script>
<!-- script>
function searchTabelaFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("searchTabela");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabelaMembros");
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
-->
<script>
function montaLinha(Usuario){
	$('#tabelaMembros tbody').append( 
            '<tr>	 <td>'+Usuario.first_name+' '+Usuario.last_name+'</td>'+
            		'<td>'+Usuario.phone+'</td>'+
            		'<td>'+Usuario.mobile+'</td>'+
    				'<td>'+
					'<a href="'+window.location.origin+'/membro/'+Usuario.id+'" class="btn btn-primary btn-circle"><i class="fa fa-search" aria-hidden="true"></i></a>'+
    				'</td>'+
    		'</tr>'
     );
}

$(document).ready(function() {
     $("#searchTabela").on('keyup', function (e){
		 e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('membro.ajax') }}",
                dataType: "json",
                data: {
                    _token : '{{csrf_token()}}',
                    nome : this.value
                },
                success: function( data ){
                    //$('#ajaxResponse').append( JSON.stringify(data, null, 4) );
                    $('#tabelaMembros tbody tr').remove();
                    for(i=0; i<=data.users.length; i++){
                    	montaLinha(data.users[i]);
                    }                    
                },
                error: function ( data ){
                	//$('#ajaxResponse').append( JSON.stringify(data, null, 4) )
                }
            });
      });
});
</script><!--  -->
 @endpush