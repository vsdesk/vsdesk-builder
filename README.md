vsDesk Builder
==============

How it works 
-----
It is about two main things:

 - A user interface like a workbench tool to quickly prototype application schema (entities,attributes,relations,..) 
 - A list of console commands dynamically generated based on the prototype and executed in terminal. Those commands should do stuff like cleaning DB, create and execute migrations, use [Gii](https://github.com/yiisoft/yii2-gii) to generate models, CRUDs, ...


> :bangbang: **IMPORTANT** :bangbang: 

> This extension is meant **to be used with new creations only**. If Gii UI has the decency to ask before overriding stuff, this extension won't. Its default Gii console commands are labeled by  `--interactive=0` and `--overwrite=1 ` flags. So **it will literally destroy your DATABASE plus any existing code found on its way**.


 Installation
-----

Install via composer

```
php composer.phar require --prefer-dist vsdesk/vsdesk-builder "*"
```

or by adding

```
"vsdesk/vsdesk-builder": "*"
```

to the require-dev section of your `composer.json` file.


Usage
-----

Once the extension is installed, add it to **both** `web.php` and `console.php` configuration files:

```php
/* preferably to add under 'dev' environment */

if (YII_ENV_DEV) {
   
    $config['bootstrap'][] = 'builder';
    $config['modules']['builder'] = [
        'class' => 'vsdesk\builder\Module',
        /**
	  * Optional Attributes
	  *
	  * 'allowedIPs' => ...
	  * 'yiiScript' => ...
	  * 'dataPath' => ...
	  * 'previewUrlCallback' => ...
	  * 'commands' => ...
	  */
    ]; 
}
```

You can then access it through the following URL:
```
http://localhost/path/to/index.php?r=builder
```
or `http://localhost/path/to/index.php/builder` depending on your app routing configurations. Also note that it is not required to name the module `builder` you can use `schema-builder` or any other name you like.

Once there, create your first schema *(ex: admin, v1)*, set all its related configurations at once *(form inputs are organized within **different tabs**)* then click on the created schema to get into its view page and start adding entities *(ex: user, book)*. To each entity you need to add attributes and define relationships if there is any *(no need to declare any  `id` or `xxx_id`  columns as those will be auto generated)*. Once your schema is complete go back to its view page and hit that **GENERATE** button.

Optional Attributes
-----
**allowedIPs:** The list of IP adresses allowed to access the builder tool. default to `['127.0.0.1', '::1']`.

**yiiScript:** The path that points to `./yii` script. default to `@app/yii`.

**dataPath:** Path to store GUI related data and settings. default to `'runtime/schema-builder/data'`.

**previewUrlCallback:** If the preview link doesn't correctly point to your resources, this is where you declare your own function to generate the correct link. see default implementation [here](https://github.com/vsdesk/vsdesk-builder/blob/65156f6ad057779d4a5f060ae9efa84892ed14fa/models/Entity.php#L86-L94).

**commands:** This is the array holding the list of commands to be dynamically generated. A command can be represented within a simple *string*, a *callable function* or a *generator*:

```php
$commands = [
    // a string example representing the command to be executed
    'yii migrate/up --interactive=0',

    // a callable example returning a command or a list of commands to be executed
    function($schema) {
	// implement your logic here then
	// return either a string or an array of strings
    }

    // a custom generator (where you can also set default form values)
    [
        'class' => 'vsdesk\builder\generators\model\Generator',
        'defaultAttributes' => [
            'ns' => 'api\modules\v1\models',
            'queryNs' => 'api\modules\v1\models',
        ],
    ],
];
```

Custom generators are required when you need to collect user inputs for settings. A generator should have a `form.php` file (like gii generators) that will be auto rendered in a separate tab with the schema create/update form. Related inputs will be saved within GUI data.

Default value of `$commands` is the following:

```php
$commands = [
    ['class' => 'vsdesk\builder\generators\migration\Generator'],
    ['class' => 'vsdesk\builder\generators\module\Generator'],
    ['class' => 'vsdesk\builder\generators\model\Generator'],
    ['class' => 'vsdesk\builder\generators\crud\Generator']
];
```

Copy any of those classes from the extension and adapt it to your needs when you need to create a custom generator.

Keep in mind when building your own logic that both callable functions as generators have access to the `$schema` instance being selected. From that instance you can access to all the GUI ActiveRecord classes which are *Attribute*, *Entity* and *Relationship*. Please refer to `vsdesk\builder\models` folder and see the code for more details.

Other example, an advanced example list of commands could also be seen [here](https://github.com/vsdesk/yii2-app-builder/blob/0a0c4042f74421dc28c4fc3a07550b41cde99e47/environments/dev/api/config/main-local.php#L40-L81) which are the related commands for generating working REST resources in the app template I linked before.

 Built With
-----

 - [yiisoft/yii2](https://github.com/yiisoft/yii2)  -  this extension is powered by and for [Yii framework 2.0](http://www.yiiframework.com/) based applications.
 - [yiisoft/yii2-gii](https://github.com/yiisoft/yii2-gii) - the official Gii Extension for Yii framework 2.0.
 - [yiisoft/yii2-bootstrap](https://github.com/yiisoft/yii2-bootstrap) - the official Twitter Bootstrap extension for Yii framework 2.0.
 - [yii2tech/filedb](https://github.com/yii2tech/filedb) - an extension by @klimov-paul to use files for storage like db. Used to store all related GUI data.
 - [designmodo/Flat-UI](https://github.com/designmodo/Flat-UI) - a twitter bootstrap theme by @designmodo *(implemented with slight color modifications)*.
 - Code snippets from different places. Usually linked within a comment [like this one](https://github.com/vsdesk/vsdesk-builder/blob/f56d61bbcfdd94d243002e1716b9a517a3d7791a/controllers/DefaultController.php#L299) which was copied from [samdark/yii2-webshell](https://github.com/samdark/yii2-webshell) extension by @samdark.


License
------------
This project is licensed under the MIT License - see the [LICENSE.md](https://raw.githubusercontent.com/vsdesk/vsdesk-builder/master/LICENSE.md) file for details.
