<?php

use CRM_CiviMobileAPI_ExtensionUtil as E;

return array(
	'slacknotifications_slack_webhook' => array(
		'name'            => 'slacknotifications_slack_webhook',
		'type'            => 'String',
		'add'             => '4.7',
		'is_domain'       => 1,
		'is_contact'      => 0,
		'default'         => array(),
		'title'           => E::ts( 'Slack webhook URL' ),
		'description'     => E::ts( 'Incoming webhook URL provided by Slack' ),
		'html_type'       => 'text',
		'html_attributes' => array(
			'size' => 70,
		),
		'settings_pages'  => ['slacknotifications' => ['weight' => 5]],
	),
);
