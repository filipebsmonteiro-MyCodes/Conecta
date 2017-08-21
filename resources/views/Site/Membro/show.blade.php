@extends('layouts.app') @section('content')

@can('membro_update')
<div class="row">
	<div class="col-lg-12">
		<a href="{{route('membro.edit', $membro->id)}}" class="btn btn-primary"> 
			Editar {{$membro->first_name}}</a>
	</div>
</div>
@endcan

<div class="row">
	<div class=col-lg-2>
		<img src="{{ url('imagens/Profile')}}/{{$membro->idFoto or '1'}}.jpg"
			class="img-responsive img-circle " alt="Foto Perfil">
	</div>
	<div class="col-lg-6">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Nome</td>
						<td>{{$membro->first_name}}</td>
					</tr>
					<tr>
						<td>Sobrenome</td>
						<td>{{$membro->last_name}}</td>
					</tr>
					<tr>
						<td>Apelido</td>
						<td>{{$membro->nickname}}</td>
					</tr>
					<tr>
						<td><hr></td>
						<td><hr></td>
					</tr>
					<tr>
						<td>Email</td>
						<td>{{$membro->email}}</td>
					</tr>
					<tr>
						<td>Data de Nascimento</td>
						<td>{{$membro->birthday}}</td>
					</tr>
					<tr>
						<td>Estado Civil</td>
						<td>{{$membro->EstCivil}}</td>
					</tr>
					<tr>
						<td>Gênero</td>
						<td>{{$membro->gender}}</td>
					</tr>
					<tr>
						<td>CPF</td>
						<td>{{$membro->CPF}}</td>
					</tr>
					<tr>
						<td>RG</td>
						<td>{{$membro->RG}}</td>
					</tr>
					<tr>
						<td>Órgão Emissor</td>
						<td>{{$membro->Emissor}}</td>
					</tr>
					<tr>
						<td>Celular</td>
						<td>{{$membro->mobile}}</td>
					</tr>
					<tr>
						<td>Telefone</td>
						<td>{{$membro->phone}}</td>
					</tr>
					<tr>
						<td>CEP</td>
						<td>{{$membro->CEP}}</td>
					</tr>
					<tr>
						<td>Endereço</td>
						<td>{{$membro->Logradouro}}</td>
					</tr>
					<tr>
						<td>Bairro</td>
						<td>{{$membro->Bairro}}</td>
					</tr>
					<tr>
						<td>Cidade</td>
						<td>{{$membro->Cidade}}</td>
					</tr>
					<tr>
						<td>Estado</td>
						<td>{{$membro->UF}}</td>
					</tr>
					<tr>
						<td>Tipo de Membro</td>
						<td>{{$membro->tpMembro}}</td>
					</tr>
					<tr>
						<td>Tipo de Entrada</td>
						<td>{{$membro->tpEntrada}}</td>
					</tr>
					<tr>
						<td>Data de Entrada</td>
						<td>{{$membro->DataEntrada}}</td>
					</tr>
					<tr>
						<td>Igreja de Origem</td>
						<td>{{$membro->IgrejaDeOrigem}}</td>
					</tr>
					<tr>
						<td>Discipulador</td>
						<td>{{'Em Construção'}}</td>
					</tr>
					<tr>
						<td>Nome da Celula</td>
						<td>{{$membro->Celula}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- Div Col-6 -->
</div>
@endsection
