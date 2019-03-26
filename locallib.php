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
 * Guest access plugin implementation.
 *
 * @package    enrol_warwickguest
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use \enrol_warwickguest\selector\type\user\department;
use \enrol_warwickguest\selector\type\user\designation;

require_once("$CFG->libdir/formslib.php");

class enrol_warwickguest_enrol_form extends moodleform {
    protected $instance;

    public function definition() {
        $mform = $this->_form;
        $instance = $this->_customdata;
        $this->instance = $instance;
        $plugin = enrol_get_plugin('warwickguest');

        $heading = $plugin->get_instance_name($instance);
        $mform->addElement('header', 'guestheader', $heading);

        $mform->addElement('password', 'guestpassword', get_string('password', 'enrol_warwickguest'));

        $this->add_action_buttons(false, get_string('submit'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $instance->courseid);

        $mform->addElement('hidden', 'instance');
        $mform->setType('instance', PARAM_INT);
        $mform->setDefault('instance', $instance->id);
    }

    public function validation($data, $files) {
        global $DB, $CFG, $USER;

        $errors = parent::validation($data, $files);
        $instance = $this->instance;
        
        if ($instance->password !== '') {
            if ($data['guestpassword'] !== $instance->password) {
                $plugin = enrol_get_plugin('warwickguest');
                if ($plugin->get_config('showhint')) {
                    $hint = core_text::substr($instance->password, 0, 1);
                    $errors['guestpassword'] = get_string('passwordinvalidhint', 'enrol_warwickguest', $hint);
                } else {
                    $errors['guestpassword'] = get_string('passwordinvalid', 'enrol_warwickguest');
                }
            }
        }
        
        if( designation::isValueSet( $instance, 'customtext1' ) ){
            if( !designation::hasValue( $instance, $USER->phone2,'customtext1', 'phone2' ) ){
                $errors['guestpassword'] = 'invalid designation';
            }
        }
        
        if( department::isValueSet( $instance, 'customtext2' ) ){
            if( !department::hasValue( $instance, $USER->department,'customtext2', 'department' ) ){
                $errors['guestpassword'] = 'invalid department';
            }
        }

        return $errors;
    }
}
