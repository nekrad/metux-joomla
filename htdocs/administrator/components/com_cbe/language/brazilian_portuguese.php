<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* Versão brasileira por Diogo Magalhães | diogo@seuze.com.br | http://www.seuze.com.br
* para Mambo Brasil | http://www.mambobrasil.org
*************************************************************/


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Field Labels
DEFINE('_UE_HITS','Exibições');
DEFINE('_UE_USERNAME','ID');
DEFINE('_UE_Address','Endereço');
DEFINE('_UE_City','Cidade');
DEFINE('_UE_State','Estado');
DEFINE('_UE_PHONE','Telefone ');
DEFINE('_UE_FAX','Fax');
DEFINE('_UE_ZipCode','CEP');
DEFINE('_UE_Country','País');
DEFINE('_UE_Occupation','Ocupação');
DEFINE('_UE_Company','Empresa');
DEFINE('_UE_Interests','Interesses');
DEFINE('_UE_Birthday','Aniversário');
DEFINE('_UE_AVATAR','Retrato do usuário?');
DEFINE('_UE_ICQ','ICQ');
DEFINE('_UE_AIM','AIM');
DEFINE('_UE_YIM','YIM');
DEFINE('_UE_MSNM','MSNM');
DEFINE('_UE_Website','Site');
DEFINE('_UE_Location','Localização');
DEFINE('_UE_EDIT_TITLE','Edite seu perfil');
DEFINE('_UE_YOUR_NAME','Seu nome');
DEFINE('_UE_EMAIL','E-mail');
DEFINE('_UE_UNAME','ID');
DEFINE('_UE_PASS','Senha');
DEFINE('_UE_VPASS','Vericar senha');
DEFINE('_UE_SUBMIT_SUCCESS','Envio bem sucedido!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Seu item foi enviado com sucesso para ser revisado antes de ser publicado. Obrigado');
DEFINE('_UE_WELCOME','Bem-vindo!');
DEFINE('_UE_WELCOME_DESC','Bem-vindo à seção do usuário do site.');
DEFINE('_UE_CONF_CHECKED_IN','Todos os itens foram marcados');
DEFINE('_UE_CHECK_TABLE','Tabela de verificação');
DEFINE('_UE_CHECKED_IN','Checados ');
DEFINE('_UE_CHECKED_IN_ITEMS',' itens');
DEFINE('_UE_PASS_MATCH','A senha não confere.');
DEFINE('_UE_RTE','Habilitar o editor WYSIWYG');
DEFINE('_UE_RTE_DESC','Marque &quot;Sim&quot; para habilitar o Editor WYSIWYG para perfil dos usuários. Marque &quot;Não&quot; para um editor de texto plano.');
DEFINE('_UE_USERNAME_DESC','Marque &quot;Sim&quot; para permitir que o ID seja alterado pelo usuário. Marque &quot;Não&quot; para que o ID não possa ser alterado depois do cadastro.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','Usuário pode omitir e-mail?');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','&quot;SIM&quot; vai permitir que o usuário possa escolher entre publicar ou não seu e-mail. ATENÇÃO: Esta opção vai definir a exibição do e-mail apenas por este componente!');

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Membro desde');
DEFINE('_UE_LASTONLINE','Última visita');
DEFINE('_UE_ONLINESTATUS','Situação');
DEFINE('_UE_ISONLINE','Está conectado');
DEFINE('_UE_ISOFFLINE','Não está conectado');
DEFINE('_UE_PROFILE_TITLE','<br />Página de Perfil');
DEFINE('_UE_UPDATEPROFILE','Alterar seu Perfil');
DEFINE('_UE_UPDATEAVATAR','Alterar imagem');
DEFINE('_UE_CONTACT_INFO_HEADER','Informações para contato');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Mais informações');
DEFINE('_UE_MALE','Masculino');
DEFINE('_UE_FEMALE','Feminino');
DEFINE('_UE_REQUIRED_ERROR','Este campo é obrigatório!');
DEFINE('_UE_FIELD_REQUIRED',' Obrigatório!');
DEFINE('_UE_DELETE_AVATAR',' Remover imagem');

