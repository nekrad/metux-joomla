<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* Vers�o brasileira por Diogo Magalh�es | diogo@seuze.com.br | http://www.seuze.com.br
* para Mambo Brasil | http://www.mambobrasil.org
*************************************************************/


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Field Labels
DEFINE('_UE_HITS','Exibi��es');
DEFINE('_UE_USERNAME','ID');
DEFINE('_UE_Address','Endere�o');
DEFINE('_UE_City','Cidade');
DEFINE('_UE_State','Estado');
DEFINE('_UE_PHONE','Telefone ');
DEFINE('_UE_FAX','Fax');
DEFINE('_UE_ZipCode','CEP');
DEFINE('_UE_Country','Pa�s');
DEFINE('_UE_Occupation','Ocupa��o');
DEFINE('_UE_Company','Empresa');
DEFINE('_UE_Interests','Interesses');
DEFINE('_UE_Birthday','Anivers�rio');
DEFINE('_UE_AVATAR','Retrato do usu�rio?');
DEFINE('_UE_ICQ','ICQ');
DEFINE('_UE_AIM','AIM');
DEFINE('_UE_YIM','YIM');
DEFINE('_UE_MSNM','MSNM');
DEFINE('_UE_Website','Site');
DEFINE('_UE_Location','Localiza��o');
DEFINE('_UE_EDIT_TITLE','Edite seu perfil');
DEFINE('_UE_YOUR_NAME','Seu nome');
DEFINE('_UE_EMAIL','E-mail');
DEFINE('_UE_UNAME','ID');
DEFINE('_UE_PASS','Senha');
DEFINE('_UE_VPASS','Vericar senha');
DEFINE('_UE_SUBMIT_SUCCESS','Envio bem sucedido!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Seu item foi enviado com sucesso para ser revisado antes de ser publicado. Obrigado');
DEFINE('_UE_WELCOME','Bem-vindo!');
DEFINE('_UE_WELCOME_DESC','Bem-vindo � se��o do usu�rio do site.');
DEFINE('_UE_CONF_CHECKED_IN','Todos os itens foram marcados');
DEFINE('_UE_CHECK_TABLE','Tabela de verifica��o');
DEFINE('_UE_CHECKED_IN','Checados ');
DEFINE('_UE_CHECKED_IN_ITEMS',' itens');
DEFINE('_UE_PASS_MATCH','A senha n�o confere.');
DEFINE('_UE_RTE','Habilitar o editor WYSIWYG');
DEFINE('_UE_RTE_DESC','Marque &quot;Sim&quot; para habilitar o Editor WYSIWYG para perfil dos usu�rios. Marque &quot;N�o&quot; para um editor de texto plano.');
DEFINE('_UE_USERNAME_DESC','Marque &quot;Sim&quot; para permitir que o ID seja alterado pelo usu�rio. Marque &quot;N�o&quot; para que o ID n�o possa ser alterado depois do cadastro.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','Usu�rio pode omitir e-mail?');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','&quot;SIM&quot; vai permitir que o usu�rio possa escolher entre publicar ou n�o seu e-mail. ATEN��O: Esta op��o vai definir a exibi��o do e-mail apenas por este componente!');

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Membro desde');
DEFINE('_UE_LASTONLINE','�ltima visita');
DEFINE('_UE_ONLINESTATUS','Situa��o');
DEFINE('_UE_ISONLINE','Est� conectado');
DEFINE('_UE_ISOFFLINE','N�o est� conectado');
DEFINE('_UE_PROFILE_TITLE','<br />P�gina de Perfil');
DEFINE('_UE_UPDATEPROFILE','Alterar seu Perfil');
DEFINE('_UE_UPDATEAVATAR','Alterar imagem');
DEFINE('_UE_CONTACT_INFO_HEADER','Informa��es para contato');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Mais informa��es');
DEFINE('_UE_MALE','Masculino');
DEFINE('_UE_FEMALE','Feminino');
DEFINE('_UE_REQUIRED_ERROR','Este campo � obrigat�rio!');
DEFINE('_UE_FIELD_REQUIRED',' Obrigat�rio!');
DEFINE('_UE_DELETE_AVATAR',' Remover imagem');

