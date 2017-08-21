<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Convidado;
use App\Models\Site\Regiao;
use App\Http\Requests\Site\ConvidadoFormRequest;
use App\Models\Site\Visita;
use Carbon\Carbon;
use App\Models\Site\User;

class ConvidadoController extends Controller
{
	private $Convidado;
	private $TotalPagina=10;
	
	public function get_Convidado(){
		return $this->Convidado;
	}
	
	public function __construct(Convidado $convidado) {
		$this->middleware('auth');
		$this->Convidado = $convidado;
	}
    
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_list');
    	
    	$title = 'Lista de Convidados';
    	$convidados = $this->Convidado
					    	->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
					        ->paginate($this->TotalPagina);
        return view('site.convidado.index', compact('title', 'convidados'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Regiao $regiao)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_create');
    	
        $title			= 'Cadastrar Convidado';
        $destinyForm	= 'convidado.store';
        
        $regioes = $regiao->all();
        
        return view('site.convidado.cadastrar-editar', compact('title', 'regioes', 'destinyForm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Convidado $convidado, ConvidadoFormRequest $request)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_create');
    	
    	try {
    		$title		= "Cadastrar Convidado";
    		
    		//Pega Todos os dados do formulario
    		$dataForm = $request->except(['_token', 'var_Auxiliar']);
    		
    		$convidados	= $convidado->where('created_at', '>=', Carbon::today())
    								->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
    								->where('nome', $dataForm['nome'])->count();
			if ($convidados > 0) {
				flash('Convidado com mesmo nome já cadastrado hoje!', 'danger');
				return redirect()->back();
			}
    		
    		//Faz o cadastro
    		$dataForm['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
    		$this->Convidado->create($dataForm);
    		
    		flash('Convidado(a) Cadastrado(a) com sucesso!', 'success');
    		return redirect()->route('convidado.index');
    		
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
    public function show(Visita $visita, User $user, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_show');
    	
    	$title = 'Apresentar Convidados';
    	
    	$convidados = $visita->select('convidados.nome', 'visitas.created_at')
    							->join('convidados', 'visitas.Convidados_idConvidados', '=', 'convidados.id')
    							->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
    							->where('visitas.created_at', '>=', Carbon::today())
    							->get();
    	
		$aniversariantes = $user->select('first_name', 'birthday')
								->whereDay('birthday', '>=', date('d'))
								->whereDay('birthday', '<=', date('d', strtotime('date("d") +1 week')))
								->whereMonth('birthday', '=', date('m') )
								->get();

		return view('site.convidado.apresentar', compact('title', 'convidados', 'aniversariantes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Regiao $regiao, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_update');
    	
    	$title			= 'Alterar Convidado';
    	
    	$regioes		= $regiao->all();
    	
    	$convidado		= $this->Convidado->find($id);
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $convidado->Igrejas_idIgrejas);

    	return view('site.convidado.cadastrar-editar', compact('title', 'regioes', 'convidado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConvidadoFormRequest $request, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('convidado_update');
    	
    	try {
    		
    		//Recupera Todos os dados do formulário
    		$dataForm = $request->except(['_token', '_method', 'var_Auxiliar']);
    		
    		//Recupera Convidado para Editar
    		$convidado = $this->Convidado->find($id);
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $convidado->Igrejas_idIgrejas);
    		
    		//Altera o Convidado
    		$convidado->update($dataForm);
    		
    		flash('Convidado(a) Alterado(a) com sucesso!', 'success');
    		return redirect()->route('convidado.edit', $id);
    		
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
    	return 'ERROR: INVALID METHOD';
    }
    
    /**
     * Confirma Presença do Convidado
     *
     * @param  int  $idConvidado
     * @return \Illuminate\Http\Response
     */
    public function presenca(Visita $visita, $idConvidado) {
    	
    	//valida se User tem Autorização
    	$this->authorize('convidado_presenca');
    	
    	try {
    	
    		$visitou = $visita->where('created_at', '>=', Carbon::today())
	    						->where('Convidados_idConvidados', $idConvidado)->count();
	    						
    		if ($visitou > 0) {
	    		flash('Convidado já confirmou presença hoje!', 'info');
	    		return redirect()->back();
    		}else {
	    		$visita->create([
				    		'Convidados_idConvidados'	=> $idConvidado,
				    		'Observacoes'				=> ''
		    			]);
	    		flash('Presença Confirmada com Sucesso!', 'success');
	    		return redirect()->route('convidado.index');
    		}
    	} catch (Exception $e) {
    		flash($e->getMessage(), 'danger');
    	}
    	
    }
}