//Administrator Tab Names
DEFINE('_UE_USERPROFILE','Perfil do usuário');
DEFINE('_UE_USERLIST','Lista de usuários');
DEFINE('_UE_AVATARS','Imagens');
DEFINE('_UE_REGISTRATION','Registro');
DEFINE('_UE_SUBSCRIPTION','Subscrição');
DEFINE('_UE_INTEGRATION','Integração');

//Administrator Integration Tab
DEFINE('_UE_PMS',' Mensagens Privadas myPMS2');
DEFINE('_UE_PMS_DESC','Marque &quot;Sim&quot; se você tem o myPMS2 instalado e deseja habilitar o envio de Mensagens Privadas entre usuários cadastrados');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Nome do Campo');
DEFINE('_UE_EXPLANATION','Explicação');
DEFINE('_UE_FIELD_EXPLAINATION','Decidir se este campo será obrigatório e exibido ao usuário.');
DEFINE('_UE_CONFIG','Configuração');
DEFINE('_UE_CONFIG_DESC','Mudar a configuração');
DEFINE('_UE_VERSION','A sua versão é ');
DEFINE('_UE_BY','Um componente para Mambo 4.5 por');
DEFINE('_UE_CURRENT_SETTINGS','Configuração atual');
DEFINE('_UE_A_EXPLANATION','Explicação');
DEFINE('_UE_DISPLAY','Exibir?');
DEFINE('_UE_REQUIRED','Obrigatório?');
DEFINE('_UE_YES','Sim');
DEFINE('_UE_NO','Não');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Marque &quot;Sim&quot; se você deseja que os usuários cadastrados possam usar imagens em seu perfil (gerenciadas pela suas próprias páginas de perfil)');
DEFINE('_UE_AVHEIGHT','Altura máxima da imagem');
DEFINE('_UE_AVWIDTH','Largura máxima da imagem');
DEFINE('_UE_AVSIZE','Tamanho máximo da imagem<br/><em>em Kbytes</em>');
DEFINE('_UE_AVATARUPLOAD','Permitir envio de imagens?');
DEFINE('_UE_AVATARUPLOAD_DESC','Marque &quot;Sim&quot; se você deseja permitir que usuários cadastrados possam enviar imagens.');
DEFINE('_UE_AVATARIMAGERESIZE','Auto ajustar imagens?');
DEFINE('_UE_AVATARIMAGERESIZE_DESC','Auto ajustar imagens exige o GD Library instalado.  GD2 instalado? ');
DEFINE('_UE_AVATARGALLERY','Usar galeria de imagens?');
DEFINE('_UE_AVATARGALLERY_DESC','Marque &quot;Sim&quot; se você deseja permitir que usuários cadastrados possam escolher uma imagem da galeria.');
DEFINE('_UE_TNWIDTH','Max. Largura do thumbnail');
DEFINE('_UE_TNHEIGHT','Max. Altura do thumbnail');