//Administrator Tab Names
DEFINE('_UE_USERPROFILE','Perfil do usu�rio');
DEFINE('_UE_USERLIST','Lista de usu�rios');
DEFINE('_UE_AVATARS','Imagens');
DEFINE('_UE_REGISTRATION','Registro');
DEFINE('_UE_SUBSCRIPTION','Subscri��o');
DEFINE('_UE_INTEGRATION','Integra��o');

//Administrator Integration Tab
DEFINE('_UE_PMS',' Mensagens Privadas myPMS2');
DEFINE('_UE_PMS_DESC','Marque &quot;Sim&quot; se voc� tem o myPMS2 instalado e deseja habilitar o envio de Mensagens Privadas entre usu�rios cadastrados');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Nome do Campo');
DEFINE('_UE_EXPLANATION','Explica��o');
DEFINE('_UE_FIELD_EXPLAINATION','Decidir se este campo ser� obrigat�rio e exibido ao usu�rio.');
DEFINE('_UE_CONFIG','Configura��o');
DEFINE('_UE_CONFIG_DESC','Mudar a configura��o');
DEFINE('_UE_VERSION','A sua vers�o � ');
DEFINE('_UE_BY','Um componente para Mambo 4.5 por');
DEFINE('_UE_CURRENT_SETTINGS','Configura��o atual');
DEFINE('_UE_A_EXPLANATION','Explica��o');
DEFINE('_UE_DISPLAY','Exibir?');
DEFINE('_UE_REQUIRED','Obrigat�rio?');
DEFINE('_UE_YES','Sim');
DEFINE('_UE_NO','N�o');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Marque &quot;Sim&quot; se voc� deseja que os usu�rios cadastrados possam usar imagens em seu perfil (gerenciadas pela suas pr�prias p�ginas de perfil)');
DEFINE('_UE_AVHEIGHT','Altura m�xima da imagem');
DEFINE('_UE_AVWIDTH','Largura m�xima da imagem');
DEFINE('_UE_AVSIZE','Tamanho m�ximo da imagem<br/><em>em Kbytes</em>');
DEFINE('_UE_AVATARUPLOAD','Permitir envio de imagens?');
DEFINE('_UE_AVATARUPLOAD_DESC','Marque &quot;Sim&quot; se voc� deseja permitir que usu�rios cadastrados possam enviar imagens.');
DEFINE('_UE_AVATARIMAGERESIZE','Auto ajustar imagens?');
DEFINE('_UE_AVATARIMAGERESIZE_DESC','Auto ajustar imagens exige o GD Library instalado.  GD2 instalado? ');
DEFINE('_UE_AVATARGALLERY','Usar galeria de imagens?');
DEFINE('_UE_AVATARGALLERY_DESC','Marque &quot;Sim&quot; se voc� deseja permitir que usu�rios cadastrados possam escolher uma imagem da galeria.');
DEFINE('_UE_TNWIDTH','Max. Largura do thumbnail');
DEFINE('_UE_TNHEIGHT','Max. Altura do thumbnail');

