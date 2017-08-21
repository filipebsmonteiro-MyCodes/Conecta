@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Confirmar Inscrição</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-sm-12">

						<div class="row">
							<div class="col-lg-6 col-md-6">
						
							<form method="post" action="{{ route('evento.pagamento', Request::route('idEvento') ) }}">
								
								{!! csrf_field() !!}
						
									<div class="form-group">
										@forelse ( $pagamentosAceitos as $value )  
											
											@if ( $value->id == 8 )
											<div class="checkbox">
												<label> <input id="depConta" type="radio" 
													name="Tipos_Pagamentos_idTipos_Pagamentos" value="8"
													{{ ( isset($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos) 
														&& $dataPgto->Tipos_Pagamentos_idTipos_Pagamentos==8 
													? 'checked' : '' ) }}>
													Depósito na Conta do Evento
												</label>
											</div>
											@endif
											@if ( $value->id == 9 )
											<div class="checkbox">
												<label> <input id="trfConta" type="radio" 
													name="Tipos_Pagamentos_idTipos_Pagamentos" value="9"
													{{ ( isset($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos) 
														&& $dataPgto->Tipos_Pagamentos_idTipos_Pagamentos==9 
													? 'checked' : '' ) }}> 
													TED/DOC na Conta do Evento
												</label>
											</div>
								
											@endif
											@if ( $value->id == 10 )
											<div class="checkbox">
												<label> <input id="dinheiro" type="radio" 
													name="Tipos_Pagamentos_idTipos_Pagamentos" value="10"
													{{ ( isset($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos) 
														&& $dataPgto->Tipos_Pagamentos_idTipos_Pagamentos==10 
													? 'checked' : '' ) }}>
													Dinheiro
												</label>
											</div>
						
											@endif
											@if ( $value->id == 11 ) 
											<div class="checkbox">
												<label> <input id="pagSeguro" type="radio" 
													name="Tipos_Pagamentos_idTipos_Pagamentos" value="11"
													{{ (isset($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos) 
														&& ($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos==11 ||
															$dataPgto->Tipos_Pagamentos_idTipos_Pagamentos<8)
													? 'checked' : '' ) }}>
													PagSeguro
												</label>
											</div>
											<div id="avisoPag">
												<span class="label label-warning">Atenção</span> 
												Não preencha Código e Valor se o pagamento escolhido for PagSeguro!<br>
											</div>
											@endif
										@empty
										@endforelse
									</div>
						
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-money"></i> Valor
											Transação:</span> <input type="text" class="form-control"
											name="Valor_Bruto" placeholder="Valor da Tansação"
											value="{{ $dataPgto->Valor_Bruto or old('Valor_Bruto') }}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i> Código:</span>
										<input type="text" class="form-control" name="Codigo"
											placeholder="Código da Transação"
											value="{{ $dataPgto->Codigo or old('Codigo') }}">
									</div>
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-book"></i>
											Comentário:</span>
										<textarea class="form-control" rows="2" name="Comentario"
											placeholder="Comentário Opcional">{{ $dataPgto->Comentario or old('Comentario') }}</textarea>
									</div>
													
									<button type="submit" class="btn btn-success">
									<i class="fa fa-credit-card"></i> Registrar Pagamento</button>
									
								</form>
									
								</div>
						
								<div class="col-lg-6 col-md-6">
									
									@isset($status)
										<div class="product_price">
											<h1 class="price">{{$status->name or ''}}</h1>
											<span class="price-tax">{{$status->description or ''}}</span>
											<br><br>
										<!-- `tbl_tipopagamento`.`tpgTexto`, `tbl_tipopagamento`.`tpgDescricao` -->
										@if( !empty($dataPgto->Codigo) && 
											($dataPgto->Tipos_Pagamentos_idTipos_Pagamentos < 8 ||
											 $dataPgto->Tipos_Pagamentos_idTipos_Pagamentos == 11) )
											<form action="{{route('pagSeguro.search', $dataPgto->Codigo )}}">
												<button type="submit" class="btn btn-primary btn-xs">Consultar Alteração de Status </button>
											</form>
										</div>
										@endif
									@endisset
							
								</div>
						
							</div>
							<!-- End Row -->
							<hr>
						
						
						<div class="row">
							<div id="dadosBancarios" class="col-lg-6 col-md-6" style="display:none">
						    	<h4>Dados Bancários para Transferência/Depósito</h4>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> Banco:</span>
									<input type="text" class="form-control" placeholder="Nome do Banco" 
										name="Nome_Banco" disabled value="{{$evento->Nome_Banco or old('Nome_Banco')}}">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> Agência:</span>
									<input type="text" class="form-control" placeholder="Número da Agência" 
										name="Agencia" disabled value="{{$evento->Agencia or old('Agencia')}}">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> Conta:</span>
									<input type="text" class="form-control" placeholder="Número da Conta" 
									name="Conta" disabled value="{{$evento->Conta or old('Conta')}}">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> Tipo de Conta:</span>
									<input type="text" class="form-control" placeholder="ex.Conta Poupamça" 
										name="Tipo_Conta" disabled value="{{$evento->Tipo_Conta or old('Tipo_Conta')}}">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> CPF / CNPJ:</span>
									<input type="text" class="form-control" placeholder="CPF ou CNPJ" 
										name="Cpf_Cnpj" disabled value="{{$evento->Cpf_Cnpj or old('Cpf_Cnpj')}}">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-book"></i> Beneficiário:</span>
									<input type="text" class="form-control" placeholder="Nome" 
										name="NomeBeneficiario" disabled value="{{$evento->Nome_Beneficiario or old('NomeBeneficiario')}}">
								</div>
							</div>
						                        
						</div><!-- End Row -->

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection


@push('scripts')
	@isset($codeLightBox)
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
	
	<!-- script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script -->
	
	<script type="text/javascript">
	PagSeguroLightbox({
		code: '{{$codeLightBox}}'
	});    			
	</script>
	@endisset
	
	<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function (event) {
		
		//Listener se tipo de pagamento selecionado
	    var inputs=document.querySelectorAll("input[type=radio]"),
	    x=inputs.length;
    	var dadosBanco	= document.getElementById('dadosBancarios');
    	var aviso		= document.getElementById('avisoPag');
    	var Valor		= document.querySelector('input[name=Valor_Bruto]');
    	var Codigo		= document.querySelector('input[name=Codigo]');
		while(x--)
	    inputs[x].addEventListener("change",function(){
			//Esconde valor e código caso pagSeguro
			if (this.value == 11) {
	        	aviso.style.display = 'block';
	        	Valor.style.display = 'none';
	        	Codigo.style.display = 'none';
	        } else {
	        	aviso.style.display = 'none';
	        	Valor.style.display = 'block';
	        	Codigo.style.display = 'block';
	        	
	        }
	        
		    //mostra Dados Bancarios caso TED ou Deposito
	    	if (this.value == 8 || this.value == 9) {
	        	dadosBanco.style.display = 'block';
	        } else {
	        	dadosBanco.style.display = 'none';
	        	
	        }
	        //console.log("Checked: "+this.checked);
	        //console.log("Name: "+this.name);
	        //console.log("Value: "+this.value);
	        //console.log("Parent: "+this.parent);
	    },0);

		//Listener Desabilita campos PagSeguro
	    
	    
	});
	</script>
@endpush