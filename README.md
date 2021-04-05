# Slack Notifications for CiviCRM

This extension allows CiviCRM to send notifications to Slack when an Individual, Contribution or Pledge is created or modified.

The extension is beta software, and may not be suitable for a production environment. Issues and pull requests welcome.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.2+
* CiviCRM 5+
* Command line access for `composer install`

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.chrishardie.slacknotifications@https://github.com/ChrisHardie/civicrm-slack-notifications/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/ChrisHardie/civicrm-slack-notifications.git com.chrishardie.slacknotifications
cv en com.chrishardie.slacknotifications
```

(The `cv en` command does not appear to be valid for WordPress installs.)

## Getting Started

You may need to do a `composer install` to get required librarires in place.

Follow [Slack's documentation to set up an Incoming Webhook](https://slack.com/help/articles/115005265063-Incoming-webhooks-for-Slack) and get the URL.

Navigate to Administer -> System Settings -> Slack Notification Settings.

## Known Issues

* This is the author's first CiviCRM extension and probably contains errors or failures to adhere to best practices
* Checkboxes on settings screen have extra bullet points in front of them, weird
* The Slack messages could be improved to be more generally useful across CiviCRM use cases
* The list of supported objects for notifications is hardcoded but should be dynamic
* Configuration of the Slack message icon and name must be done in the Incoming Webhook settings
