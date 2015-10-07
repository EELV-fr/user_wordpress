<?php
/**
 * Copyright (c) 2011 Jakob Sack <mail@jakobsack.de>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */


/*
if(substr($_SERVER["REQUEST_URI"],0,strlen(OC_App::getAppWebPath('calendar').'/caldav.php')) == OC_App::getAppWebPath('calendar'). '/caldav.php') {
	$baseuri = OC_App::getAppWebPath('calendar').'/caldav.php';
}

// only need authentication apps
$RUNTIME_APPTYPES=array('authentication');
OC_App::loadApps($RUNTIME_APPTYPES);
*/
OCP\App::checkAppEnabled('calendar');
$RUNTIME_APPTYPES=array('authentication');
OC_App::loadApps($RUNTIME_APPTYPES);
require_once('apps/calendar/appinfo/app.php');

require_once(OC::$CLASSPATH['OC_Connector_Sabre_CalDAV']);

$app_rel_path = "apps_for_ccc";
require_once($app_rel_path . '/lib/autoauth.php');
//require_once('apps/user_wordpress/lib/autoauth.php');


// Backends
$authBackend = new OC_Connector_Sabre_Auth();
$principalBackend = new OC_Connector_Sabre_Principal();
$caldavBackend    = new OC_Connector_Sabre_CalDAV();

$uid=OC_User::getUser();

// Root nodes
$Sabre_CalDAV_Principal_Collection = new Sabre_CalDAV_Principal_Collection($principalBackend);
$Sabre_CalDAV_Principal_Collection->disableListing = false; // Disable listening

$calendarRoot = new OC_Connector_Sabre_CalDAV_CalendarRoot($principalBackend, $caldavBackend);
$calendarRoot->disableListing = false; // Disable listening

$nodes = array(
	$Sabre_CalDAV_Principal_Collection,
	$calendarRoot,
	);

// Fire up server
$server = new Sabre_DAV_Server($nodes);
$server->setBaseUri($baseuri);
// Add plugins



$server->currentUser=$uid;
$server->addPlugin(new Sabre_DAV_Auth_Plugin($authBackend,'ownCloud'));
$server->addPlugin(new Sabre_CalDAV_Plugin());
$server->addPlugin(new Sabre_DAVACL_Plugin());
$server->addPlugin(new Sabre_DAV_Browser_Plugin(false)); // Show something in the Browser, but no upload
$server->addPlugin(new Sabre_CalDAV_ICSExportPlugin());

// And off we go!
$server->exec();