//Admin User List Tab Labels
DEFINE('_UE_USERLIST_TITLE','Título da lista de usuários');
DEFINE('_UE_USERLIST_TITLE_DESC','Coloque o título da lista de usuários');
DEFINE('_UE_LISTVIEW','Lista');
DEFINE('_UE_PICTLIST','Lista de imagem');
DEFINE('_UE_PICTDETAIL','Detalhes da imagem');
DEFINE('_UE_LISTVIEW','Lista');
DEFINE('_UE_NUM_PER_PAGE','Usuários por página');
DEFINE('_UE_NUM_PER_PAGE_DESC','Número de usuários por página a exibir.');
DEFINE('_UE_VIEW_TYPE','Exibir tipo?');
DEFINE('_UE_VIEW_TYPE_DESC','Exibe o tipo.');
DEFINE('_UE_ALLOW_EMAIL','Links de e-mail?');
DEFINE('_UE_ALLOW_EMAIL_DESC','Permite ou não links de e-mail. Atenção: essa definição só se aplica a campos do tipo e-mail.');
DEFINE('_UE_ALLOW_WEBSITE','Links de sites?');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Permite ou não links de sites.');
DEFINE('_UE_ALLOW_IM','Links de Instant Messenging.');
DEFINE('_UE_ALLOW_IM_DESC','Permite ou não links de Instant Messenging.');
DEFINE('_UE_ALLOW_ONLINESTATUS','Exibir situação?');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Mostra se o usuário está logado ou não.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','Exibir e-mail?');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','&quot;Sim&quot; vai mostrar os endereços de e-mail pelo componente. &quot;Não&quot; vai omití-los.');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Moderação');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Grupo de moderadores');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','Todos os usuários no grupo selecionado e nos grupos hierarquicamente superiores serão moderadores.');
DEFINE('_UE_ALLOWUSERREPORTS','Permitir relatar usuário');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Permite usuários relatarem o comportamento inadequado de outros usuários aos moderadores.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Requer aprovação para o envio de imagens');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Exige que todas as imagens enviadas por usuários sejam aprovadas antes de exibidas.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Permite que os moderadores restrinjam a publicação de um perfil de usuário.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Permitir a suspensão de perfis?');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Formato do nome');
DEFINE('_UE_DATE_FORMAT','Formato da data');
DEFINE('_UE_NAME_FORMAT_DESC','Escolha qual formato dos campos Nome/ID que deseja exibir.');
DEFINE('_UE_DATE_FORMAT_DESC','Escolha qual formato do campo Data que deseja exibir.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Marque &quot;Sim&quot; para enviar e-mail ao usuário avisando sobre o link de confirmação do cadastro.');
DEFINE ('_UE_REG_CONFIRMATION','Exigir confirmação por e-mail?');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Exigir aprovação do Administrador?');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Exige que todo cadastro de usuário seja aprovado pelo Administrador');
DEFINE ('_UE_REG_EMAIL_NAME','Nome no e-mail de cadastro');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Por favor coloque seu nome como você quer que apareça quando enviar e-mail');
DEFINE ('_UE_REG_EMAIL_FROM','Endereço de e-mail de cadastro');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','Endereço de e-mail do qual deseja enviar os avisos a cadastrantes.');
DEFINE ('_UE_REG_EMAIL_REPLYTO','Endereço de e-mail para receber respostas aos avisos de cadastros');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','E-mail que você deseja como &quot;Responder para&quot;');
DEFINE ('_UE_REG_PEND_APPR_MSG','E-mail de aprovação pendente.');
DEFINE ('_UE_REG_WELCOME_MSG','E-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_MSG','E-mail de recusa de cadastro.');
DEFINE ('_UE_REG_PEND_APPR_SUB','Assunto do e-mail.');
DEFINE ('_UE_REG_WELCOME_SUB','Assunto do e-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_SUB','Assunto do e-mail de recusa.');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Use para assunto do e-mail de aprovação pendente.');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Use para o assunto do e-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Use para assunto do e-mail de recusa.');
DEFINE ('_UE_REG_SIGNATURE','Assinatura do e-mail.');
DEFINE ('_UE_REG_ADMIN_PA_SUB','Atenção! Cadastro de novo usuário com aprovação pendente.');
DEFINE ('_UE_REG_ADMIN_PA_MSG','Um usuário regsitrou-se em [SITEURL] e pede aprovação.\n'
.'Este e-mail contém detalhes de sua conta\n\n'
.'Nome - [NAME]\n'
.'E-mail - [EMAILADDRESS]\n'
.'ID - [USERNAME]\n\n\n'
.'Por favor, não responda a esta mensagem. Ela foi gerada automaticamente apenas para sua informação\n');
DEFINE ('_UE_REG_ADMIN_SUB','Registro de novo usuário');
DEFINE ('_UE_REG_ADMIN_MSG','Um novo usuário cadastrou-se em [SITEURL].\n'
.'Este e-mail contém detalhes de sua conta\n\n'
.'Nome - [NAME]\n'
.'E-mail - [EMAILADDRESS]\n'
.'ID - [USERNAME]\n\n\n'
.'Por favor, não responda a esta mensagem. Ela foi gerada automaticamente apenas para sua informação\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Nome do usuário.<br />'
.'[USERNAME] - ID do usuário.<br />'
.'[DETAILS] - Detalhes da conta do usuário como endereço de e-mail, ID e senha.<br />'
.'[CONFIRM] - Insere o link de confirmação se essa função estiver habilitada.<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Sua senha foi enviada para o e-mail que você forneceu.<br />&nbsp;&nbsp;'
.'Voce poderá logar-se quando receber sua senha.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Agora você já pode logar-se.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro necessita de aprovação. Feito isso, sua senha será enviada para o e-mail que você forneceu.<br />&nbsp;&nbsp;'
.'Quando for notificado da aprovação e receber uma senha, você poderá logar-se.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro necessita de aprovação. Feito isso, uma notificação será enviada para o e-mail que você forneceu.<br />&nbsp;&nbsp;'
.'Quando for notificado da aprovação, voce poderá logar-se.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Um e-mail com mais instruções de como completar seu cadastro foi enviado para o e-mail que você forneceu.  Por favor, verifique sua caixa postal para completar seu regisro.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Sua senha foi enviada para o e-mail que você forneceu.<br />&nbsp;&nbsp;'
.'Quando você receber sua senha e seguir as instruções de confirmação, você poderá logar-se.');

