<?php

namespace Spin\Lib;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 André Spindler <typo3@andre-spindler.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Directly printing extension to tx_lib_formBase
 *
 * The methods simply print the form elements.
 * The namingstyle is consistent, prepending "print".
 *
 * Example how to use this class in your template:
 * <code>
 *  $form = $this->form;
 *  $form->setRowPattern('%1$s%4$s<dt>%2$s</dt>%4$s<dd>%3$s</dd>%4$s');
 *  $form->requireListControl('<dl>', '</dl>');
 *
 *  $form->printBegin('cherriesInputFunctions');
 *    $form->printHidden('hidden', array('value' => 'aHiddenValue'));
 *
 *    $form->printFieldsetBegin('fieldsetCheckbox', array(), 'Checkbox');
 *        $form->printCheckboxRow('checkbox', 'Checkbox', array('value' =>'Checkbox'));
 *    $form->printFieldsetEnd();
 *
 *    $form->printFieldsetBegin('fieldsetSingleSelections', array(), 'Single selections');
 *      $form->printSelectRow('select', 'Select', array(), array(1 => 'Option 1', 2 => 'Option 2'));
 *      $form->printFieldsetBegin('fieldsetRadioGroup', array(), 'Radio group');
 *        $form->printRadioRow('radio1', 'Radio 1', array('name' => 'radio', 'value' => 'value1'));
 *        $form->printRadioRow('radio2', 'Radio 2', array('name' => 'radio', 'value' => 'value2'));
 *    $form->printFieldsetEnd();
 *    $form->printFieldsetEnd();
 *
 *  $form->printEnd();
 * </code>
 *
 * For more and more complex examples look into EXT:cherries.
 * For documentation see tx_lib_formBase.
 *
 * Depends on: tx_lib_formBase
 *
 * @package    TYPO3
 * @subpackage lib
 * @license    http://www.gnu.org/licenses/gpl.html
 *               GNU General Public License, version 3 or later
 * @author     Elmar Hinz <elmar.hinz@team-red.net>
 * @author     André Spindler <typo3@andre-spindler.de>
 * @copyright  2006-2007 Elmar Hinz, 2012-2014 André Spindler
 */
class PhpFormEngine extends FormBase {


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function __construct($parameter1 = NULL, $parameter2 = NULL) {
		$this->PhpFormEngine($parameter1, $parameter2);
	}


	/**
	 * constructor
	 *
	 * @param mixed $parameter1
	 * @param mixed $parameter2
	 */
	function PhpFormEngine($parameter1 = NULL, $parameter2 = NULL) {
		parent::FormBase($parameter1, $parameter2);
	}


	/**
	 * Print the current request url with all parameters.
	 *
	 * @return    void
	 */
	function printAction() {
		print $this->action();
	}


	/**
	 * Print the opening tag of a form.
	 *
	 * @param   mixed       $key key of internal data array
	 * @param    array $attributes : ...
	 * @return    void
	 */
	function printBegin($key, $attributes = array()) {
		print $this->begin($key, $attributes);
	}


	/**
	 * Print the HTML code of a checkbox.
	 *
	 * Notice: You have to set an entry "value" in the $attributes array
	 * to get this function working.
	 *
	 * @param    string        $key the id for that checkbox
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printCheckbox($key, $attributes = array()) {
		print $this->checkbox($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a checkbox.
	 *
	 * Notice: You have to set an entry "value" in the $attributes array
	 * to get this function working.
	 *
	 * @param    string        $key the id for that row
	 * @param    string        $labelText the text of the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printCheckboxRow($key, $labelText, $attributes = array()) {
		print $this->checkboxRow($key, $labelText, $attributes);
	}


	/**
	 * Print the checked attribute as html code.
	 *
	 * @param    string        $key id of checkbox to check
	 * @param    mixed        $comparisValue the comparision value
	 * @return    void
	 */
	function printChecked($key, $comparisValue) {
		print $this->checked($key, $comparisValue);
	}


	/**
	 * Print the closing tag of the form.
	 *
	 * @return    void
	 */
	function printEnd() {
		print $this->end();
	}


	/**
	 * Print the opening tag of a fieldset.
	 *
	 * @param    string        $key id of that fieldset
	 * @param    array        $attributes attributes to the fieldset tag as key=>value
	 * @param    string        $legend the text of the legend
	 * @return    void
	 */
	function printFieldsetBegin($key, $attributes = array(), $legend) {
		print $this->fieldsetBegin($key, $attributes, $legend);
	}


	/**
	 * Print the closing tag of a fieldset.
	 *
	 * @return    void
	 */
	function printFieldsetEnd() {
		print $this->FieldsetEnd();
	}


	/**
	 * Print an hidden field.
	 *
	 * @param    string        $key id of the hidden field
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printHidden($key, $attributes = array()) {
		print $this->hidden($key, $attributes);
	}


	/**
	 * Print an input field.
	 *
	 * @param    string        $key id of the input field
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printInput($key, $attributes = array()) {
		print $this->input($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a input field.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText the text of the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printInputRow($key, $labelText, $attributes = array()) {
		print $this->inputRow($key, $labelText, $attributes);
	}


	/**
	 * Print a label.
	 *
	 * @param    string        $key id of the label
	 * @param    array        $attributes attributes to the label tag as key=>value
	 * @param    string        $text the text of the label
	 * @return    void
	 */
	function printLabel($key, $attributes = array(), $text = NULL) {
		print $this->label($key, $attributes, $text);
	}


	/**
	 * Print the method of this form.
	 *
	 * @return    void
	 */
	function printMethod() {
		print $this->method();
	}