//Admin User List Tab Labels
DEFINE('_UE_USERLIST_TITLE','T�tulo da lista de usu�rios');
DEFINE('_UE_USERLIST_TITLE_DESC','Coloque o t�tulo da lista de usu�rios');
DEFINE('_UE_LISTVIEW','Lista');
DEFINE('_UE_PICTLIST','Lista de imagem');
DEFINE('_UE_PICTDETAIL','Detalhes da imagem');
DEFINE('_UE_LISTVIEW','Lista');
DEFINE('_UE_NUM_PER_PAGE','Usu�rios por p�gina');
DEFINE('_UE_NUM_PER_PAGE_DESC','N�mero de usu�rios por p�gina a exibir.');
DEFINE('_UE_VIEW_TYPE','Exibir tipo?');
DEFINE('_UE_VIEW_TYPE_DESC','Exibe o tipo.');
DEFINE('_UE_ALLOW_EMAIL','Links de e-mail?');
DEFINE('_UE_ALLOW_EMAIL_DESC','Permite ou n�o links de e-mail. Aten��o: essa defini��o s� se aplica a campos do tipo e-mail.');
DEFINE('_UE_ALLOW_WEBSITE','Links de sites?');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Permite ou n�o links de sites.');
DEFINE('_UE_ALLOW_IM','Links de Instant Messenging.');
DEFINE('_UE_ALLOW_IM_DESC','Permite ou n�o links de Instant Messenging.');
DEFINE('_UE_ALLOW_ONLINESTATUS','Exibir situa��o?');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Mostra se o usu�rio est� logado ou n�o.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','Exibir e-mail?');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','&quot;Sim&quot; vai mostrar os endere�os de e-mail pelo componente. &quot;N�o&quot; vai omit�-los.');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Modera��o');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Grupo de moderadores');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','Todos os usu�rios no grupo selecionado e nos grupos hierarquicamente superiores ser�o moderadores.');
DEFINE('_UE_ALLOWUSERREPORTS','Permitir relatar usu�rio');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Permite usu�rios relatarem o comportamento inadequado de outros usu�rios aos moderadores.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Requer aprova��o para o envio de imagens');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Exige que todas as imagens enviadas por usu�rios sejam aprovadas antes de exibidas.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Permite que os moderadores restrinjam a publica��o de um perfil de usu�rio.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Permitir a suspens�o de perfis?');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Formato do nome');
DEFINE('_UE_DATE_FORMAT','Formato da data');
DEFINE('_UE_NAME_FORMAT_DESC','Escolha qual formato dos campos Nome/ID que deseja exibir.');
DEFINE('_UE_DATE_FORMAT_DESC','Escolha qual formato do campo Data que deseja exibir.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Marque &quot;Sim&quot; para enviar e-mail ao usu�rio avisando sobre o link de confirma��o do cadastro.');
DEFINE ('_UE_REG_CONFIRMATION','Exigir confirma��o por e-mail?');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Exigir aprova��o do Administrador?');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Exige que todo cadastro de usu�rio seja aprovado pelo Administrador');
DEFINE ('_UE_REG_EMAIL_NAME','Nome no e-mail de cadastro');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Por favor coloque seu nome como voc� quer que apare�a quando enviar e-mail');
DEFINE ('_UE_REG_EMAIL_FROM','Endere�o de e-mail de cadastro');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','Endere�o de e-mail do qual deseja enviar os avisos a cadastrantes.');
DEFINE ('_UE_REG_EMAIL_REPLYTO','Endere�o de e-mail para receber respostas aos avisos de cadastros');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','E-mail que voc� deseja como &quot;Responder para&quot;');
DEFINE ('_UE_REG_PEND_APPR_MSG','E-mail de aprova��o pendente.');
DEFINE ('_UE_REG_WELCOME_MSG','E-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_MSG','E-mail de recusa de cadastro.');
DEFINE ('_UE_REG_PEND_APPR_SUB','Assunto do e-mail.');
DEFINE ('_UE_REG_WELCOME_SUB','Assunto do e-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_SUB','Assunto do e-mail de recusa.');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Use para assunto do e-mail de aprova��o pendente.');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Use para o assunto do e-mail de boas-vindas.');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Use para assunto do e-mail de recusa.');
DEFINE ('_UE_REG_SIGNATURE','Assinatura do e-mail.');
DEFINE ('_UE_REG_ADMIN_PA_SUB','Aten��o! Cadastro de novo usu�rio com aprova��o pendente.');
DEFINE ('_UE_REG_ADMIN_PA_MSG','Um usu�rio regsitrou-se em [SITEURL] e pede aprova��o.\n'
.'Este e-mail cont�m detalhes de sua conta\n\n'
.'Nome - [NAME]\n'
.'E-mail - [EMAILADDRESS]\n'
.'ID - [USERNAME]\n\n\n'
.'Por favor, n�o responda a esta mensagem. Ela foi gerada automaticamente apenas para sua informa��o\n');
DEFINE ('_UE_REG_ADMIN_SUB','Registro de novo usu�rio');
DEFINE ('_UE_REG_ADMIN_MSG','Um novo usu�rio cadastrou-se em [SITEURL].\n'
.'Este e-mail cont�m detalhes de sua conta\n\n'
.'Nome - [NAME]\n'
.'E-mail - [EMAILADDRESS]\n'
.'ID - [USERNAME]\n\n\n'
.'Por favor, n�o responda a esta mensagem. Ela foi gerada automaticamente apenas para sua informa��o\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Nome do usu�rio.<br />'
.'[USERNAME] - ID do usu�rio.<br />'
.'[DETAILS] - Detalhes da conta do usu�rio como endere�o de e-mail, ID e senha.<br />'
.'[CONFIRM] - Insere o link de confirma��o se essa fun��o estiver habilitada.<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Sua senha foi enviada para o e-mail que voc� forneceu.<br />&nbsp;&nbsp;'
.'Voce poder� logar-se quando receber sua senha.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Agora voc� j� pode logar-se.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro necessita de aprova��o. Feito isso, sua senha ser� enviada para o e-mail que voc� forneceu.<br />&nbsp;&nbsp;'
.'Quando for notificado da aprova��o e receber uma senha, voc� poder� logar-se.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro necessita de aprova��o. Feito isso, uma notifica��o ser� enviada para o e-mail que voc� forneceu.<br />&nbsp;&nbsp;'
.'Quando for notificado da aprova��o, voce poder� logar-se.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Um e-mail com mais instru��es de como completar seu cadastro foi enviado para o e-mail que voc� forneceu.  Por favor, verifique sua caixa postal para completar seu regisro.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registro Completo!</span><br />&nbsp;&nbsp;'
.'Sua senha foi enviada para o e-mail que voc� forneceu.<br />&nbsp;&nbsp;'
.'Quando voc� receber sua senha e seguir as instru��es de confirma��o, voc� poder� logar-se.');

