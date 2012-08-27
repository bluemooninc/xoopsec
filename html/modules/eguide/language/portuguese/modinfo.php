<?php
// $Id: modinfo.php,v 1.2 2010-10-10 06:30:12 nobu Exp $
// Módulo traduzido para o Português do Brasil (portuguese) por
// Leco (m_ohse@hotmail.com) URL: http://xoopersBR.com

if (defined('_MI_EGUIDE_NAME')) return;

// The name of this module
define("_MI_EGUIDE_NAME","Guia de eventos");

// A brief description of this module
define("_MI_EGUIDE_DESC","Sistema de agendamento e vizualização detalhada de eventos");

// Names of blocks for this module (Not all module has blocks)
define("_MI_EGUIDE_MYLIST","Eventos agendados");
define("_MI_EGUIDE_SUBMIT","Registrar um novo evento");
define("_MI_EGUIDE_COLLECT","Coleção de configurações");
define("_MI_EGUIDE_REG","Notifique-me de novos eventos");
define("_MI_EGUIDE_HEADLINE","Guia de eventos");
define("_MI_EGUIDE_HEADLINE_DESC","Lista dos próximos eventos");
define("_MI_EGUIDE_HEADLINE2","Novos eventos");
define("_MI_EGUIDE_HEADLINE2_DESC","Lista dos últimos postadores");
define("_MI_EGUIDE_HEADLINE3","Eventos concluídos");
define("_MI_EGUIDE_HEADLINE3_DESC","Lista dos eventos concluídos");
define("_MI_EGUIDE_CATBLOCK","Categoria do evento");
define("_MI_EGUIDE_CATBLOCK_DESC","Escolha a categoria do evento");

define("_MI_EGUIDE_EVENTS","Operação do artigo do evento");
define("_MI_EGUIDE_NOTIFIES","Notifique-me de novos registros");
define("_MI_EGUIDE_CATEGORY","Categorias dos eventos");
define("_MI_EGUIDE_SUMMARY","Sumário do agendamento");
define("_MI_EGUIDE_CATEGORY_MARK","Categoria - ");
define("_MI_EGUIDE_ABOUT","Sobre o Guia de eventos");

