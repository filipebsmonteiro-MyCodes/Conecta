<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">
		<input id="searchTabela" type="search"
			placeholder="Procurar Participantes" class="form-control"
			onkeyup="searchTabelaFunction()">
	</div>
</div>
<br>

<div class="table-responsive">
	<table id="tabelaParticipantes"
		class="table table-bordered table-hover table-striped">
		<thead align="center">
			<tr>
				<th>Participantes</th>
				<th>Opções</th>
			</tr>
		</thead>
		<tbody>
			@forelse ( $participantes as $participante )
			<tr>
				<td>
					@if( isset($participante->first_name) )
						{{ $participante->first_name }} {{ $participante->last_name }}
					@else
						{{ $participante->nome }}
					@endif
				</td>
				<td>
					<input type="text" class="hide" name="Celulas_idCelulas" value="{{Request::route('id')}}">
					<label class="switch">
						<input type="checkbox" name="User_has_Celulas_idUser_has_Celulas[]" value="{{$participante->idRelacionamento}}"  
							@isset($presentes)
							@foreach ($presentes as $presente)
								@if ($presente->idPresente == $participante->idRelacionamento)
								{{'checked'}}
								@break
								@endif
							@endforeach
							@endisset
						>
						<div class="slider round"></div>
					</label>
				</td>
			</tr>
			@empty
				<b>Ainda não há Paricipantes cadastrados nessa Célula.</b>
			@endif
		</tbody>
	</table>
</div>

<script>
function searchTabelaFunction() {
	// Declare variables
	var input, filter, table, tr, td, i;
	input = document.getElementById("searchTabela");
	filter = input.value.toUpperCase();
	table = document.getElementById("tabelaParticipantes");
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
