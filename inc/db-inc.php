<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
// MySQL aceess parameters
//$db_host			= "idl-mysql-01";
//$db_user			= "agrotend";
//$db_password		= "vA7tMkl6Tk680qtsfNYl";
//$db_database		= "agrotend";
$db_host			= "localhost";
//$db_user			= "agrotender_site";
//$db_password		= "sTexTgEm7q";
//$db_database		= "agrotender_site";
$db_user			= "root";
$db_password		= "root";
$db_database		= "agrotender";
$db_preffix			= "agt_";

// Default host name, used in links
if ( $_SERVER['SERVER_NAME'] == 'localhost' )
{
    $WWWHOST						= "/";
    $IMGHOST						= "/";
    $PICHOST						= "/";
}
else
{
    $WWWHOST						= "https://agrotender.com.ua/";
    $IMGHOST						= "https://agrotender.com.ua/";
    $PICHOST						= "https://agrotender.com.ua/";
}

$WWWNAMERU	= "Агротендер";
$WWWNAMEEN	= "Agrotender";

// Link style in urls
$WWW_LINK_MODE 					= "html";	// "php" or "html"
$DEF_ENC						= "UTF-8";//"UTF-8";

$DEBUG_ON						= false;

$AUTHMEMNAME = "ATGUID";
$MODERMEMID = "MODERCOMPU";

$RECAPTCHA_PUBLIC	= '6LfkrxMUAAAAAPXOjRlZvei0SoTd7RIgHx1l0ge5';
$RECAPTCHA_SECRET	= '6LfkrxMUAAAAAFVyDzOF55p07hIRNCKGxNEfGTp3';
$RECAPTCHA_URL		= 'https://www.google.com/recaptcha/api/siteverify';

$UHCMS_SMS_EPOSHTA				= true;

// ?????????????????
//$PREFIX							= $db_preffix;

////////////////////////////////////////////////////////////////////////////////
// Database tables

// Basic page functionality
$TABLE_USER_GROUPS				= $db_preffix."user_groups";
$TABLE_USERS					= $db_preffix."users";
$TABLE_USER_AUTH				= $db_preffix."user_auth";

$TABLE_LANGS					= $db_preffix."langs";

$TABLE_PAGES					= $db_preffix."pages";
$TABLE_PAGES_LANGS				= $db_preffix."pages_lang";
$TABLE_PAGE_PHOTO				= $db_preffix."pages_photo";
$TABLE_PAGE_PHOTO_LANGS			= $db_preffix."pages_photo_langs";
$TABLE_PAGE_RESOURCES			= $db_preffix."pages_resassign";
$TABLE_PAGE_VIDEO				= $db_preffix."page_video";
$TABLE_PAGE_VIDEO_LANGS			= $db_preffix."page_video_lang";

$TABLE_RESOURCE					= $db_preffix."resource";
$TABLE_RESOURCE_LANGS			= $db_preffix."resource_lang";

$TABLE_SITE_OPTIONS				= $db_preffix."contact_options";
$TABLE_SLIDES					= $db_preffix."slides";
$TABLE_PREFERENCES				= $db_preffix."preferences";

$TABLE_BANNERS					= $db_preffix."banners";
$TABLE_BANNERS_LANGS			= $db_preffix."banners_lang";

$TABLE_BANNER_PLACES			= $db_preffix."banner_places";
$TABLE_BANNER_ROTATE			= $db_preffix."banner_rotate";

// Country module
$TABLE_CONTINENT				= $db_preffix."continent";
$TABLE_COUNTRY					= $db_preffix."country";
$TABLE_COUNTRY_LANG				= $db_preffix."country_lang";
$TABLE_CITY						= $db_preffix."city";
$TABLE_CITY_LANG				= $db_preffix."city_lang";

$TABLE_RAYON					= $db_preffix."rayon";
$TABLE_RAYON_LANGS				= $db_preffix."rayon_lang";

// -------------------------------  Modules ------------------------------------
// Staff work
$TABLE_STAFF_GROUP				= $db_preffix."staff_group";
$TABLE_STAFF_GROUP_LANGS		= $db_preffix."staff_group_lang";
$TABLE_STAFF					= $db_preffix."staff";

// News
$TABLE_NEWS						= $db_preffix."news";
$TABLE_NEWS_LANGS				= $db_preffix."news_lang";
$TABLE_NEWS_COMMENT				= $db_preffix."news_comment";
$TABLE_NEWS_COMMENT_LANGS		= $db_preffix."news_comment_lang";
$TABLE_NEWS_RATE				= $db_preffix."news_rate";

$TABLE_BLNEWS					= $db_preffix."blacknews";
$TABLE_BLNEWS_LANGS				= $db_preffix."blacknews_lang";
$TABLE_BLNEWS_COMMENT			= $db_preffix."blacknews_comment";
$TABLE_BLNEWS_COMMENT_LANGS		= $db_preffix."blacknews_comment_lang";
$TABLE_BLNEWS_RATE				= $db_preffix."blacknews_rate";

// Awards and certificates
$TABLE_AWARDS					= $db_preffix."awards";
$TABLE_AWARDS_LANGS				= $db_preffix."awards_lang";

// Partners or usefull links
$TABLE_LINKS					= $db_preffix."partner_links";
$TABLE_LINKS_LANGS				= $db_preffix."partner_links_lang";

// Vacancy
$TABLE_VACANCY					= $db_preffix."vacancy";

// Faq
$TABLE_FAQ_GROUP				= $db_preffix."faq_group";
$TABLE_FAQ_GROUP_LANGS			= $db_preffix."faq_group_lang";
$TABLE_FAQ						= $db_preffix."faq";
$TABLE_FAQ_LANGS				= $db_preffix."faq_lang";
$TABLE_FAQ_ASSIGN				= $db_preffix."faq_assign";

// Our office adresses
$TABLE_OFFICES					= $db_preffix."offices";
$TABLE_OFFICES_LANG				= $db_preffix."offices_lang";

// photo galery
$TABLE_GALERY					= $db_preffix."galery_items";
$TABLE_GALERY_LANGS				= $db_preffix."galery_items_lang";
$TABLE_GALERY_PHOTO				= $db_preffix."galery_photos";
$TABLE_GALERY_PHOTO_LANGS		= $db_preffix."galery_photos_lang";

//$TABLE_TECHNOLOGY				= $db_preffix."technology";
//$TABLE_TECHNOLOGY_LANGS			= $db_preffix."technology_lang";

