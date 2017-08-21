<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Rede;
use App\Http\Requests\Site\RedeFormRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class RedeController extends Controller
{
	private $Rede;
	private $TotalPagina;
	
	public function __construct(Rede $rede){
		$this->middleware('auth');
		$this->Rede = $rede;
	}
    
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//valida se User tem Autorização
    	$this->authorize('rede_list');
    	
        $title = 'Lista de Redes';
        $redes = $this->Rede->select('redes.*', 'users.first_name')
					        ->join('users',		'users.id',		'=',	'redes.Users_idSupervisor')
					        ->where('redes.Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
        					->get();
        return view('site.rede.index', compact('title', 'redes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	//valida se User tem Autorização
    	$this->authorize('rede_create');
    	
    	$users = Session::get( 'users' );
    	$title		= "Cadastrar Rede";
    	return view('site.rede.cadastrar-editar', compact('title', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RedeFormRequest $request)
    {
    	//valida se User tem Autorização
    	$this->authorize('rede_create');
    	
    	try {
    		//Pega Todos os dados do formul�rio
    		$dataForm = $request->except('_token');
    		
    		//Faz o cadastro
    		$dataForm['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
    		$this->Rede->create($dataForm);
    		
    		flash('Rede Cadastrada com sucesso!', 'success');
    		return redirect()->route('rede.index');
    		
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
    	if ( !$this->Rede->is_Super($id) ) {
    		flash('Acesso Negado a Rede!', 'danger');redirect()->back();
    	}
    	
    	$title		= 'Visualizar Rede';
    	//flash('Presença Registrada com sucesso!', 'success');
    	return view('site.evento.presenca', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//valida se User tem Autorização
    	$this->authorize('rede_update');
    	if ( !$this->Rede->is_Super($id) ) {
    		flash('Acesso Negado a Rede!', 'danger'); return redirect()->back();
    	}
    	
    	$title		= 'Editar Rede';
    	$users 		= Session::get( 'users' );
    	$rede		= $this->Rede->select('redes.*', 'users.first_name as Supervisor', 'users.last_name as SupervisorSN')
				    			->join('users', 'users.id','=', 'redes.Users_idSupervisor')
				    			->where('redes.id', $id)->first();
    	
    	return view('site.rede.cadastrar-editar', compact('title', 'rede', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RedeFormRequest $request, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('rede_update');
    	if ( !$this->Rede->is_Super($id) ) {
    		flash('Acesso Negado a Rede!', 'danger'); return redirect()->back();
    	}
    	
    	try{
    		//Recupera a Rede
    		$rede = $this->Rede->find($id);
    		
    		//Pega Todos os dados do formulario
    		$dataForm = $request->except('_token', '_method');
	    	
	    	//Atualiza o cadastro
	    	$update = $rede->update($dataForm);
	    	
	    	flash('Rede Atualizada com sucesso!', 'success');
	    	return redirect()->route('rede.index');
	    	
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
    	$this->authorize('rede_delete');
    	if ( !$this->Rede->is_Super($id) ) {
    		flash('Acesso Negado a Rede!', 'danger'); return redirect()->back();
    	}
    	
    	try{
    		//Recupera a Rede
    		$rede = $this->Rede->find($id)->delete();
    		
    		flash('Rede Deletada com sucesso!', 'success');
    		return redirect()->route('rede.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
}
