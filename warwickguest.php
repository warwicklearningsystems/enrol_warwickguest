<?php 

//exit(var_dump(realpath(__DIR__ )));

exit(var_dump($CFG));
require_once("$CFG->dirroot/config.php");
require_once($CFG->libdir.'/adminlib.php');

$confirmadd = optional_param('confirmadd', 0, PARAM_INT);
$confirmdel = optional_param('confirmdel', 0, PARAM_INT);

$PAGE->set_url('/enrol/warwickguest/warwickguest.php');

admin_externalpage_setup('warwickguest');
if (!is_siteadmin()) {
die;
}