//$TABLE_USEFUL					= $db_preffix."useful";
//$TABLE_USEFUL_LANGS				= $db_preffix."useful_lang";

//$TABLE_ARTICLES					= $db_preffix."article";
//$TABLE_ARTICLES_LANGS			= $db_preffix."article_lang";

//$TABLE_FEEDBACK_LIST			= $db_preffix."feedlist";
//$TABLE_FEEDBACK_LIST_LANGS		= $db_preffix."feedlist_lang";

// Quest List Tables
//$TABLE_QUEST_GROUP				= $db_preffix."quest_group";
//$TABLE_QUEST_GROUP_LANGS		= $db_preffix."quest_group_langs";
//$TABLE_QUEST_ITEMS				= $db_preffix."quest_items";
//$TABLE_QUEST_ITEMS2PAGE			= $db_preffix."quest_items2page";

//Comment List Table
//$TABLE_COMMENT					= $db_preffix."comment";
//$TABLE_COMMENT_LANGS			= $db_preffix."comment_lang";

//------------------------------ Torg ---------------------------------------
// Tender Torgi
$TABLE_TORG_PROFILE				= $db_preffix."torg_profile";
$TABLE_TORG_PROFILE_LANGS		= $db_preffix."torg_profile_lang";
$TABLE_TORG_CATALOG				= $db_preffix."torg_rayon";
$TABLE_TORG_CATALOG_LANGS		= $db_preffix."torg_rayon_lang";
$TABLE_TORG_ITEMS				= $db_preffix."torg_item";
$TABLE_TORG_ITEMS_LANGS			= $db_preffix."torg_item_lang";
$TABLE_TORG_ITEMS_PICS			= $db_preffix."torg_item_pics";
$TABLE_TORG_ITEMS_COMMENT		= $db_preffix."torg_item_comment";
$TABLE_TORG_ITEMS_COMMENT_LANGS	= $db_preffix."torg_item_comment_lang";
$TABLE_TORG_ITEMS_RATE			= $db_preffix."torg_item_rate";
$TABLE_TORG_ITEM2RAY			= $db_preffix."torg_item2rayon";
$TABLE_TORG_ITEM2ELEV			= $db_preffix."torg_item2elev";
$TABLE_TORG_CATITEMS			= $db_preffix."torg_sectitem";
$TABLE_TORG_PARAM_DISP_TYPE		= $db_preffix."torg_param_type";
$TABLE_TORG_GROUP_PARAM			= $db_preffix."torg_param_group";
$TABLE_TORG_GROUP_PARAM_LANGS	= $db_preffix."torg_param_group_lang";
$TABLE_TORG_PARAMS				= $db_preffix."torg_param";
$TABLE_TORG_PARAMS_LANGS		= $db_preffix."torg_param_lang";
$TABLE_TORG_PROFILE_PARAMS		= $db_preffix."torg_profile_param";
$TABLE_TORG_PARAM_OPTIONS		= $db_preffix."torg_option";
$TABLE_TORG_PARAM_OPTIONS_LANGS	= $db_preffix."torg_option_lang";
$TABLE_TORG_PARAM_VALUES		= $db_preffix."torg_param_value";
$TABLE_TORG_PARAM_VALUES_OPTS	= $db_preffix."torg_param_valopt";
$TABLE_TORG_MAIN_PARAMS			= $db_preffix."torg_param_main";
$TABLE_TORG_BIDS				= $db_preffix."torg_bids";

$TABLE_TORG_ELEV				= $db_preffix."torg_elevator";
$TABLE_TORG_ELEV_LANGS			= $db_preffix."torg_elevator_lang";

$TABLE_TORG_BUYERS				= $db_preffix."torg_buyer";
$TABLE_TORG_BUYER_ADDR			= $db_preffix."torg_buyer_addr";
$TABLE_TORG_BUYER_AUTH			= $db_preffix."torg_buyer_auth";
$TABLE_TORG_BUYER_BAN			= $db_preffix."torg_buyer_ban";
$TABLE_TORG_BUYERS_MODERATORS	= $db_preffix."torg_buyer_moder";
$TABLE_TORG_BUYERS_MODERATORS_OBL= $db_preffix."torg_buyer_moder_obl";
$TABLE_TORG_BUYERS_PHONES		= $db_preffix."torg_buyer_phones";

$TABLE_REPHONE_CALLBACK			= $db_preffix."reqest_callback";

$TABLE_TORG_SEARCH				= $db_preffix."torg_search_cache";
$TABLE_TORG_TITLES				= $db_preffix."torg_seo_titles";

$TABLE_TORG_REL2REL				= $db_preffix."torg_rel2rel";

$TABLE_ADV_TGROUPS				= $db_preffix."adv_torg_tgroups";
$TABLE_ADV_TOPIC				= $db_preffix."adv_torg_topic";
$TABLE_ADV_POST					= $db_preffix."adv_torg_post";
$TABLE_ADV_POST_PICS			= $db_preffix."adv_torg_post_pics";
$TABLE_ADV_POST_UPS				= $db_preffix."adv_torg_post_ups";
$TABLE_ADV_POST2OBL				= $db_preffix."adv_torg_post_2obl";
$TABLE_ADV_POST_RATE			= $db_preffix."adv_torg_post_rate";
$TABLE_ADV_POST_MODER_MSG		= $db_preffix."adv_torg_post_modermsg";

$TABLE_ADV_TOPIC_POSTNUM		= $db_preffix."adv_torg_topic_postnum";
$TABLE_ADV_TOPIC_POSTNUM_RUNS	= $db_preffix."adv_torg_topic_postnum_runs";

$TABLE_ADV_POST_COMPLAINS		= $db_preffix."adv_torg_post_complains";

$TABLE_ADV_TAGS					= $db_preffix."adv_tags";
$TABLE_ADV_TAGS_RATE			= $db_preffix."adv_tags_rate";
$TABLE_ADV_TAGS_2POST			= $db_preffix."adv_tags_2post";

$TABLE_ADV_SEARCH				= $db_preffix."adv_search";
$TABLE_ADV_WORDCROSS			= $db_preffix."adv_word2topic";

$TABLE_TRADER					= $db_preffix."traders";
$TABLE_TRADER_LANGS				= $db_preffix."traders_lang";
$TABLE_TRADER_PRICES			= $db_preffix."traders_price";

$TABLE_TRADER_COMMENT			= $db_preffix."traders_comment";
$TABLE_TRADER_COMMENT_LANGS		= $db_preffix."traders_comment_lang";
$TABLE_TRADER_RATE				= $db_preffix."traders_rate";

