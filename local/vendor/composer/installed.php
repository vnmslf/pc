<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => null,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => null,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'akh/typograf' => array(
            'pretty_version' => 'v0.4.10',
            'version' => '0.4.10.0',
            'reference' => 'ee8f30b22819b254f419b30c56edb464b26f05cc',
            'type' => 'library',
            'install_path' => __DIR__ . '/../akh/typograf',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'andreyryabin/sprint.migration' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '3a5789fc049dec8d3a848969ffaa555eadf7d369',
            'type' => 'bitrix-module',
            'install_path' => __DIR__ . '/../../modules/sprint.migration',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'composer/installers' => array(
            'pretty_version' => 'v1.12.0',
            'version' => '1.12.0.0',
            'reference' => 'd20a64ed3c94748397ff5973488761b22f6d3f19',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'phpmailer/phpmailer' => array(
            'pretty_version' => 'v6.9.3',
            'version' => '6.9.3.0',
            'reference' => '2f5c94fe7493efc213f643c23b1b1c249d40f47e',
            'type' => 'library',
            'install_path' => __DIR__ . '/../phpmailer/phpmailer',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roundcube/plugin-installer' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
    ),
);
