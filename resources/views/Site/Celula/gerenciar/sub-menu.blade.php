@extends('layouts.app')

@section('content')

<style>
@media (min-width: 0px) {

  .nav-j > li {
    display: table-cell;
    width: 20%;
  }
</style>

<form method="post">
	{!! csrf_field() !!}
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab1" class="nav nav-tabs bar_tabs right nav-j" role="tablist" >
			<li role="presentation" class="'active'">
				<a href="#tab_content00" id="migrar-tabb" role="tab" data-toggle="tab" aria-controls="migrar" aria-expanded="false">Migrar</a>
			</li>
			<li role="presentation" class="'active'">
				<a href="#tab_content11" id="multiplicar-tabb" role="tab" data-toggle="tab" aria-controls="multiplicar" aria-expanded="false">Multiplicar</a>
			</li>
			<li role="presentation" class="'active'">
				<a href="#tab_content22" role="tab" id="lideranca-tabb" data-toggle="tab" aria-controls="lideranca" aria-expanded="false">Liderança</a>
			</li>
			<li role="presentation" class="'presenca'">
				<a href="#tab_content33" role="tab" id="presenca-tabb3" data-toggle="tab" aria-controls="presenca" aria-expanded="true">Presença</a>
			</li>
		</ul>
		
		<!-- ------------------------------------------------------------------------------------------------------------------------------------------ -->
		
		<div id="myTabContent2" class="tab-content">
			<div role="tabpanel" class="tab-pane fade" id="tab_content00" aria-labelledby="migrar-tab">
			
				@include('Site.Celula.gerenciar.migrar')
				
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content11" aria-labelledby="multiplicar-tab">
			
				@include('Site.Celula.gerenciar.multiplicar')
				
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="lideranca-tab">
			
				@include('Site.Celula.gerenciar.lideranca')

			</div>
			
			<div role="tabpanel" class="tab-pane fade" id="tab_content33" aria-labelledby="presenca-tab">
				
				@include('Site.Celula.gerenciar.presenca')
				
			</div>
		</div>
	</div>
	
	@include('Site.Celula.gerenciar.participantes')

</form>
	
@endsection