$TABLE_TRADER_PR_CULTS			= $db_preffix."traders_products";
$TABLE_TRADER_PR_CULTS_LANGS	= $db_preffix."traders_products_lang";
$TABLE_TRADER_PR_CULTS2BUYER	= $db_preffix."traders_products2buyer";
$TABLE_TRADER_PR_PLACES			= $db_preffix."traders_places";
$TABLE_TRADER_PR_PRICES			= $db_preffix."traders_prices";
$TABLE_TRADER_PR_PRICESARC		= $db_preffix."traders_prices_arc";
$TABLE_TRADER_PR_REPORTCOLS		= $db_preffix."traders_price_reports";

$TABLE_TRADER_PR_PORTS			= $db_preffix."traders_ports";
$TABLE_TRADER_PR_PORTS_LANGS	= $db_preffix."traders_ports_lang";
$TABLE_TRADER_PR_PORTS2BUYER	= $db_preffix."traders_ports2buyer";

$TABLE_TRADER_PR_CULT_GROUPS	= $db_preffix."traders_product_groups";
$TABLE_TRADER_PR_CULT_GROUPS_LANGS= $db_preffix."traders_product_groups_lang";

$TABLE_TRADER_PR_CONTACTS		= $db_preffix."traders_contacts"; 
$TABLE_TRADER_PR_CONTACTS_REGS	= $db_preffix."traders_contacts_regions";

$TABLE_TRADER_PR_FILTERS		= $db_preffix."traders_filters"; 

$TABLE_TRADER_TYPES				= $db_preffix."traders_types";
$TABLE_TRADER_TYPES2ITEMS		= $db_preffix."traders_types2items";

$TABLE_COMPANY_TGROUPS			= $db_preffix."comp_tgroups";
$TABLE_COMPANY_TOPIC			= $db_preffix."comp_topic";
$TABLE_COMPANY_ITEMS			= $db_preffix."comp_items";
$TABLE_COMPANY_ITEM_PICS		= $db_preffix."comp_item_pics";
$TABLE_COMPANY_ITEMS2TOPIC		= $db_preffix."comp_item2topic";
//$TABLE_ADV_POST_UPS				= $db_preffix."adv_torg_post_ups";
$TABLE_COMPANY_COMMENT			= $db_preffix."comp_comment";
$TABLE_COMPANY_COMMENT_LANGS	= $db_preffix."comp_comment_lang";
$TABLE_COMPANY_RATE				= $db_preffix."comp_rate";
$TABLE_COMPANY_RATE_DATETMP		= $db_preffix."comp_rate_byday";
$TABLE_COMPANY_COMMENT_LIKES	= $db_preffix."comp_comment_likes";
$TABLE_COMPANY_COMMENT_COMPLAINS= $db_preffix."comp_comment_complains";

$TABLE_COMPANY_CONTACTS			= $db_preffix."comp_items_contact";

$TABLE_COMPANY_NEWS				= $db_preffix."comp_news";
$TABLE_COMPANY_VACANCY			= $db_preffix."comp_vacancy";
$TABLE_COMPANY_ADVTOPICS		= $db_preffix."comp_cabadvtopics";
$TABLE_COMPANY_POST2ADVTOPICS 	= $db_preffix."comp_cabadv2ctopic";
$TABLE_COMPANY_STARTPAGE		= $db_preffix."comp_startpage_cfg";
$TABLE_COMPANY_STARTPAGE_BLKLIST= $db_preffix."comp_startpage_blks";

$TABLE_SUBSCRIPTION				= $db_preffix."subscription";

$TABLE_LENTA					= $db_preffix."lenta";
$TABLE_FISHKA					= $db_preffix."fishka";

$TABLE_BUYER_PACKS				= $db_preffix."buyer_tarif_packs";
$TABLE_PAYED_PACK_ORDERS		= $db_preffix."buyer_packs_orders";
$TABLE_TORG_BUYERS_BALANCE		= $db_preffix."buyer_balance";

$TABLE_TORG_MSNGR				= $db_preffix."messenger";
$TABLE_TORG_MSNGR_P2P			= $db_preffix."messenger_p2p";

$TABLE_SMS_SEND					= $db_preffix."sms_log";

$TABLE_BUYER_SUBSCR_TRPR		= $db_preffix."traders_subscr";

$TABLE_POPUP					= $db_preffix."popup_dlgs";
$TABLE_POPUP_LANGS				= $db_preffix."popup_dlgs_lang";
$TABLE_POPUP_VIEWS				= $db_preffix."popup_dlgs_views";

$TABLE_SEO_TITLES				= $db_preffix."seo_titles";

$TABLE_LIQP_LOG					= $db_preffix."lp_log";

$TABLE_PAY_ACTIONS				= $db_preffix."py_actions";
$TABLE_PAY_BALANCE_OPER			= $db_preffix."py_balance";
$TABLE_PAY_BILL					= $db_preffix."py_bill";
$TABLE_PAY_BILL_DOC				= $db_preffix."py_bill_doc";
$TABLE_PAY_BILL_OOO				= $db_preffix."py_bill_firm";
$TABLE_PAY_BILL_ADDR			= $db_preffix."py_bill_addr";

////////////////////////////////////////////////////////////////////////////////
// Payed period types
$PAYED_PERIOD_TYPE = Array("0" => "День", "1" => "Месяц", "2" => "Год");


////////////////////////////////////////////////////////////////////////////////
// Other basic presets
$NEWS_ALL = -1;
$NEWS_UKR = 0;
$NEWS_WORLD = 1;
$NEWS_OTHER = 2;
$NEWS_SITE = 3;

$NEWS_TYPES = Array("Новости Украины", "Новости мира", "Другие новости", "Новости сайта");
$NEWS_URLS = Array("ukraine", "world", "other", "our");

////////////////////////////////////////////////////////////////////////////////
// Stat basic presets
$VIEWSTAT_COMP	= 0;
$VIEWSTAT_CONT	= 1;
$VIEWSTAT_ADVS	= 2;
$VIEWSTAT_ACTS	= 3;
$VIEWSTAT_PRICE_COMP= 4;
$VIEWSTAT_PRICE_TBL	= 5;
$VIEWSTAT_PRICE2_COMP= 6;
$VIEWSTAT_PRICE2_TBL= 7;

