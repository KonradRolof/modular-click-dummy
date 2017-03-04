modular-click-dummy
===================

*Author: [Konrad Rolof](http://www.konrad-rolof.de)*

> Building click dummies as a prototype for enormous frameworks like Symfony or Typo3 is often a lot of copy and past of markup. It is not just wasted time to copy your code. The big trouble comes with working in a team or if you must make changes.  
So it's better to write the markup of a module just one time an include it at the points where it's needed. This little system should help you the build click dummies easier.

## What you need?

Include HTML modules just with HTML is not possible unfortunately. So you need some things:

1. **PHP**: With PHP you get the possibility to include files into an other File.
2. **PHP-Files**: You have to write your markup in PHP file instead of HTML files.
3. **Server**: To run a PHP application you need a server. It doesn't matter if you use a virtual localhost or a physically server.
4. **These files**: You have to include these 3 little PHP files.

## What you get?

Of course you could simply use the PHP `include` function to include code in from one file to another. So why you should use the modular-click-dummy system?
The modular-click-dummy system is based on a PHP class and comes with some little features:

* You could use variables to add optional classes to module markup. Or you use these variables to make simple `if`-`else` conditions.
* Use PHP objects saved in variables to include your modules. It is easier and saver as writing `include 'pathToFile/moduleName.php` every time.
* Get exceptions if you make a mistake with useful information instead of a blank page in your browser

---

## Getting started

Now how to use the modular-click-dummy system?

### Preparation
* As I wrote before, you need to write your markup in PHP files instead of HTML files.
* Add the directories `classes` and `inc`, with the files in it, to your project.

### Include the system to your click dummy
* Include the file `_bootstrap.inc.php` from the directory `inc` at the top of your pages:

```PHP
<?php
require_once __DIR__ . '/inc/_bootstrap.inc.php';
?>
```

### Make a module
* The markup you want to exclude in a module comes in a single file. The file should be named like `module-name.inc.php`. Important is the part **.inc** before the file extension
* Save your module files in the directory `inc`
* Save new module object in a variable inside the file `_modules.inc.php` and transfer the module name to the class `Module`. The name should be the part of the file name before `.inc.php`

```PHP
$navigation = new Module('navigation');
```
_this example loads the module file_ `navigation.inc.php`

### Include a module in your markup

To load a module in your pages you have to add short PHP snippets in your markup.

```HTML
<div>
    <?php $navigation->render(); ?>
</div>
```

The method `render()` of your module PHP object include the module file in your page at the point of the PHP code.

## Using variables in your modules

The biggest feature of the modular-click-dummy system is, that you could use variables for optional classes or simple `if`-`else` conditions. Let's look how it works.

### Define default values

To use variables inside your module you have to declare the variables and give it a default value. Inside the `_modules.inc.php` after you created a new module you call the method `setVars` on the module object.

```PHP
$navigation = new Module('navigation');
$navigation->setVars(
    array(
        'additionalClass' => '',
        'active' => 1
    )
);
```

The method `setVars()` expects an associative array as parameter. The keys will be the names of the variables. So the key `'active'` becomes the variable `$active`. The values of the array becomes the default values of your variables.
You could define strings, empty strings, integers or booleans as default values for your variables.

### Adding the variables to your modules

To use the defines variables inside your modules you have to add short PHP snippets to your markup again. To output the value of a variable use `echo`.

#### Output the value of a variable
```HTML
<nav class="nav <?php echo $additionalClass; ?>">
    more markup
</nav>

becomes:

<nav class="nav ">
    more markup
</nav>
```

#### if else condition
```HTML
<li <?php if ($active === 1) : ?>class="active"<?php endif; ?>>
    <a href="#">Link</a>
</li>

becomes:

<li class="active">
    <a href="#">Link</a>
</li>
```

### Overwrite default values

Defining variables just make sense if you can overwrite them on certain points. To do this you could transfer a new associative array as optional parameter to the method `render()`.

```HTML
<div>
    <?php $navigation->render(array('additionalClass'=>'smaller')); ?>
</div>
```

You don't have to add values for all variables. Set just key value pairs for the variables you want to change.

## Using modules inside modules

Because it's possible to save PHP objects in variables you can easily add a module to an other module. It is just important the module you want to include is defined before the module in which it will be included.

```PHP
$navigation = new Module('navigation');

$header = new Module('header');
$header->setVars(
    array(
        'navigationModule' => $navigation
    )
);
```

The markup inside the module header could look like this:

```HTML
<header>
    <?php $navigationModule->render(); ?>
</header>

becomes:

<header>
    <nav>
        more markup
    </nav>
</header>
```

### Passing variables

Variables are not inherited but it's still possible to use a module with variables in a module. There are two ways you could pass variables.

1 Define new variables for the parent module and call them in the associative array parameter of the child module `render()` method.

Define inside `_modules.inc.php` something like this:
```PHP
$navigation = new Module('navigation');
$navigation->setVars(
    array(
        'active' => 1
    )
);

// main site header includes $navigation
$header = new Module('header');
$header->setVars(
    array(
        'navigation' => $navigation,
        'activeForNavigation' => 1
    )
);
```

Use the `$activeForNavigation` inside the module 'header' like this:
```HTML
<header>
    <?php $navigation->render(array('active'=>$activeForNavigation)); ?>
</header>
```

2 Save the whole associative array for the child module inside a variable of the parent module.

Define inside `_modules.inc.php` something like this:
```PHP
$navigation = new Module('navigation');
$navigation->setVars(
    array(
        'active' => 1
    )
);

// main site header includes $navigation
$header = new Module('header');
$header->setVars(
    array(
        'navigation' => $navigation,
        'navigationVars' => array(
            'active' => 1
        )
    )
);
```

Use the `$navigationVars` inside the module 'header' like this:
```HTML
<header>
    <?php $navigation->render($navigationVars); ?>
</header>
```

It's getting harder the more nesting you use so keep calm!

---

## License

[See MIT License here](https://github.com/KonradRolof/modular-click-dummy/blob/master/LICENSE)