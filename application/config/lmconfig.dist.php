<?php

//APP NAME - for example "Aideron Technologies' LMeve"
$LM_APP_NAME = 'LMeve';
//locked
$LM_LOCKED = 0;
//read-only
$LM_READONLY = 0;
//check for session IP changes
$LM_IPCONTROL = 1;
//maximum session cookie time
$LM_SESSION = 3600;
//cookie path. must have a trailing slash, for example: /lmeve/
$LM_COOKIEPATH = '/';
//debug database queries? (include additional information in error messages)
$LM_DEBUG = 1;
$LM_DBENGINE = 'MYSQL'; //MYSQL || PGSQL
//database settings
$LM_dbhost = 'localhost';
$LM_dbname = 'lmeve';
$LM_dbuser = 'lmeve';
$LM_dbpass = 'password';
//salt used for passwords. Should be a random string CHANGE IT!
$LM_SALT = 'test';
//thousand and decimal separators
$THOUSAND_SEP = ",";
$DECIMAL_SEP = ".";
//default CSS style
$LM_DEFAULT_CSS = "/css/rixxjavix.css";
//force SSL
$LM_FORCE_SSL = FALSE;
//use CSRF tokens in forms
$LM_SECUREFORMS = TRUE;
//use EVE SSO - see https://wiki.eveonline.com/en/wiki/EVE_SSO_Documentation
$SSOENABLED = FALSE;
$SSO_REDIRECT_URL = 'https://lmeve.com/ssologin.php';
$SSO_CLIENT_ID = 'sso_client_id';
$SSO_CLIENT_SECRET = 'sso_client_secret';
//Auth server can be either login.eveonline.com for Tranquility, or sisilogin.testeveonline.com when trying to use Sisi.
$SSO_AUTH_SERVER = 'sisilogin.testeveonline.com';
//CSRF token expiry time (in seconds)
$LM_SECUREFORMSEXPIRY = 300;
//LMeve will use static data from this database.
$LM_EVEDB = 'eve_rub130_dbo';
//Buy calculator can show colored hints green - we buy, yellow - we have enough, red - we have way more than enough - we dont buy
$LM_BUYCALC_SHOWHINTS = TRUE;
//for LDAP authentication use the following settings
$LM_LDAP_USE = false;
$LM_LDAP_UID = "uid="; //for Windows: "" || for Linux: "uid="
$LM_LDAP_DOMAIN = ",ou=people,dc=diameter,dc=local"; //for Windows: @domain.company.com || for Linux: ,ou=people,dc=diameter,dc=local
$LM_LDAP_HOSTS = array("192.168.0.1");
//table with usernames and passwords for internal authentication
$USERSTABLE = 'lmusers';
//should LMeve learn new rights 1 for development, 0 for production
$LM_LEARNING_MODE = 0;
//use proxy for CCP WebGL assets
$LM_CCPWGL_USEPROXY = FALSE;
//CCP CDN URL - normally it should never be changed
$LM_CCPWGL_URL = 'https://web.ccpgamescdn.com/ccpwgl/res/';
//TODO: Make the below 2 variables values in a database table or something maybe?
//What EVE Central price to use for profit explorer manufacturing costs
$EC_PRICE_TO_USE_FOR_MAN = array('type' => 'sell', 'price' => 'min');
//What EVE Central price to use for profit explorer market price
$EC_PRICE_TO_USE_FOR_SELL = array('type' => 'sell', 'price' => 'min');
$LMEVE_LINK = '<your lmeve absolute url>';

$LM_PAGES = array(
    0 => array('path' => '/alltasks.html', 'name' => 'alltasks', 'displayName' => 'All Tasks', 'rootPerm' => 'ViewAllTasks'),
    1 => array('path' => '/tasks.html', 'name' => 'tasks', 'displayName' => 'Tasks', 'rootPerm' => 'ViewOwnTasks'),
    2 => array('path' => '/matsrequired.html', 'name' => 'matsrequired', 'displayName' => 'Materials Required', 'rootPerm' => 'ViewMatsRequired'),
    3 => array('path' => '/queue.html', 'name' => 'queue', 'displayName' => 'Corporate Queue', 'rootPerm' => 'ViewQueue'),
    4 => array('path' => '/metrics.html', 'name' => 'metrics', 'displayName' => 'Financials', 'rootPerm' => 'ViewMetrics')
);

/* * ************************************************************************************************************************************
 *                                       Now set all of the above into the $config array                                              *
 * ************************************************************************************************************************************ */
$config['LM_APP_NAME'] = $LM_APP_NAME;
$config['LM_LOCKED'] = $LM_LOCKED;
$config['LM_READONLY'] = $LM_READONLY;
$config['LM_IPCONTROL'] = $LM_IPCONTROL;
$config['LM_SESSION'] = $LM_SESSION;
$config['LM_COOKIEPATH'] = $LM_COOKIEPATH;
$config['LM_DEBUG'] = $LM_DEBUG;
$config['LM_DBENGINE'] = $LM_DBENGINE;
$config['LM_dbhost'] = $LM_dbhost;
$config['LM_dbname'] = $LM_dbname;
$config['LM_dbuser'] = $LM_dbuser;
$config['LM_dbpass'] = $LM_dbpass;
$config['LM_SALT'] = $LM_SALT;
$config['THOUSAND_SEP'] = $THOUSAND_SEP;
$config['DECIMAL_SEP'] = $DECIMAL_SEP;
$config['LM_DEFAULT_CSS'] = $LM_DEFAULT_CSS;
$config['LM_FORCE_SSL'] = $LM_FORCE_SSL;
$config['LM_SECUREFORMS'] = $LM_SECUREFORMS;
$config['SSOENABLED'] = $SSOENABLED;
$config['SSO_REDIRECT_URL'] = $SSO_REDIRECT_URL;
$config['SSO_CLIENT_ID'] = $SSO_CLIENT_ID;
$config['SSO_CLIENT_SECRET'] = $SSO_CLIENT_SECRET;
$config['SSO_AUTH_SERVER'] = $SSO_AUTH_SERVER;
$config['LM_SECUREFORMSEXPIRY'] = $LM_SECUREFORMSEXPIRY;
$config['LM_EVEDB'] = $LM_EVEDB;
$config['LM_BUYCALC_SHOWHINTS'] = $LM_BUYCALC_SHOWHINTS;
$config['LM_LDAP_USE'] = $LM_LDAP_USE;
$config['LM_LDAP_UID'] = $LM_LDAP_UID;
$config['LM_LDAP_DOMAIN'] = $LM_LDAP_DOMAIN;
$config['LM_LDAP_HOSTS'] = $LM_LDAP_HOSTS;
$config['USERSTABLE'] = $USERSTABLE;
$config['LM_LEARNING_MODE'] = $LM_LEARNING_MODE;
$config['LM_CCPWGL_USEPROXY'] = $LM_CCPWGL_USEPROXY;
$config['LM_CCPWGL_URL'] = $LM_CCPWGL_URL;
$config['EC_PRICE_TO_USE_FOR_MAN'] = $EC_PRICE_TO_USE_FOR_MAN;
$config['EC_PRICE_TO_USE_FOR_SELL'] = $EC_PRICE_TO_USE_FOR_SELL;
$config['LMEVE_LINK'] = $LMEVE_LINK;
$config['LM_MENU'] = $LM_MENU;
?>
