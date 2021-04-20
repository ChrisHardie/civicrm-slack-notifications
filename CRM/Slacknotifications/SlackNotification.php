<?php

/**
 * Class to process CiviRules action.
 */

use Civi\Token\TokenProcessor;
use Maknz\Slack\Client;

class CRM_Slacknotifications_SlackNotification extends CRM_Civirules_Action {

  /**
   * Method processAction to execute the action.
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   *   Trigger Data.
   *
   * @access public.
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $slack_webhook_url = Civi::settings()->get('slacknotifications_slack_webhook');

    if (FALSE === strpos($slack_webhook_url, 'https://hooks.slack.com/services/')) {
      return;
    }

    $action_params = $this->getActionParameters();

    $message_template = $action_params['message_template'];
    $channel = $action_params['channel'];

    $message = $this->replaceTokens($message_template, $triggerData);

    $client_settings = [
      'channel' => $channel,
    ];

    $accessory = $this->getNotificationAccessory($triggerData);

    $client = new Client($slack_webhook_url, $client_settings);

    if (!empty($accessory)) {
      $client
        ->withBlock([
          'type'      => 'section',
          'text'      => [
            'type' => 'mrkdwn',
            'text' => $message,
          ],
          'accessory' => $accessory,
        ])
        ->send($message);
    }
    else {
      $client->send($message);
    }
  }

  /**
   * Method to return the url for additional form processing.
   *
   * @param int $ruleActionId
   *   The ID of this action within the rule.
   *
   * @return bool
   *   Return value
   *
   * @access public.
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/slacknotificationdetails', 'rule_action_id=' . $ruleActionId);
  }

  /**
   * Set user-friendly description of condition parameters.
   */
  public function userFriendlyConditionParams() {
    $params = $this->getActionParameters();
    $labels = [];
    $labels['message_template'] = 'Message template: ' . $params['message_template'];
    $labels['Channel'] = 'Channel: ' . $params['channel'];

    return implode('<br />', $labels);
  }

  /**
   * Replace any tokens found in the message template.
   */
  protected function replaceTokens($template, $triggerData) {
    $contactId = $triggerData->getContactId();
    $message = $template;
    if (!empty($contactId) && !empty($template) && strpos($template, '{') !== FALSE) {
      $tp = new TokenProcessor(
            \Civi::dispatcher(),
            [
              'controller' => __CLASS__,
              'smarty'     => FALSE,
            ]
        );
      $tp->addMessage('slack_message', $message, 'text/plain');
      $row = $tp->addRow();
      $row->context('contactId', $contactId);
      // @todo add more context depending on the action entity
      $tp->evaluate();
      $message = $tp->render('slack_message', $row);
    }

    return $message;
  }

  /**
   * If possible, set up a Slack accessory (button).
   */
  protected function getNotificationAccessory($triggerData): array {

    $contactId = $triggerData->getContactId();

    $accessory = [
      'type'      => 'button',
      'text'      => 'View Details',
      'action_id' => 'view_civicrm',
      'url'       => CRM_Utils_System::url('civicrm'),
    ];

    if (!empty($contactId)) {
      $contact = civicrm_api3('Contact', 'getsingle', ['id' => $contactId]);
      $accessory['text'] = 'View ' . $contact['display_name'];
      $accessory['url'] = CRM_Utils_System::url('civicrm/contact/view', 'reset=1&cid=' . $contactId, TRUE, NULL, FALSE, FALSE, TRUE);
    }

    return $accessory;

  }

}