// User List Labels
DEFINE ('_UE_HAS','tem');
DEFINE ('_UE_USERS','usu�rios cadastrados');
DEFINE ('_UE_SEARCH_ALERT','Por favor, coloque uma express�o para a procura!');
DEFINE ('_UE_SEARCH','Achar usu�rio');
DEFINE ('_UE_ENTER_EMAIL','Coloque e-mail, nome ou ID do usu�rio');
DEFINE ('_UE_SEARCH_BUTTON','Procurar');
DEFINE ('_UE_SHOW_ALL','Exibir todos os usu�rios');
DEFINE ('_UE_NAME','Nome');
DEFINE ('_UE_UL_USERNAME','ID do usu�rio (ID)');
DEFINE ('_UE_USERTYPE','Tipo de usu�rio');
DEFINE ('_UE_VIEWPROFILE','Ver perfil');
DEFINE ('_UE_LIST_ALL','Listar todos');
DEFINE ('_UE_PAGE','P�gina');
DEFINE ('_UE_RESULTS','Resultados');
DEFINE ('_UE_OF_TOTAL','do total');
DEFINE ('_UE_NO_RESULTS','Sem resultado');
DEFINE ('_UE_FIRST_PAGE','primeira p�gina');
DEFINE ('_UE_PREV_PAGE','p�gina anterior');
DEFINE ('_UE_NEXT_PAGE','pr�xima p�gina');
DEFINE ('_UE_END_PAGE','�ltima p�gina');
DEFINE('_UE_CONTACT','Contato');
DEFINE('_UE_INSTANT_MESSAGE','Instant Message');
DEFINE('_UE_IMAGEAVAILABLE','Foto');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Perfil');
DEFINE('_UE_PRIVATE_MESSAGE','Mensagem privada');
DEFINE('_UE_ADDITIONAL','Informa��es adicionais');
DEFINE('_UE_NO_DATA','Campo vazio');
DEFINE('_UE_CLICKTOVIEW','Clique para');
DEFINE('_UE_UL_USERNAME_NAME','ID(Nome)');
DEFINE('_UE_PM','PM');
DEFINE('UE_PM_USER','Enviar mensagem privada');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','N�o tem um cadastro?');
DEFINE('_UE_CREATE_ACCOUNT','Crie um!');
DEFINE('_LOGIN_NOT_CONFIRMED','Seu cadastro ainda n�o foi completado. Verifique sua caixa postal para mais instru��es.');
DEFINE('_LOGIN_NOT_APPROVED','Sua conta ainda n�o foi aprovada!');
DEFINE('_UE_USER_CONFIRMED','Agora sua conta est� ativa. Voce j� pode logar-se!');
DEFINE('_UE_USER_NOTCONFIRMED','Sua conta ainda n�o est� ativa. Por favor, verifique sua caixa postal e siga as instru��es para completar seu cadastro.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Enviar');
DEFINE('_UE_UPLOAD_DIMENSIONS','Sua imagem pode ter no m�ximo (largura x altura - tamanho)');
DEFINE('_UE_UPLOAD_SUBMIT','Enviar uma nova imagem');
DEFINE('_UE_UPLOAD_SELECT_FILE','Selecionar arquivo');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Por favor utilize apenas imagens jpeg, jpg ou png');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Por favor, selecione um arquivo antes de enviar.');
DEFINE('_UE_UPLOAD_ERROR_NAME','O nome do arquivo pode conter apenas caracteres alfanum�ricos, sem espa�os.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','O tamanho da imagem excede o m�ximo permitido.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','A altura ou a largura da imagem excede o m�ximo permitido.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','A largura da imagem excede o permitido.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','A altura da imagem excede o permitido.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE',"Voc� n�o escolheu uma imagem da galeria.");
DEFINE('_UE_UPLOAD_UPLOADED','Sua imagem foi enviada.');
DEFINE('_UE_UPLOAD_GALLERY','Escolha uma imagem da galeria');
DEFINE('_UE_UPLOAD_CHOOSE','Confirme sua escolha.');
DEFINE('_UE_UPLOAD_UPDATED','Sua imagem foi habilitada.');
DEFINE('_UE_USER_PROFILE_NOT','Seu perfil n�o p�de ser atualizado.');
DEFINE('_UE_USER_PROFILE_UPDATED','Seu perfil foi atualizado.');
DEFINE('_UE_USER_RETURN_A','Se voc� n�o for redirecionado de volta para seu perfil em poucos instantes ');
DEFINE('_UE_USER_RETURN_B','clique aqui.');
DEFINE('_UPDATE','Atualizar');