$CCAB_BLK_ABOUT		= 1;
$CCAB_BLK_CONTACTS	= 2;
$CCAB_BLK_GOODS		= 3;
$CCAB_BLK_BUYS		= 4;
$CCAB_BLK_SERV		= 5;
$CCAB_BLK_NEWS		= 6;
$CCAB_BLK_VAC		= 7;
$CCAB_BLK_TENDERS	= 8;
$CCAB_BLK_COMMENT	= 9;
$CCAB_BLK_ALLADVS	= 0;

$BOARD_MAX_UPS = 5;

$FISHKA_UPDATE		= 4;	// Каждые четыре часа
$FISHKA_LIVE		= 24;	// Срок дейтствия фишки 24 часа

$LENTA_TPOSTBUY = 1;
$LENTA_TPOSTSELL = 2;
$LENTA_TPOSTSERV = 3;
$LENTA_TNEWCOMP = 4;
$LENTA_TNEWNEWS = 5;
$LENTA_TNEWVAC = 6;
$LENTA_TNEWCOST = 7;		// Закупочные цены трейдеров обновлены
$LENTA_TNEWCOSTSELL = 8;	// Продажные цены трейдеров обновлены

$LENTA_ALL = -1;
$LENTA_SIMPLE = 0;
$LENTA_TRADER = 1;

$TRADER_PLACE_ELEV		= 0;
$TRADER_PLACE_OLDPORT	= 1;
$TRADER_PLACE_PORT		= 2;

$BOARD_PTYPE_MAIN = -1;
$BOARD_PTYPE_ALL = 0;
$BOARD_PTYPE_BUY = 1;
$BOARD_PTYPE_SELL = 2;
$BOARD_PTYPE_SERV = 3;

$BOART_PTYPE_STR = Array("", "Куплю", "Продам", "Услуга");

$COMP_CONT_MAIL 	= $BOARD_PTYPE_MAIN;
$COMP_CONT_ALL 		= $BOARD_PTYPE_ALL;
$COMP_CONT_BUY 		= $BOARD_PTYPE_BUY;
$COMP_CONT_SELL 	= $BOARD_PTYPE_SELL;
$COMP_CONT_SERV 	= $BOARD_PTYPE_SERV;
$COMP_CONT_TRADER 	= 4;

$COMP_ADV_TYPES = Array("", "Закупки", "Товары", "Услуги");

$BOARD_UP_PERIOD	= 7;

$BOARD_UTYPE_ANONIM = 0;
$BOARD_UTYPE_USER = 1;
$BOARD_UTYPE_COMP = 2;

$BOARD_LIMITS = Array(
	$BOARD_UTYPE_ANONIM => Array("maxpost" => 5, "maxpostarc" => 0, "maxups" => 5, "upsfpd" => 7),
	$BOARD_UTYPE_USER => Array("maxpost" => 30, "maxpostarc" => 50, "maxups" => 1000000, "upsfpd" => 1),
	$BOARD_UTYPE_COMP => Array("maxpost" => 30, "maxpostarc" => 50, "maxups" => 1000000, "upsfpd" => 1)
);

$CURRENCY_NAMES = Array("grn" => "Грн.", "usd" => "USD", "eur" => "EUR");
$CURRENCY_IDS = Array("grn" => 0, "usd" => 1, "eur" => 2);
$CURRENCY_BYID = Array( 0 => "grn", 1 => "usd", 2 => "eur");

$MSNGR_STATUS_NEW = 0;
$MSNGR_STATUS_DECLINED = -1;
$MSNGR_STATUS_APPROVED = 1;

$MSNGR_MAX_PROPOSALS = 5;
$MSNGR_MAX_ERROR = "Вы превысили лимит предложений. Вы не можете одновременно поддерживать более {MAX_PROP} текущих предложений. Подтвердите продажу уже размещенных объемов или удалите не актуальные.";

$SEO_PAGETYPE_BOARD	= 0;
$SEO_PAGETYPE_COMP	= 1;
$SEO_PAGETYPE_TRADER= 2;

$REKL_UP_DBID = 13;

$BILLING_PAYMETH_P24	= 1;
$BILLING_PAYMETH_CARD	= 2;
$BILLING_PAYMETH_BILL	= 3;
$BILLING_PAYMETH_STR	= Array("", "Приват 24", "Карта", "По счету");

$BILLING_PAY_OPER_ALL	= -1;
$BILLING_PAY_OPER_DEBIT = 0;
$BILLING_PAY_OPER_KREDIT = 1;
//$BILLING_PAY_OPER_STR	= Array("Дебит", "Кредит");
$BILLING_PAY_OPER_STR	= Array("Списание", "Пополнение");

$BILLING_PACK_ALL		= -1;
$BILLING_PACK_POSTNUM	= 0;
$BILLING_PACK_POSTTOP	= 1;
$BILLING_PACK_POSTUP	= 2;
$BILLING_PACK_POSTCOLOR	= 3;
$BILLING_PACK_STR		= Array(-1 => "Все", 0 => "Количество объявлений", 1 => "Объявление в топ", 2 => "UP Объявления", 3 => "Выделение цветом");

$BILLING_FIRM_FOP	= 0;
$BILLING_FIRM_OOO	= 1;
$BILLING_FIRM_STR	= Array("Физ. лицо", "Юр. лицо");

$BILLING_STATUS_CANCEL		= -1;
$BILLING_STATUS_NEW			= 0;
$BILLING_STATUS_HOLD		= 1;
$BILLING_STATUS_PROCESSED	= 2;
$BILLING_STATUS_DONE		= 3;
$BILLING_STATUS_STR		= Array(-1 => "Отменен", 0 => "Новый", 1 => "Приостановлен", 2 => "В обработке", 3 => "Выполнен");

$BILLING_DOCTYPE_ALL	= -1;
$BILLING_DOCTYPE_BILL	= 0;
$BILLING_DOCTYPE_AKT	= 1;
$BILLING_DOCTYPE_SCAN	= 2;
$BILLING_DOCTYPE_STR	= Array(-1 => "Все", 0 => "Счёт", 1 => "Акт", 2 => "Скан-копия");

$BILLING_AKTSTATUS_NONE = 0;
$BILLING_AKTSTATUS_NEED = 1;
$BILLING_AKTSTATUS_DONE = 2;
$BILLING_AKTSTATUS_STR	= Array("", "Нужен", "Загружен");

$BILLING_DOCDIR			= "billdocs/";


