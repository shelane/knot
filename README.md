# Knot, a custom, opinionated, lightweight framework

The framework files all exist inside the _knot directory. This directory should
be higher than the public web directory so that its files are not accessible to
the public. The files will be called as needed through the knot.

## _knot Directory Structure

>     _knot
>       \_ _templates
>            \_ pages
>                  \_ basic.inc
>                  \_ error.inc
>                  \_ footer.inc
>                  \_ header.inc
>                  \_ home.inc
>            \_ base.inc
>            \_ css-includes.inc
>            \_ js-includes.inc
>       \_ App
>            \_ Database.php
>            \_ Emailer.php
>            \_ Knot.php
>            \_ Map.php
>            \_ Menu.php
>            \_ Page.php
>            \_ Session.php
>            \_ TaskBar.php
>            \_ TaskBarButtonGroup.php
>            \_ TaskBarFontAwesome.php
>       \_ .editorconfig
>       \_ debugger.php
>       \_ index.php
>       \_ knot.php
>       \_ tags.php

### The _knot directory contains the inner workings of the framework.

At the start is the `index.php` file. It will require the `knot.php` file, which
bootstraps the framework. To extend the knot framework for an application,
a file with those settings must be created and inluded on the `knot.php` file.
This includes the use of the Database class where configuration settings will
need to be added to the `Knot` container. Read the doc block for the Database
container for the specific requirements. Variables defined with a beginning 
double underscore are declared by and needed by knot. The `index.php` file will 
read the site's declared configuration. It will set the user requested path, 
get the path of the site's page files and set page and navigation data. It will 
determine if an allowed process is called through a user action and will call 
files specific to database processing (add, update, and delete). If there is no 
process to run, it will look for the requested page file and set page content. 
Then the rendering begins.

### The _templates directory contains html rendering template files.

The _templates directory holds files that contain layered html structured
elements that will build the final output of the page. The `base.inc` file
includes the basic outer layer of the html page including the html, head, and
body. It will include into the head the `header-includes.inc` file. The body
will call the template that is defined for the selected page.

### The App directory contains classes used by knot.

The Database class manages a singleton database connection for all instances of 
the class while individual Database objects will have separate property values.

The Knot class is a container for the application where specific configurations
of the application will be held. Functions can also be stored for later use.

The Map class is a getter/setter class for an associative array. This allows for
only name/value pairs.

The Menu class is responsible for rendering the menu and storing the current
page information, such as template and page title.

The Page class will hold properties specific to elements of a page.

The Session class is currently not used. Once instantiated in the `knot.php`
bootstrap file, it will manage starting sessions for all pages called in the
knot.

## Public Web Directory

>     docroot
>       \_ _config
>            \_ config.ssi
>            \_ menu.ssi
>       \_ _pages
>            \_ home.inc
>            \_ ... other pages for site
>       \_ _process
>            \_ ... process files match route using .ssi
>       \_ assets
>            \_ css
>            \_ js
>            \_ img
>            \_ ... other public asset files

A symbolic link in the public web directory should point to this file. It will
expect in the web directory a `_config` directory with `config.ssi` and
`menu.ssi` files.

The `config.ssi` file must add `content_path`, `site_name`, and `default_page`
to the Knot container. A `$route` variable is optional, but be sure to use the
`var_define` function to set an array of validated route calls.

The `menu.ssi` file must contain the site's navigation and any page that will
be rendered by knot and should be an array containing an associated array with
these settings: path (the path name that will be added to the href - it should
not contain any `/` characters), label (the name displayed in the output of the
menu), title (the title of the page displayed in the title element and html
head), menu (a boolean for weather to render in the menu), icon (value for the
menu display), style (additional classes). Children of the page can be added to
the menu array under `children` with the same structure. The parent paths are
automatically built and do not need to be included in the `path` value.

At the root of the `_pages` directory should be a file for each of your pages
with the name of the file matching the `path` in the menu and must have an
`.inc` file extension. Any additional includes should be placed in an includes
directory to get the `_pages` directory clean. For sites with depth greater
than 1, files should be in successive directories matching the parent path name.

The `_process` directory is for files to run processes that match a `$route`
request. These must have `.ssi` extension.

The `assets` directory should include any publicly served files such as
css files, javascript files, or images.
