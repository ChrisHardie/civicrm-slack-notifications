<?php

class CRM_Slacknotifications_SlackNotification extends CRM_Civirules_Action {

	/**
	 * Method processAction to execute the action
	 *
	 * @param CRM_Civirules_TriggerData_TriggerData $triggerData
	 * @access public
	 *
	 */
	public function processAction( CRM_Civirules_TriggerData_TriggerData $triggerData ) {
		$slack_webhook_url = Civi::settings()->get( 'slacknotifications_slack_webhook' );

		if ( false === strpos( $slack_webhook_url, 'https://hooks.slack.com/services/' ) ) {
			return;
		}

		$action_params = $this->getActionParameters();

		$client = new Maknz\Slack\Client( $slack_webhook_url );

		$client->send( 'Rule successfully triggered.' );
	}

	/**
	 * Method to return the url for additional form processing for action
	 * and return false if none is needed
	 *
	 * @param int $ruleActionId
	 * @return bool
	 * @access public
	 */
	public function getExtraDataInputUrl( $ruleActionId ) {
		return CRM_Utils_System::url( 'civicrm/civirule/form/action/slacknotificationdetails', 'rule_action_id='.$ruleActionId );
	}

	public function userFriendlyConditionParams() {
		$params = $this->getActionParameters();
		$labels = array();
		$labels['message_template'] = 'Message template: ' . $params['message_template'];
		$labels['Channel'] = 'Channel: ' . $params['channel'];
		return implode('<br />', $labels);
	}
}