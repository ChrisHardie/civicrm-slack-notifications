<?php

/**
 * @file
 * Establish settings page parameters for Slack notification extension.
 */

return [
  'slacknotifications_slack_webhook' => [
    'name'            => 'slacknotifications_slack_webhook',
    'type'            => 'String',
    'add'             => '4.7',
    'is_domain'       => 1,
    'is_contact'      => 0,
    'default'         => [],
    'title'           => \CRM_CiviMobileAPI_ExtensionUtil::ts('Slack webhook URL'),
    'description'     => \CRM_CiviMobileAPI_ExtensionUtil::ts('Incoming webhook URL provided by Slack'),
    'html_type'       => 'text',
    'html_attributes' => [
      'size' => 70,
    ],
    'settings_pages'  => ['slacknotifications' => ['weight' => 5]],
  ],
];
