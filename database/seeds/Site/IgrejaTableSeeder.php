<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Igreja;
use App\Models\Site\EstadoCivil;
use App\Models\Site\Uf;
use App\Models\Site\TipoMembro;
use App\Models\Site\TipoEntrada;
use App\Models\Site\TiposPagamento;
use App\Models\Site\StatusPagamento;

class IgrejaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Igreja::create(['nome'				=> 'Igreja Metodista Paranoá']);
    	//Igreja::create(['nome'				=> 'Igreja Metodista Sobradinho']);
    	
    	EstadoCivil::create(['description'	=> ' ']);
    	EstadoCivil::create(['description'	=> 'Solteiro(a)']);
    	EstadoCivil::create(['description'	=> 'Casado(a)']);
    	EstadoCivil::create(['description'	=> 'Viúvo(a)']);
    	EstadoCivil::create(['description'	=> 'Divorciado(a)']);
    	EstadoCivil::create(['description'	=> 'União Estável']);
    	EstadoCivil::create(['description'	=> 'Outros']);
    	
    	UF::create(['Nome'					=> ' '	,'Regiao_Administrativa'	=> ' ']);
    	UF::create(['Nome'					=> 'DF'	,'Regiao_Administrativa'	=> 'Centro Oeste']);
    	UF::create(['Nome'					=> 'GO'	,'Regiao_Administrativa'	=> 'Centro Oeste']);
    	
    	TipoMembro::create(['description'	=> 'Membro do Rol']);
    	TipoMembro::create(['description'	=> 'Membro Desagregado']);
    	TipoMembro::create(['description'	=> 'Criança']);
    	
    	TipoEntrada::create(['description'	=> 'Batismo']);
    	TipoEntrada::create(['description'	=> 'Transferência']);
    	
    	TiposPagamento::create(['id'		=> 1	,'description'				=> 'Pag Seguro - Cartão de crédito']);
    	TiposPagamento::create(['id'		=> 2	,'description'				=> 'Pag Seguro - Boleto']);
    	TiposPagamento::create(['id'		=> 3	,'description'				=> 'Pag Seguro - Débito Online (TEF)']);
    	TiposPagamento::create(['id'		=> 4	,'description'				=> 'Pag Seguro - Saldo PagSeguro']);
    	TiposPagamento::create(['id'		=> 5	,'description'				=> 'Pag Seguro - Oi Paggo']);
    	TiposPagamento::create(['id'		=> 7	,'description'				=> 'Pag Seguro - Depósito em Conta']);
    	TiposPagamento::create(['id'		=> 8	,'description'				=> 'Depósito na Conta do Evento']);
    	TiposPagamento::create(['id'		=> 9	,'description'				=> 'TED/DOC na Conta do Evento']);
    	TiposPagamento::create(['id'		=> 10	,'description'				=> 'Dinheiro']);
    	TiposPagamento::create(['id'		=> 11	,'description'				=> 'PagSeguro']);
    	
    	StatusPagamento::create(['id'		=> 1	,'name'						=>'Aguardando pagamento',
    			'description'	=> 'O comprador iniciou a transação, mas até o momento o Sistema não recebeu nenhuma informação sobre o pagamento.']);
    	StatusPagamento::create(['id'		=> 2	,'name'						=>'Em Análise',
    			'description'	=> 'O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.']);
    	StatusPagamento::create(['id'		=> 3	,'name'						=>'Paga',
    			'description'	=> 'A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.']);
    	StatusPagamento::create(['id'		=> 4	,'name'						=>'Disponível',
    			'description'	=> 'A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.']);
    	StatusPagamento::create(['id'		=> 5	,'name'						=>'Em Disputa',
    			'description'	=> 'O comprador, dentro do prazo de liberação da transação, abriu uma disputa.']);
    	StatusPagamento::create(['id'		=> 6	,'name'						=>'Devolvida',
    			'description'	=> 'O valor da transação foi devolvido para o comprador.']);
    	StatusPagamento::create(['id'		=> 7	,'name'						=>'Cancelada',
    			'description'	=> 'A transação foi cancelada sem ter sido finalizada.']);
    }
}
