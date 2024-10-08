# module2_Building-Database-Applications-in-PHP
Building Database Applications in PHP

<strong>General Specifications</strong> </br>
Here are some general specifications for this assignment:

You must use the PHP PDO database layer for this assignment. If you use the "mysql_" library routines or "mysqli" routines to access the database, you will receive a zero on this assignment.

Your name must be in the title tag of the HTML for all of the pages for this assignment.

Your program must be resistant to HTML Injection attempts. All data that comes from the users must be properly escaped using the htmlentities() function in PHP. You do not need to escape text that is generated by your program.

Your program must be resistant to SQL Injection attempts. This means that you should never concatenate user provided data with SQL to produce a query. You should always use a PDO prepared statement.

Please do not use HTML5 in-browser data validation (i.e. type="number") for the fields in this assignment as we want to make sure you can properly do server side data validation. And in general, even when you do client-side data validation, you should still validate data on the server in case the user is using a non-HTML5 browser.</br>

<strong>Specifications for the Login Screen</strong></br>
The login screen needs to have some error checking on its input data. If either the name or the password field is blank, you should display a message of the form:

     Email and password are required

Note that we are using "email" and not "user name" to log in in this assignment.

If the password is non-blank and incorrect, you should put up a message of the form:

     Incorrect password

For this assignment, you must add one new validation to make sure that the login name contains an at-sign (@) and issue an error in that case:

     Email must have an at-sign (@)

If the incoming password, properly hashed matches the stored stored_hash value, the user's browser is redirected to the autos.php page with the user's name as a GET parameter using:

     header("Location: autos.php?name=".urlencode($_POST['who']));

You must also use the error_log() function to issue the following message when the user fails login due to a bad password showing the computed hash of the password plus the salt:

     error_log("Login fail ".$_POST['who']." $check");

When the login succeeds (i.e. the hash matches) issue the following log message:

     error_log("Login success ".$_POST['who']);




Specifications for the Auto Database Screen

In order to protect the database from being modified without the user properly logging in, the autos.php must first check the $_GET variable to see if the user's name is set and if the user's name is not present, the autos.php must stop immediately using the PHP die() function:

     die("Name parameter missing");

To test, navigate to autos.php manually without logging in - it should fail with "Name parameter missing".

 

If the user is logged in, they should be presented with a screen that allows them to append a new make, mileage and year for an automobile. The list of all automobiles entered will be shown below the form. If there are no automobiles in the database, none need be shown.

If the Logout button is pressed the user should be redirected back to the index.php page using:

     header('Location: index.php');

When the "Add" button is pressed, you need to do some input validation.

The mileage and year need to be integers. If is suggested that you use the PHP function is_numeric() to determine if the $_POST data is numeric. If either field is not nummeric, you must put up the following message:

     Mileage and year must be numeric

Also if the make is empty (i.e. it has less than 1 character in the string) you need to put out a message as follows:

     Make is required

Note that only one of the error messages need to come out regardless of how many errors the user makes in their input data. Once you detect one error in the input data, you can stop checking for further errors.

If the user has pressed the "Add" button and the data passes validation, you can add the automobile to the database using an INSERT statement.

When you successfully add data to your database, you need to put out a green "success message:

     Record inserted

Once there are records in the database they should be shown below the form to add a new entry.