$TORG_TYPES = Array("Все", "Закупка", "Продажа");
$TORG_TYPES_COMP = Array("Все", "Закупки", "Товары", "Услуги");
$TORG_STATUS = Array("Активный", "Приостановлен", "Закрыт", "Окончен");

$TORG_BUY	= 1;
$TORG_SELL	= 2;

$TORG_STATUS_ACT 	= 0;
$TORG_STATUS_PAUSE	= 1;
$TORG_STATUS_CLOSE	= 2;
$TORG_STATUS_FINISH = 3;

$BID_STATUS_NORM	= 0;
$BID_STATUS_WIN		= 1;

$PROD_STATUS_EMPTY	= 0;
$PROD_STATUS_NEW	= 1;
$PROD_STATUS_ACT	= 2;
$PROD_STATUS_SPEZ	= 3;
$PROD_STATUS_SOON	= 4;

$CURRENCY_NAME = "грн.";

$GROUP_NO					= 0;		// No group is selected (when no logon is made)
$GROUP_ADMIN				= 1;		// Administrators Group
$GROUP_OPERATOR				= 2;		// Translators

$FIELD_TYPE_EDIT			= 1;
$FIELD_TYPE_SELECT			= 2;
$FIELD_TYPE_OPTIONS			= 3;
$FIELD_TYPE_FLAG			= 4;
$FIELD_TYPE_TEXTAREA		= 5;
$FIELD_TYPE_HTML			= 6;
$FIELD_TYPE_RADIO			= 7;
$FIELD_TYPE_FILE			= 8;
$FIELD_TYPE_DIAP			= 9;

$ENGLANGID					= 1;		//???????????

////////////////////////////////////////////////////////////////////////////////
// Default directories
$SESSION_PATH				= "sesid";
$FILE_DIR					= "files/";
$DATA_DIR					= "pics/";

$AWARD_DIR					= $DATA_DIR."awards/";

$CAT_PHOTO_DIR				= $DATA_DIR."ppic/src/";
$CAT_BIG_DIR				= $DATA_DIR."ppic/big/";
$CAT_THUMB_DIR				= $DATA_DIR."ppic/thumb/";
$CAT_SMTHUMB_DIR			= $DATA_DIR."ppic/ico/";

$CAT_LOGO_DIR				= $DATA_DIR."ppic/logo/";
$COMP_LOGO_DIR				= $DATA_DIR."comp/";
$COMP_TMPLOGO_DIR			= $DATA_DIR."comptmp/";

$WATERMARK_BIG				= "../img/watermark/big.png";
$WATERMARK_THUMB			= "../img/watermark/small.png";


////////////////////////////////////////////////////////////////////////////////
// Catalog product's picture presets
$JPEG_COMPRESS_RATIO		= 90;

//Pics for product
$BIGPIC_W					= 1000;
$BIGPIC_H					= 750;

$THUMB_W					= 260;
$THUMB_H					= 210;

$SMTHUMB_W					= 195;
$SMTHUMB_H					= 130;

$COMPLOGO_W					= 240;
$COMPLOGO_H					= 240;

$LOGOTHUMB_W				= 227;		// ??????
$LOGOTHUMB_H				= 107;		// ??????

////////////////////////////////////////////////////////////////////////////////
// Page photos defines
$PAGEPIC_DIR				= $DATA_DIR."pages/";
$PAGEPIC_ICO				= "ico/";
$PAGEPIC_THUMB				= "thumb/";
$PAGEPIC_PHOTO				= "photo/";

$PAGEPIC_P_W				= 1000;	// Photo galery big photo width
$PAGEPIC_P_H				= 1000;	// Photo galery big photo height
$PAGEPIC_T_W				= 800;	// Photo galery thumb photo width
$PAGEPIC_T_H				= 800;	// Photo galery thumb photo height
$PAGEPIC_I_W				= 150;	// Photo galery ico photo width
$PAGEPIC_I_H				= 150;	// Photo galery ico photo height

////////////////////////////////////////////////////////////////////////////////
// Photo galary defines
$GALERY_DIR					= $DATA_DIR."galery/";
$GALERY_ICO					= "ico/";
$GALERY_THUMB				= "thumb/";
$GALERY_PHOTO				= "photo/";

$GALERY_P_W					= 1000;	// Photo galery big photo width
$GALERY_P_H					= 800;	// Photo galery big photo height
$GALERY_T_W					= 600;	// Photo galery thumb photo width
$GALERY_T_H					= 600;	// Photo galery thumb photo height
$GALERY_I_W					= 150;	// Photo galery ico photo width
$GALERY_I_H					= 150;	// Photo galery ico photo height

////////////////////////////////////////////////////////////////////////////////
// Adv board pics
$BOARD_DIR					= $DATA_DIR."z/";
$BOARD_ICO_DIR				= $BOARD_DIR."ico/";
$BOARD_PIC_DIR				= $BOARD_DIR."pic/";

$BOARD_I_W					= 140;
$BOARD_I_H					= 120;
$BOARD_P_W					= 640;
$BOARD_P_H					= 640;

$COMP_HEAD_PIC_W			= 890;
$COMP_HEAD_PIC_H			= 193;

$COMP_BLK_PICDIR			= $DATA_DIR."compblks/";
$COMP_NEWS_PICDIR			= $DATA_DIR."compnews/";

$COMP_BLK_PIC_W				= 170;
$COMP_BLK_PIC_H				= 160;

$COMP_NEWS_PIC_W			= 170;
$COMP_NEWS_PIC_H			= 160;

////////////////////////////////////////////////////////////////////////////////
// Page load initialization
if(empty($UserGroup)){
    $UserGroup = $GROUP_NO;
}
if( isset($_SERVER['PHP_SELF']) ){
    $PHP_SELF = $_SERVER['PHP_SELF'];
}

////////////////////////////////////////////////////////////////////////////////
// Global functions and arrays
function GetParameter( $parameter_name, $default_value, $replace_quotes = true )
{
    $tmp_val = $default_value;
    if( isset( $_POST[$parameter_name] ) ){
        $tmp_val = $_POST[$parameter_name];

    }else if( isset( $_GET[$parameter_name] ) )	 {
        $tmp_val = $_GET[$parameter_name];
    }else{

        $tmp_val = $default_value;
    }
    if( $replace_quotes )
    {
        if( !is_array($tmp_val) && ($tmp_val != "") )
            $tmp_val = str_replace ("\"", "&quot;", $tmp_val);
    }
    return $tmp_val;
}
$coding_table = Array(
                'X', 'F', 'D', 'E', 'U', 'S', 'P', 'N', 'W', 'T',
                'M', 'Y', 'O', 'A', 'B', 'I', 'V', 'L', 'K', 'R',
                'Z', 'G');
