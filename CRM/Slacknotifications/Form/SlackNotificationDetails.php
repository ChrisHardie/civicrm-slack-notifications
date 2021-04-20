<?php

use CRM_Slacknotifications_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Slacknotifications_Form_SlackNotificationDetails extends CRM_CivirulesActions_Form_Form {
	public function buildQuickForm() {

		// Add form elements

		// Slack message template
		$this->add(
			'text', // field type
			'message_template', // field name
			'Slack message template', // field label
			array( 'size' => 50 ),
			true // is required
		);


		// Slack Channel
		$this->add(
			'text', // field type
			'channel', // field name
			'Slack Channel (blank for default associated with incoming webhook)', // field label
			null,
			false // is required
		);
		$this->addButtons(
			array(
				array(
					'type'      => 'submit',
					'name'      => E::ts( 'Submit' ),
					'isDefault' => false,
				),
			)
		);

		// export form elements
		$this->assign( 'elementNames', $this->getRenderableElementNames() );
		parent::buildQuickForm();
	}

	public function setDefaultValues() {
		$defaultValues = parent::setDefaultValues();
		$data          = unserialize( $this->ruleAction->action_params, array( 'allowed_classes' => true ) );

		if ( ! empty( $data['channel'] ) ) {
			$defaultValues['channel'] = $data['channel'];
		}
		if ( ! empty( $data['message_template'] ) ) {
			$defaultValues['message_template'] = $data['message_template'];
		} else {
			$defaultValues['message_template'] = 'The rule was triggered.';
 		}

		return $defaultValues;
	}

	public function postProcess() {
		parent::postProcess();
	}

	/**
	 * Get the fields/elements defined in this form.
	 *
	 * @return array (string)
	 */
	public function getRenderableElementNames() {
		$elementNames = array();
		foreach ( $this->_elements as $element ) {
			/** @var HTML_QuickForm_Element $element */
			$label = $element->getLabel();
			if ( ! empty( $label ) ) {
				$elementNames[] = $element->getName();
			}
		}

		return $elementNames;
	}
}
