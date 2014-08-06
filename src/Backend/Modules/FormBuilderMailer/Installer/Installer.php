<?php

namespace Backend\Modules\FormBuilderMailer\Installer;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the Form Builder Mailer module
 *
 * @author webleads <fork@webleads.nl>
 */
class Installer extends ModuleInstaller
{
	public function install()
	{
		// install the module in the database
		$this->addModule('form_builder_mailer');

		// install the locale, this is set here because we need the module for this
		$this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

		$this->setModuleRights(1, 'form_builder_mailer');
        $this->setActionRights(1, 'form_builder_mailer', 'Settings');

        // settings navigation
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'FormBuilderMailer', 'form_builder_mailer/settings');

        BackendModel::setModuleSetting('form_builder_mailer', 'enabled', true);
        BackendModel::subscribeToEvent(
            'FormBuilder',
            'after_submission',
            'FormBuilderMailer',
            array('Backend\Modules\FormBuilderMailer\Model', 'afterFormSubmission')
        );
	}
}