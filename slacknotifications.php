<?php

/**
 * @file
 * Base Slack Notifications extension file.
 */

require_once 'slacknotifications.civix.php';
// phpcs:disable
use CRM_Slacknotifications_ExtensionUtil as E;
// phpcs:enable

require __DIR__ . '/vendor/autoload.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function slacknotifications_civicrm_config(&$config) {
  _slacknotifications_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function slacknotifications_civicrm_xmlMenu(&$files) {
  _slacknotifications_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function slacknotifications_civicrm_install() {
  _slacknotifications_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function slacknotifications_civicrm_postInstall() {
  _slacknotifications_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function slacknotifications_civicrm_uninstall() {
  _slacknotifications_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function slacknotifications_civicrm_enable() {
  _slacknotifications_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function slacknotifications_civicrm_disable() {
  _slacknotifications_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function slacknotifications_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _slacknotifications_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function slacknotifications_civicrm_managed(&$entities) {
  _slacknotifications_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function slacknotifications_civicrm_caseTypes(&$caseTypes) {
  _slacknotifications_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function slacknotifications_civicrm_angularModules(&$angularModules) {
  _slacknotifications_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function slacknotifications_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _slacknotifications_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function slacknotifications_civicrm_entityTypes(&$entityTypes) {
  _slacknotifications_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function slacknotifications_civicrm_themes(&$themes) {
  _slacknotifications_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
// Function slacknotifications_civicrm_preProcess($formName, &$form) {
//
// }.

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */

/**
 * Function slacknotifications_civicrm_navigationMenu(&$menu) {
 * _slacknotifications_civix_insert_navigation_menu($menu, 'Mailings', array(
 * 'label' => E::ts('New subliminal message'),
 * 'name' => 'mailing_subliminal_message',
 * 'url' => 'civicrm/mailing/subliminal',
 * 'permission' => 'access CiviMail',
 * 'operator' => 'OR',
 * 'separator' => 0,
 * ));
 * _slacknotifications_civix_navigationMenu($menu);
 * }
 */
function slacknotifications_civicrm_post($op, $objectName, $objectId, &$objectRef) {

  $slack_webhook_url = Civi::settings()->get('slacknotifications_slack_webhook');

  if (FALSE === strpos($slack_webhook_url, 'https://hooks.slack.com/services/')) {
    return;
  }

  // If ( in_array( $objectName, array( 'Individual', 'Contribution', 'Pledge' ), true ) ) {
  //        switch( $objectName) {
  //            case 'Individual':
  //                $display_name = sprintf( '%s (%s)', $objectRef->display_name, $objectName );
  //                $url          = CRM_Utils_System::url( 'civicrm/contact/view', 'reset=1&cid=' . $objectId, true, null, false, false, true );
  //                break;
  //            case 'Contribution':
  //                $display_name = 'Contribution #' . $objectId;
  //                $url          = CRM_Utils_System::url( 'civicrm/contact/view/contribution', 'action=view&reset=1&context=home&id=' . $objectId, true, null, false, false, true );
  //                break;
  //            case 'Pledge':
  //                $display_name = 'Pledge #' . $objectId;
  //                $url          = CRM_Utils_System::url( 'civicrm/contact/view/pledge', 'action=view&reset=1&context=home&id=' . $objectId, true, null, false, false, true );
  //                break;
  //            default:
  //                $url          = null;
  //                $display_name = 'an object';
  //        }
  //
  //        $message = sprintf(
  //            '%s performed on <%s|%s>',
  //            $op,
  //            $url,
  //            $display_name,
  //        );
  //
  //        $client = new Maknz\Slack\Client( $slack_webhook_url );
  //
  //        if ( ! empty( $url ) ) {
  //            $client
  //                ->withBlock([
  //                    'type'      => 'section',
  //                    'text'      => [
  //                        'type' => 'mrkdwn',
  //                        'text' => $message,
  //                    ],
  //                    'accessory' => array(
  //                        'type'      => 'button',
  //                        'text'      => 'View Record',
  //                        'action_id' => 'view_civicrm_record',
  //                        'url'       => $url,
  //                    ),
  //                ])
  //                ->send( $message );
  //        } else {
  //            $client->send( $message );
  //        }
  //    }.
}

/**
 * Set up navigation menu item.
 */
function slacknotifications_civicrm_navigationMenu(&$menu) {
  _slacknotifications_civix_insert_navigation_menu($menu, 'Administer/System Settings', [
    'label'      => E::ts('Slack Notification Settings'),
    'name'       => 'slacknotifications',
    'url'        => 'civicrm/admin/settings/slacknotifications',
    'permission' => 'administer CiviCRM',
  ]);
}
