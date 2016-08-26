# isma_framework
##A Custom PHP framework using the MVC structure

You can use it in **linux** and **windows**

- Latest release : **version** : *1.6.00* **date** : *26-08-2016*
- License : [AGPLv3](http://www.gnu.org/licenses/agpl-3.0.fr.html)

You must edit the `config.php` and change the value in `$array_database`  

You can also use `cmd.php` to use the framework more quickly and easier

This command line tool is here to create model or controller, can check if the core files work correctly.
Don't forget to use this tool to create database table or to fill it.

The view is in :  

```
http://localhost/{{ project_name }}/public/
```
  
After public/ the next parameter is the Controler name and the next one is the Method name :  
```
http://localhost/{{ project_name }}/public/Test/bla
```
  
{{ project_name }} is the name of the framework directory (you can change it for your personnal project)
In this exemple we use in `TestController.php` the method `blaAction()`
  
You can prepare the replacement in the template like this :  
```
{{ foo }} => current variable
{% css:style.css %} => take style.css in public/css folder
{% js:jquery.js %} => take jquery.js in public/js folder
```

You can also add some attribute in your image :  
```
{% img:src:my_photo.jpg|alt:mega big image|id:big_image|class:image %}
take photo.jpg in public/img folder with big_image as id and image as class
```  

For loop you must do like this :  
```
{% user in users %}  
    * {{ user.firstname }}
    * {{ user.lastname }}
{% else %}
    No user found !!
{% endfor %}
```  

In your controller, you must render with an array like this :  
```
$users = $user_table->find_all('*');
$this->render("Index:test.html", array("users" => $users));
```
