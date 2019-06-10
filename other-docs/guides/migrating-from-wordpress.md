# Migrating a WordPress Codebase

This guide covers how to migrate a typical WordPress project to Altis.

## Setup Composer

If the project does not already have a `composer.json` in the root of the repository, you should run `composer init` from the project root. This will prompt you fill out the required fields. For now, don’t bother adding any dependencies. If you already have a `composer.json` move to Remove Dependencies.

## Remove Dependencies

We’ll need to remove all the dependencies that are part of Altis, as those will be installed by Altis itself. Firstly, remove any submodules that are included in Altis. For example, `wordpress` and `hm-platform` submodules. To correctly remove a submodule:

1. `git submodule deinit -f wordpress`
2. `git rm -rf wordpress`
3. `rm -rf .git/modules/wordpress`

Do the same for `hm-platform` if you have this project dependency. Altis also includes the following WordPress plugins, so if your project uses git submodules or composer to include them, you should remove them from your project (unless you plan to disable the Altis module that makes use of the plugin, and continue with the plugin directly):

- `smart-media`
- `gaussholder`
- `aws-rekognition`
- `two-factor`
- `stream`
- `wp-simple-saml`
- `delegated-oauth`
- `elasticpress`
- `hm-redirects`
- `msm-sitemap`
- `wp-seo`
- `amp`
- `facebook-instant-articles-wp`
- `meta-tags`
- `query-monitor`
- `hm-gtm`
- `workflows`
- `wp-user-signups`

## Move wp-config.php

Installing Altis will replace your `wp-config.php` so you should back it up if you have application level configuration in your `wp-config.php`.

## Installing Altis

Now you have your composer project up and running, it’s time to add Altis to the project. Do so by running `composer require altis/altis`.

Once Altis has been installed, you should see the `wordpress` directory back in the project root, a new `wp-config.php` and `index.php`. Add these 3 files to your project's `.gitignore` file, as they should not be committed to version control. If your project had no `.gitignore` file, one will have been created for you.

## Restore site configuration

If you have any custom configuration in your old `wp-config.php` (such as custom PHP constants, etc. You will need to put them into a new file outside of `wp-config.php` (as changes to this file are not allowed). It’s possible your project already has the configuration split out into a `.config` directory, but if not, create a file at `.config/load.php`.

Only copy across constants that your custom code actually needs. There should be no database constants, or any other WordPress type constants. If you have these already in your `.config` directory, you should delete those.

The `.config/load.php` file will be automatically included from the generated `wp-config.php`.

## Migrate $hm_platform options (when applicable)

In your old `wp-config.php` you’ll see there is a `global $hm_platform` that sets options for hm-platform. Only migrate anything that you specifically need to, as most likely Altis will have better defaults. In rare cases though, things will be disabled for good reason. In Altis, most of the same settings are supported, but it’s now done via the `composer.json` for configuration (as is all Altis configuration). You should be familiar with [Altis configuration](docs://getting-started/configuration.md) before continuing. `$hm_platform` options should go in the `altis.modules.cloud` section of the `extra` block in the `composer.json`.

```json
{
	"extra": {
		"altis": {
			"modules": {
				"cloud": {
					"batcache": false
				}
			}
		}
	}
}
```

## Rename content/plugins-mu to content/mu-plugins

Altis uses the standard WordPress must-use plugins directory of `content/mu-plugins` so if your project is using something different, it should be renamed.

## Add composer install to the build script

If you project was not previously using composer, you'll need to add a `composer install --no-dev` to your projects `.build-script`. Simply add the following line to your `.build-script` or create that file if it doesn't already exist.

```
composer install --no-dev
```

## Setup the local server

Assuming your project uses Chassis for local development, we’ll be removing the local Chassis install, and installing the Altis module. If you have a setup script (such as `.bin/setup.sh`) you should remove any Chassis setup / installation steps.
Once you have cleaned out Chassis, install the `altis/local-chassis` composer package as a dev dependency.

```
composer require --dev altis/local-chassis
```

Once completed, install and start your local server with `composer chassis init` and then `composer chassis start`. You should now be able to navigate to http://altis.local to see the site!

## Migrating email sending domain

It's quite possible your project specifies the wp mail sending domain via the `wp_mail_from` hook. This can now be specified as setting in the `composer.json`'s `extra.altis.modules.cloud.email.email-from-address` setting:

```json
{
	"modules": {
		"cloud": {
			"email-from-address": "webmaster@mydomainname.com"
		}
	}
}
```

## Optionally disable Altis branding

As this guide is for migrating a non-Altis project to use Altis, it's possible the client relationship and understanding does warrant changing anything visible or user-facing. If you are sure this is an "under the hood" migration, and the client has not been on-boarded with Altis as a brand, you can disable the branding via the `altis.modules.cms.branding` setting:

```json
{
	"modules": {
		"cms": {
			"branding": false
		}
	}
}
```

## Optionally disable Altis features

There are some features of Altis that are user-facing and default-on that you might want to audit. For example, image [lazy loading](docs://media/lazy-loading.md) via Guassholder is on by default. Smart Media with Cropping UI is enabled by default. You should consult the Altis documentation for the behaviour of specific modules. Again, unless there is specific reason to disable feature and modules, we recommend keeping them on.

Any module can be disabled by setting its `enabled` setting to `false`:

```json
{
	"extra": {
		"altis": {
			"modules": {
				"seo": {
					"enabled": false
				}
			}
		}
	}
}
```

## Deploying to Cloud

The first time Altis is deployed, depending on the exact configuration, there may be tasks to perform on deploy. Altis is always configured to be a WordPress multisite, as such any sites that are not on installed as Multisite already, will need converting via the `multisite-convert` WP CLI command.

As always, be sure to test the migration and deployment in `development` or `staging` environments before rolling out to production.