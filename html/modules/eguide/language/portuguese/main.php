<?php
// $Id: main.php,v 1.3 2010-10-10 06:30:12 nobu Exp $
// Módulo traduzido para o Português do Brasil (portuguese) por
// Leco (m_ohse@hotmail.com) URL: http://xoopersBR.com

if (defined('_MD_RESERV_FORM')) return;

define("_MD_RESERV_FORM","Agendamento aqui");
define("_MD_RESERVATION","Fazer um agendamento");
define("_MD_NAME","/^Name\\*?\$/");
define('_MD_SDATE_FMT', 'D, j M Y');
define('_MD_STIME_FMT', 'H:i');
// Localization Transrate Weekly date name
//global $ev_week;
//$ev_week = array('Sun'=>'S', 'Mon'=>'M','Tue'=>'T', 'Wed'=>'W','Thu'=>'U','Fri'=>'F', 'Sat'=>'A');
define("_MD_POSTED_FMT", "j M Y H:i");
define("_MD_TIME_FMT", "j M Y H:i");
define("_MD_READMORE","Mais...");
define("_MD_EMAIL","Endereço de email");
define('_MD_EMAIL_CONF','Verificar e-mail');
define('_MD_EMAIL_CONF_DESC','Digite seu endereço de e-mail novamente para confirmação');
define('_MD_UNAME','Nome de usuário');
define("_MD_SUBJECT","Confirmar - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_NOTIFY_EVENT",  "Notificação de novos eventos");
define("_MD_NOTIFY_REQUEST","Notifique-me, via email, quando novos eventos forem postados");
define('_MD_REQUIRE_MARK', '<em>*</em>');
define('_MD_LISTITEM_FMT', '[%s]');
define("_MD_ORDER_NOTE1","'"._MD_REQUIRE_MARK."'itens requeridos. ");
define("_MD_ORDER_NOTE2","'[ ]' item que será mostrado na lista de participantes.");
define('_MD_ORDER_SEND','Agendamento');
define('_MD_ORDER_CONF','Confirmar');

define("_MD_EVENT_NONE","Não existe evento agendando");
define("_MD_BACK","Voltar");
define("_MD_RESERVED","Existe apenas um agendamento");
define("_MD_RESERV_NUM","Número máximo de lugares %d");
define("_MD_RESERV_REG","Atualmente foram reservados lugares %d");
define("_PRINT", "Imprimir");

define("_MD_NOITEM_ERR","Nada informado. Por favor, informe um valor.");
define("_MD_NUMITEM_ERR","Precisa ser um valor numérico");
define("_MD_MAIL_ERR","Erro no formato do endereço de email");
define('_MD_MAIL_CONF_ERR','Confirmar endereço de email não coincidem');
define("_MD_SEND_ERR","Falha no envio de email");
define("_MD_DUP_ERR","Nós já agendamos um lugar com seu endereço de email");
define('_MD_DATE_ERR','A data está fora do período de abrangência');
define('_MD_DATEDELETE_ERR','Pare e remova a data pois existe um agendamento');
define("_MD_DUP_REGISTER","A notificação via email já foi registrada");
define("_MD_REGISTERED","A notificação via email foi registrada");

define("_MD_RESERV_ACCEPT","Enviada confirmação por email");
define("_MD_RESERV_STOP","Os agendamentos foram cancelados.");
define("_MD_RESERV_CONF","Ordenamento da informação");
define("_MD_RESERV_ADMIN","Lista de agendamentos");
define("_MD_RESERV_REGISTER","Agendamento registrado");

define("_MD_RESERV_ACTIVE"," foi aceito.");
define("_MD_RESERV_REFUSE"," foi recusado.");

define("_AM_MAILGOOD","Sucesso: %s");
define("_AM_SENDMAILNG","Falha: %s");

