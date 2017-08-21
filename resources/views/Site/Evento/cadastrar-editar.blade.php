@extends('layouts.app') @section('content')
<div class="row">
	@if ( isset($evento) )
		<form class="form" method="post" action="{{route('evento.update', $evento->id)}}">
		{!! method_field('PUT') !!} 
	@else
		<form method="POST" action="{{route('evento.store')}}">
	@endif 
		{!! csrf_field() !!}
			<div class="col-lg-12">
				<!-- End Panel Group -->

				<div id="wizard_verticle" class="form_wizard wizard_verticle">
					<ul class="list-unstyled wizard_steps anchor">
						<li>
							<a href="#step-11" class="selected" isdone="1" rel="1">
								<span class="step_no">Informação</span>
							</a>
						</li>
						<li>
							<a href="#step-22" class="disabled" isdone="0" rel="2">
								<span class="step_no">Descrição</span>
							</a>
						</li>
						<li id='33'>
							<a href="#step-33" class="disabled" isdone="0" rel="3">
								<span class="step_no">Inscrição</span>
							</a>
						</li>
						<li id='44'>
							<a href="#step-44" class="disabled" isdone="0" rel="4">
								<span class="step_no">Restrição</span>
							</a>
						</li>
						<li id='55'>
							<a href="#step-55" class="disabled" isdone="0" rel="5">
								<span class="step_no">Pagamento</span>
							</a>
						</li>
					</ul>
				
					<div class="stepContainer" >
						<div id="step-11" style="display: block;">
							<h2 class="StepTitle">Informações Básicas</h2>
							<!-- div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-area-chart"></i> Tipo de Evento</span>
								<select class="form-control" name="idTipo" onchange="loadDescricao(this.value);">
								< ?php
								if(isset($tiposEvento)){
									foreach($tiposEvento as $tipo){
										if (isset($descTipoEvento['tevid']) && $descTipoEvento['tevid']==$tipo['tevid']) {?>
											<option value="< ?php echo $tipo['tevid'];?>" selected="selected">< ?php echo $tipo['tevTipoEvento'];?></option>
										< ?php } else {?>
											<option value="< ?php echo $tipo['tevid'];?>">< ?php echo $tipo['tevTipoEvento'];?></option>
									 < ?php }
										}
									}?>
								</select>
								<span class="input-group-btn">
									<!-- Button trigger modal -- >
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
										<i class="fa fa-plus"></i>
									</button>
								</span>
							</div -->
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-terminal"></i>
									Nome do Evento</span> <input type="text" class="form-control"
									placeholder="Nome do evento" name="Nome" required="required"
									autofocus value="{{$evento->Nome  or old('Nome')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>
									Início</span> <input type="date" class="form-control"
									placeholder="Data de Início" name="Inicio" required="required"
									value="{{$evento->Inicio  or old('Inicio')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>
									Término</span> <input type="date" class="form-control"
									placeholder="Data de Término" name="Final" required="required"
									value="{{$evento->Final  or old('Final')}}">
							</div>
					
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>
									Localização</span> <input type="text" class="form-control"
									placeholder="Local" name="Local" required="required"
									value="{{$evento->Local  or old('Local')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-users"></i>
									Quantidade de vagas</span> <input type="number"
									class="form-control" placeholder="Total de vagas"
									name="Quantidade_Vagas" required="required"
									value="{{$evento->Quantidade_Vagas  or old('Quantidade_Vagas')}}">
							</div>
							<div class="form-group">
								<div class="checkbox" id="check-33"
									onchange="deleteStep('33');" onuncheck="alert('hahaha');">
									<label> <input type="checkbox" checked name="EventoInscricoes">Evento
										Possui Inscrições?
									</label>
								</div>
								<div class="checkbox" id="check-44"
									onchange="deleteStep('44');">
									<label> <input type="checkbox" checked name="EventoRestricoes">Evento
										possui Restrições para Participantes?
									</label>
								</div>
								<div class="checkbox" id="check-55"
									onchange="deleteStep('55');">
									<label> <input type="checkbox" checked name="EventoPago">Evento
										Pago?
									</label>
								</div>
							</div>
						</div>
						<div id="step-22" style="display: none;">
							<h2 class="StepTitle">Detalhes do Evento</h2>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-book"></i>
									Descrição:</span>
								<textarea class="form-control" rows="3"
									placeholder="Fale mais sobre o evento" name="description">{{$evento->description  or old('description')}}</textarea>
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label> <input type="checkbox" checked name="Ativo" value="1">Evento
										Ativo?
									</label>
								</div>
							</div>
						</div>
						<div id="step-33" style="display: none;">
							<h2 class="StepTitle">Prazos de Inscrições</h2>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>
									Início Inscrições</span> <input type="date"
									class="form-control" placeholder="Início das Inscrições"
									name="Prazos[0][Prazo_Data]" required="required"
									value="{{$prazos[0]->Prazo_Data  or old('Prazos[0][Prazo_Data]')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-money"></i>
									1º Valor</span> <input type="number" class="form-control"
									placeholder="Opcional" name="Prazos[0][Prazo_Valor]" step="0.50"
									value="{{$prazos[0]->Prazo_Valor  or old('Prazos[0][Prazo_Valor]')}}">
							</div>
							<hr>
							
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>
									2º Lote Inscrição</span> <input class="form-control"
									name="Prazos[1][Prazo_Data]" placeholder="Opcional" type="date"
									value="{{$prazos[1]->Prazo_Data  or old('Prazos[1][Prazo_Data]')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-money"></i>
									2º Valor</span> <input type="number" class="form-control"
									placeholder="Opcional" name="Prazos[1][Prazo_Valor]" step="0.50"
									value="{{$prazos[1]->Prazo_Valor  or old('Prazos[1][Prazo_Valor]')}}">
							</div>
							<hr>
							
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i>
											Último Dia Inscrição</span> <input type="date"
											class="form-control" placeholder="Dt Término"
											name="Prazos[2][Prazo_Data]" required="required"
											value="{{$prazos[2]->Prazo_Data  or old('Prazos[2][Prazo_Data]')}}">
									</div>
									<hr>
								</div>
							</div>
						</div>
						<div id="step-44" style="display: none;">
							<h2 class="StepTitle">Restrições</h2>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-book"></i>
									Idade Mínima:</span> <input type="number" class="form-control"
									placeholder="Idade Mínima" name="Restricoes[idade_Minima]"
									value="{{$restricoes->idade_Minima  or old('Restricoes[idade_Minima]')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-book"></i>
									Idade Máxima:</span> <input type="number" class="form-control"
									placeholder="Idade" name="Restricoes[idade_Maxima]"
									value="{{$restricoes->idade_Maxima  or old('Restricoes[idade_Maxima]')}}">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-heart"></i>
									Estado Civil / Somente</span> 
									<select class="form-control" name="Restricoes[EstadoCivils_idEstadoCivils]"> 
									@foreach ( $estadoCivils as	$estadoCivil ) 
										<option value="{{$estadoCivil->id}}"
										{{ 
											(isset($restricoes) && $restricoes->EstadoCivils_idEstadoCivils == $estadoCivil->id)||
											(old('Restricoes[EstadoCivils_idEstadoCivils]') == $estadoCivil->id) 
											? "selected" : "" 
										}}>
										{{$estadoCivil->description}}</option>
									@endforeach
									</select>
							</div>
							<div class="form-group">
								<label class="input-group">Gênero / Somente</label> <label
									class="radio-inline"> <input type="radio"
									name="Restricoes[genero]" id="M" value="M"
									@if(isset($restricoes->genero) && $restricoes->genero=='M') {{'checked'}}@endif>
									Masculino
								</label> <label class="radio-inline"> <input type="radio"
									name="Restricoes[genero]" id="F" value="F"
									@if(isset($restricoes->genero) && $restricoes->genero=='F') {{'checked'}}@endif>
									Feminino
								</label>
							</div>
						</div>
						<div id="step-55" style="display: none;">
							<h2 class="StepTitle">Pagamentos</h2> 
							<h4>Tipos De Pagamentos Aceitos para Esse Evento</h4>
							@foreach( $tiposPagamento as $tipoPagamento)
									<div class="form-group">
										<div class="checkbox">
											<label> <input id="tipoPgto{{$tipoPagamento->id}}" type="checkbox"
												name="PagamentosAceitos[]" value="{{$tipoPagamento->id}}"
												@if(isset($evento->PagamentosAceitos) ) 
													@foreach($evento->PagamentosAceitos as $idTipos_Pagamentos)
														@if( $idTipos_Pagamentos->idTipos_Pagamentos == $tipoPagamento->id )
															{{'checked'}}
														@endif
													@endforeach
												@endif> 
												{{$tipoPagamento->description}}
											</label>
										</div>
									</div>
							@endforeach
							<hr>
				
							<!-- ----------------------------------- -->
							<div class="row">
								<div id="dadosBancarios" class="col-lg-6 col-md-6"
									style="display: none">
									<h4>Dados Bancários para Transferência/Depósito</h4>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Banco:</span> <input type="text" class="form-control"
											placeholder="Nome do Banco" name="Nome_Banco"
											value="{{$evento->Nome_Banco or old('Nome_Banco')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Agência:</span> <input type="text" class="form-control"
											placeholder="Número da Agência" name="Agencia"
											value="{{$evento->Agencia or old('Agencia')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Conta:</span> <input type="text" class="form-control"
											placeholder="Número da Conta" name="Conta"
											value="{{$evento->Conta or old('Conta')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Tipo de Conta:</span> <input type="text"
											class="form-control" placeholder="ex.Conta Poupamça"
											name="Tipo_Conta"
											value="{{$evento->Tipo_Conta or old('Tipo_Conta')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											CPF / CNPJ:</span> <input type="text" class="form-control"
											placeholder="CPF ou CNPJ" name="Cpf_Cnpj"
											value="{{$evento->Cpf_Cnpj or old('Cpf_Cnpj')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Beneficiário:</span> <input type="text" class="form-control"
											placeholder="Nome" name="Nome_Beneficiario"
											value="{{$evento->Nome_Beneficiario or old('Nome_Beneficiario')}}">
									</div>
								</div>
				
								<div id="dadosPagSeguro" class="col-lg-6 col-md-6"
									style="display: none">
									<h4>Dados Para Recebimeno no PagSeguro</h4>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											E-mail:</span> <input type="email" class="form-control"
											placeholder="Email PagSeguro" name="Email_PagSeguro"
											value="{{$evento->Email_PagSeguro or old('Email_PagSeguro')}}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Token:</span> <input type="text" class="form-control"
											placeholder="Oficial ou SandBox" name="Token_PagSeguro"
											value="{{$evento->Token_PagSeguro or old('Token_PagSeguro')}}">
									</div>
								</div>
							</div>
							<!-- End Row --> 
						</div>
					</div>
				</div>
				
			</div>
		</form>
</div>



                      
@endsection @push('scripts')
<!-- javascripts Evento -->
<script src="{{url('js/EventoJS.js')}}"></script>
<!-- jQuery Smart Wizard -->
<script src="{{url('Gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
    // Smart Wizard         
    $('#wizard_verticle').smartWizard({
    	 enableFinishButton: true, // make finish button enabled always
 	     labelNext:'Próximo', // label for Next button
 	     labelPrevious:'Anterior', // label for Previous button
 	     labelFinish:'Cadastrar Evento',  // label for Finish button
 	     ajaxType: 'POST',
         onLeaveStep:leaveAStepCallback,
         onShowStep: showStepCallback,
    });

    var STEP;
    
    function leaveAStepCallback(obj, context){
        STEP = context.toStep;
        return true; 
    }

    function showStepCallback(obj, context){
        localStep = STEP++;

        if( $('#step-'+localStep+localStep).find( 'h2' ).html() == "Clique em Próximo ou Cadastrar Evento!" )
        	$('#wizard_verticle').smartWizard('goForward');

        return true; 
    }
	
});

</script>
@endpush
