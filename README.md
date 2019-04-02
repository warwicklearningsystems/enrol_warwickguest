# [Warwick Guest access]

The _Warwick Guest access_ plugin is an extension of the built-in _Guest access_ plugin. In addition to the password restriction that's provided by the built-in plugin it also provides two further restrictions, department and designation. It allows for the administration of a definitive list of departments/designations from which to restrict guest enrolments based on those user properties, e.g. Joe Bloggs is in the 'Law School' department and has the 'lecturer' designation. The _Warwick Guest access_ plugin has been configured against a course to only allow the 'Economics' department. Joe Bloggs will be refused Guest access to that particular course.

## Configuration
Configuration of the plugin is done in two stages, _settings_ and _course_. Both the department and designation fields are free-text fields stored against the user record, which has inevitably resulted in an unwieldy list. Therefore, in order to present a more contained list to users that will configure the plugin against a course, the settings page presents an opportunity to tame these lists.

#### Settings

To complete the first stage of the configuration of the plugin go to _Site Administration > Plugins > Enrolments > Warwick Guest Access._

Simply select _Designation Settings_ or _Department Settings_. Both pages operate in exactly the same manor. You will be presented with a multiselect which displays all the available designations/departments on the right-hand side (_available list_) of the element. Select the required item(s) and click 'Add'. The selected values will now be displayed on the left-hand side of the element, and will be presented in the _available list_ of the _course_ configuration of the plugin for the same options. 

To remove items, simply select and click 'Remove'. _Note: although this will remove the value(s) from the appropriate available list of the course config, it does not perform a deep removal from courses that may already contain the value(s) in their config for this plugin. In those instances the value will still be available until it is removed from the course config._

#### Course

To the final stage of the configuration go to _Dashboard > My courses > {course} > Users > Enrolment methods > Warwick Auto Enrolment._

The Designation and Department elements are presented directly on this form and can be configured in exactly the same way as described above.