define("_MD_RESERV_NOTFOUND","Não existem agendamentos ou todos já foram cancelados.");
define("_MD_RESERV_CANCEL","Você tem certeza que deseja cancelar?");
define("_MD_RESERV_CANCELED","O agendamento do evento foi cancelado");
define("_MD_RESERV_NOCANCEL","O agendamento não pode ser cancelado após o finalização do tempo");
define("_MD_RESERV_NOTIFY","%s\n\nOrdenação do email: %s\nEvento agendando: %s\n  %s\n");
define("_MD_RESERV_FULL","Os agendamentos foram cancelados porque o evento agora está totalmente reservado.");
define('_MD_RESERV_TOMATCH',' %d is too match (%d esquerda)');
define('_MD_RESERV_CLOSE','Agendamento finalizado');
define('_MD_RESERV_NEEDLOGIN','Você precisa estar <a href="'.XOOPS_URL.'/user.php">logado</a>, quando desejar efetuar algum agendamento');
define('_MD_RESERV_PLUGIN_FAIL','Não existem condições para registrar o agendamento');
define("_MD_CANCEL_FAIL","Flaha no cancelamento");
define("_MD_NODATA","Não existem dados");
define("_MD_NOEVENT","Não existem eventos listados");
define("_MD_SHOW_PREV","Eventos anteriores");
define("_MD_SHOW_NEXT","Eventos futuros");

define("_MD_POSTERC","Quem postou");
define('_MD_POSTDATE','Registrado');
define('_MD_STARTTIME','Evento iniciado');
define('_MD_CLOSEDATE','Agendamento finalizado');
define('_MD_CLOSEBEFORE','Finalizar antes do tempo');
define('_MD_CLOSEBEFORE_DESC','Antes do início (Exemplo: 3 dias, 2 horas, 50 minutos)');
define('_MD_TIME_UNIT','dias,horas,minutos');
define('_MD_TIME_REG','d(ia)?s?,h(ora)?,minuto');
define('_MD_CALENDAR','Ir ao calendário');
define('_MD_CAL','Calendário');
define('_MD_CAL_MONDAY_FIRST', 'Verdadeiro');
define("_MD_REFER","%d acessos");
define("_MD_RESERV_LIST","Lista de participantes");

define('_MD_NEED_UPGRADE','É necessário para proceder a atualização do módulo');

//%%%%%%	File Name receiept.php 	%%%%%
define("_MD_RESERV_EDIT","Editar agendamentos");
define("_MD_OPERATION","Operação");
define("_MD_STATUS","Situação");
define("_MD_RESERV_RETURN","Retorna à lista");
define("_MD_RESERV_REC","Agendamentos gravados");
define("_MD_RVID","ID do agendamento");
define("_MD_ORDER_COUNT","Contagem");
define("_MD_PRINT_DATE","Data da impressão");
define("_MD_SAVECHANGE","Salvar mudanças");
define("_MD_RESERV_DEL","Excluir agendamento");
define("_MD_DETAIL","Detalhe");
define("_MD_RESERV_MSG_H","Enviar mensagem para o agendamento");
define("_MD_ACTIVATE","Aprovado");
define("_MD_REFUSE","Recusado");
define("_MD_EXPORT_OUT","Formato excel");
define('_MD_EXPORT_CHARSET', 'UTF-8');
define("_MD_INFO_MAIL","Enviado email");
define("_MD_SUMMARY","Sumário");
define("_MD_SUM_ITEM","Resumo do item");
define("_MD_SUM","Soma");