// User List Labels
DEFINE ('_UE_HAS','tem');
DEFINE ('_UE_USERS','usuários cadastrados');
DEFINE ('_UE_SEARCH_ALERT','Por favor, coloque uma expressão para a procura!');
DEFINE ('_UE_SEARCH','Achar usuário');
DEFINE ('_UE_ENTER_EMAIL','Coloque e-mail, nome ou ID do usuário');
DEFINE ('_UE_SEARCH_BUTTON','Procurar');
DEFINE ('_UE_SHOW_ALL','Exibir todos os usuários');
DEFINE ('_UE_NAME','Nome');
DEFINE ('_UE_UL_USERNAME','ID do usuário (ID)');
DEFINE ('_UE_USERTYPE','Tipo de usuário');
DEFINE ('_UE_VIEWPROFILE','Ver perfil');
DEFINE ('_UE_LIST_ALL','Listar todos');
DEFINE ('_UE_PAGE','Página');
DEFINE ('_UE_RESULTS','Resultados');
DEFINE ('_UE_OF_TOTAL','do total');
DEFINE ('_UE_NO_RESULTS','Sem resultado');
DEFINE ('_UE_FIRST_PAGE','primeira página');
DEFINE ('_UE_PREV_PAGE','página anterior');
DEFINE ('_UE_NEXT_PAGE','próxima página');
DEFINE ('_UE_END_PAGE','última página');
DEFINE('_UE_CONTACT','Contato');
DEFINE('_UE_INSTANT_MESSAGE','Instant Message');
DEFINE('_UE_IMAGEAVAILABLE','Foto');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Perfil');
DEFINE('_UE_PRIVATE_MESSAGE','Mensagem privada');
DEFINE('_UE_ADDITIONAL','Informações adicionais');
DEFINE('_UE_NO_DATA','Campo vazio');
DEFINE('_UE_CLICKTOVIEW','Clique para');
DEFINE('_UE_UL_USERNAME_NAME','ID(Nome)');
DEFINE('_UE_PM','PM');
DEFINE('UE_PM_USER','Enviar mensagem privada');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','Não tem um cadastro?');
DEFINE('_UE_CREATE_ACCOUNT','Crie um!');
DEFINE('_LOGIN_NOT_CONFIRMED','Seu cadastro ainda não foi completado. Verifique sua caixa postal para mais instruções.');
DEFINE('_LOGIN_NOT_APPROVED','Sua conta ainda não foi aprovada!');
DEFINE('_UE_USER_CONFIRMED','Agora sua conta está ativa. Voce já pode logar-se!');
DEFINE('_UE_USER_NOTCONFIRMED','Sua conta ainda não está ativa. Por favor, verifique sua caixa postal e siga as instruções para completar seu cadastro.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Enviar');
DEFINE('_UE_UPLOAD_DIMENSIONS','Sua imagem pode ter no máximo (largura x altura - tamanho)');
DEFINE('_UE_UPLOAD_SUBMIT','Enviar uma nova imagem');
DEFINE('_UE_UPLOAD_SELECT_FILE','Selecionar arquivo');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Por favor utilize apenas imagens jpeg, jpg ou png');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Por favor, selecione um arquivo antes de enviar.');
DEFINE('_UE_UPLOAD_ERROR_NAME','O nome do arquivo pode conter apenas caracteres alfanuméricos, sem espaços.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','O tamanho da imagem excede o máximo permitido.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','A altura ou a largura da imagem excede o máximo permitido.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','A largura da imagem excede o permitido.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','A altura da imagem excede o permitido.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE',"Você não escolheu uma imagem da galeria.");
DEFINE('_UE_UPLOAD_UPLOADED','Sua imagem foi enviada.');
DEFINE('_UE_UPLOAD_GALLERY','Escolha uma imagem da galeria');
DEFINE('_UE_UPLOAD_CHOOSE','Confirme sua escolha.');
DEFINE('_UE_UPLOAD_UPDATED','Sua imagem foi habilitada.');
DEFINE('_UE_USER_PROFILE_NOT','Seu perfil não pôde ser atualizado.');
DEFINE('_UE_USER_PROFILE_UPDATED','Seu perfil foi atualizado.');
DEFINE('_UE_USER_RETURN_A','Se você não for redirecionado de volta para seu perfil em poucos instantes ');
DEFINE('_UE_USER_RETURN_B','clique aqui.');
DEFINE('_UPDATE','Atualizar');

