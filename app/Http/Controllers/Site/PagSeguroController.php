<?php
namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Models\Site\User_has_evento;
use App\Models\Site\Pagamento;
use App\Models\Site\Prazo;

class PagSeguroController extends Controller
{
	private $Payment;
	private $sessionCode;
	private $checkoutCode;
	
	/**
	 * Método Gera Conexão com o PagSeguro
	 * @param string $email
	 * @param string $token
	 */
	public function criaSessao($email, $token, $authCode=null, $ambiente='sandbox') 
	{
		try {
			\PagSeguro\Library::initialize();
			\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
			\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
			
			\PagSeguro\Configuration\Configure::setEnvironment($ambiente);
			\PagSeguro\Configuration\Configure::setAccountCredentials($email, $token);
			
			$this->sessionCode = 
					\PagSeguro\Services\Session::create(
						\PagSeguro\Configuration\Configure::getAccountCredentials()
					); 
			
		} catch (Exception $e) {
			die($e);
		}
	}
	
	/**
	 * Método Cria Requisição LightBox para o PagSeguro
	 * @param integer $idInscricao
	 * @return array( codigoTransacao, valorTransacao)
	 */
	public function RequestLightBox($idInscricao) 
	{
		$UE							= new User_has_evento();
		$dadosVenda					= $UE->find($idInscricao);
		
		$VU	= $dadosVenda->user()->first();
		$VE	= $dadosVenda->evento()->first();
		$VP	= $dadosVenda->pagamento()->first();
		
		$valorEvento				= $this->recuperaValorInscricao($VE->id, $dadosVenda->created_at);
		
		$retorno['valorTransacao']	= $valorEvento;
		
		//Valida se já não existe pagamento criado
		if ( empty($VP) ) {
			
			$this->criaSessao($VE->Email_PagSeguro, $VE->Token_PagSeguro);
			
			$this->Payment	= new \PagSeguro\Domains\Requests\Payment();
			
			$this->Payment->setCurrency("BRL");
			$this->Payment->setReference($idInscricao);
			
			// Seta informacoes do seu cliente.
			$this->Payment->setSender()->setName($VU->first_name.' '.$VU->last_name);
			$this->Payment->setSender()->setEmail($VU->email);
			//'c87074500108915543147@sandbox.pagseguro.com.br'
			//Senha: 		M7553DR8uwX60L05    45138294784
			$this->Payment->setSender()->setDocument()->withParameters('CPF', $VU->CPF);
			
			//Retira A Mascara de Celular para Enviar ao PagSeguro
			if ( !empty($VU->mobile) ) {
				$ddd = substr($VU->mobile, 1, 2);
				$cel = substr($VU->mobile, 5, 1);
				$cel = $cel.substr($VU->mobile, 7, 4);
				$cel = $cel.substr($VU->mobile, 12, 4);
				$this->Payment->setSender()->setPhone()->withParameters( $ddd, $cel);
			}
			
			//Add items
			$this->Payment->addItems()->withParameters( $idInscricao,  $VE->Nome, 1, $valorEvento );
			
			$this->Payment->setRedirectUrl(url('/home'));
			$this->Payment->setNotificationUrl(
					url('/pagSeguroListener/').
					\PagSeguro\Configuration\Configure::getAccountCredentials()->getEmail().'/'.
					\PagSeguro\Configuration\Configure::getAccountCredentials()->getToken()
					);
			
			$resultPagamento = $this->Payment->register(
					\PagSeguro\Configuration\Configure::getAccountCredentials(),
					true );
			
			$retorno['checkoutCode']	= $resultPagamento->getCode();
			
		}else {
			//Caso já possua venda Aberta
			$retorno['checkoutCode']	= null;
		}
		
		return $retorno;
	}
	
	/**
	 * Método recupera Valor da Inscricao no Banco de Dados 
	 * @param integer $idInscricao
	 * @return double
	 */
	private function recuperaValorInscricao($idEvento, $dataInscricao)
	{
		try {
			$prazo			= new Prazo();
			$valor	= $prazo
					->where('prazos.Prazo_Data', '<=', $dataInscricao)
					->where('Eventos_idEventos', $idEvento)
					->orderBy('prazos.Prazo_Data', 'desc')
					->first();
					
			return $valor->Prazo_Valor;
					
		} catch (\Illuminate\Database\QueryException $e) {
			flash($e->getMessage(), 'danger');
			return redirect()->back();
		}
	}
	
	/**
	 * Método recupera Inscricao no Banco de Dados pelo código do pagamento
	 * @param integer $codigo
	 * @return unknown|\Illuminate\Http\RedirectResponse
	 */
	private function recuperaInscricaoByCode($code)
	{
		try {
			$pagamento		= new Pagamento();
			$dadosPG		= $pagamento->where('Codigo', $code)->first();
			
			return $dadosPG->inscricao()->first();
					
		} catch (\Illuminate\Database\QueryException $e) {
			flash($e->getMessage(), 'danger');
			return redirect()->back();
		}
	}
	
	public function transactionListener(Pagamento $pagamento, $email, $token) {
		
		try {
			
			$this->criaSessao($email, $token);
			
			if (\PagSeguro\Helpers\Xhr::hasPost()) {
				$response = \PagSeguro\Services\Transactions\Notification::check(
						\PagSeguro\Configuration\Configure::getAccountCredentials()
						);
			} else {
				throw new \InvalidArgumentException($_POST);
			}
			
			$dataUpdate	= [
					'Valor_Bruto'							=> $response->getGrossAmount(),
					'Valor_Liquido'							=> $response->getNetAmount(),
					'Tipos_Pagamentos_idTipos_Pagamentos'	=> $response->getPaymentMethod()->getType(),
					'Status_Pagamentos_idStatus_Pagamentos'	=> $response->getStatus(),
					'Codigo'								=> $response->getCode()
			];
			
			$update		= $pagamento->where('Users_has_Eventos_idUsers_has_Eventos', $response->getReference())
									->first();
			
			$update->updateOrCreate(['Users_has_Eventos_idUsers_has_Eventos'=>$response->getReference()], $dataUpdate);
			/*$myfile = fopen("notificacao.txt", "w") or die("Unable to open file!");
			$txt = var_export($response->getLastEventDate(), true);
			$txt = var_export($response, true);
			fwrite($myfile, $txt);
			fclose($myfile);
			*/
			
		} catch (Exception $e) {
			die($e->getMessage());
		}
		
	}
	
	public function searchTransaction(Pagamento $pagamento, $code)
	{
		
		$inscricao			= $this->recuperaInscricaoByCode($code);
		
		$this->criaSessao($inscricao->evento()->first()->Email_PagSeguro, $inscricao->evento()->first()->Token_PagSeguro);
		
		try {
			$response = \PagSeguro\Services\Transactions\Search\Code::search(
					\PagSeguro\Configuration\Configure::getAccountCredentials(),
					$code
					);
			
			$dataUpdate	= [
					'Valor_Bruto'							=> $response->getGrossAmount(),
					'Valor_Liquido'							=> $response->getNetAmount(),
					'Tipos_Pagamentos_idTipos_Pagamentos'	=> $response->getPaymentMethod()->getType(),
					'Status_Pagamentos_idStatus_Pagamentos'	=> $response->getStatus(),
					'Codigo'								=> $response->getCode()
			];
			
			$update		= $pagamento->where('Users_has_Eventos_idUsers_has_Eventos', $response->getReference())
									->first();
			
			$update->update($dataUpdate);
			
			flash('Dados da Transação Consultados com Sucesso!', 'success');
			return redirect()->back();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	
}