//Moderator
DEFINE('_UE_USERPROFILEBANNED','Este perfil foi suspenso por um moderador.');
DEFINE('_UE_REQUESTUNBANPROFILE','Enviar solicita��o de reabilita��o de perfil');
DEFINE('_UE_REPORTUSER','Relatar usu�rio');
DEFINE('_UE_BANPROFILE','Suspender perfil');
DEFINE('_UE_UNBANPROFILE','Reabilitar perfil');
DEFINE('_UE_REPORTUSER_TITLE','Relat�rio de usu�rio');
DEFINE('_UE_USERREASON','Motivo do relat�rio');
DEFINE('_UE_BANREASON','Motivo da suspens�o');
DEFINE('_UE_SUBMITFORM','Enviar');
DEFINE('_UE_NOUNBANREQUESTS','Nenhuma solicita��o de cancelamento de suspen��o para processar.');
DEFINE('_UE_BANREASON','Motivo para a suspens�o');
DEFINE('_UE_IMAGE_MODERATE','Ver imagens para Modera��o');
DEFINE('_UE_APPROVE_IMAGES','Aprovar imagem');
DEFINE('_UE_REJECT_IMAGES','Recusar imagem');
DEFINE('_UE_MODERATE_TITLE','Moderador');
DEFINE('_UE_NOIMAGESTOAPPROVE','Nenhuma imagem para aprovar');
DEFINE('_UE_USERREPORT_MODERATE','Modera��o de relat�rios de usu�rio');
DEFINE('_UE_REPORTEDUSER','Usu�rio relatado');
DEFINE('_UE_REPORT','Relat�rio');
DEFINE('_UE_REPORTEDONDATE','Data do relat�rio');
DEFINE('_UE_REPORTEDUSER','Usu�rio relatado');
DEFINE('_UE_REPORTEDBY','Relatado por');
DEFINE('_UE_PROCESSUSERREPORT','Processar');
DEFINE('_UE_NONEWUSERREPORTS','Nenhum novo relat�rio de usu�rio');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Perfil reabilitado com sucesso.');
DEFINE('_UE_REPORTUSERSACTIVITY','Descrever atividade do usu�rio');
DEFINE('_UE_USERREPORT_SUCCESSFUL','Relat�rio de usu�rio enviado com sucesso.');
DEFINE('_UE_USERBAN_SUCCESSFUL','Perfil de usu�rio suspenso com sucesso.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','Esta fun��o est� desabilitada.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Sua imagem est� aguardando aprova��o de um moderador.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Sua imagem foi enviada com sucesso.');
DEFINE('_UE_UNBANREQUEST','Solicita��o de cancelamento de suspen��o');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Sua solicita��o de cancelamento de suspen��o foi enviada com sucesso.');
DEFINE('_UE_USERREPORT','Relat�rio de usu�rio');
DEFINE('_UE_VIEWUSERREPORTS','Ver relat�rios de usu�rio');
DEFINE('_UE_USERREQUESTRESPONSE','Ver r�plica do usu�rio');
DEFINE('_UE_MODERATORREQUESTRESPONSE','Ver resposta do moderador');
DEFINE('_UE_REPORTBAN_TITLE','Relat�rio de suspens�o');
DEFINE('_UE_REPORTUNBAN_TITLE','Relat�rio de reabilita��o');

