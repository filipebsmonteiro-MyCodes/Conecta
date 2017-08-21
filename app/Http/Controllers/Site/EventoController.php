<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Evento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Site\Prazo;
use App\Models\Site\EstadoCivil;
use App\Http\Requests\Site\EventoFormRequest;
use App\Models\Site\Restricao;
use App\Models\Site\PresencaEvento;
use App\Models\Site\TiposPagamento;
use App\Models\Site\Eventos_has_TiposPagamento;
use App\Models\Site\User_has_evento;
use App\Models\Site\Pagamento;
use App\Models\Site\Igreja;
use App\Models\Site\Perfil;
use Illuminate\Contracts\Auth\Access\Gate;

class EventoController extends Controller
{
	private $Evento;
	private $TotalPagina = 10;
	private $Payment;
	
	public function __construct(Evento $evento){
		$this->middleware('auth')->except(['index', 'show']);
		$this->Evento = $evento;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Igreja $igreja)
    {
    	
    	if(auth()->check()){
    		$idIgr			= auth()->user()->Igrejas_idIgrejas;
    	}else {
    		$idIgr			= 1;//$request->only('idIgr');
    	}
    	
    	$title				= 'Inscrições de Eventos';
    	$igrejas			= $igreja->all();
    	$eventosAtuais		= $this->Evento->select('id', 'Nome', 'Inicio', 'Final', 'Local')
    	->where('Igrejas_idIgrejas', $idIgr)
								    	->whereDate('Inicio', '<=', Carbon::now()->format('Y-m-d'))
								    	->whereDate('Final', '>=', Carbon::now()->format('Y-m-d'))
								    	->get();

    	$eventosFuturos		= $this->Evento->select(DB::raw('eventos.id, Nome, Inicio, Final, Local, MIN(prazos.Prazo_Data) as Abertura'))
								    	->join('prazos', 'prazos.Eventos_idEventos', '=', 'eventos.id')
								    	->where('Igrejas_idIgrejas', $idIgr)
								    	->whereDate('Inicio', '>', Carbon::now()->format('Y-m-d'))
								    	->get();
								    	
		$eventosPassados	= $this->Evento->select('id', 'Nome', 'Inicio', 'Final', 'Local')
										->where('Igrejas_idIgrejas', $idIgr)
								    	->whereDate('Final', '<', Carbon::now()->format('Y-m-d'))
								    	->limit(5)
								    	->get();
		
    	return view('site.evento.index', compact('title', 'eventosAtuais', 'eventosFuturos', 'eventosPassados', 'igrejas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EstadoCivil $estCivils, TiposPagamento $tpPagamento, Perfil $perfil, Gate $gate )
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_create');
    	
        $title			= 'Cadastrar Evento';
        $estadoCivils	= $estCivils->all();
        $tiposPagamento	= $tpPagamento->where('id','>', 7)->get();
        return view('site.evento.cadastrar-editar', compact('title', 'estadoCivils', 'tiposPagamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventoFormRequest $request, Prazo $prazos, Restricao $restricoes, Eventos_has_TiposPagamento $EveTiPgto)
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_create');
    	
    	try {
    		//Pega Todos os dados do formulario
    		$dataEvento		= $request->except('_token', 'Restricoes', 'Prazos');
    		$dataRestricoes	= $request->only('Restricoes');
    		$dataPrazos		= $request->only('Prazos');
    		$pagamentos		= $request->only('PagamentosAceitos')['PagamentosAceitos'];
    		
    		//Faz o cadastro
    		$dataEvento['Igrejas_idIgrejas']		= auth()->user()->Igrejas_idIgrejas;
    		$insertEvento	= $this->Evento->create($dataEvento);
    		
    		$dataRestricoes['Restricoes']['Eventos_idEventos']	= $insertEvento->id;
    		$restricoes->create($dataRestricoes['Restricoes']);
    		
    		for ($i = 0; $i < sizeof($dataPrazos['Prazos']); $i++) {
    			$dataPrazos['Prazos'][$i]['Eventos_idEventos'] = $insertEvento->id;
    			$prazos->create($dataPrazos['Prazos'][$i]);
    		}
    		
    		if (!empty($pagamentos)) {
    			foreach ($pagamentos as $idTipoPgto) {
    				$EveTiPgto->create([
    						'Eventos_idEventos'		=> $insertEvento->id,
    						'idTipos_Pagamentos'	=> $idTipoPgto
    				]);
    			}
    		}
    		
    		flash('Evento Cadastrado com sucesso!', 'success');
    		return redirect()->route('evento.index');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    	
    }

    /**
     * Display the specified Evento to Subscribe if is Possible.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Prazo $prazo, Restricao $restricao, $id)
    {
    	$title		= 'Inscrever';
    	$evento		= $this->Evento->find($id);
    	$prazos		= $prazo->select('*')->where('Eventos_idEventos', $id)->get();
    	$restricoes	= $restricao->select('*', 'Estado_Civils.description')
    	->join('Estado_Civils', 'Estado_Civils.id', '=', 'EstadoCivils_idEstadoCivils')
    	->where('Eventos_idEventos', $id)->first();
    	//dd($evento);
    	return view('site.evento.show', compact('title', 'evento', 'prazos', 'restricoes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Prazo $prazo, Restricao $restricao, EstadoCivil $estCivils, TiposPagamento $tpPagamento, 
    					Eventos_has_TiposPagamento $EveTiPgto, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_update');
    	
    	$title				= 'Editar Evento';
    	$evento				= $this->Evento->find($id);
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $evento->Igrejas_idIgrejas);
    	
    	$prazos				= $prazo->select('*')->where('Eventos_idEventos', $id)->orderBy('Prazo_Data')->get();
    	$restricoes			= $restricao->select('*')->where('Eventos_idEventos', $id)->first();
    	$evento['PagamentosAceitos'] = $EveTiPgto->select('idTipos_Pagamentos')
    											->where('Eventos_idEventos', $id)
    											->orderBy('Eventos_idEventos')
    											->get();
    	
    	$estadoCivils	= $estCivils->all();
    	$tiposPagamento	= $tpPagamento->where('id','>', 7)->get();
    	return view('site.evento.cadastrar-editar', compact('title', 'evento', 'prazos', 'restricoes', 'estadoCivils', 'tiposPagamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventoFormRequest $request, Prazo $prazos, Restricao $restricoes, Eventos_has_TiposPagamento $EveTiPgto, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_update');
    	
    	try {
    		
    		//Pega Todos os dados do formulario
    		$dataEvento		= $request->except('_token', 'Restricoes', 'Prazos');
    		$dataRestricoes	= $request->only('Restricoes');
    		$dataPrazos		= $request->only('Prazos');
    		$pagamentos		= $request->only('PagamentosAceitos')['PagamentosAceitos'];
    		
    		//Faz o cadastro
    		$evento = $this->Evento->find($id);
    		//Valida Multi-Empresa
    		$this->authorize('mesma-igreja', $evento->Igrejas_idIgrejas);
    		
    		$evento->update($dataEvento);
    		
    		$dataRestricoes['Restricoes']['Eventos_idEventos']	= $id;
    		$restricoes->select('*')->where('Eventos_idEventos', $id)->first()->update($dataRestricoes['Restricoes']);
    		
    		//Recupera os Objetos de prazos Ordenados pela data assim como foram passados pra view, e serão recebidos
    		$BDPrazos		= $prazos->select('*')->where('Eventos_idEventos', $id)->orderBy('Prazo_Data')->get();
    		for ($i = 0; $i < sizeof($BDPrazos); $i++) {
    			$dataPrazos['Prazos'][$i]['Eventos_idEventos'] = $id;
    			$BDPrazos[$i]->update($dataPrazos['Prazos'][$i]);
    		}
    		
    		foreach ($pagamentos as $idTipoPgto) {
    			$EveTiPgto->updateOrCreate([
    					'Eventos_idEventos'		=> $id,
    					'idTipos_Pagamentos'	=> $idTipoPgto
    			]);
    		}
    		
    		flash('Evento Alterado com sucesso!', 'success');
    		return redirect()->route('evento.index');
    		
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
    	$this->authorize('evento_delete');
    	
    	$evento = $this->Evento->find($id);
    	//Valida Multi-Empresa
    	$this->authorize('mesma-igreja', $evento->Igrejas_idIgrejas);
    	
    	$evento->delete();
    	flash('Evento Deletado com sucesso!', 'success');
    	return redirect()->route('evento.index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_list');
    	
    	$title			= 'Inscrições de Eventos';
    	$eventos		= $this->Evento->select('id', 'Nome', 'Inicio', 'Quantidade_Vagas')
    									->where('Igrejas_idIgrejas', auth()->user()->Igrejas_idIgrejas)
								    	->whereDate('Final', '>=', Carbon::now()->format('Y-m-d'))
								    	->paginate($this->TotalPagina);
    	
    	return view('site.evento.listar', compact('title', 'eventos'));
    }
    
    /**
     * Método inscreve usuário no evento
     * Se for Pago Carrega página de Pagamento(ConfirmarInscrição)
     * 
     * @param Request $request
     * @return string|\Illuminate\Http\RedirectResponse
     */
    public function inscrever(Request $request, $idEvento, User_has_evento $UE, Pagamento $pagamento) {
    	try {
    		$title				= 'Confirmar Inscrição';
    		//Pega Todos os dados do formulário
    		$dataForm 						= $request->except('_token');
    		$dataForm['Eventos_idEventos']	= $idEvento;
    		$dataForm['Users_idUsers']		= auth()->user()->id;
    		
    		//Faz o cadastro
    		$inscricao 			= $UE->updateOrCreate($dataForm);
    		
    		//Verifica se Evento é pago
    		$pagamentosAceitos	= $this->Evento->find($idEvento)->tipos_pagamentos()->get();
	    	flash('Inscrição Registrada com sucesso!', 'success');
	    	
    		if ($pagamentosAceitos) {
    			
    			$evento			= $this->Evento->find($idEvento);
    			//Consulta Dados de pagamentos já existentes
    			$dataPgto		= $inscricao->pagamento()->first();
    			if($dataPgto) $status	= $dataPgto->status()->first();
    			
    			return view('site.evento.confirmarInscricao', compact('title', 'evento', 'pagamentosAceitos', 'dataPgto', 'status'));
    			
    		}else {
    			return redirect()->route('evento.show', $idEvento);
    		}
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
    public function pagamento(Request $request, Pagamento $pagamento, User_has_evento $UE, $idEvento) {
    	try {
    		$title				= 'Confirmar Pagamento';
    		$dataForm			= $request->except('_token');
    		
    		$inscricao			= $UE->where('Users_idUsers', auth()->user()->id)
						    		->where('Eventos_idEventos', $idEvento)
						    		->first();
    		
    		if (isset($dataForm['Tipos_Pagamentos_idTipos_Pagamentos']) && $dataForm['Tipos_Pagamentos_idTipos_Pagamentos'] == 11) {
    			
    			$pagSeguro		= new PagSeguroController();
    			$dataLightBox	= $pagSeguro->RequestLightBox($inscricao->id);
    			
    			$dataForm['Valor_Bruto']	= $dataLightBox['valorTransacao'];
    			$codeLightBox				= $dataLightBox['checkoutCode'];
			}
			
			$aux = $pagamento->updateOrCreate(['Users_has_Eventos_idUsers_has_Eventos'=>$inscricao->id], $dataForm);
			
    		//Consulta Dados de pagamentos
			$evento				= $inscricao->evento()->first();
			$pagamentosAceitos	= $evento->tipos_pagamentos()->get();
    		$dataPgto			= $inscricao->pagamento()->first();
    		if($dataPgto) $status	= $dataPgto->status()->first();
    		
			flash('Pagamento Registrado com Sucesso!', 'success');
    		return view('site.evento.confirmarInscricao', compact('title', 'evento', 'pagamentosAceitos', 'dataPgto', 'status', 'codeLightBox'));
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    	
    }
    
    /**
     * Store or update a newly PresencaEvento resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function presenca(PresencaEvento $presenca, Request $request, $id)
    {
    	//valida se User tem Autorização
    	$this->authorize('evento_presenca');
    	
    	try {
    		$title		= 'Presença do Evento';
    		//Pega Todos os dados do formulário
    		
    		
    		//Faz o cadastro
    		
    		
    		//flash('Presença Registrada com sucesso!', 'success');
    		return view('site.evento.presenca', compact('title'));
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		flash($e->getMessage(), 'danger');
    		return redirect()->back();
    	}
    }
    
}
