<?php

/**
 * Form controller class.
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Slacknotifications_Form_SlackNotificationDetails extends CRM_CivirulesActions_Form_Form {

  /**
   * Build the form.
   */
  public function buildQuickForm() {

    // Add form elements.
    $this->setFormTitle();
    $this->add('hidden', 'rule_action_id');

    // Slack message template.
    $this->add(
    // Field type.
    'text',
    // Field name.
    'message_template',
    // Field label.
    'Slack message template',
    ['size' => 50],
    // Is required.
    TRUE
     );

    // Slack Channel.
    $this->add(
    // Field type.
    'text',
    // Field name.
    'channel',
    // Field label.
    'Slack Channel<br />(Blank for default associated with incoming webhook.)',
    ['placeholder' => '#channel'],
    // Is required.
    FALSE
     );
    $this->addButtons(
    [
                [
                  'type'      => 'next',
                  'name'      => ts('Save'),
                  'isDefault' => TRUE,
                ],
                [
                  'type' => 'cancel',
                  'name' => ts('Cancel'),
                ],
    ]
     );

    // Export form elements.
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Set the default values.
   */
  public function setDefaultValues(): array {
    $defaultValues = parent::setDefaultValues();
    $data = unserialize($this->ruleAction->action_params, ['allowed_classes' => TRUE]);

    if (!empty($data['channel'])) {
      $defaultValues['channel'] = $data['channel'];
    }
    if (!empty($data['message_template'])) {
      $defaultValues['message_template'] = $data['message_template'];
    }
    else {
      $defaultValues['message_template'] = 'The rule was triggered.';
    }

    return $defaultValues;
  }

  /**
   * Get the submitted data.
   */
  protected function getSubmittedData(): array {
    $data = [];
    $data['message_template'] = $this->_submitValues['message_template'];
    $data['channel'] = $this->_submitValues['channel'];

    return $data;
  }

  /**
   * Process the submitted data.
   */
  public function postProcess() {
    $data = $this->getSubmittedData();
    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array
   *   (string)
   */
  public function getRenderableElementNames(): array {
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }

    return $elementNames;
  }

}
