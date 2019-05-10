<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Guest access plugin settings and presets.
 *
 * @package    enrol_warwickguest
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*$designationUrl = new moodle_url("/enrol/warwickguest/designation.php");
$departmentUrl = new moodle_url("/enrol/warwickguest/department.php");
    
$ADMIN->add('enrolments', new admin_category('enrol_warwickguest', 'Warwick Guest', true ));
$ADMIN->add('enrol_warwickguest', new admin_externalpage('warwickguestdesignations', 'Designations', $designationUrl, 'moodle/site:config'));
$ADMIN->add('enrol_warwickguest', new admin_externalpage('warwickguestdepartments', 'Departments', $departmentUrl, 'moodle/site:config'));
*/
$pluginName = 'enrol_warwickguest';
$designationUrl = new moodle_url( "/local/enrolmultiselect/designation.php", [ 'plugin_name' => $pluginName ] );
$departmentUrl = new moodle_url( "/local/enrolmultiselect/department.php", [ 'plugin_name' => $pluginName ] );

$ADMIN->add('enrolments', new admin_category('enrol_warwickguest', 'Warwick Guest', true ));
$ADMIN->add('enrol_warwickguest', new admin_externalpage("{$pluginName}_departments", 'Departments', $departmentUrl, 'moodle/site:config'));
$ADMIN->add('enrol_warwickguest', new admin_externalpage("{$pluginName}_designations", 'Designations', $designationUrl, 'moodle/site:config'));

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('enrol_warwickguest_dep','',"<a href='$departmentUrl'>Department Settings</a> | <a href='$designationUrl'>Designation Settings</a>"));
    
    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_warwickguest_settings', '', get_string('pluginname_desc', 'enrol_warwickguest')));

    $settings->add(new admin_setting_configcheckbox('enrol_warwickguest/requirepassword',
        get_string('requirepassword', 'enrol_warwickguest'), get_string('requirepassword_desc', 'enrol_warwickguest'), 0));

    $settings->add(new admin_setting_configcheckbox('enrol_warwickguest/usepasswordpolicy',
        get_string('usepasswordpolicy', 'enrol_warwickguest'), get_string('usepasswordpolicy_desc', 'enrol_warwickguest'), 0));

    $settings->add(new admin_setting_configcheckbox('enrol_warwickguest/showhint',
        get_string('showhint', 'enrol_warwickguest'), get_string('showhint_desc', 'enrol_warwickguest'), 0));

    
    
    //--- enrol instance defaults ----------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_warwickguest_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $settings->add(new admin_setting_configcheckbox('enrol_warwickguest/defaultenrol',
        get_string('defaultenrol', 'enrol'), get_string('defaultenrol_desc', 'enrol'), 1));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect_with_advanced('enrol_warwickguest/status',
        get_string('status', 'enrol_warwickguest'), get_string('status_desc', 'enrol_warwickguest'),
        array('value'=>ENROL_INSTANCE_DISABLED, 'adv'=>false), $options));

}