$decode_table = Array(
		'X' => 0, 'F' => 1, 'D' => 2, 'E' => 3, 'U' => 4, 'S' => 5, 'P' => 6, 'N' => 7, 'W' => 8, 'T' => 9,
		'M' => 10, 'Y' =>11, 'O' =>12, 'A' =>13, 'B' =>14, 'I' =>15, 'V' =>16, 'L' =>17, 'K' =>18, 'R' => 19,
		'Z' => 20, 'G' => 21);
////////////////////////////////////////////////////////////////////////////////

$REGIONS_URL = Array("ukraine",
	"crimea",
	"vinnica",
	"volin",
	"dnepr",
	"donetsk",
	"zhitomir",
	"zakorpat",
	"zaporizh",
	"ivanofrank",
	"kyiv",
	"kirovograd",
	"lugansk",
	"lviv",
	"nikolaev",
	"odessa",
	"poltava",
	"rovno",
	"sumy",
	"ternopil",
	"kharkov",
	"kherson",
	"khmelnitsk",
	"cherkassi",
	"chernigov",
	"chernovci"
);

$REGIONS = Array("Украина",
	"АР Крым",						// 1
	"Винницкая область",			// 2
	"Волынская область",			// 3
	"Днепропетровская область",		// 4
	"Донецкая область",				// 5
	"Житомирская область",			// 6
	"Закарпатская область",			// 7
	"Запорожская область",			// 8
	"Ивано-франковская область",	// 9
	"Киевская область",				// 10
	"Кировоградская область",		// 11
	"Луганская область",			// 12
	"Львовская область",			// 13
	"Николаевская область",			// 14
	"Одесская область",				// 15
	"Полтавская область",			// 16
	"Ровенская область",			// 17
	"Сумская область",				// 18
	"Тернопольская область",		// 19
	"Харьковская область",			// 20
	"Херсонская область",			// 21
	"Хмельницкая область",			// 22
	"Черкасская область",			// 23
	"Черниговская область",			// 24
	"Черновицкая область"			// 25
);

$REGIONS_SHORT = Array("Украина",
	"АР Крым",						// 1
	"Винницкая область",			// 2
	"Волынская область",			// 3
	"Днепр-кая область",			// 4
	"Донецкая область",				// 5
	"Житомирская область",			// 6
	"Закарпатская область",			// 7
	"Запорожская область",			// 8
	"Ив.-франк-ая область",	// 9
	"Киевская область",				// 10
	"Киров-кая область",		// 11
	"Луганская область",			// 12
	"Львовская область",			// 13
	"Николаевская область",			// 14
	"Одесская область",				// 15
	"Полтавская область",			// 16
	"Ровенская область",			// 17
	"Сумская область",				// 18
	"Тернопольская область",		// 19
	"Харьковская область",			// 20
	"Херсонская область",			// 21
	"Хмельницкая область",			// 22
	"Черкасская область",			// 23
	"Черниговская область",			// 24
	"Черновицкая область"			// 25
);

$REGIONS_SHORT2 = Array("Все области",
	"АР Крым",						// 1
	"Винницкая обл.",			// 2
	"Волынская обл.",			// 3
	"Днепр-кая обл.",			// 4
	"Донецкая обл.",				// 5
	"Житомирская обл.",			// 6
	"Закарпатская обл.",			// 7
	"Запорожская обл.",			// 8
	"Ивано-франковская обл.",	// 9
	"Киевская обл.",				// 10
	"Киров-кая обл.",		// 11
	"Луганская обл.",			// 12
	"Львовская обл.",			// 13
	"Николаевская обл.",			// 14
	"Одесская обл.",				// 15
	"Полтавская обл.",			// 16
	"Ровенская обл.",			// 17
	"Сумская обл.",				// 18
	"Тернопольская обл.",		// 19
	"Харьковская обл.",			// 20
	"Херсонская обл.",			// 21
	"Хмельницкая обл.",			// 22
	"Черкасская обл.",			// 23
	"Черниговская обл.",			// 24
	"Черновицкая обл."			// 25
);

$REGIONS2 = Array("",
	"Крымской области",				// 1
	"Винницкой области",			// 2
	"Волынской области",			// 3
	"Днепропетровской области",		// 4
	"Донецкой области",				// 5
	"Житомирской области",			// 6
	"Закарпатской области",			// 7
	"Запорожской области",			// 8
	"Ивано-франковской области",	// 9
	"Киевской области",				// 10
	"Кировоградской области",		// 11
	"Луганской области",			// 12
	"Львовской области",			// 13
	"Николаевской области",			// 14
	"Одесской области",				// 15
	"Полтавской области",			// 16
	"Ровенской области",			// 17
	"Сумской области",				// 18
	"Тернопольской области",		// 19
	"Харьковской области",			// 20
	"Херсонской области",			// 21
	"Хмельницкой области",			// 22
	"Черкасской области",			// 23
	"Черниговской области",			// 24
	"Черновицкой области"			// 25
);

$REGIONS_CITY = Array("",
	"Крым",						// 1
	"Винница",			// 2
	"Волынь",			// 3
	"Днепропетровск",		// 4
	"Донецк",				// 5
	"Житомир",			// 6
	"Закарпатье",			// 7
	"Запорожье",			// 8
	"Ивано-франковск",	// 9
	"Киев",				// 10
	"Кировоград",		// 11
	"Луганск",			// 12
	"Львов",			// 13
	"Николаев",			// 14
	"Одесса",				// 15
	"Полтава",			// 16
	"Ровно",			// 17
	"Сумы",				// 18
	"Тернополь",		// 19
	"Харьков",			// 20
	"Херсон",			// 21
	"Хмельницк",			// 22
	"Черкассы",			// 23
	"Чернигов",			// 24
	"Черновцы"			// 25
);

$REGIONS_CITY2 = Array("Украине",
	"Крыму",						// 1
	"Виннице",			// 2
	"Волыни",			// 3
	"Днепропетровске",		// 4
	"Донецке",				// 5
	"Житомире",			// 6
	"Закарпатье",			// 7
	"Запорожье",			// 8
	"Ивано-франковске",	// 9
	"Киеве",				// 10
	"Кировограде",		// 11
	"Луганске",			// 12
	"Львове",			// 13
	"Николаеве",			// 14
	"Одессе",				// 15
	"Полтаве",			// 16
	"Ровно",			// 17
	"Сумах",				// 18
	"Тернополе",		// 19
	"Харькове",			// 20
	"Херсоне",			// 21
	"Хмельницке",			// 22
	"Черкассах",			// 23
	"Чернигове",			// 24
	"Черновцах"			// 25
);

