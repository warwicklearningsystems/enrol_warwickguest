<?php

require_once('HTML/QuickForm/element.php');

use \enrol_warwickguest\selector\type\user\potential_department;

class enrol_warwickguest_formelementdepartmentremove extends HTML_QuickForm_element {
    
    private $instance;
    
    /**
     * 
     * @param type $elementName
     * @param type $elementLabel
     * @param type $options
     * @param type $attributes
     */
    public function __construct($elementName=null, $elementLabel=null, $options=null, $attributes=null) {
        parent::__construct('departments_remove', $elementLabel, $attributes);
        $this->setMultiple(true);
    }
    
    /**
     * 
     * @param type $instance
     */
    public function setInstance($instance){
        $this->instance = $instance;
    }

    public function toHtml()
    {
        global $OUTPUT;

        $departmentPotentialSelector = new potential_department($this->getName(), ['plugin' => 'enrol_warwickguest', 'enrol_instance' => $this->instance]);

        $availableDesignations = $departmentPotentialSelector->display(true);
        $label = get_string('availabledepartments', 'enrol_warwickguest');

$html = <<<__HTML__
    <td id="potentialcell">
        <p>
          <label for="addselect">$label</label>
        </p>
        $availableDesignations
    </td>
  </tr>
</table>

__HTML__;

        return $html;
        
    }
    
    /**
    * We check the options and return only the values that _could_ have been
    * selected. We also return a scalar value if select is not "multiple"
    */
    public function exportValue(&$submitValues, $assoc = false)
    {
        $value = $this->_findValue($submitValues);
        if (is_null($value)) {
            $value = $this->getValue();
        } elseif(!is_array($value)) {
            $value = array($value);
        }
        if (is_array($value) && !empty($this->_options)) {
            $cleanValue = null;
            foreach ($value as $v) {
                for ($i = 0, $optCount = count($this->_options); $i < $optCount; $i++) {
                    if ($v == $this->_options[$i]['attr']['value']) {
                        $cleanValue[] = $v;
                        break;
                    }
                }
            }
        } else {
            $cleanValue = $value;
        }
        if (is_array($cleanValue) && !$this->getMultiple()) {
            return $this->_prepareValue($cleanValue[0], $assoc);
        } else {
            return $this->_prepareValue($cleanValue, $assoc);
        }
    }
    
    /**
     * 
     * @param type $name
     */
    public function setName($name)
    {
        $this->updateAttributes(array('name' => $name));
    }
    
    public function getName()
    {
        return $this->getAttribute('name');
    }
    
    /**
     * 
     * @param type $multiple
     */
    public function setMultiple($multiple)
    {
        if ($multiple) {
            $this->updateAttributes(array('multiple' => 'multiple'));
        } else {
            $this->removeAttribute('multiple');
        }
    }
    

    public function getMultiple()
    {
        return (bool)$this->getAttribute('multiple');
    }
    
}
?>
