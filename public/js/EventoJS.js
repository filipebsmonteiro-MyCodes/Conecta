/**
 * Implementa Lógicas e Esconde Div's NO Cadastrar-Editar.blade.php Eventos
 */
//Função Recarrega a Página Selecionando Tipo de Evento e Carregando Descrição
function loadDescricao(id) {
	  if (confirm('Deseja Carregar Especificações desse Tipo de Evento na Descrição?')) {
	    window.location.href='?controller=evento&action=cadastrar&descTipoEvento='+id;
	  }
	  return false;
}

function deleteStep(stepNo)
{
	if(stepNo == '33')
		text = "Inscrições"

	if(stepNo == '44')
		text = "Restições"

	if(stepNo == '55')
		text = "Pagamentos"
  
	if ( confirm('Deseja Remover '+text+' desse Evento?') ){
	  //Remove o checkBox
	  $('#check-'+stepNo).remove();
	  //Remove o indice Lateral
	  $('#'+stepNo).remove();
	  //Altera o Conteúdo da DIV
	  $('#step-'+stepNo).empty();
	  $('#step-'+stepNo).append( "<h2>Clique em Próximo ou Cadastrar Evento!</h2>" );
      //return true;
  }
}

//Função "Mostra e Esconde" Div 
document.addEventListener("DOMContentLoaded", function (event) {

	  //3 Listener de acordo com o Tipo de Pagamento aceito no Evento
	  var _selectorDepConta = document.querySelector('#tipoPgto8');
	  var _selectorTrfConta = document.querySelector('#tipoPgto9');
	  var dadosBanco		= document.getElementById('dadosBancarios');
	  _selectorDepConta.addEventListener('change', function (event) {

	    if (_selectorDepConta.checked || _selectorTrfConta.checked) {
	    	dadosBanco.style.display = 'block';
	    } else {
	    	dadosBanco.style.display = 'none';
	    }
	  });
	  _selectorTrfConta.addEventListener('change', function (event) {

	    if (_selectorDepConta.checked || _selectorTrfConta.checked) {
	    	dadosBanco.style.display = 'block';
	    } else {
	    	dadosBanco.style.display = 'none';
	    }
	  });

	  var _selectorPag = document.querySelector('#tipoPgto11');
	  _selectorPag.addEventListener('change', function (event) {

		var dadosPagSeguro		= document.getElementById('dadosPagSeguro');
	    if (_selectorPag.checked) {
	    	dadosPagSeguro.style.display = 'block';
	    } else {
	    	dadosPagSeguro.style.display = 'none';
	    }
	  });
    
});
