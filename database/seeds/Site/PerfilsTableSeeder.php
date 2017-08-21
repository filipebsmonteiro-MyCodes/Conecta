<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Perfil;
use App\Models\Site\Permissao;

class PerfilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/**
    	 * Perfils
    	 */
    	Perfil::create([
    			'name'			=> 'recepcao',
    			'description'	=> 'Responsável pela recepção de Membros e/ou Convidados na Igreja'
    	]);//1
    	
    	Perfil::create([
    			'name'			=> 'eventos_gestor',
    			'description'	=> 'Responsável pela recepção de Membros e/ou Convidados na Igreja'
    	]);//2
    	
    	Perfil::create([
    			'name'			=> 'celula_super',
    			'description'	=> 'Supervisor de uma ou mais Rede(s)/Célula(s)'
    	]);//3
    	
    	Perfil::create([
    			'name'			=> 'celula_lider',
    			'description'	=> 'Lider de uma ou mais Célula(s)'
    	]);//4
    	
    	Perfil::create([
    			'name'			=> 'secretariado',
    			'description'	=> 'Função Relativa ao trabalho de Secretários(as)'
    	]);//5
    	
    	Perfil::create([
    			'name'			=> 'pastorado',
    			'description'	=> 'Função Relativa ao trabalho de Pastores(as)'
    	]);//6
    	
    	Perfil::create([
    			'name'			=> 'admin',
    			'description'	=> 'Administrador com acesso a todas as funções do sistema'
    	]);//7
    	
    	/**
    	 * Permissões
    	 */
    	//Convidado
	    	Permissao::create([
	    			'name'			=> 'convidado_create',
	    			'description'	=> 'Permissão de Criar Novos Convidados.'
	    	]);//1
	    	
	    	Permissao::create([
	    			'name'			=> 'convidado_update',
	    			'description'	=> 'Permissão de Editar Convidados.'
	    	]);//2
	    	
	    	Permissao::create([
	    			'name'			=> 'convidado_list',
	    			'description'	=> 'Permissão de Listar Convidados Cadastrados.'
	    	]);//3
	    	
	    	Permissao::create([
	    			'name'			=> 'convidado_show',
	    			'description'	=> 'Permissão de Apresentar Convidados/Aniversariantes.'
	    	]);//4
	    	
	    	Permissao::create([
	    			'name'			=> 'convidado_presenca',
	    			'description'	=> 'Permissão de Marcar Presença de Convidados.'
	    	]);//5
    	
    	//Evento
	    	Permissao::create([
	    			'name'			=> 'evento_create',
	    			'description'	=> 'Permissão de Criar Novos Eventos.'
	    	]);//6
	    	
	    	Permissao::create([
	    			'name'			=> 'evento_update',
	    			'description'	=> 'Permissão de Editar Eventos.'
	    	]);//7
	    	
	    	Permissao::create([
	    			'name'			=> 'evento_list',
	    			'description'	=> 'Permissão de Listar Eventos Cadastrados.'
	    	]);//8
	    	
	    	Permissao::create([
	    			'name'			=> 'evento_delete',
	    			'description'	=> 'Permissão de Deletar Eventos.'
	    	]);//9
	    	
	    	Permissao::create([
	    			'name'			=> 'evento_presenca',
	    			'description'	=> 'Permissão de Marcar Presença dos Usuários nos Eventos.'
	    	]);//10
	    	
    	//Membro
	    	Permissao::create([
	    			'name'			=> 'membro_create',
	    			'description'	=> 'Permissão de Criar Novos Membros.'
	    	]);//11
	    	
	    	Permissao::create([
	    			'name'			=> 'membro_update',
	    			'description'	=> 'Permissão de Editar Membros.'
	    	]);//12
	    	
	    	Permissao::create([
	    			'name'			=> 'membro_list',
	    			'description'	=> 'Permissão de Listar Membros Cadastrados.'
	    	]);//13
	    	
	    	Permissao::create([
	    			'name'			=> 'membro_delete',
	    			'description'	=> 'Permissão de Deletar Membros.'
	    	]);//14
	    	
	    	Permissao::create([
	    			'name'			=> 'membro_show',
	    			'description'	=> 'Permissão de Visualizar dados de Membros Cadastrados.'
	    	]);//15
	    	
    	//Rede
	    	Permissao::create([
	    			'name'			=> 'rede_create',
	    			'description'	=> 'Permissão de Criar Novas Redes.'
	    	]);//16
	    	
	    	Permissao::create([
	    			'name'			=> 'rede_update',
	    			'description'	=> 'Permissão de Editar Rede da qual seja Supervisor(a).'
	    	]);//17
	    	
	    	Permissao::create([
	    			'name'			=> 'rede_list',
	    			'description'	=> 'Permissão de Listar Redes Cadastradas.'
	    	]);//18
	    	
	    	Permissao::create([
	    			'name'			=> 'rede_show',
	    			'description'	=> 'Permissão de Visualizar dados de Redes Cadastradas.'
	    	]);//19
	    	
	    	Permissao::create([
	    			'name'			=> 'rede_delete',
	    			'description'	=> 'Permissão de Deletar Rede da qual seja Supervisor(a).'
	    	]);//20
	    	
    	//Celula
	    	Permissao::create([
	    			'name'			=> 'celula_create',
	    			'description'	=> 'Permissão de Criar Novas Células.'
	    	]);//21
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_update',
	    			'description'	=> 'Permissão de Editar Células da qual seja Líder.'
	    	]);//22
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_list',
	    			'description'	=> 'Permissão de Listar Células Cadastradas.'
	    	]);//23
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_show',
	    			'description'	=> 'Permissão de Visualizar dados de Células Cadastradas.'
	    	]);//24
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_delete',
	    			'description'	=> 'Permissão de Deletar Células da qual seja Líder.'
	    	]);//25
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_gerenciar',
	    			'description'	=> 'Permissão de Gerenciar (Presença, Multiplicar e Migrar) Células da qual seja Líder.'
	    	]);//26
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_lideranca',
	    			'description'	=> 'Permissão de Gerenciar Liderança e Liderança em Treinamento de Células.'
	    	]);//27
	    	
	    	Permissao::create([
	    			'name'			=> 'celula_reciclar',
	    			'description'	=> 'Permissão de Reciclar Participantes das Células da qual seja Líder.'
	    	]);//28
	    	
	    	Permissao::create([
	    			'name'			=> 'regiao_create',
	    			'description'	=> 'Permissão de Criar novas Regiões de atuação da Igreja.'
	    	]);//29
	    	
	    	Permissao::create([
	    			'name'			=> 'regiao_update',
	    			'description'	=> 'Permissão de Editar Regiões de atuação da Igreja.'
	    	]);//30
	    	
	    	Permissao::create([
	    			'name'			=> 'regiao_list',
	    			'description'	=> 'Permissão de Listar Regiões de atuação da Igreja.'
	    	]);//31
	    	
	    	Permissao::create([
	    			'name'			=> 'regiao_delete',
	    			'description'	=> 'Permissão de Excluir Regiões de atuação da Igreja.'
	    	]);//32
    }
}