//Moderator
DEFINE('_UE_USERPROFILEBANNED','Este perfil foi suspenso por um moderador.');
DEFINE('_UE_REQUESTUNBANPROFILE','Enviar solicitação de reabilitação de perfil');
DEFINE('_UE_REPORTUSER','Relatar usuário');
DEFINE('_UE_BANPROFILE','Suspender perfil');
DEFINE('_UE_UNBANPROFILE','Reabilitar perfil');
DEFINE('_UE_REPORTUSER_TITLE','Relatório de usuário');
DEFINE('_UE_USERREASON','Motivo do relatório');
DEFINE('_UE_BANREASON','Motivo da suspensão');
DEFINE('_UE_SUBMITFORM','Enviar');
DEFINE('_UE_NOUNBANREQUESTS','Nenhuma solicitação de cancelamento de suspenção para processar.');
DEFINE('_UE_BANREASON','Motivo para a suspensão');
DEFINE('_UE_IMAGE_MODERATE','Ver imagens para Moderação');
DEFINE('_UE_APPROVE_IMAGES','Aprovar imagem');
DEFINE('_UE_REJECT_IMAGES','Recusar imagem');
DEFINE('_UE_MODERATE_TITLE','Moderador');
DEFINE('_UE_NOIMAGESTOAPPROVE','Nenhuma imagem para aprovar');
DEFINE('_UE_USERREPORT_MODERATE','Moderação de relatórios de usuário');
DEFINE('_UE_REPORTEDUSER','Usuário relatado');
DEFINE('_UE_REPORT','Relatório');
DEFINE('_UE_REPORTEDONDATE','Data do relatório');
DEFINE('_UE_REPORTEDUSER','Usuário relatado');
DEFINE('_UE_REPORTEDBY','Relatado por');
DEFINE('_UE_PROCESSUSERREPORT','Processar');
DEFINE('_UE_NONEWUSERREPORTS','Nenhum novo relatório de usuário');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Perfil reabilitado com sucesso.');
DEFINE('_UE_REPORTUSERSACTIVITY','Descrever atividade do usuário');
DEFINE('_UE_USERREPORT_SUCCESSFUL','Relatório de usuário enviado com sucesso.');
DEFINE('_UE_USERBAN_SUCCESSFUL','Perfil de usuário suspenso com sucesso.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','Esta função está desabilitada.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Sua imagem está aguardando aprovação de um moderador.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Sua imagem foi enviada com sucesso.');
DEFINE('_UE_UNBANREQUEST','Solicitação de cancelamento de suspenção');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Sua solicitação de cancelamento de suspenção foi enviada com sucesso.');
DEFINE('_UE_USERREPORT','Relatório de usuário');
DEFINE('_UE_VIEWUSERREPORTS','Ver relatórios de usuário');
DEFINE('_UE_USERREQUESTRESPONSE','Ver réplica do usuário');
DEFINE('_UE_MODERATORREQUESTRESPONSE','Ver resposta do moderador');
DEFINE('_UE_REPORTBAN_TITLE','Relatório de suspensão');
DEFINE('_UE_REPORTUNBAN_TITLE','Relatório de reabilitação');