	/**
	 * Print a checkbox list that allows the selection of multiple entries.
	 *
	 * The third parameter options is optional. If it is given, it is used.
	 * By default the key is used to fetch the options from the internal option list array.
	 *
	 * @param    string    $key id of the checkboxes
	 * @param    array        $attributes attributes
	 * @param    array        $options array in value=>text format for select options
	 * @return    void
	 */
	function printMulticheckboxes($key, $attributes = array(), $options = NULL) {
		print $this->multicheckboxes($key, $attributes, $options);
	}


	/**
	 * Print a select that allows the selection of multiple entries.
	 *
	 * The third parameter options is optional. If it is given, it is used.
	 * By default the key is used to fetch the options from the internal option list array.
	 *
	 * @param    string        $key id of the multiselect
	 * @param    array        $attributes attributes to the select tag as key=>value
	 * @param    array        $options array in value=>text format for select options
	 * @return    void
	 */
	function printMultiselect($key, $attributes = array(), $options = NULL) {
		print $this->multiselect($key, $attributes, $options);
	}


	/**
	 * Print the HTML code of a table row containing a label and a multi checkbox list.
	 *
	 * The fourth parameter options is optional. If it is given, it is used.
	 * By default the key is used to fetch the options from the internal option list array.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes
	 * @param    array        $options optional array in value=>text format for select options
	 * @return    void
	 */
	function printMulticheckboxesRow($key, $labelText, $attributes = array(), $options = NULL) {
		print $this->multicheckboxesRow($key, $labelText, $attributes, $options);
	}


	/**
	 * Print the HTML code of a table row containing a label and a multi select.
	 *
	 * The fourth parameter options is optional. If it is given, it is used.
	 * By default the key is used to fetch the options from the internal option list array.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the select tag as key=>value
	 * @param    array        $options array in value=>text format for select options
	 * @return    void
	 */
	function printMultiselectRow($key, $labelText, $attributes = array(), $options = NULL) {
		print $this->multiselectRow($key, $labelText, $attributes, $options);
	}


	/**
	 * Print a input field usable for passwords or other secret things.
	 *
	 * @param    string        $key id of the input tag
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printPassword($key, $attributes = array()) {
		print $this->password($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a password input field.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printPasswordRow($key, $labelText, $attributes = array()) {
		print $this->passwordRow($key, $labelText, $attributes);
	}


	/**
	 * Print a radio button.
	 *
	 * You have to provide a "name" and a "value" entry in the attributes array.
	 * The "name" is used to define the group this button belongs to and the "value"
	 * is the value this button represents.
	 *
	 * @param    string        $key id of the input tag
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printRadio($key, $attributes = array()) {
		print $this->radio($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a radio button.
	 *
	 * You have to provide a "name" and a "value" entry in the attributes array.
	 * The "name" is used to define the group this button belongs to and the "value"
	 * is the value this button represents.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printRadioRow($key, $labelText, $attributes = array()) {
		print $this->radioRow($key, $labelText, $attributes);
	}


	/**
	 * Print a form reset button.
	 *
	 * @param    string        $key id of the input tag
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printReset($key, $attributes = array()) {
		print $this->reset($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a form reset button.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printResetRow($key, $labelText, $attributes = array()) {
		print $this->resetRow($key, $labelText, $attributes);
	}


	/**
	 * Print a select box.
	 *
	 * @param    string        $key id of the select tag
	 * @param    array        $attributes attributes to the select tag as key=>value
	 * @param    array        $options array in value=>text format for select options
	 * @return    void
	 */
	function printSelect($key, $attributes = array(), $options = NULL) {
		print $this->select($key, $attributes, $options);
	}


	/**
	 * Print the HTML code of a table row containing a label and a select box.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the select tag as key=>value
	 * @param    array        $options array in value=>text format for select options
	 * @return    void
	 */
	function printSelectRow($key, $labelText, $attributes = array(), $options = NULL) {
		print $this->selectRow($key, $labelText, $attributes, $options);
	}


	/**
	 * Print the "selected" attribute as html code.
	 *
	 * @param    string        $key id of selectbox to check
	 * @param    mixed        $comparisValue the comparision value
	 * @return    void
	 */
	function printSelected($key, $comparisValue) {
		print $this->selected($key, $comparisValue);
	}


	/**
	 * Print a submit button.
	 *
	 * @param    string        $key id of input tag
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printSubmit($key, $attributes = array()) {
		print $this->submit($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a submit button.
	 *
	 * @param    string        $key id of that row
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the input tag as key=>value
	 * @return    void
	 */
	function printSubmitRow($key, $labelText, $attributes = array()) {
		print $this->submitRow($key, $labelText, $attributes);
	}


	/**
	 * Print a textarea.
	 *
	 * @param    string        $key id of textarea tag
	 * @param    array        $attributes attributes to the textarea tag as key=>value
	 * @return    void
	 */
	function printTextarea($key, $attributes = array()) {
		print $this->textarea($key, $attributes);
	}


	/**
	 * Print the HTML code of a table row containing a label and a submit button.
	 *
	 * @param    string        $key id of textarea tag
	 * @param    string        $labelText text for the label
	 * @param    array        $attributes attributes to the textarea tag as key=>value
	 * @return    void
	 */
	function printTextareaRow($key, $labelText, $attributes = array()) {
		print $this->textareaRow($key, $labelText, $attributes);
	}


	/**
	 * Print the value of a given form element.
	 *
	 * @param    string        $key the id of the form element
	 * @return    void
	 */
	function printValue($key) {
		print $this->value($key);
	}


}


?>
