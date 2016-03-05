# isma_framework
##A Custom PHP framework
###Using the MVC structure

You can use it in **linux** and **windows**

- Latest Stable release : **version** : *1.1.00* **date** : *04-03-2016*
- Latest Dev release : **version** : *1.1.00* **date** : *04-03-2016*
- License : [AGPLv3](http://www.gnu.org/licenses/agpl-3.0.fr.html)

You must edit the `config.php` and change the value in `$array_database`  

You can also use `cmd.php` to use the framework more quickly and easier the framework

The view is in :  

```
http://your_localhost/public/
```
  
After public/ the next parameter is the Controler name and the next one is the Method name :  
```
http://your_localhost/public/Test/bla
```
  
In this exemple we use in `TestController.php` the method `blaAction()`
  
You can prepare the replacement in the template like this :  
```
{# foo #} => current variable
{# css:style.css #} => take style.css in public/css folder
{# css:jquery.js #} => take jquery.js in public/js folder
```

You can also add some attribute in your image :  
```
{# img:src:my_photo.jpg|alt:mega big image|id:big_image|class:image #}
take photo.jpg in public/img folder with big_image as id and image as class
```