// Configuration variable for this module
define("_MI_EGUIDE_POSTGROUP","Grupo de usuários que podem postar");
define("_MI_EGUIDE_POSTGROUP_DESC","Configuração do grupo de usuários que o administrador permite o registro de seus próprios evento.");
define("_MI_EGUIDE_NOTIFYADMIN","Notificar o administrdor via e-mail");
define("_MI_EGUIDE_NOTIFYADMIN_DESC","Notificar, via e-mail, o administrador quando um novo evento for registrado");
define("_MI_EGUIDE_NOTIFY_ALWAYS","Sempre");
define("_MI_EGUIDE_NOTIFYGROUP","Grupo administrador que será notificado");
define("_MI_EGUIDE_NOTIFYGROUP_DESC","Grupo que receberá notificação do administrador, via e-mail");
define("_MI_EGUIDE_NEEDPOSTAUTH","Você precisa aprovar um novo evento");
define("_MI_EGUIDE_NEEDPOSTAUTH_DESC","É necessário a aprovação do novo evento pelo administrador do site");
define("_MI_EGUIDE_MAX_LISTITEM","Mostrar itens adicionais na lista");
define("_MI_EGUIDE_MAX_LISTITEM_DESC","Mostrar o registro dos dos itens classificados no formulário adicional");
define("_MI_EGUIDE_MAX_LISTLINES","Mostar a lista dos itens em uma página");
define("_MI_EGUIDE_MAX_LISTLINES_DESC","Quantidade de itens em uma página");
define("_MI_EGUIDE_MAX_EVENT","Mostrar os eventos na página principal");
define("_MI_EGUIDE_MAX_EVENT_DESC","Número de itens listados na página principal");
define("_MI_EGUIDE_SHOW_EXTENTS","Mostrar registros múltiplos");
define("_MI_EGUIDE_SHOW_EXTENTS_DESC","Mostrar cada registros, quando um evento tiver registros múltiplos. SIM - Mostra cada registro. NÃO - Mostra somente o último registro.");
define("_MI_EGUIDE_USER_NOTIFY","O usuário solicita ser notificado dos novos eventos");
define("_MI_EGUIDE_USER_NOTIFY_DESC","SIM - Habilitar notificação, via e-mail. NÃO - Desabilitar.");
define("_MI_EGUIDE_MEMBER","É necessário estar logado no site para poder registrar um evento. Cadastre-se no site.");
define("_MI_EGUIDE_MEMBER_DESC","Somente usuários logado podem agendar eventos. (Não usu endereço de e-mail)");
define('_MI_EGUIDE_MEMBER_RELAX', "Ambos");
define("_MI_EGUIDE_ORDERCONF","Necessário a confirmação");
define("_MI_EGUIDE_ORDERCONF_DESC","Mostrar página de confirmação quando enviar o agendamento");
define("_MI_EGUIDE_CLOSEBEFORE","Tempo antes de fechar (min)");
define("_MI_EGUIDE_CLOSEBEFORE_DESC","Configuração em minutos do tempo de encerramento antes do registro de evento.");
define("_MI_EGUIDE_LAB_PERSONS","Opções do item adicional");
define("_MI_EGUIDE_LAB_PERSONS_DESC","Configurações do item adicional, como a etiqueta do campo para quantas pessoas. Example: 'label_persons=Persons'. Veja <a href=\"../../eguide/admin/help.php#form_options\"> na página de ajuda do Guia de eventos</a> mais detalhes.");
define("_MI_EGUIDE_DATE_FORMAT","Formato da data");
define("_MI_EGUIDE_DATE_FORMAT_DESC","Mostrar formato da data(tempo) do evento aberto. Utilize o formato da função data do PHP.");
define("_MI_EGUIDE_DATE_FORMAT_DEF","D, d M Y");
define("_MI_EGUIDE_EXPIRE_AFTER","Tempo expirado");
define("_MI_EGUIDE_EXPIRE_AFTER_DESC","O tempo expira na página inicial depois que o tempo do evento inicia em minutos.");
define("_MI_EGUIDE_PERSONS","Valor padrão da pessoas");
define("_MI_EGUIDE_PERSONS_DESC","Agendamento de pessoas postando em formulário e eventos");
define("_MI_EGUIDE_PLUGINS","Usar plugin de controle de agendamento");
define("_MI_EGUIDE_PLUGINS_DESC","Controle interno aceitar plugins do formulário de registro");
define("_MI_EGUIDE_COMMENT","Permitir comentários");
define("_MI_EGUIDE_COMMENT_DESC","Permitir comentários para o evento");
define("_MI_EGUIDE_MARKER","Marcar nivel do registro atual");
define("_MI_EGUIDE_MARKER_DESC","Marcar significa quantos registros estão em curso. Mostrar marca corresponde a uma percentagem. (xx,yy signfica menos que xx% aparecendo yy. E '0,yy' significa fora da data marcada)");
define("_MI_EGUIDE_MARKER_DEF","0,[Fechar]\n50,[Vago]\n100,[Muitos]\n101,[Todo]\n");
define("_MI_EGUIDE_TIME_DEFS","Etiquetas da tabela do tempo");
define("_MI_EGUIDE_TIME_DEFS_DESC","Configurar a hora de início na página das configurações da coleção. Exemplo: 08:00,14:00,16:00");
define("_MI_EGUIDE_EXPORT_LIST","Lista do item na exportação dos egendamentos");
define("_MI_EGUIDE_EXPORT_LIST_DESC","Item `name' ou `number' separados por virgula(,). Asterisco(*) significa itens a esquerda. Exemplo: 3,4,0,2,*");
// Templates
define("_MI_EGUIDE_INDEX_TPL", "Lista da Guia de eventos na página inicial");
define("_MI_EGUIDE_EVENT_TPL", "Detalhe do evento");
define("_MI_EGUIDE_ENTRY_TPL", "Registro do agendamento");
define("_MI_EGUIDE_EVENT_PRINT_TPL", "Imprimir detalhe do evento");
define("_MI_EGUIDE_RECEIPT_TPL", "Lista dos agendamentos");
define("_MI_EGUIDE_ADMIN_TPL", "Formulário de registro do evento");
define("_MI_EGUIDE_RECEIPT_PRINT_TPL", "Imprimir a lista dos agendamentos");
define("_MI_EGUIDE_EVENT_ITEM_TPL", "Mostrar item do evento");
define("_MI_EGUIDE_EVENT_CONF_TPL", "Formulário de confirmação do evento");
define("_MI_EGUIDE_EVENT_LIST_TPL", "Lista dos eventos agendados");
define("_MI_EGUIDE_EVENT_CONFIRM_TPL", "Confirmação do agendamento");
define("_MI_EGUIDE_EDITDATE_TPL", "Editar data da abertura");
define("_MI_EGUIDE_COLLECT_TPL", "Configuração da coleção de agendamentos");
define("_MI_EGUIDE_EXCEL_TPL", "Exportação no formato de arquivo Excel (XML)");

// Notifications
define('_MI_EGUIDE_GLOBAL_NOTIFY', 'Notifique-me de todas as modificações');
define('_MI_EGUIDE_GLOBAL_NOTIFY_DESC', 'Notifique-me sobre os eventos');
define('_MI_EGUIDE_CATEGORY_NOTIFY', 'Categoria atual');
define('_MI_EGUIDE_CATEGORY_NOTIFY_DESC', 'Notifique-me sobre os categorias de eventos');
define('_MI_EGUIDE_CATEGORY_BOOKMARK', 'Evento atual');
define('_MI_EGUIDE_CATEGORY_BOOKMARK_DESC', 'Notifique-me sobre o evento atual');

define('_MI_EGUIDE_NEWPOST_SUBJECT', 'Novo evento - {EVENT_DATE} {EVENT_TITLE}');
define('_MI_EGUIDE_NEWPOST_NOTIFY', 'Postar novo evento');
define('_MI_EGUIDE_NEWPOST_NOTIFY_CAP', 'Notificar quando um novo evento for postado');
define('_MI_EGUIDE_CNEWPOST_NOTIFY', 'Novo evento postado na categoria');
define('_MI_EGUIDE_CNEWPOST_NOTIFY_CAP', 'Notifique-me quando um novo evento for postado na categoria atual');

// for altsys
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Modelos');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocos e Permissões');
    define('_MD_A_MYMENU_MYLANGADMIN','Linguagens');
    define('_MD_A_MYMENU_MYPREFERENCES','Preferências');
}
?>
