@extends('layouts.app') @section('content')

<div class="row">
	@if ( isset($membro) )
	<form class="form" method="post" action="{{route('membro.update', $membro->id)}}">
		{!! method_field('PUT') !!} 
	@else
	<form method="POST" action="{{route('membro.store')}}">
	@endif 
	{!! csrf_field() !!}

		<fieldset>
			<div class="col-lg-6">
				<!-- Aciona Modal Avatar -->
				<div class="input-group-btn"> 
					<button type="button" class="btn btn-primary" data-toggle="modal"
						data-target="#myModal">
						<i class="fa fa-plus"></i> | Avatar
					</button>
				
					<!-- Aciona Modal Dicipulador -->
					<button type="button" class="btn btn-primary" data-toggle="modal"
						data-target="#DiscipuladorModal">
						<i class="fa fa-info"></i> | Discipulador
					</button>
					
					@isset( $membro->id )
					<!-- Link Edição Perfis -->
					<a href="{{ route('membro.editPermissoes', $membro->id) }}" class="btn btn-primary">
						<i class="fa fa-check"></i> | Permissões
					</a>
					@endisset
				</div>
				<br>
				@if(isset($membro->discipulador))
					<h4>Discipulador(a):</h4>
					<h5>{{$membro->discipulador->first_name.' '.$membro->discipulador->last_name}}</h5>
					<input type="radio" checked class="hide" name="Users_idDiscipulador" value="{{$membro->Users_idDiscipulador}}">
				@endif
				
				<!-- Inicio Lista de Discipuadores -->
				@if (isset($discipuladores))
				<div class="table-responsive">
					<table id="tabelaParticipantes"
						class="table table-bordered table-hover table-striped">
						<thead align="center">
							<tr>
								<th>Opções</th>
								<th>Usuario</th>
								<th>Sobrenome</th>
								<th>Apelido</th>
							</tr>
						</thead>
						<tbody>
							@foreach($discipuladores as $ListDiscipulador)
							<tr>
								<td>
									<div class="radio">
										<label for="">
											<input type="radio" name="Users_idDiscipulador"
												value="{{$ListDiscipulador->id}}">
										</label>
									</div>
								</td>
								<td>
									{{$ListDiscipulador->first_name}}
								</td>
								<td>
									{{$ListDiscipulador->last_name}}
								</td>
								<td>
									{{$ListDiscipulador->nickname}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@endif
				<!-- Final Lista de Discipuladores -->
				<br>

				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i>Primeiro Nome</span>
					<input type="text" class="form-control"
						placeholder="Nome do usuário" name="first_name" required="required"
						value="{{$membro->first_name  or old('first_name')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i> Sobrenome</span> 
					<input type="text" class="form-control"
						placeholder="Sobrenome do usuário" name="last_name" 
						value="{{$membro->last_name  or old('last_name')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i> Apelido</span>
					<input type="text" class="form-control"
						placeholder="Apelido do usuário" name="nickname" 
						value="{{$membro->nickname  or old('nickname')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-at"></i> E-mail</span>
					<input type="email" class="form-control"
						placeholder="E-mail do usuário" name="email" 
						value="{{$membro->email  or old('email')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-birthday-cake"></i>
						Dt Nasc</span> <input type="date" class="form-control"
						placeholder="Data de nascimento" name="birthday" value="{{$membro->birthday  or old('birthday')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-heart"></i> Estado Civil</span> 
					<select class="form-control" name="EstadoCivils_idEstadoCivils"> 
					@foreach ( $estadoCivils as	$estadoCivil ) 
						<option value="{{$estadoCivil->id}}"
						{{ 
							(isset($membro) && $membro->EstadoCivils_idEstadoCivils == $estadoCivil->id)||
							(old('EstadoCivils_idEstadoCivils') == $estadoCivil->id) 
							? "selected" : "" 
						}}>
						{{$estadoCivil->description}}</option>
					@endforeach
					</select>
				</div>
				<div class="form-group">
					<label class="input-group">Genêro</label> 
					<label class="radio-inline">
						<input type="radio" name="gender" value="M" 
						@if(isset($membro->gender) && $membro->gender=='M') {{'checked'}}@endif >
						Masculino
					</label> 
					<label class="radio-inline"> 
						<input type="radio"name="gender" value="F" 
						@if (isset($membro->gender) && $membro->gender=='F') {{'checked'}}@endif >
						Feminino
					</label>
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-list"></i> CPF</span>
					<input type="text" class="form-control"
						placeholder="CPF do usuário" name="CPF"
						data-inputmask="'mask': '999.999.999-99'" 
						value="{{$membro->CPF  or old('CPF')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-list"></i> RG</span>
					<input type="text" class="form-control" placeholder="RG do usuário" name="RG" 
						value="{{$membro->RG  or old('RG')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-list"></i> Órgão Emissor:</span> 
					<input type="text" class="form-control" placeholder="Órgão emissor do RG" name="Emissor" 
					value="{{$membro->Emissor  or old('Emissor')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-phone"></i> Telefone</span> 
					<input type="text" class="form-control"
						placeholder="Telefone do usuário" name="phone"
						data-inputmask="'mask': '(99) 9999-9999'" 
						value="{{$membro->phone  or old('phone')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-mobile"></i> Celular</span> 
					<input type="text" class="form-control"
						placeholder="Celular do usuário" name="mobile"
						data-inputmask="'mask': '(99) 9 9999-9999'" 
						value="{{$membro->mobile  or old('mobile')}}">
				</div>
				<hr>
				<!-- ----------------------------------------------------------------------------------------- -->
				<hr>
				<!-- ----------------------------------------------------------------------------------------- -->
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-folder-o"></i> CEP</span>
					<input type="text" class="form-control"
						placeholder="CEP do usuário" name="CEP" id="cep"
						data-inputmask="'mask': '99.999-999'"
						onblur="pesquisacep(this.value);" 
						value="{{$dataEnd->CEP  or old('CEP')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-institution"></i> Logradouro</span> 
						<input type="text" class="form-control"
						placeholder="Endereço do usuário" name="Logradouro" id="Logradouro" maxlength="60" 
						value="{{$dataEnd->Logradouro  or old('Logradouro')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-institution"></i> Bairro</span> 
						<input type="text" class="form-control"
						placeholder="Bairro do usuário" name="Bairro" id="bairro" maxlength="40" 
						value="{{$dataEnd->Bairro  or old('Bairro')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-institution"></i> Cidade</span> <input type="text" class="form-control"
						placeholder="Cidade do usuário" name="Cidade" id="cidade" maxlength="40" 
						value="{{$dataEnd->Cidade  or old('Cidade')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-flag"></i> UF</span>
					<select class="form-control" name="UFs_idUFs" id="uf"> 
					@foreach ( $UFs as $UF )
						<option value="{{$UF->id}}"
							{{ (isset($dataEnd) && $dataEnd->UFs_idUFs == $UF->id)|| (old('UFs_idUFs') == $UF->id) ? "selected" : ""}}>
							{{$UF->Nome}}
						</option> 
					@endforeach
					</select>
					</p>
				</div>
				<div class="form-group">
					<label class="input-group">Tipo de Membro:</label> 
					@foreach ($tiposMembro as $tpMb) 
					<label class="radio-inline"> <input type="radio"
						{{ isset($membro) && $membro->TipoMembros_idTipoMembros == $tpMb->id ? "checked" : "" }}
						name="TipoMembros_idTipoMembros" value="{{$tpMb->id}}">{{$tpMb->description}}
					</label> 
					@endforeach
				</div>
				<div class="form-group">
					<label class="input-group">Tipo de Entrada como Membro </label>
					@foreach ($tiposEntrada as $tpEt) 
					<label class="radio-inline"> 
						<input type="radio" name="TipoEntradas_idTipoEntradas"
						{{ isset($membro) && $membro->TipoEntradas_idTipoEntradas == $tpEt->id ? "checked" : "" }}
						value="{{$tpEt->id}}">{{$tpEt->description}}
					</label> 
					@endforeach
				</div>
				<div class="form-group input-group" id="DtEntrada">
					<span class="input-group-addon"><i class="fa fa-birthday-cake"></i> Entrada</span> 
					<input type="date" class="form-control"
						placeholder="Data de entrada" name="DataEntrada" 
						value="{{$membro->DataEntrada  or old('DataEntrada')}}">
				</div>
				<div class="form-group input-group" id="IgrejaOrigem">
					<span class="input-group-addon"><i class="fa fa-unlink"></i> Igreja de Origem</span> 
					<input type="text" class="form-control"
						placeholder="Caso transferido(a)" name="IgrejaDeOrigem" 
						value="{{$membro->IgrejaDeOrigem  or old('IgrejaDeOrigem')}}">
				</div>
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-wrench"></i> Célula</span> 
					<select class="form-control" name="Celulas_idCelulas">
					@foreach ( $celulas as $celula )
						<option value="{{$celula->id}}"
						{{ (isset($dataMemCel) && $dataMemCel->Celulas_idCelulas == $celula->id) || 
							(old('Celulas_idCelulas') == $celula->id) ? "selected" : ""}}>
						{{$celula->Nome}}</option> 
					@endforeach
					</select>
					<input type="text" class="hide" name="Ativo" value="1">
				</div>
				
				<div class="form-group input-group">
					<button type="reset" class="btn btn-default">Limpar</button>
					<button type="submit" class="btn btn-success">Enviar</button>
				</div>
			</div>
			<!-- END COL-6 -->

			<!-- Modal AVATAR -->
			<!-- Modal Dentro do form Pois Atributo idFoto Vai Jnto com os Dados Alterados -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<!-- button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
							<h4 class="modal-title" id="myModalLabel">Selecionar Novo Avatar</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="input-group">Profile Avatar</label> <label
									class="radio-inline"> <input type="radio" 
									name="idFoto" value="2.1" {{(isset($membro) && $membro->idFoto=='2.1' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/2.1.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="2.2" {{(isset($membro) && $membro->idFoto=='2.2' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/2.2.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio" 
									name="idFoto" value="2.3" {{(isset($membro) && $membro->idFoto=='2.3' ? 'checked' : '' )}}> 
									 <img src="{{ url('imagens/Profile/2.3.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <br> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="2.4" {{(isset($membro) && $membro->idFoto=='2.4' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/2.4.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="2.5" {{(isset($membro) && $membro->idFoto=='2.5' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/2.5.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="2.6" {{(isset($membro) && $membro->idFoto=='2.6' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/2.6.jpg')}}"
									class="img-circle" width="100" height="100">
								</label>
								<hr>
								<label class="radio-inline"> <input type="radio" 
									name="idFoto" value="1.1" {{(isset($membro) && $membro->idFoto=='1.1' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.1.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="1.2" {{(isset($membro) && $membro->idFoto=='1.2' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.2.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="1.3" {{(isset($membro) && $membro->idFoto=='1.3' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.3.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <br> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="1.4" {{(isset($membro) && $membro->idFoto=='1.4' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.4.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="1.5" {{(isset($membro) && $membro->idFoto=='1.5' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.5.jpg')}}"
									class="img-circle" width="100" height="100">
								</label> <label class="radio-inline"> <input type="radio"
									name="idFoto" value="1.6" {{(isset($membro) && $membro->idFoto=='1.6' ? 'checked' : '' )}}> 
									<img src="{{ url('imagens/Profile/1.6.jpg')}}"
									class="img-circle" width="100" height="100">
								</label>
							</div>
						</div>
						<!-- MODAL BODY -->
						<div class="modal-footer">
							<!-- button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button -->
							<button type="button" class="btn btn-primary"
								data-dismiss="modal">Salvar</button>
						</div>
						<!-- MODAL FOOTER -->
					</div>
				</div>
			</div>
			<!-- Final MODAL AVATAR -->

		</fieldset>
	</form>


	<!-- Modal Discipulador-->
	<!-- Modal fora do form principal Pois envia consulta para outra controller -->
	<div class="modal fade" id="DiscipuladorModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<!-- button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
					<h4 class="modal-title" id="myModalLabel">Selecionar Discipuladorr</h4>
				</div>
				<div class="modal-body">
				
					<!-- ------------------ Inicio Pesquisa Discipulado ------------------>
					<form method="post" action="{{route('membro.search')}}">
						{!! csrf_field() !!}
						<!-- IF USADO PARA RETORNO DO MÉTODO SEARCH MEMBRO -->
						@if ( isset($membro) )
							<input type="text" class="hide" name="route" value="membro.edit" />
							<input type="text" class="hide" name="id" value="{{$membro->id}}" />
						@else
							<input type="text" class="hide" name="route" value="membro.create" />
							<input type="text" class="hide" name="id" value="0" />
						@endif
						<!-- Alterar o Valor do campo para Editar -->
						<div class="input-group">
							<input type="text" class="form-control" name="nome" placeholder="Busque Discipulador(a)" /> 
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">Buscar</button>
							</span>
						</div>
					</form>
					<!-- ------------------- Fim Pesquisa Discipulado -------------------- -->
				
				</div>
				<!-- MODAL BODY -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<!-- button type="button" class="btn btn-primary"
						data-dismiss="modal">Salvar</button -->
				</div>
				<!-- MODAL FOOTER -->
			</div>
		</div>
	</div>
	<!-- Final MODAL Discipulador -->
				
</div>

@endsection

 @push('scripts')
<!-- jquery.inputmask -->
<script src="{{url('Gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>

<script type="text/javascript">
//-------------------------------------------------------------------------------
//Parte CEP
//-------------------------------------------------------------------------------
function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('Logradouro').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
        document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('Logradouro').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}
    
function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
	
    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('Logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//-------------------------------------------------------------------------------
//Parte CEP
//-------------------------------------------------------------------------------
</script>

@endpush