//%%%%%%	File Name admin.php 	%%%%%
define("_MD_EDITARTICLE","Editar o evento");
define("_MD_NEWTITLE","Novo evento");
define("_MD_NEWSUB","Novo evento - {EVENT_DATE} {EVENT_TITLE}");
define("_MD_TITLE","Título");
define("_MD_EVENT_DATE","Data do evento");
define("_MD_EVENT_EXPIRE","Mostrar finalização");
define('_MD_EVENT_EXTENT','Repetir abertura');
define('_MD_EVENT_CATEGORY','Categoria');
define('_MD_EDIT_EXTENT','Editar data aberta');
define('_MD_EXTENT_REPEAT','Repetições');
define('_MD_ADD_EXTENT','Adicionar data da abertura');
define('_MD_ADD_EXTENT_DESC','Data de abertura adicional no "YYYY-MM-DD HH:MM" formato (Registros múltiplos separados em nova linha)');
define("_MD_INTROTEXT","Texto introdutório");
define("_MD_EXTEXT","Descrição");
define("_MD_EVENT_STYLE","Estilo de saída");
define('_MD_RESERV_SETTING','Agendamento');
define("_MD_RESERV_DESC","Permitir continuação dos agendamentos");
define('_MD_RESERV_STOPFULL','Parar agendamentos quando o limite for alcançado');
define("_MD_RESERV_AUTO","Aceitar automaticamente agendamentos (Não é necessária a aprovação)");
define('_MD_RESERV_NOTIFYPOSTER','Agendamento notificado por email');
define('_MD_RESERV_UNIT','');
define('_MD_RESERV_ITEM','Itens adicionais');
define('_MD_RESERV_LAB','Nome do item');
define('_MD_RESERV_LABREQ','Por favor, informe o nome do item');
define('_MD_RESERV_REQ','Requerido');
define('_MD_RESERV_ADD','Adicionar');
define('_MD_RESERV_OPTREQ','Necessário opção argumento');
define('_MD_RESERV_ITEM_DESC','<a href="language/english/help.html#form" target="help">Sobre o formato dos itens adicionais</a>');
define('_MD_RESERV_LABEL_DESC','Utilize o nome do item "%s" caso múltiplos agendamnto pessoal.');
define('_MD_OPTION_VARS','Variáveis Opcionais');
define('_MD_OPTION_OTHERS','Outros');
define('_MD_RESERV_REDIRECT','URL de redirecionamento após o agendamento');
define('_MD_RESERV_REDIRECT_DESC','Configurar o número de segundos para aguardar (Exemplo: "4;http://..."). variáveis: {X_EID}, {X_SUB}, {X_RVID}');
define('_MD_APPROVE','Mostrar aprovação');
define('_MD_PREVIEW','Vizualização');
define('_MD_SAVE','Salvar');
define('_MD_UPDATE','Atualizar');
define('_MD_DBUPDATED','Banco de dados atualizado');
define('_MD_DBDELETED','Evento excluído');

define('_MD_EVENT_DEL_DESC','Excluir este evento');
define('_MD_EVENT_DEL_ADMIN','Excluir todos os dados, inlusive os agendamentos.');

define('_MD_TIMEC','Hora');
// Localization Transrate Month name
//global $ev_month;
//$ev_month = array(1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr",
//                  5=>"May", 6=>"Jun", 6=>"Jul", 8=>"Aug",
//                  9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");

define('_MD_RESERV_DEFAULT_ITEM',"Nome*,tamanho=40\nEndereço\n");
define('_MD_RESERV_DEFAULT_MEMBER',"");

// notification message
define('_MD_APPROVE_REQ','Por favor, confirme o evento aprove-o.');
//%%%%%%	File Name sendinfo.php 	%%%%%
define("_MD_INFO_TITLE","Enviar informação por email");
define("_MD_INFO_CONDITION","Enviar para");
define("_MD_INFO_NODATA","Não existem dados");
define("_MD_INFO_SELF","Auto enviar (%s)");
define("_MD_INFO_DEFAULT","-mensagens-\n\n\nEvento agendando\n    {EVENT_URL}\n");
define("_MD_INFO_MAILOK","Email enviado");
define("_MD_INFO_MAILNG","Falha no envio do email");
define("_MD_UPDATE_SUBJECT","Evento atualizado");
define("_MD_UPDATE_DEFAULT","Padrão");

//%%%%%%	File Name print.php 	%%%%%

define("_MD_URLFOREVENT","URL deste evento:");
// %s represents your site name
define("_MD_THISCOMESFROM","Mais informações de eventos em %s");

//%%%%%%	File Name mylist.php 	%%%%%
define('_MD_MYLIST','Agendamento de eventos');
define('_MD_CANCEL','Cancelar');
define('_MD_CANCEL_SUBJ','Cancelar - {EVENT_DATE} {EVENT_TITLE}');
?>
