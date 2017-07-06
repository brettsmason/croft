# Croft
**Welcome to Croft, the Foundation WordPress starter theme.**

Croft is built with search-engine optimization (SEO) in mind by utilizing the most current HTML5 conventions and [Schema.org](http://schema.org) microdata.
Croft combines ZURB's Foundation, the most advanced responsive front-end framework in the world, and Hybrid Core, the developer friendly theme framework created by one of the best WordPress developers around, Justin Tadlock.

Croft isn't mean't to be used as is, it's mean't to used to create your next masterpeice!

Croft requires a minimum of WordPress 4.5.

## What comes with Croft?
Croft comes with all of the features you love from Foundation for Sites, along with minimal styling to cover all WordPress core components. The theme comes setup to be used with Foundations Sass mixins (default and my preferred method) or optionally with classes.

## What tools do I need to use Croft?
Croft is built with **Bower** and **Gulp** usage in mind and is the recommended way to use this theme.
However theme assets should compile just fine using other tools.

## Getting Started With Croft

### Install node.js.
- Using the command line, navigate to your theme directory
- Run `npm install` to install Node packages and add a fresh copy of Hybrid Core to `/inc/hybrid-core/`.
- Run `gulp` to confirm everything is working

### What Gulp tasks are included?
Croft comes with a few useful Gulp tasks out of the box:

#### gulp
The default Gulp task. Runs the `build` task and watches files for changes.

#### gulp clean
Cleans and removes the contents of the `dist` directory.

#### gulp Sass
Compiles and minifies the `style.scss` stylesheet.

#### gulp sass:editor
Compiles the `editor-style.scss` stylesheet into the `/assets/css/` directory.
Used to style the WordPress visual editor.

#### gulp javascript
Concats and minifies the main JS file.

#### gulp translate
A simple task for creating a pot file for your theme so it's ready for translation.

#### gulp build
Runs the clean, copy:hc, sass and javascript tasks.

#### gulp renametheme
This will rename all references to the theme text domain, function names and any other theme specific names.
*To use this task please make sure you change the `THEME` variable in `gulpfile.js` before running this task.*

#### gulp dist
Copies all final theme files to the `dist` folder.

#### gulp zip
Creates a zip file of the `dist` directory ready to distribute the theme.

## Copyright and License
The following resources are included or used in part within the theme package.

* [Foundation](http://foundation.zurb.com) by Zurb, Inc. - Licensed under the [MIT License](https://opensource.org/licenses/MIT).
* [Genericons](http://genericons.com/) by Joen Asmussen - Licensed under the [GPL, version 2 or later](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
* [Hybrid Core](http://themehybrid.com/) by Justin Tadlock - Licensed under the [GPL, version 2 or later](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
* [Underscores](http://underscores.me/) by Automattic, Inc. - Licensed under the [GPL, version 2 or later](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html).

All other resources and theme elements are licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2017 &copy; [Brett Mason](http://brettmason.co.uk).
