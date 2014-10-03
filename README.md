txtController
=============

A php txt control class

With this php class you can easily control and manage your all txt files.

### Initialization
To utilize this class, first import class.txtController.php into your project, and require it.

```php
require_once ('class.txtController.php');
```

After that, create a new instance of the class.

```php
$txt = new txtController;
```

### Catching Errors
This function returns system errors. When an error occurs, functions return FALSE.

Example
```php
$error = $txt->error();
```

### Open
If there is no file, it'll create it. (It won't creates a directory or a folder!!!)
You must use this function before everything. (You can't change or read any txt file before open it, right?)
```php
$txt->open("mytxtfile.txt");
```
If you want to create a file, you can also set it's data like that
```php
$txt_data = "My txt data...";
$txt->open("mytxtfile.txt", $txt_data);
```

It returns error when; it's not a txt file.

### Create
It's like open function, it creates a file and opens it. So if you use this function, you don't need to use open function.
```php
$txt_data = "My txt data...";
$txt->create("mytxtfile.txt",$txt_data);
```
It returns error when; it's not a txt file or file already exists.

### Read
With this function you can read opened txt file. Also with this function you can directly write (echo) all txt data and replace all txt lines (\n) to the <br> easily. But both of them are optional.

Simle example
```php
$txt_data = $txt->read();
```

Detailed example
```php
$echo   = TRUE;
$add_br     = TRUE;
$txt->read($echo, $add_br);
```
It returns error when; there is no opened txt file.

### Change
With this function you can change opened txt file. All other txt datas will gone.

Simle example
```php
$new_data = "This is my new data!";

$txt->change($new_data);
```
It returns error when; there is no opened txt file.

### Append
Appends your text to the txt file. Not overwrites...
It also has a ability to add your datas with a new line.

Simle example
```php
$additional_data = "This is my additional data!";

$txt->append($additional_data);
```

Other example
```php
$additional_data = "This is my additional data! Also this line will be in the new line!";
$new_line = TRUE;

$txt->append($additional_data, $new_nile);
```
It returns error when; there is no opened txt file.

### Delete
It deletes your currently opened txt file. It won't be back...

Example
```php
$txt->delete();
```
It returns error when; there is no opened txt file.

### Get Line
Gives you a specified line. So you can read just a specified line. Don't forget; first line's, line number is 0 :)

Example
```php
$line_number = 5;
$txt->get_line($line_number); //It returns 6th line to me.
```
It returns error when; there is no opened txt file or line does not exist.

### Change Line
Changes a specified line. So you can change just a specified line. Don't forget; first line's, line number is 0 :)

Example
```php
$line_number = 5;
$new_data = "This is my new data!";
$txt->change_line($line_number, $new_data); //It changes 6th line with our new data.
```
It returns error when; there is no opened txt file or line does not exist.

### Delete Line
Deletes a specified line. So you can delete just a specified line. Don't forget; first line's, line number is 0 :)

Example
```php
$line_number = 5;
$txt->del_line($line_number); //It deletes 6th line. It's gone..
```
It returns error when; there is no opened txt file or line does not exist.
