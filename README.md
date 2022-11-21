# Steps to run this on your local machine


1. download the zip file and save it in htdocs on xampp (make sure you have *'xampp v7.4.12'* phpmyadmin software installed on *'C:\'* diractory)

2. open xampp-control.exe in xampp folder

3. click on *'config'* on Apache and select 'Apache (<ins>httpd.conf</ins>)' it will open a **txt* file.

4. click **'Ctrl + F'** and search for **'80'** and replace it with **'8888'** and then save and close.

5. start Apache and MySQL (make sure they are both highlighted with <ins>**green**</ins> once started).

6. go to your browser and paste this link `http://localhost:8888/phpmyadmin/`.

7. Now, create a database with the name `workflow-db` (make sure *'latin1_swedish_ci'* is selected)

8. once created click on import and then import the `workflow-db.sql` saved in *'database'* folder on the *'workflow-app'* project diractory.

9. once imported, scroll down and click GO!.

10. lastly, paste this link on your browser `http://localhost:8888/workflow-app/` and you are DONE !!  :smiley:


--------------------------------------------------------------------------------------------------------------------------------------------


## Admin Login Details

**Username:** *admin*\
**Password:** *admin123*

**Username:** *admin1*\
**Password:** *admin123*

**Username:** *admin2*\
**Password:** *admin123*

## User Login Details

**Username:** *user*\
**Password:** *terror123*

**Username:** *user1*\
**Password:** *moriti123*

**Username:** *user2*\
**Password:** *hannon123*


--------------------------------------------------------------------------------------------------------------------------------------------

**NOTE:** After creating a new account for the users, you'll get a random-generated
temporary password which is provided inside ***"Manage User"*** section of the application.
Copy that temporary password and use it for the user's login to reset it to the user's preference.

--------------------------------------------------------------------------------------------------------------------------------------------