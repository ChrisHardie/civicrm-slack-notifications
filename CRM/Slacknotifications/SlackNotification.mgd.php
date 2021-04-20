<?php

/**
 * @file
 * Metadata for Slack notification extension.
 */

return [
  0 =>
        [
          'name'   => 'Civirules:Action.SlackNotification',
          'entity' => 'CiviRuleAction',
          'params' =>
                [
                  'version'    => 3,
                  'name'       => 'notify_slack',
                  'label'      => 'Notify Slack',
                  'class_name' => 'CRM_Slacknotifications_SlackNotification',
                  'is_active'  => 1,
                ],
        ],
];
