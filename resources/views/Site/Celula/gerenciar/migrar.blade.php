	<!-- Início SubMenu Migração -->
	<div class="row">
									
		<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 10px;">
			<select class="form-control" name="NovaCelulas_idCelulas">
				@forelse($celulas as $celula)
						<option value="{{$celula->id}}">{{$celula->Nome}}</option>
				@empty
					<option selected disabled>Sem Células Cadastradas</option>
				@endif
			</select>
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-3">
			<button type="submit" class="btn btn-round btn-success" onClick="return confirm('Deseja realmente Migrar Participantes ?');"
				formaction="{{route('celula.migrar')}}">Migrar Participantes</button>
		</div>
			
		<div class="dropdown col-lg-3 col-md-3 col-sm-3">
			<button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Instruções
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="background-color: #e7e7e7;">
				<li>1. Selecione a Célula de Destino</li>
				<li class="separator"></li>
				<li>2. Selecione os Participantes que irão para uma Nova Célula.</li>
				<li class="separator"></li>	
				<li>3. Clique em Migrar Participantes.</li>
			</ul>
		</div>
		
	</div>
	<hr>
	<!-- Início SubMenu Migração -->