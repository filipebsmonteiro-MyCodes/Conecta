@extends('layouts.app') 

@section('content')
<div class="row">
	@if ( isset($celula) )
	<form class="form" method="post" action="{{route('celula.update', $celula->id)}}">
		{!! method_field('PUT') !!} 
	@else
	<form method="post" action="{{route('celula.store')}}">
	@endif 
		{!! csrf_field() !!}
		<div class="col-lg-6">
			<div class="form-group input-group">
				<span class="input-group-addon">Célula</span> 
				<input type="text" class="form-control" placeholder="Nome da Célula" 
						name="Nome" required="required" value="{{$celula->Nome or old('Nome')}}" autofocus>
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-area-chart"></i>
					Região</span> 
				<select class="form-control" name="Regiaos_idRegiaos">
					@foreach($regioes as $regiao)
						<option value="{{$regiao->id}}"
							{{ (isset($celula->Regiaos_idRegiaos) && $celula->Regiaos_idRegiaos == $regiao->id)|| 
								(old('Redes_idRedes') == $regiao->id) ? "selected" : ""
							}}>{{$regiao->nome}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-paw"></i> Rede</span>
				<select class="form-control" name="Redes_idRedes">
					<option selected disabled value="0">Selecione</option>
						@foreach($redes as $rede)
							<option value="{{$rede->id}}"
							{{ (isset($celula->Redes_idRedes) && $celula->Redes_idRedes == $rede->id)|| 
								(old('Redes_idRedes') == $rede->id) ? "selected" : ""
							}}>
							{{$rede->Nome}}</option>
						@endforeach
					</select>
			</div>

			<hr>
			<!-- ----------------------------------------------------------------------------------------- -->
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-folder-o"></i> CEP</span>
				<input type="text" class="form-control" placeholder="CEP da Célula"
					name="CEP" id="cep" data-inputmask="'mask': '99.999-999'"
					onblur="pesquisacep(this.value);" value="{{$dataEnd->CEP or old('CEP')}}">
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-institution"></i>
					Endereço</span> <input type="text" class="form-control"
					placeholder="Endereço da Célula" name="Logradouro" id="Logradouro"
					maxlength="60" value="{{$dataEnd->Logradouro or old('Logradouro')}}">
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-institution"></i>
					Bairro</span> <input type="text" class="form-control"
					placeholder="Bairro da Célula" name="Bairro" id="bairro"
					maxlength="40" value="{{$dataEnd->Bairro or old('Bairro')}}">
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-institution"></i>
					Cidade</span> <input type="text" class="form-control"
					placeholder="Cidade da Célula" name="Cidade" id="cidade"
					maxlength="40" value="{{$dataEnd->Cidade or old('Cidade')}}">
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class="fa fa-flag"></i> UF</span>
				<select class="form-control" size="1" name="UFs_idUFs" id="uf">
		      		@foreach ( $UFs as $UF )
						<option value="{{$UF->id}}"
							{{ (isset($dataEnd) && $dataEnd->UFs_idUFs == $UF->id)|| (old('UFs_idUFs') == $UF->id) ? "selected" : ""}}>
							{{$UF->Nome}}
						</option> 
					@endforeach
				</select>
			</div>
			<!-- ----------------------------------------------------------------------------------------- -->

			<div class="form-group input-group">
				<button type="reset" class="btn btn-default">Limpar</button>
				<button type="submit" class="btn btn-success">Enviar</button>
			</div>
		</div>
	</form>

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