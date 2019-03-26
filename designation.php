<?php
    require_once(__DIR__ . '/../../config.php');
    require_once($CFG->libdir.'/adminlib.php');

    use \enrol_warwickguest\selector\type\settings\designation;
    use \enrol_warwickguest\selector\type\settings\potential_designation;

    $confirmadd = optional_param('confirmadd', 0, PARAM_INT);
    $confirmdel = optional_param('confirmdel', 0, PARAM_INT);

    $PAGE->set_url('/enrol/warwickguest/designations.php');

    admin_externalpage_setup('warwickguestdesignations');
    if (!is_siteadmin()) {
        die;
    }

    // Print header.
    echo $OUTPUT->header();

    $warwickGuestUrl = new moodle_url($PAGE->url);
    
    $designationCurrentSelector = new designation('s_enrol_warwickguest_designation_add', ['contextid'=>1, 'plugin'=> 'enrol_warwickguest']);
    $designationPotentialSelector = new potential_designation('s_enrol_warwickguest_designation_remove', ['contextid'=>1,'plugin' => 'enrol_warwickguest']);

    if (optional_param('add', false, PARAM_BOOL) && confirm_sesskey()) {
        $designationsToAssign = $designationPotentialSelector->get_selected_users();

        if ( !empty( $designationsToAssign ) ) {
            $designationCurrentSelector->addToConfig( $designationsToAssign );

            $designationPotentialSelector->invalidate_selected_users();
            $designationCurrentSelector->invalidate_selected_users();
        }
    }
    
    if (optional_param('remove', false, PARAM_BOOL) && confirm_sesskey()) {
        $designationsToRemove = $designationCurrentSelector->get_selected_users();

        if ( !empty( $designationsToRemove ) ) {
            $designationCurrentSelector->removeFromConfig( $designationsToRemove );

            $designationPotentialSelector->invalidate_selected_users();
            $designationCurrentSelector->invalidate_selected_users();
        }
    }

?>

<form action="<?php echo $warwickGuestUrl ?>" method="post">
    <div>
        <input type="hidden" name="section" value="enrolsettingswarwickguest">
        <input type="hidden" name="action" value="save-settings">
        <input type="hidden" name="sesskey" value="<?php echo sesskey() ?>">
        <input type="hidden" name="return" value="">
      
        <table class="generaltable generalbox groupmanagementtable boxaligncenter" summary="">
            <tr>
              <td id='existingcell'>
                  <p>
                    <label for="removeselect"><?php print_string('existingdesignations', 'enrol_warwickguest'); ?></label>
                  </p>
                  <?php $designationCurrentSelector->display(); ?>
                  </td>
              <td id="buttonscell">
                <p class="arrow_button">
                    <input name="add" id="add" type="submit" value="<?php echo $OUTPUT->larrow().'&nbsp;'.get_string('add'); ?>"
                           title="<?php print_string('add'); ?>" class="btn btn-secondary"/><br />
                    <input name="remove" id="remove" type="submit" value="<?php echo get_string('remove').'&nbsp;'.$OUTPUT->rarrow(); ?>"
                           title="<?php print_string('remove'); ?>" class="btn btn-secondary"/><br />
                </p>
              </td>
              <td id="potentialcell">
                  <p>
                    <label for="addselect"><?php print_string('disignations', 'enrol_warwickguest'); ?></label>
                  </p>
                  <?php $designationPotentialSelector->display(); ?>
              </td>
            </tr>
        </table>

    </div>
</form>

<?php
echo $OUTPUT->footer();