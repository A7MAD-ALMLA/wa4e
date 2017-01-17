<?php
$OUTPUT->bodyStart();
$R = $CFG->apphome . '/';
$T = $CFG->wwwroot . '/';
$adminmenu = isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true";
$set = new \Tsugi\UI\MenuSet();
$set->setHome($CFG->servicename, $CFG->apphome);
$set->addLeft('Get Started', $R.'install.php');
if ( isset($CFG->lessons) ) {
    $set->addLeft('Lessons', $T.'lessons.php');
}
$set->addLeft('YouTube', 'https://www.youtube.com/playlist?list=PLlRFEj9H3Oj7FHbnXWviqQt0sKEK_hdKX');
if ( isset($_SESSION['id']) ) {
	if ( isset($CFG->disqushost) ) $set->addLeft('Discuss', $T.'discuss.php');
	else if ( isset($CFG->disquschannel) ) $set->addLeft('Discuss', $CFG->disquschannel);
	$set->addLeft('Assignments', $T.'assignments.php');
}


if ( isset($_SESSION['id']) ) {
    $submenu = new \Tsugi\UI\Menu();
    $submenu->addLink('Profile', $T.'profile.php');
    if ( isset($CFG->google_map_api_key) && $adminmenu ) {
        $submenu->addLink('Map', $T.'map.php');
    }
    $submenu->addLink('Badges', $T.'badges.php');
    if ( $CFG->DEVELOPER ) {
        $submenu->addLink('Test LTI Tools', $T . 'dev.php');
    }
    if ( $CFG->providekeys ) {
        $submenu->addLink('LMS Integration', $T . 'admin/key/index.php');
    }
    if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true" ) {
        $submenu->addLink('Administer', $T . 'admin/');
    }
    $submenu->addLink('Rate this course', 'https://www.class-central.com/mooc/7362/web-applications-for-everybody');
    $submenu->addLink('Logout', $T.'logout.php');
    if ( isset($_SESSION['avatar']) ) {
        $set->addRight('<img src="'.$_SESSION['avatar'].'" style="height: 2em;"/>', $submenu);
        // htmlentities($_SESSION['displayname']), $submenu);
    } else {
        $set->addRight(htmlentities($_SESSION['displayname']), $submenu);
    }
} else {
    $set->addRight('Login', $T.'login.php');
}

$set->addRight('Book', 'http://textbooks.opensuny.org/the-missing-link-an-introduction-to-web-development-and-programming/');
$set->addRight('Instructor', 'http://www.dr-chuck.com');

// Set the topNav for the session
$OUTPUT->topNavSession($set);

$OUTPUT->topNav();
$OUTPUT->flashMessages();