DEFINE('_UE_UNBANREQUIREACTION',' Solicitação de reabilitação');
DEFINE('_UE_USERREPORTSREQUIREACTION','Relatórios de usuário');
DEFINE('_UE_IMAGESREQUIREACTION','Imagem(s)');
DEFINE('_UE_NOACTIONREQUIRED','Sem pendências');

DEFINE('_UE_UNBAN_MODERATE','Pedidos de reabilitação de perfis');
DEFINE('_UE_BANNEDUSER','Usuário suspenso');
DEFINE('_UE_BANNEDREASON','Razão da suspensão');
DEFINE('_UE_BANNEDON','Data da suspensão');
DEFINE('_UE_BANNEDBY','Suspenso por');

DEFINE('_UE_MODERATORBANRESPONSE','Resposta do moderador');
DEFINE('_UE_USERBANRESPONSE','Resposta do usuário');

DEFINE('_UE_IMAGE_ADMIN_SUB','Aprovação de imagem pendente');
DEFINE('_UE_IMAGE_ADMIN_MSG','Um usuário enviou uma imagem para avaliação. Por favor, tome as medidas apropriadas.');
DEFINE('_UE_USERREPORT_SUB','Revisão de relatório de usuário pendente');
DEFINE('_UE_USERREPORT_MSG','Um usuário enviou um relatório que precisa de sua revisão. Por favor, conecte-se e tome as medidas apropriadas.');
DEFINE('_UE_IMAGEAPPROVED_SUB','Imagem aprovada');
DEFINE('_UE_IMAGEAPPROVED_MSG','Sua imagem foi aprovada por um moderador.');
DEFINE('_UE_IMAGEREJECTED_SUB','Imagem rejeitada');
DEFINE('_UE_IMAGEREJECTED_MSG','Sua imagem foi rejeitada por um moderador. Por favor, envie outra.');
DEFINE('_UE_BANUSER_SUB','Perfil de usuário suspenso.');
DEFINE('_UE_BANUSER_MSG','Seu perfil foi suspenso por um administrador. Por favor, conecte-se e verifique por que foi suspenso.');
DEFINE('_UE_UNBANUSER_SUB','Perfil reabilitado');
DEFINE('_UE_UNBANUSER_MSG','Seu perfil foi reaabilitado por um administrador e está visível para todos os outros usuários novamente.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Pedido de reabilitação dependendo de revisão');
DEFINE('_UE_UNBANUSERREQUEST_MSG','Um usuário solicitou a reabilitação de seu perfil. Por favor, tome as medidas apropriadas.');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Thumbnail');
DEFINE('_UE_FORMATNAME','Nome formatado');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Campos obrigatórios pelo Admin.');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Marque &quot;Sim&quot; para que o &quot;Admin. de Usuários&quot; respeite as exigências de preenchimento definidas para os campos e &quot;Não&quot; para ignorar essas exigências.');
DEFINE('_UE_CANCEL','Cancelar');
DEFINE('_UE_NA','Nenhuma');
DEFINE('_UE_MODERATOREMAIL','Enviar e-mail para moderadores?');
DEFINE('_UE_MODERATOREMAIL_DESC','Se &quot;SIM&quot;, os moderadores receberão e-mail quando for necessária sua intervenção.');