DEFINE('_UE_UNBANREQUIREACTION',' Solicita��o de reabilita��o');
DEFINE('_UE_USERREPORTSREQUIREACTION','Relat�rios de usu�rio');
DEFINE('_UE_IMAGESREQUIREACTION','Imagem(s)');
DEFINE('_UE_NOACTIONREQUIRED','Sem pend�ncias');

DEFINE('_UE_UNBAN_MODERATE','Pedidos de reabilita��o de perfis');
DEFINE('_UE_BANNEDUSER','Usu�rio suspenso');
DEFINE('_UE_BANNEDREASON','Raz�o da suspens�o');
DEFINE('_UE_BANNEDON','Data da suspens�o');
DEFINE('_UE_BANNEDBY','Suspenso por');

DEFINE('_UE_MODERATORBANRESPONSE','Resposta do moderador');
DEFINE('_UE_USERBANRESPONSE','Resposta do usu�rio');

DEFINE('_UE_IMAGE_ADMIN_SUB','Aprova��o de imagem pendente');
DEFINE('_UE_IMAGE_ADMIN_MSG','Um usu�rio enviou uma imagem para avalia��o. Por favor, tome as medidas apropriadas.');
DEFINE('_UE_USERREPORT_SUB','Revis�o de relat�rio de usu�rio pendente');
DEFINE('_UE_USERREPORT_MSG','Um usu�rio enviou um relat�rio que precisa de sua revis�o. Por favor, conecte-se e tome as medidas apropriadas.');
DEFINE('_UE_IMAGEAPPROVED_SUB','Imagem aprovada');
DEFINE('_UE_IMAGEAPPROVED_MSG','Sua imagem foi aprovada por um moderador.');
DEFINE('_UE_IMAGEREJECTED_SUB','Imagem rejeitada');
DEFINE('_UE_IMAGEREJECTED_MSG','Sua imagem foi rejeitada por um moderador. Por favor, envie outra.');
DEFINE('_UE_BANUSER_SUB','Perfil de usu�rio suspenso.');
DEFINE('_UE_BANUSER_MSG','Seu perfil foi suspenso por um administrador. Por favor, conecte-se e verifique por que foi suspenso.');
DEFINE('_UE_UNBANUSER_SUB','Perfil reabilitado');
DEFINE('_UE_UNBANUSER_MSG','Seu perfil foi reaabilitado por um administrador e est� vis�vel para todos os outros usu�rios novamente.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Pedido de reabilita��o dependendo de revis�o');
DEFINE('_UE_UNBANUSERREQUEST_MSG','Um usu�rio solicitou a reabilita��o de seu perfil. Por favor, tome as medidas apropriadas.');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Thumbnail');
DEFINE('_UE_FORMATNAME','Nome formatado');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Campos obrigat�rios pelo Admin.');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Marque &quot;Sim&quot; para que o &quot;Admin. de Usu�rios&quot; respeite as exig�ncias de preenchimento definidas para os campos e &quot;N�o&quot; para ignorar essas exig�ncias.');
DEFINE('_UE_CANCEL','Cancelar');
DEFINE('_UE_NA','Nenhuma');
DEFINE('_UE_MODERATOREMAIL','Enviar e-mail para moderadores?');
DEFINE('_UE_MODERATOREMAIL_DESC','Se &quot;SIM&quot;, os moderadores receber�o e-mail quando for necess�ria sua interven��o.');

