<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Regiao;
use App\Http\Requests\Site\RegiaoFormRequest;

class RegiaoController extends Controller
{
	private $Regiao;
	private $TotalPagina=10;
	
	public function __construct(Regiao $regiao) {
		$this->middleware('auth');
		$this->Regiao = $regiao;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$title		= "Regiões Administrativas";
    	
    	$regioes 	= $this->Regiao
					    	->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
					    	->paginate($this->TotalPagina);
    	
        return view('site.regiao.index', compact('title', 'regioes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$title		= "Cadastrar Região";
    	return view('site.regiao.cadastrar-editar', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegiaoFormRequest $request)
    {
    	try {
    		//Pega Todos os dados do formul�rio
    		$dataForm = $request->except('_token');
    		
    		//Faz o cadastro
    		$dataForm['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
    		$insert = $this->Regiao->create($dataForm);
    		
    		flash('Região Cadastrada com sucesso!', 'success');
    		return redirect()->route('regiao.index');
    		
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
    	return 'ERROR: INVALID METHOD';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//Recupera Artigo pelo Seu ID
    	$regiao = $this->Regiao->find($id);
    	
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $regiao->Igrejas_idIgrejas);
    	
    	$title		= "Editar Região";
    	return view('site.regiao.cadastrar-editar', compact('title', 'regiao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegiaoFormRequest $request, $id)
    {
    	try {
    	
    		//Recupera Todos os dados do formulário
    		$dataForm = $request->except(['_token', '_method']);
    	
    		//Recupera Artigo para Editar
    		$regiao = $this->Regiao->find($id);
    		
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $regiao->Igrejas_idIgrejas);
    	
    		//Altera o Artigo
    		$regiao->update($dataForm);
    	
    		flash('Região Alterada com sucesso', 'success');
    		return redirect()->route('regiao.index');
    		
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
    	try {
    		//Recupera Artigo Pelo ID
    		$regiao = $this->Regiao->find($id);
    		
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $regiao->Igrejas_idIgrejas);
    		
    		//Deleta o Artigo
    		$regiao->delete();
    		
    		return redirect()->route('regiao.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		
    		if ($e->getCode()=='23000') {
    			flash('Existem Dados Vinculados ao Item que deseja Deletar no Sistema', 'danger');
    		} else {
    			flash($e->getMessage(), 'danger');
    		}
    		
    		return redirect()->back();
    	}
    	
    }
}
