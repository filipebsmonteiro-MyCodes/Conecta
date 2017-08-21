<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\User;
use App\Models\Site\EstadoCivil;
use App\Models\Site\Uf;
use App\Models\Site\TipoMembro;
use App\Models\Site\TipoEntrada;
use App\Http\Requests\Site\MembroFormRequest;
use App\Models\Site\Celula;
use App\Models\Site\Endereco;
use App\Models\Site\User_has_Celula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Session;
use App\Models\Site\Perfil;
use App\Models\Site\User_has_perfil;

class MembroController extends Controller
{
	private $Membro;
	private $TotalPagina=20;
	
	public function __construct (User $membro){
		$this->middleware('auth');
		$this->Membro = $membro;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//valida se User tem Autorização
    	$this->authorize('membro_list');
    	
        $title = 'Lista de Membros';
        $membros = $this->Membro->select('*')
        						->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
						        ->orderBy('first_name', 'asc')
						        ->Paginate($this->TotalPagina);
        return view('site.membro.index', compact('title', 'membros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EstadoCivil $est, Uf $uf, TipoMembro $tpMembro, TipoEntrada $tpEntrada, Celula $celula)
    {
    	//valida se User tem Autorização
    	$this->authorize('membro_create');
    	
    	$title = 'Cadastrar Membro';
    	
    	$estadoCivils	= $est		->all();
    	$UFs			= $uf		->all();
    	$tiposMembro	= $tpMembro	->all();
    	$tiposEntrada	= $tpEntrada->all();
    	$celulas		= $celula	->all();
    	$discipuladores = Session::get( 'users' );
    	
    	return view('site.membro.cadastrar-editar', compact('title', 'estadoCivils', 'UFs', 'tiposMembro', 'tiposEntrada', 'celulas', 'discipuladores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MembroFormRequest $request, Endereco $endereco, User_has_Celula $MembroCelula)
    {
    	//valida se User tem Autorização
    	$this->authorize('membro_create');
    	
    	try {
    		$title		= "Cadastrar Membro";
    		
    		//Pega Todos os dados do formulario
    		$dataMembro		= $request->except('_token', 'CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs', 'Celulas_idCelulas');
    		
    		$dataEndereco	= $request->only('CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
    		
    		$dataCelula		= $request->only('Celulas_idCelulas');
    		
    		//Faz o cadastro
    		$insertEndereco	= $endereco->create($dataEndereco);
    		
    		$dataMembro['Enderecos_idEnderecos']	= $insertEndereco->id;
    		$dataMembro['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
    		$insertMembro	= $this->Membro->create($dataMembro);
    		
    		$dataCelula['Users_idUsers'] = $insertMembro->id;
    		$MembroCelula->create($dataCelula);
    		
    		flash('Membro(a) Cadastrado(a) com sucesso!', 'success');
    		return redirect()->route('membro.index');
    		
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
    public function show($id)
    {
    	//valida se User tem Autorização
    	$this->authorize('membro_show');
    	
    	$title		= 'Visualizar Membro'; 
    	$membro		= $this->Membro->select(
    											'users.*', 'Estado_Civils.description as EstCivil',
								    			'Enderecos.CEP', 'Enderecos.Logradouro', 
								    			'Enderecos.Bairro', 'Enderecos.Cidade', 
								    			'UFs.nome as UF',
								    			'Tipo_Membros.description as tpMembro', 'Tipo_Entradas.description as tpEntrada', 
    											'Celulas.Nome as Celula' 
    										)
    			
    								->leftJoin('Estado_Civils',		'Estado_Civils.id',	'=',	'users.EstadoCivils_idEstadoCivils')
    								->leftJoin('Enderecos',			'Enderecos.id',		'=',	'users.Enderecos_idEnderecos')
    								->leftJoin('UFs',				'UFs.id',			'=',	'Enderecos.UFs_idUFs')
    								->join('Tipo_Membros',			'Tipo_Membros.id',	'=',	'users.TipoMembros_idTipoMembros')
    								->leftJoin('Tipo_Entradas',		'Tipo_Entradas.id',	'=',	'users.TipoEntradas_idTipoEntradas')
    								->leftJoin('User_has_celulas',	'Users_idUsers',	'=',	'users.id')
    								->leftJoin('Celulas',			'Celulas.id',		'=',	'User_has_celulas.Celulas_idCelulas')
    								->where('users.id', $id)->first();
    	//Valida Multi-Empresa
		$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    								
    	return view('site.membro.show', compact('title', 'membro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EstadoCivil $est, Uf $uf, TipoMembro $tpMembro, TipoEntrada $tpEntrada, Celula $celula, 
    					Endereco $endereco, User_has_celula $MembroCelula, $id)
    {
    	//valida se User tem Autorização
    	if ( $id != auth()->user()->id ) {
    		$this->authorize('membro_update');;
    	}
    	
    	$title = 'Editar Membro';
    	
    	$estadoCivils	= $est		->all();
    	$UFs			= $uf		->all();
    	$tiposMembro	= $tpMembro	->all();
    	$tiposEntrada	= $tpEntrada->all();
    	$celulas		= $celula	->all();
    	$membro			= $this->Membro	->find($id);
    	$dataEnd		= $endereco		->find($membro['Enderecos_idEnderecos']);
    	$dataMemCel		= $MembroCelula->where('Users_idUsers', $id)->first();
    	
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    	
    	$membro['discipulador'] = $this->Membro->select('users.id', 'users.first_name', 'users.last_name')
    									->where('users.id', $membro->Users_idDiscipulador)->first();
    	$discipuladores = Session::get( 'users' );
    	
    	return view('site.membro.cadastrar-editar', compact('title', 'estadoCivils', 'UFs', 'tiposMembro', 'tiposEntrada', 'celulas', 
    														'membro', 'dataEnd', 'dataMemCel', 'discipuladores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MembroFormRequest $request, Endereco $endereco, User_has_Celula $MembroCelula, $id)
    {
    	//valida se User tem Autorização
    	if ( $id != auth()->user()->id ) {
    		$this->authorize('membro_update');
    	}
    	
    	try {
    		
    		//Recupera o Membro
    		$membro = $this->Membro->find($id);
    		
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    		
    		//Pega Todos os dados do formulario
    		$dataMembro		= $request->except('_token', '_method', 'CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs', 'Celulas_idCelulas');
    		
    		$dataEndereco	= $request->only('CEP', 'Logradouro', 'Bairro', 'Cidade', 'UFs_idUFs');
    		
    		$dataCelula		= $request->only('Celulas_idCelulas');
    		$dataCelula['Users_idUsers'] = $id;
    		
    		//Atualiza o cadastro
    		$membro->update($dataMembro);
    		
    		$endereco->find($membro['Enderecos_idEnderecos'])->update($dataEndereco);
    		    		
    		$MembroCelula->where('Users_idUsers', $id)->updateorCreate($dataCelula);
    		
    		flash('Membro(a) Atualizado(a) com sucesso!', 'success');
    		return redirect()->back();
    		
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
    	$this->authorize('membro_delete');
    	
    	try {
    		$membro = $this->Membro->find($id);
    		
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    		
    		$membro->delete();
    		
    		flash('Membro(a) '.$membro->first_name.' Excluído(a) com Sucesso!', 'success');
    		return redirect()->route('membro.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
       
    /**
     * Display the specified resource.
     *
     * @param  string  $nome, $route
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
    	$nome		= $request->only('nome')['nome'];
    	$route		= $request->only('route')['route'];
    	$id			= $request->only('id')['id'];
    	
    	$users		= $this->Membro	->select('users.id','users.first_name','users.last_name', 'users.nickname')
    								->whereRaw('
										Igrejas_idIgrejas	= '.auth()->user()->Igrejas_idIgrejas.' AND
										(
											users.first_name	like  "%'.$nome.'%"	OR
											users.last_name		like  "%'.$nome.'%"	OR
											users.nickname		like  "%'.$nome.'%"
										)
									')
    								->get();
    	if(empty($id)){
    		return redirect()->route($route)->with('users', $users);
    	}else{
    		return redirect()->route($route, $id)->with('users', $users);
    	}
    }
    
    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     *
     * @return Response
     */
    public function alterarSenha(PasswordBroker $PB, $token=Null )
    {
    	//dd(auth()->user());
    	$title = 'Alterar Senha';
    	if (auth()->check() && is_null( $token)) {
    		
    		// user is logged in and has no token, in other words, he/she access this route by
    		// clicking a link pointing to "password/reset", so we generate a new token and save it
    		// to the password_resets table
    		$token = $PB->createToken( auth()->user() );
    	}
    	$email = auth()->user()->email;
    	Auth::logout();
    	return view( 'auth.passwords.reset' )->with('token', $token)->with('email', $email);
    }
        
    /**
     * Carrega Permissoes e User informado
     * @param integer $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function editPermissoes(\App\User $user, Perfil $perfil, $id) {
    	//valida se User tem Autorização
    	//$this->authorize('membro_update');
    	
    		
    	$title		= 'Alterar Permissoes';
    	$membro		= $user->find($id);
    	$perfis		= $perfil->all();
    	
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    	
    	return view('site.membro.permissoes', compact('title', 'membro', 'perfis'));
    }
    
    public function updatePermissoes(Request $request, Perfil $perfil, User_has_perfil $UP, \App\User $user) {
    	//valida se User tem Autorização
    	$this->authorize('membro_update');
    	
    	try{
    		$idUsuario		= $request->only('Users_idUsers')['Users_idUsers'];
    		$membro			= $user->find($idUsuario);
    		$idPerfis		= $request->only('Perfils_idPerfils')['Perfils_idPerfils'];
    		$newPerfis		= $perfil->whereIn('id', $idPerfis)->get();
    		$oldPerfis		= $membro->perfils()->get();
    		
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $membro->Igrejas_idIgrejas);
    		
    		//Valida O que Ganhou
    		if ( $newPerfis->diff($oldPerfis)->count() > 0 ) {
    			foreach ($newPerfis->diff($oldPerfis) as $perfil) {
    				
    				$UP->updateOrCreate([
    						'Users_idUsers'			=> $idUsuario,
    						'Perfils_idPerfils'		=> $perfil->id
    				]);
    			}
    		};
    		
    		//Valida O que Perdeu
    		if ( $oldPerfis->diff($newPerfis)->count() > 0 ) {
    			foreach ($oldPerfis->diff($newPerfis) as $perfil) {
    				
    				$UP->where('Users_idUsers', $idUsuario)
    					->where('Perfils_idPerfils', $perfil->id)
    					->delete();
    			}
    		};
    		
	    	flash('Permissões Editadas com sucesso!', 'success');
	    	return redirect()->route('membro.editPermissoes', $idUsuario);
	    	
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    	
    }

    public function ajax(Request $request) {
    	
    	$nome = $request->only('nome')['nome'];
    	
    	if ( $request->ajax() && strlen($nome)>=2 ) {
    		
			$membros    	=  $this->Membro
									->select('users.id','users.first_name','users.last_name'
											, 'users.mobile', 'users.phone')
						    		->whereRaw('
										Igrejas_idIgrejas	= '.auth()->user()->Igrejas_idIgrejas.' AND
										(
											users.first_name	like  "%'.$nome.'%"	OR
											users.last_name		like  "%'.$nome.'%"	OR
											users.nickname		like  "%'.$nome.'%"
										)
									')
									->orderBy('users.first_name')
									->get();
    		
    		$response = array(
    				'users'			=> $membros 
    		);
    		return response()->json($response, '200');
    	}/*else {
    		$response = array(
    				'status'		=> 'succes HTTP',
    				'msg'			=> 'Foi e HTTP com Sucesso!!!'
    		);
    		return $response;
    	}*/
    }
}