//Beta 1 Build
DEFINE('_UE_UPDATE','Atualizar');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','Vis�vel no Perfil');
DEFINE('_UE_FIELDNOPROFILE','Invis�vel no Perfil');
DEFINE('_UE_FIELDREQUIRED','Campo obrigat�rio');
DEFINE('_UE_NOT_AUTHORIZED','Voc� n�o tem autoriza��o para ver esta p�gina!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Permitido o acesso por:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','Escolha o grupo que voc� deseja que possa ver a lista. Todos os usu�rios desse grupo e dos n�veis listados abaixo v�o ter o mesmo acesso.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Permitido o acesso por:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC',' Escolha o grupo que voc� deseja que possa ver os prefis. Todos os usu�rios desse grupo e dos n�veis listados abaixo v�o ter o mesmo acesso.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','N�o existem listas publicadas!');
DEFINE('_UE_ALLOW_PROFILELINK','Permitir link para o perfil?');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Marque &quot;SIM&quot; para permitir que cada linha da lista  seja o link para o perfil do usu�rio e &quot;N�O&quot; para evitar isso.');
DEFINE('_UE_REGISTERFORPROFILE','Por favor, logue-se ou cadastre-se para ver ou alterar seu perfil.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','O GD2 Image Library n�o est� instalado ou n�o foi compilado adequadamente para  PHP! Por favor, notifique o administrador do seu sistema para desabilitar o Ajuste Autom�tico de Imagens.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','Ocorreu um erro ao enviar ou processar a imagem!');
DEFINE('_UE_TOC','Aceitar os Termos e Condi��es');
DEFINE('_UE_TOC_REQUIRED','Voc� tem de aceitar os Termos e Condi��es antes de efetuar seu cadastro!');
DEFINE('_UE_REG_TOC_MSG','Habilitar os Termos e Condi��es');
DEFINE('_UE_REG_TOC_DESC','Marque &quot;SIM&quot; para exigir que seus usu�rios tenham que aceitar o Termos e Condi��es antes de efetuar o cadastro!');
DEFINE('_UE_REG_TOC_URL_MSG','URL para Termos e Condi��es');
DEFINE('_UE_REG_TOC_URL_DESC','Entre com a URL para os Termos e Condi��es. Ela deve ser relativa � raiz do seu site Mambo.');
DEFINE('_UE_LASTUPDATEDON','�ltima atualiza��o');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','IMPORTANTE: Seu e-mail ser� conhecido por quem receber a mensagem que voc� enviar.');
DEFINE('_UE_EMAILFORMSUBJECT','Assunto:');
DEFINE('_UE_EMAILFORMMESSAGE','Mensagem:');
DEFINE('_UE_EMAILFORMINSTRUCT','Enviar mensagem por e-mail para <a href="index.php?option=com_cbe&task=UserDetails&user=%s">%s </a>.');
DEFINE('_UE_GENERAL','Geral');
DEFINE('_UE_SENDEMAILNOTICE','ATEN��O: Essa � uma mensagem de %s at %s ( %s ).  Esse usu�rio n�o viu seu endere�o de e-mail, mas se voc� responder a esta mensagem, ela conter� seu endere�o. %s propriet�rios n�o se responsabilizar�o pelo conte�do das mensagens.');
DEFINE('_UE_SENDEMAIL','Enviar e-mail');
DEFINE('_UE_SENTEMAILSUCCESS','E-mail enviado com sucesso!');
DEFINE('_UE_SENTEMAILFAILED','Falha ao enviar seu e-mail!  Tente de novo, por favor.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','O e-mail est� sendo enviado');
DEFINE('_UE_REGISTERDATE','Data');
DEFINE('_UE_ACTION','A��o');
DEFINE('_UE_USER','Usu�rio');
DEFINE('_UE_USERAPPROVAL_MODERATE','Aprova��o/rejei��o de usu�rio');
DEFINE('_UE_USERPENDAPPRACTION',' Usu�rio(s)');
DEFINE('_UE_APPROVEUSER','Processar usu�rios(s)');
DEFINE('_UE_REG_REJECT_SUB','Sinto muito , seu cadastro foi rejeitado!');
DEFINE('_UE_USERREJECT_MSG','Seu cadastro foi rejeitado pelo seguinte motivo: \n %s');
DEFINE('_UE_COMMENT','Coment�rio ');
DEFINE('_UE_APPROVE','Aprovado');
DEFINE('_UE_REJECT','Rejeitado');
DEFINE('_UE_USERREJECT_SUCCESSFUL','Esse grupo de usu�rios foi devidamente rejeitado!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','Esse grupo de usu�rios foi devidamente aprovado!');
DEFINE('_LOGIN_REJECTED','Seu pedido de cadastro foi rejeitado!');
DEFINE('_UE_EMAILFOOTER','ATEN��O: Este e-mail foi gerado automaticamente por %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Aprova��o de usu�rios por moderador');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','Essa configura��o permite que os moderadores aprovem cadastros de usu�rios pendentes pela frente do site.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Pedido de cadastro completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro definitivo requer aprova��o e confirma��o por e-mail. Por favor, siga os passo indicados no e-mail que voc� vai receber em breve. Quando aprovado, voc� vai ser notificado pelo endere�o de e-mai que voc� forneceu.<br />&nbsp;&nbsp;'
.'Quando voc� receber a notifica��o de aprova��o, voc� vai poder logar-se.');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Pedido de cadastro completo!</span><br />&nbsp;&nbsp;'
.'Seu cadastro definitivo requer aprova��o e confirma��o por e-mail. Por favor, siga os passo indicados no e-mail que voc� vai receber em breve. <br />&nbsp;&nbsp;'
.'Quando voc� receber por e-mail a notifica��o de aprova��o, voc� vai receber uma senha com a qual vai poder logar-se.');
DEFINE('_UE_NAME_STYLE','Estilo dos Nomes');
DEFINE('_UE_NAME_STYLE_DESC','O Estilo dos Nomes detalha a maneira como voc� deseja que seja o preenchimento dos campos  dos nomes pelos usu�rios, no cadastro.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Obrigado por voc� ter confirmado seu endere�o de e-mail. Seu cadastro definitivo requer avalia��o e aprova��o de um moderador. Voc� receber� um e-mail com o resultado dessa avalia��o.');
DEFINE('_UE_YOUR_FNAME','Primeiro nome');   
DEFINE('_UE_YOUR_MNAME','Nome do meio');
DEFINE('_UE_YOUR_LNAME','�ltimo nome');


//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Configura��es do forum');
DEFINE('_UE_SB_TABDESC','Essas s�o suas configura��es do forum');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Modo de vis�o');
DEFINE('_UE_SB_VIEWTYPE_FLAT','Plano');
DEFINE('_UE_SB_VIEWTYPE_THREADED','Hier�rquico');
DEFINE('_UE_SB_ORDERING_TITLE','Modo de organiza��o das postagens');
DEFINE('_UE_SB_ORDERING_OLDEST','Mais velhas primeiro');
DEFINE('_UE_SB_ORDERING_LATEST','Mais novas primeiro');
DEFINE('_UE_SB_SIGNATURE','Assinatura');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','Sem imagem');
DEFINE('_UE_IMG_PENDIMG','Aprova��o pendente');

?>