//Beta 1 Build
DEFINE('_UE_UPDATE','Atualizar');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','Visível no Perfil');
DEFINE('_UE_FIELDNOPROFILE','Invisível no Perfil');
DEFINE('_UE_FIELDREQUIRED','Campo obrigatório');
DEFINE('_UE_NOT_AUTHORIZED','Você não tem autorização para ver esta página!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Permitido o acesso por:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','Escolha o grupo que você deseja que possa ver a lista. Todos os usuários desse grupo e dos níveis listados abaixo vão ter o mesmo acesso.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Permitido o acesso por:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC',' Escolha o grupo que você deseja que possa ver os prefis. Todos os usuários desse grupo e dos níveis listados abaixo vão ter o mesmo acesso.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','Não existem listas publicadas!');
DEFINE('_UE_ALLOW_PROFILELINK','Permitir link para o perfil?');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Marque &quot;SIM&quot; para permitir que cada linha da lista  seja o link para o perfil do usuário e &quot;NÃO&quot; para evitar isso.');
DEFINE('_UE_REGISTERFORPROFILE','Por favor, logue-se ou cadastre-se para ver ou alterar seu perfil.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','O GD2 Image Library não está instalado ou não foi compilado adequadamente para  PHP! Por favor, notifique o administrador do seu sistema para desabilitar o Ajuste Automático de Imagens.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','Ocorreu um erro ao enviar ou processar a imagem!');
DEFINE('_UE_TOC','Aceitar os Termos e Condições');
DEFINE('_UE_TOC_REQUIRED','Você tem de aceitar os Termos e Condições antes de efetuar seu cadastro!');
DEFINE('_UE_REG_TOC_MSG','Habilitar os Termos e Condições');
DEFINE('_UE_REG_TOC_DESC','Marque &quot;SIM&quot; para exigir que seus usuários tenham que aceitar o Termos e Condições antes de efetuar o cadastro!');
DEFINE('_UE_REG_TOC_URL_MSG','URL para Termos e Condições');
DEFINE('_UE_REG_TOC_URL_DESC','Entre com a URL para os Termos e Condições. Ela deve ser relativa à raiz do seu site Mambo.');
DEFINE('_UE_LASTUPDATEDON','Última atualização');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','IMPORTANTE: Seu e-mail será conhecido por quem receber a mensagem que você enviar.');
DEFINE('_UE_EMAILFORMSUBJECT','Assunto:');
DEFINE('_UE_EMAILFORMMESSAGE','Mensagem:');
DEFINE('_UE_EMAILFORMINSTRUCT','Enviar mensagem por e-mail para <a href="index.php?option=com_cbe&task=UserDetails&user=%s">%s </a>.');
DEFINE('_UE_GENERAL','Geral');
DEFINE('_UE_SENDEMAILNOTICE','ATENÇÃO: Essa é uma mensagem de %s at %s ( %s ).  Esse usuário não viu seu endereço de e-mail, mas se você responder a esta mensagem, ela conterá seu endereço. %s proprietários não se responsabilizarão pelo conteúdo das mensagens.');
DEFINE('_UE_SENDEMAIL','Enviar e-mail');
DEFINE('_UE_SENTEMAILSUCCESS','E-mail enviado com sucesso!');
DEFINE('_UE_SENTEMAILFAILED','Falha ao enviar seu e-mail!  Tente de novo, por favor.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','O e-mail está sendo enviado');
DEFINE('_UE_REGISTERDATE','Data');
DEFINE('_UE_ACTION','Ação');
DEFINE('_UE_USER','Usuário');
DEFINE('_UE_USERAPPROVAL_MODERATE','Aprovação/rejeição de usuário');
DEFINE('_UE_USERPENDAPPRACTION',' Usuário(s)');
DEFINE('_UE_APPROVEUSER','Processar usuários(s)');
DEFINE('_UE_REG_REJECT_SUB','Sinto muito , seu cadastro foi rejeitado!');
DEFINE('_UE_USERREJECT_MSG','Seu cadastro foi rejeitado pelo seguinte motivo: \n %s');
DEFINE('_UE_COMMENT','Comentário ');
DEFINE('_UE_APPROVE','Aprovado');
DEFINE('_UE_REJECT','Rejeitado');
DEFINE('_UE_USERREJECT_SUCCESSFUL','Esse grupo de usuários foi devidamente rejeitado!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','Esse grupo de usuários foi devidamente aprovado!');
DEFINE('_LOGIN_REJECTED','Seu pedido de cadastro foi rejeitado!');
DEFINE('_UE_EMAILFOOTER','ATENÇÃO: Este e-mail foi gerado automaticamente por %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Aprovação de usuários por moderador');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','Essa configuração permite que os moderadores aprovem cadastros de usuários pendentes pela frente do site.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Pedido de cadastro completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro definitivo requer aprovação e confirmação por e-mail. Por favor, siga os passo indicados no e-mail que você vai receber em breve. Quando aprovado, você vai ser notificado pelo endereço de e-mai que você forneceu.<br />&nbsp;&nbsp;'
.'Quando você receber a notificação de aprovação, você vai poder logar-se.');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Pedido de cadastro completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro definitivo requer aprovação e confirmação por e-mail. Por favor, siga os passo indicados no e-mail que você vai receber em breve. <br />&nbsp;&nbsp;'
.'Quando você receber por e-mail a notificação de aprovação, você vai receber uma senha com a qual vai poder logar-se.');
DEFINE('_UE_NAME_STYLE','Estilo dos Nomes');
DEFINE('_UE_NAME_STYLE_DESC','O Estilo dos Nomes detalha a maneira como você deseja que seja o preenchimento dos campos  dos nomes pelos usuários, no cadastro.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Obrigado por você ter confirmado seu endereço de e-mail. Seu cadastro definitivo requer avaliação e aprovação de um moderador. Você receberá um e-mail com o resultado dessa avaliação.');
DEFINE('_UE_YOUR_FNAME','Primeiro nome');   
DEFINE('_UE_YOUR_MNAME','Nome do meio');
DEFINE('_UE_YOUR_LNAME','Último nome');


//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Configurações do forum');
DEFINE('_UE_SB_TABDESC','Essas são suas configurações do forum');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Modo de visão');
DEFINE('_UE_SB_VIEWTYPE_FLAT','Plano');
DEFINE('_UE_SB_VIEWTYPE_THREADED','Hierárquico');
DEFINE('_UE_SB_ORDERING_TITLE','Modo de organização das postagens');
DEFINE('_UE_SB_ORDERING_OLDEST','Mais velhas primeiro');
DEFINE('_UE_SB_ORDERING_LATEST','Mais novas primeiro');
DEFINE('_UE_SB_SIGNATURE','Assinatura');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','Sem imagem');
DEFINE('_UE_IMG_PENDIMG','Aprovação pendente');

?>