$REGIONS_CITY3 = Array("Украины",
	"Крыма",						// 1
	"Винницы",			// 2
	"Волыни",			// 3
	"Днепропетровска",		// 4
	"Донецка",				// 5
	"Житомира",			// 6
	"Закарпатья",			// 7
	"Запорожья",			// 8
	"Ивано-Франковска",	// 9
	"Киева",				// 10
	"Кировограда",		// 11
	"Луганска",			// 12
	"Львова",			// 13
	"Николаева",			// 14
	"Одессы",				// 15
	"Полтавы",			// 16
	"Ровно",			// 17
	"Сум",				// 18
	"Тернополя",		// 19
	"Харькова",			// 20
	"Херсона",			// 21
	"Хмельницка",			// 22
	"Черкасс",			// 23
	"Чернигова",			// 24
	"Черновцов"			// 25
);

$RAYON = Array(
	// Crimea    1
	1 => Array("Бахчисарайский", "Белогорский", "Джанкойский", "Кировский", "Красногвардейский", "Красноперекопский", "Ленинский", "Нижнегорский",
		"Первомайский", "Раздольненский", "Сакский", "Симферопольский", "Советский", "Черноморский"),
	// Vinniza   1
	2 => Array("Барский", "Бершадский", "Винницкий", "Гайсинский", "Жмеринский", "Ильинецкий", "Калиновский", "Казатинский", "Крыжопольский",
		"Липовецкий", "Литинский", "Могилёв-Подольский", "Мурованокуриловецкий", "Немировский", "Оратовский", "Песчанский", "Погребищенский",
		"Тепликский", "Томашпольский", "Тростянецкий", "Тульчинский", "Тывровский", "Хмельницкий", "Черневецкий", "Чечельницкий", "Шаргородский",
		"Ямпольский"),
	// Volinskaya 1
	3 => Array("Владимир-Волынский", "Гороховский", "Иваничевский", "Киверцовский", "Ковельский", "Камень-Каширский", "Локачинский", "Луцкий",
		"Любешовский", "Любомльский", "Маневичский", "Ратновский", "Рожищенский", "Старовыжевский", "Турийский", "Шацкий"),
	// Dnepr     1
	4  => Array("Апостоловский", "Васильковский", "Верхнеднепровский", "Днепропетровский", "Криворожский", "Криничанский", "Магдалиновский",
		"Межевский", "Никопольский", "Новомосковский", "Павлоградский", "Петриковский", "Петропавловский", "Покровский", "Пятихатский",
		"Синельниковский", "Солонянский", "Софиевский", "Томаковский", "Царичанский", "Широковский", "Юрьевский"),
	// Donetsk   1
	5 => Array("Александровский", "Амвросиевский", "Артёмовский", "Великоновоселковский", "Волновахский", "Володарский", "Добропольский",
		"Константиновский", "Красноармейский", "Краснолиманский", "Марьинский", "Новоазовский", "Першотравневый", "Славянский", "Старобешевский",
		"Тельмановский", "Шахтёрский", "Ясиноватский"),
	// Zhitomir  1
	6 => Array("Андрушёвский", "Барановский", "Бердичевский", "Брусиловский", "Володарско-Волынский", "Емильчинский", "Житомирский", "Коростенский",
		"Коростышевский", "Лугинский", "Любарский", "Малинский", "Народичский", "Новоград-Волынский", "Овручский", "Олевский", "Попельнянский",
		"Радомышльский", "Романовский", "Ружинский", "Червоноармейский", "Черняховский", "Чудновский"),
	// Zakarpatye 1
	7 => Array("Береговский", "Великоберезнянский", "Виноградовский", "Воловецкий", "Иршавский", "Межгорский", "Мукачевский", "Перечинский",
		"Раховский", "Свалявский", "Тячевский", "Ужгородский", "Хустский"),
	// Zp         1
	8 => Array("Акимовский", "Бердянский", "Васильевский", "Великобелозёрский", "Весёловский", "Вольнянский", "Гуляйпольский", "Запорожский",
		"Каменско-Днепровский", "Куйбышевский", "Мелитопольский", "Михайловский", "Новониколаевский", "Ореховский", "Пологовский", "Приазовский",
		"Приморский", "Розовский", "Токмакский", "Черниговский"),
	// Ivano-frankovsk  1
	9 => Array("Богородчанский", "Верховинский", "Галичский", "Городенковский", "Долинский", "Калушский", "Коломыйский", "Косовский",
		"Надворнянский", "Рогатинский", "Рожнятовский", "Снятынский", "Тлумачский", "Тысменицкий"),
	// Kiev  1
	10 => Array("Барышевский", "Белоцерковский", "Богуславский", "Бориспольский", "Бородянский", "Броварский", "Васильковский", "Володарский",
		"Вышгородский", "Згуровский", "Иванковский", "Кагарлыкский", "Киево-Святошинский", "Макаровский", "Мироновский", "Обуховский",
		"Переяслав-Хмельницкий", "Полесский", "Ракитнянский", "Сквирский", "Ставищенский", "Таращанский", "Тетиевский", "Фастовский", "Яготинский"),
	// Kirovograd   1
	11 => Array("Александрийский", "Александровский", "Бобринецкий", "Гайворонский", "Голованевский", "Добровеличковский", "Долинский", "Знаменский", "Кировоградский", "Компанеевский", "Маловисковский", "Новгородковский", "Новоархангельский", "Новомиргородский", "Новоукраинский",
		"Ольшанский", "Онуфриевский", "Петровский", "Светловодский", "Благовещенский", "Устиновский"),
	// Lugansk      1
	12 => Array("Антрацитовский", "Беловодский", "Белокуракинский", "Краснодонский", "Кременской", "Лутугинский", "Марковский", "Меловской",
		"Новоайдарский", "Новопсковский", "Перевальский", "Попаснянский", "Сватовский", "Свердловский", "Славяносербский", "Станично-Луганский",
		"Старобельский", "Троицкий"),
	// Lvov         1
	13 => Array("Бродовский", "Бусский", "Городокский", "Дрогобычский", "Жидачовский", "Жолковский", "Золочевский", "Каменка-Бугский", "Мостисский",
		"Николаевский", "Перемышлянский", "Пустомытовский", "Радеховский", "Самборский", "Сколевский", "Сокальский", "Старосамборский", "Стрыйский",
		"Турковский", "Яворовский"),
	// Nikolaev     1
	14 => Array("Арбузинский", "Баштанский", "Березанский", "Березнеговатский", "Братский", "Веселиновский", "Вознесенский", "Врадиевский",
		"Доманёвский", "Еланецкий", "Жовтневый", "Казанковский", "Кривоозерский", "Николаевский", "Новобугский", "Новоодесский", "Очаковский",
		"Первомайский", "Снигирёвский"),
	// Odessa       1
	15 => Array("Ананьевский", "Арцизский", "Балтский", "Березовский", "Белгород-Днестровский", "Беляевский", "Болградский", "Великомихайловский",
		"Ивановский", "Измаильский", "Килийский", "Кодымский", "Коминтерновский", "Котовский", "Красноокнянский", "Любашёвский", "Николаевский",
		"Овидиопольский", "Ренийский", "Раздельнянский", "Савранский", "Саратский", "Тарутинский", "Татарбунарский", "Фрунзовский", "Ширяевский"),
	// Poltava   1
	16 => Array("Великобагачанский", "Гадячский", "Глобинский", "Гребёнковский", "Диканьский", "Зеньковский", "Карловский", "Кобелякский",
		"Козельщинский", "Котелевский", "Кременчугский", "Лохвицкий", "Лубенский", "Машевский", "Миргородский", "Новосанжарский", "Оржицкий",
		"Пирятинский", "Полтавский", "Решетиловский", "Семёновский", "Хорольский", "Чернухинский", "Чутовский", "Шишацкий"),
	// Rovenskaya  1
	17 => Array("Березновский", "Владимирецкий", "Гощанский", "Демидовский", "Дубенский", "Дубровицкий", "Заречненский", "Здолбуновский",
		"Корецкий", "Костопольский", "Млиновский", "Острожский", "Радивиловский", "Ровненский", "Рокитновский", "Сарненский"),
	// Sumy      1
 	18 => Array("Ахтырский", "Белопольский", "Бурынский", "Великописаревский", "Глуховский", "Конотопский", "Краснопольский", "Кролевецкий",
    	"Лебединский", "Липоводолинский", "Недригайловский", "Путивльский", "Роменский", "Середино-Будский", "Сумской", "Тростянецкий",
    	"Шосткинский", "Ямпольский"),
  	// Ternopil  1
  	19 => Array("Бережанский", "Борщёвский", "Бучачский", "Гусятинский", "Залещицкий", "Збаражский", "Зборовский", "Козовский", "Кременецкий",
  		"Лановецкий", "Монастырисский", "Подволочисский", "Подгаецкий", "Теребовлянский", "Тернопольский", "Чортковский", "Шумский"),
	// Kh        1
	20 => Array("Балаклейский","Барвенковский","Близнюковский","Богодуховский","Боровской","Валковский","Великобурлукский",
    	"Волчанский","Двуречанский","Дергачевский","Зачепиловский","Змиевской","Золочевский","Изюмский","Кегичевский","Коломакский",
    	"Красноградский","Краснокутский","Купянский","Лозовской","Нововодолажский","Первомайский","Печенежский",
    	"Сахновщинский","Харьковский","Чугуевский","Шевченковский"),
 	// Kherson   1
 	21 => Array("Бериславский", "Белозёрский", "Великолепетихский", "Великоалександровский", "Верхнерогачикский", "Высокопольский", "Генический",
 		"Голопристанский", "Горностаевский", "Ивановский", "Каланчакский", "Каховский", "Нижнесерогозский", "Нововоронцовский", "Новотроицкий",
 		"Скадовский", "Цюрупинский", "Чаплинский"),
 	// Khmelnizk  1
 	22 => Array("Белогорский", "Виньковецкий", "Волочисский", "Городокский", "Деражнянский", "Дунаевецкий", "Изяславский", "Каменец-Подольский",
 		"Красиловский", "Летичевский", "Новоушицкий", "Полонский", "Славутский", "Староконстантиновский", "Старосинявский", "Теофипольский",
 		"Хмельницкий", "Чемеровецкий", "Шепетовский", "Ярмолинецкий"),
 	// Cherkassi  1
 	23 => Array("Городищенский", "Драбовский", "Жашковский", "Звенигородский", "Золотоношский", "Каменский", "Каневский", "Катеринопольский",
 		"Корсунь-Шевченковский", "Лысянский", "Маньковский", "Монастырищенский", "Смелянский", "Тальновский", "Уманский", "Христиновский",
 		"Черкасский", "Чигиринский", "Чернобаевский", "Шполянский"),
 	// Chernigov  1
 	24 => Array("Бахмачский", "Бобровицкий", "Борзнянский", "Варвинский", "Городнянский", "Ичнянский", "Козелецкий", "Коропский", "Корюковский",
 		"Куликовский", "Менский", "Нежинский", "Новгород-Северский", "Носовский", "Прилукский", "Репкинский", "Семёновский", "Сосницкий",
 		"Сребнянский", "Талалаевский", "Черниговский", "Щорский"),
 	// Chernovitskaya 1
 	25 => Array("Вижницкий", "Герцаевский", "Глыбокский", "Заставновский", "Кельменецкий", "Кицманский", "Новоселицкий", "Путильский",
 		"Сокирянский", "Сторожинецкий", "Хотинский")
);

$STREET_TYPE = Array("ул.", "просп.", "бульвар", "переулок");

$ban_page = Array("Все страницы", "Главная", "Торги по регионам", "Остальные страницы");
$ban_paytype = Array("Подарок", "Наличными", "Безнал", "Webmoney");

//$ADVTYPE = Array("Все объявления", "Куплю", "Продам", "Услуги");
$ADVTYPE = Array("Все объявления", "Закупки", "Продажи", "Услуги");

////////////////////////////////////////////////////////////////////////////////

if( $DEBUG_ON )
{
	error_reporting(E_ALL);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
else
{
	error_reporting(0);

	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

function debugMysql()
{
	global $DEBUG_ON;
	if( $DEBUG_ON )
	{
		echo mysqli_error($upd_link_db)."<br>";
	}
}

setlocale(LC_CTYPE, "ru_RU");
setlocale(LC_COLLATE, "ru_RU");

////////////////////////////////////////////////////////////////////////////////
?>
