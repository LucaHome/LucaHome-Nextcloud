<?php

/**
 * This file is licensed under the MIT License.
 * @author Jonas  Schubert <guepardoapps@gmail.com>
 * @copyright (c) 2019, Jonas Schubert
 * Source: https://github.com/nextcloud/bookmarks/blob/master/appinfo/app.php
 */

namespace OCA\LucaHome\AppInfo;

$navigationEntry = function () {
	return [
		'id' => 'lucahome',
		'order' => 10,
		'name' => \OC::$server->getL10N('lucahome')->t('LucaHome'),
		'href' => \OC::$server->getURLGenerator()->linkToRoute('lucahome.web_view.index'),
		'icon' => \OC::$server->getURLGenerator()->imagePath('lucahome', 'lucahome.svg'),
	];
};

\OC::$server->getNavigationManager()->add($navigationEntry);