# PROJECT WAS MOVED!

New repository for this project can be found [here](https://gitlab.com/Zag/intrigo-plugin-box)

# WordPress Plugin Boilerplate

Plugin base for flexible and easy extensible Wordpress plugin.

## Getting Started

If you want to contribute to this plugin˙s skelet and setup development instance all you need to do is clone the repository to plugins directory of your WP installation and activate the plugin.

### Prerequisites

You need to have [Composer](https://getcomposer.org/) installed to be able to run this project.

### Installing

Clone repository and create a development source.

```
cd wp-content/plugins
git clone https://github.com/zagm//WordPress-Plugin-Boilerplate.git <plugin-new-name>
```

Move into RefineIt module and clone support project related to this one to get all fundamental pices of plugin boilerplate.

```
git clone https://gitlab.com/Zag/refine-it-support.git
```


Create a symbolic link of a repository src folder to real plugin folder (see the example below)

```
ln -s dev-<plugin-new-name>/src <plugin-new-name>
```

Install plugin dependencies

```
cd <plugin-new-name>
composer.phar install
```

Update plugin header located in ``refine-it-plugin.php`` to match your needs.

Rename ``refine-it-plugin.php`` to ``<plugin-name>.php``.

```
mv refine-it-plugin.php <plugin-name>.php
```

If everything was done right you should see your plugin on plugins page on admin dashboard. Activation and deactivation should already be functional.

Use Wordpress plugin box (``wppb.php``) to acomplish common tasks faster.

### Add new modulue

Run command below to create new module called ```Test```. Please note that after you create a new module like that you should check and adjust configuration options located in ``config`` folder.

```
php wppb.php module create Test
```

Run command below to add new controller named ```MyController```  to module ```Test```.

```
php wppb.php controller Test MyController
```

Run command below to add new database model named ```MyModel```  to module ```Test```.

```
php wppb.php model Test MyModel
```

For new module to actually take any effect on the plugin we have to load it in file that contains WP header (place it under "Load modules" section). For example if you would want to load module ```Test``` all you need to do is place two lines into returned array like so:

```
\RefineIt\Support\Config::go(__DIR__ . '/Test'),
new \RefineIt\Support\Autoloader('Test'),
```

## Running the tests

@todo

## Deployment

1. Once your are happy with your plugin commit changes to your repository clone it again to safe place on a production server (not directory, that is accessible via browser) and use wppb´s ``publish`` command to place plugin into Wordpress plugin directory (please manually copy enitre source folder until this command is not implemented).
1. Check and change permissions on plugin folder if necessarry.
1. Activate plugin via Wordpress admin page.

## Changelog

You can find log of changes inside ``CHANGELOG.md`` file.

## Documentation

Documetation for RefineIt Plugin can be found [here](https://maticzagmajster.ddns.net/docs/refine-it-plugin/).

## Built With

* [PHP](http://www.dropwizard.io/1.0.2/docs/) - Programming language
* [Composer](https://getcomposer.org/) - Dependency Management
* [php-cli](https://github.com/splitbrain/php-cli) - Command line tool used to speed up the process.

## Contributing

Please read ```CONTRIBUTING.md``` for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the tags on this repository. 

## Authors

This fork was created by Matic Zagmajster. For more information please see ```AUTHORS``` file.

## License

This project is licensed under the GNU v3.0 License - see the ```LICENSE.md``` file for details.

## Acknowledgments

* Big thanks goes to @theantichris for inspiration on this project.
