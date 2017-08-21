<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Celula;
use App\Models\Site\Regiao;
use App\Models\Site\Uf;
use App\Models\Site\Rede;
use App\Http\Requests\Site\CelulaFormRequest;
use App\Models\Site\Endereco;
use App\Models\Site\User;
use App\Models\Site\User_has_celula;
use App\Models\Site\PresencaCelula;
use App\Http\Requests\Site\PresencaCelulaFormRequest;
use App\Models\Site\Convidado;
use App\Http\Requests\Site\ConvidadoFormRequest;

class CelulaController extends Controller
{
	private $Celula;
	private $TotalPagina;
	
	public function __construct(Celula $celula){
		$this->middleware('auth');
		$this->Celula = $celula;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Rede $rede)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_list');
    	    	
        $title		= 'Lista de Células';
        $celulas	= $this->Celula
        					->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
        					->paginate(5);
        return view('site.celula.index', compact('title', 'celulas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Regiao $regiao, Rede $rede, Uf $uf)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_create');
    	
    	$title		= 'Cadastrar Célula';
    	$regioes	= $regiao	->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)->get();
    	$redes		= $rede		->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)->get();
    	$UFs		= $uf->all();
    	return view('site.celula.cadastrar-editar', compact('title', 'regioes', 'redes', 'UFs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CelulaFormRequest $request, Endereco $endereco)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_create');
    	
    	try {
	    	//Pega Todos os dados do formulario
	    	$dataCelula		= $request->except('_token', 'CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
	    	
	    	$dataEndereco	= $request->only('CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
	    	
	    	//Faz o cadastro
	    	$insertEndereco	= $endereco->create($dataEndereco);
	    	
	    	$dataCelula['Enderecos_idEnderecos']	= $insertEndereco->id;
	    	$dataCelula['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
	    	
	    	$this->Celula->create($dataCelula);
	    	
	    	flash('Célula Cadastrada com sucesso!', 'success');
	    	return redirect()->route('celula.index');
	    	
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, User_has_celula $MembroCelula, Regiao $regiao, PresencaCelula $presenca,  $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_show');
    	if( !$this->Celula->is_Lider($id) && !$this->Celula->is_Super($id) && 
    		!auth()->user()->hasAnyPerfils('admin') ) {
    		flash('Acesso Negado!', 'danger'); return redirect()->back();
    	} 
    	
    	$title		= 'Visualizar Celula';
    	$celula		= $this->Celula->find($id);
    	$membros	= $MembroCelula->select('users.first_name', 'user_has_celulas.cargo')
    								->join('users',	'users.id', '=', 'Users_idUsers')
    								->where('User_has_Celulas.Celulas_idCelulas', $id)->get();
		$regiao		= $regiao->find($celula['Regiaos_idRegiaos']);
		$encontro	= $presenca->where('Celulas_idCelulas', $id)->max('created_at');
					    	
		return view('site.celula.show', compact('title', 'celula', 'membros', 'regiao', 'encontro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Regiao $regiao, Rede $rede, Uf $uf, Endereco $endereco, User_has_celula $UC, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_update');
    	if( !$this->Celula->is_Lider($id) && !$this->Celula->is_Super($id) &&
    		!auth()->user()->hasAnyPerfils('admin') ) {
    		flash('Acesso Negado!', 'danger');return redirect()->back();
    	}    	
    	
    	$title		= 'Editar Célula';
    	$regioes	= $regiao	->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)->get();
    	$redes		= $rede		->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)->get();
    	$UFs		= $uf		->all();
    	$celula		= $this->Celula->find($id);
    	$dataEnd	= $endereco	->find($celula['Enderecos_idEnderecos']);
    	
    	return view('site.celula.cadastrar-editar', compact('title', 'regioes', 'redes', 'UFs', 'celula', 'dataEnd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CelulaFormRequest $request, Endereco $endereco, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_update');
    	if( !$this->Celula->is_Lider($id) && !$this->Celula->is_Super($id) &&
    		!auth()->user()->hasAnyPerfils('admin') ) {
    		flash('Acesso Negado!', 'danger'); return redirect()->back();
    	} 
    	
    	try {
    		
    		//Recupera a Célula
    		$celula = $this->Celula->find($id);
    		
    		//Pega Todos os dados do formulario
    		$dataCelula		= $request->except('_token', 'CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
    		
    		$dataEndereco	= $request->only('CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
    		
    		//Faz o cadastro
    		if( !empty($celula['Enderecos_idEnderecos'])){
    			$endereco->find($celula['Enderecos_idEnderecos'])->update($dataEndereco);
    		}
    		
    		$celula->update($dataCelula);
    		
    		flash('Célula Alterada com sucesso!', 'success');
    		return redirect()->route('celula.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	//valida se User tem Autorização
    	$this->authorize('celula_delete');
    	if( !$this->Celula->is_Lider($id) && !$this->Celula->is_Super($id) &&
    		!auth()->user()->hasAnyPerfils('admin') ) {
    		flash('Acesso Negado a Célula: '. $id.' !', 'danger'); return redirect()->back();
    	} 
    	
    	try {
    		
    		//Recupera a Célula
    		$celula = $this->Celula->find($id);
    		
    		$celula->delete();
    		
    		flash('Célula Excluida com sucesso!', 'success');
    		return redirect()->route('celula.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    /* GERENCIAR CELULA SECTION */
    /**
     * Carrega os Dados para as Abas de Gerenciamento da Célula.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gerenciar(User_has_celula $UC, Celula $celula, $id){
    	if( !$this->Celula->is_Lider($id) && !$this->Celula->is_Super($id) &&
    		!auth()->user()->hasAnyPerfils('admin') ) {
    		flash('Acesso Negado a Célula: '. $id.' !', 'danger'); return redirect()->back();
    	}
    	
    	$title			= 'Gerenciar Célula';
    	$participantes	= $UC->select( 'User_has_celulas.id as idRelacionamento'
    									, 'users.first_name', 'users.last_name'
    									, 'user_has_celulas.cargo', 'user_has_celulas.cargo'
    									, 'convidados.nome'
    								)
    							->leftJoin('users', 'users.id', '=', 'user_has_celulas.Users_idUsers')
    							->leftJoin('convidados', 'convidados.id', '=', 'user_has_celulas.Convidados_idConvidados')
    									
    							->where('user_has_celulas.Celulas_idCelulas', $id)
    							->get();
    	
    	$celulas		= $celula->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)->get();
    							
    	return view('site.celula.gerenciar.sub-menu', compact('title', 'participantes', 'celulas'));
    }
    
    public function presenca(PresencaCelulaFormRequest $request, PresencaCelula $presenca){
    	//valida se User tem Autorização
    	$this->authorize('celula_gerenciar');
    	
    	try {
    		$dataPresenca	= $request->only('Celulas_idCelulas', 'Data_Encontro');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas')['User_has_Celulas_idUser_has_Celulas'];
    		
    		if (!isset($dataPresenca['Data_Encontro'])) {
    			flash('Preencha a Data do Encontro', 'danger');
    			return redirect()->back();
    		}
    		
    		foreach ($participantes as $idRelacionamento) {
    			$dataPresenca['User_has_Celulas_idUser_has_Celulas']	= $idRelacionamento;
    			$presenca->updateOrCreate($dataPresenca);
    		}
    		
    		//Deleta Ausentes
    		$this->deleta_Ausentes($dataPresenca['Celulas_idCelulas']);
    		
    		flash('Presenças Confirmadas com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $dataPresenca['Celulas_idCelulas']);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    public function carregaPresenca(PresencaCelulaFormRequest $request, User_has_celula $UC, Celula $celula, PresencaCelula $presenca, $id){
    	//valida se User tem Autorização
    	//$this->authorize('celula_gerenciar');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas')['Celulas_idCelulas'];
    		$dataEncontro	= $request->only('Data_Encontro')['Data_Encontro'];
    		//'User_has_Celulas_idUser_has_Celulas'
    		
    		if (!isset($dataEncontro)) {
    			flash('Preencha a Data do Encontro', 'danger');
    			return redirect()->back();
    		}
    					    		
    		$title			= 'Presença Célula';
    		$participantes	= $UC->select( 'User_has_celulas.id as idRelacionamento'
						    				, 'users.first_name', 'users.last_name'
						    				, 'user_has_celulas.cargo', 'user_has_celulas.cargo'
						    				, 'convidados.nome'
					    				)
			    				->leftJoin('users', 'users.id', '=', 'user_has_celulas.Users_idUsers')
			    				->leftJoin('convidados', 'convidados.id', '=', 'user_has_celulas.Convidados_idConvidados')
			    				
			    				->where('user_has_celulas.Celulas_idCelulas', $id)
			    				->get();
    				
    		$celulas		= $celula->all();
    		
    		$presentes		= $presenca->select('User_has_Celulas_idUser_has_Celulas as idPresente')
					    				->where('Celulas_idCelulas', $idCelula)
					    				->where('Data_Encontro', $dataEncontro)
					    				->get();
    		
    		flash('Presentes Encontro: '.
    				\Carbon\Carbon::createFromFormat('Y-m-d', $dataEncontro)->format('d/m/Y').
    				' Listados(as) com Sucesso!', 'success');
    		return view('site.celula.gerenciar.sub-menu', compact('title', 'participantes', 'celulas', 'presentes'));
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    /**
     * Método Deleta Participantes ausentes 
     * nos últimos 5 Encontros da Célula
     * 
     * @param int $id
     */
    private function deleta_Ausentes($id) {
    	$presenca		= new \App\Models\Site\PresencaCelula;
    	$UC				= new \App\Models\Site\User_has_celula;
    	
    	//Seleciona Últimos 5 Encontros
    	$Encontros		= $presenca->select('Data_Encontro as UltimoEncontro')
									->where('Celulas_idCelulas', $id)
									->groupBy('Data_Encontro')
									->orderBy('Data_Encontro', 'asc')
									->limit(5)->get();
    	
    	if ($Encontros->count() == 5) {
    		//Seleciona Presentes dos ultimos 5 encontros
    		$presentes	= $presenca->select( 'User_has_Celulas_idUser_has_Celulas')
				    				->where('Celulas_idCelulas', $id)
				    				->whereIn('Data_Encontro', $Encontros)
				    				->groupBy('User_has_Celulas_idUser_has_Celulas')
    								->get();
    		
			$ausentes	= $UC->select('id')
							->whereNotIn('id', $presentes)->delete();
    	}
    	
    }
    
    public function lideranca(Request $request, User_has_celula $UC){
    	//valida se User tem Autorização
    	$this->authorize('celula_lideranca');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas');
    		
    		foreach ($participantes as $idRelacionamento) {
    			
    			$lider = $UC->select('*')
    						->where('id', $idRelacionamento)
			    			->where('cargo', '!=', 'Visitante')
			    			->first()
			    			->update(['cargo'=>'Lider']);
    			
    		}
    		
    		flash('Liderança(s) atribuída(s) com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $idCelula);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    public function subLideranca(Request $request, User_has_celula $UC){
    	//valida se User tem Autorização
    	$this->authorize('celula_lideranca');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas');
    		
    		foreach ($participantes as $idRelacionamento) {
    			
    			$lider = $UC->select('*')
    						->where('id', $idRelacionamento)
			    			->where('cargo', '!=', 'Visitante')
			    			->first()
			    			->update(['cargo'=>'Lider em Treinamento']);
    			
    		}
    		
    		flash('Liderança(s) atribuída(s) com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $idCelula);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }

    /**
     * Remove a Lideranca do Lider Recebido.
     *
     * Parametros idCelula e idLider
     * 
     * @param  int  $idC, int $idL
     * @return \Illuminate\Http\Response
     */
    public function removeLideranca(User_has_celula $UC, $idUserCel){
    	//valida se User tem Autorização
    	$this->authorize('celula_lideranca');
    	
    	try {
    		
    		$obj	= $UC->select('*')
		    			->where('id', $idUserCel)
				    	->first();
    		$obj->update(['cargo'=>'Membro']);	    	
    		
    		flash('Liderança Removida com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $obj['Celulas_idCelulas']);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    public function multiplicar(Request $request, User_has_celula $UC){
    	//valida se User tem Autorização
    	$this->authorize('celula_gerenciar');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas');
    		$NomeNovaCelula	= $request->only('Nome_NovaCelula');
    		$NomeNovaCelula	= $NomeNovaCelula['Nome_NovaCelula'];
    		
    		//--------------------------------------------------------------
    		if (!isset($NomeNovaCelula)) {
    			flash('Escreva um nome para a Nova Célula!', 'danger');
    			return redirect()->back();
    		}
    		if (!isset($participantes['User_has_Celulas_idUser_has_Celulas'])) {
    			flash('Selecione ao menos 1 participante para a Nova Célula!', 'danger');
    			return redirect()->back();
    		}
    		//--------------------------------------------------------------
    		
    		$NovaCelula = $this->Celula->create(['Nome'=> $NomeNovaCelula]);
    		
    		foreach ($participantes as $idRelacionamento) {
    			$UC->select('*')
    			->where('id', $idRelacionamento)
    			->first()
    			->update(['Celulas_idCelulas'=> $NovaCelula->id]);
    		}
    		
    		flash('Célula Multiplicada com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $idCelula);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    public function migrar(Request $request, User_has_celula $UC){
    	//valida se User tem Autorização
    	$this->authorize('celula_gerenciar');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas');
    		$idNovaCelula	= $request->only('NovaCelulas_idCelulas');
    		$idNovaCelula 	= $idNovaCelula['NovaCelulas_idCelulas'];
    		
    		//--------------------------------------------------------------
    		if (!isset($idNovaCelula)) {
    			flash('Selecione a Nova Célula!', 'danger');
    			return redirect()->back();
    		}
    		if (empty($participantes['User_has_Celulas_idUser_has_Celulas'])) {
    			flash('Selecione ao menos 1 participante para a Migrar!', 'danger');
    			return redirect()->back();
    		}
    		//--------------------------------------------------------------
    		
    		foreach ($participantes as $idRelacionamento) {
    			$UC->select('*')
	    			->where('id', $idRelacionamento)
    				->first()
    				->update(['Celulas_idCelulas'=> $idNovaCelula]);
    		}
    		
    		flash('Participantes Migrados com Sucesso!', 'success');
    		return redirect()->route('celula.gerenciar', $idCelula);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    /* CONVIDADO CELULA SECTION */
    public function createConvidado(Regiao $regiao, $id){
    	//valida se User tem Autorização
    	$this->authorize('convidado_create');
    	
    	$title			= 'Cadastrar Convidado da Célula';
    	$destinyForm	= 'celula.storeConvidado';
    	$var_Auxiliar	= $id;
    	
    	$regioes = $regiao->all();
    	
    	return view('site.convidado.cadastrar-editar', compact('title', 'regioes', 'destinyForm', 'var_Auxiliar'));
    }
    
    public function storeConvidado(ConvidadoFormRequest $request, Convidado $convidado, User_has_celula $UC)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_create');
    	
    	try {
    		
    		//Pega Todos os dados do formulario
    		$dataForm = $request->except(['_token', 'var_Auxiliar']);
    		
    		//Faz o cadastro
    		$insert = $convidado->create($dataForm);
    		
    		$UC->create([
    				'Celulas_idCelulas'			=> $request->only('var_Auxiliar')['var_Auxiliar'],
    				'Users_idUsers'				=> null,
    				'Convidados_idConvidados'	=>$insert->id,
    				'cargo'						=> 'Visitante'
    		]);
    		
    		flash('Convidado(a) Cadastrado(a) com sucesso!', 'success');
    		return redirect()->route('celula.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
  
    /* RECICLAR PARTICIPANTES SECTION */
    public function reciclar(User_has_celula $UC, $id) {
    	//valida se User tem Autorização
    	$this->authorize('celula_reciclar');
    	
    	$title		= 'Reciclar Participantes';
    	$participantes	= $UC->select( 'User_has_celulas.id as idRelacionamento'
    			, 'users.first_name', 'users.last_name'
    			, 'user_has_celulas.cargo', 'user_has_celulas.cargo'
    			, 'convidados.nome'
    			)
    			->leftJoin('users', 'users.id', '=', 'user_has_celulas.Users_idUsers')
    			->leftJoin('convidados', 'convidados.id', '=', 'user_has_celulas.Convidados_idConvidados')
    			
    			->where('user_has_celulas.Celulas_idCelulas', $id)
    			->onlyTrashed()->get();
    	return view('site.celula.reciclar', compact('title', 'participantes'));
    }
    
    public function restore(Request $request, User_has_celula $UC) {
    	//valida se User tem Autorização
    	$this->authorize('celula_reciclar');
    	
    	try {
    		$idCelula		= $request->only('Celulas_idCelulas');
    		$participantes	= $request->only('User_has_Celulas_idUser_has_Celulas');
    		
    		//--------------------------------------------------------------
    		if (empty($participantes['User_has_Celulas_idUser_has_Celulas'])) {
    			flash('Selecione ao menos 1 participante para a Restaurar!', 'danger');
    			return redirect()->back();
    		}
    		//--------------------------------------------------------------
    		
    		foreach ($participantes as $idRelacionamento) {
    			$UC->select('*')
    			->where('id', $idRelacionamento)
    			->onlyTrashed()->first()
    			->update(['deleted_at'=> null]);
    		}
    		
    		flash('Participantes Restaurados com Sucesso!', 'success');
    		flash('Participantes Restaurados devem estar Presentes no próximo Lançamento de Frequência!', 'warning');
    		return redirect()->route('celula.gerenciar', $idCelula);
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
}
