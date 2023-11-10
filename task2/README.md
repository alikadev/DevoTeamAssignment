# _DevoTeam_'s Assignement Task 2

## The second task of _DevoTeam_'s backend programming assignement 

This is the second task of _DevoTeam_'s backend programming assignement. I solved it in PHP because this is wildly used backend programming language and I'm confortable with it.

This application can work on any OS that have a PHP interpretor. The web access is bloqued, you need to use the `CLI`.

# Quick start

Create the file `config.php` in the `task2/src` directory.

Add this to this file:

``` php
<?php

define("USING_GOOGLE", true);
define("USING_BING", true);

define("GOOGLE_API_KEY", "YOUR_GOOGLE_API_KEY");
define("GOOGLE_CX", "YOUR_GOOGLE_CX");
define("BING_API_KEY", "YOUR_BING_API_KEY");
```

# Execute the program

Go in the `task2/src` directory with a `CLI` and execute the `main.php` file. Add the queries at the end of the request.

``` shell
php main.php DevoTeam "I love programming"
```

The program will let you know if you haven't give all the arguments.
