	<!-- Início SubMenu Multiplicação -->
	<div class="row">
									
		<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 10px;">
			<input type="text" class="form-control" placeholder="Nome da Nova Célula" name="Nome_NovaCelula" >
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-3">
			<button type="submit" class="btn btn-round btn-success" formaction="{{route('celula.multiplicar')}}" >Multiplicar Célula</button>
		</div>
			
		<div class="dropdown col-lg-3 col-md-3 col-sm-3">
			<button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Instruções
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="background-color: #e7e7e7;">
				<li>1. Digite o nome da Nova Célula</li>
				<li class="separator"></li>
				<li>2. Selecione os Participantes da Nova Célula.</li>
				<li class="separator"></li>
				<li>3. Clique em Multiplicar Célula.</li>
			</ul>
		</div>
		
	</div>
	<hr>
	<!-- Início SubMenu Multiplicação -->