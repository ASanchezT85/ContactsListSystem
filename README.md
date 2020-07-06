<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## About Contacts List System

Exam 1: Create a System
System Name: Contacts List System
Choose any Language/Framework: Laravel, Codeigniter or Core PHP (using OOP is an advantage)
Scope: 
1.  Register, Forgot password and Update User
2.  Can Login.
3.  Create, Update, Delete, Search, View contacts
4.  List of all contacts (This will be the homepage)
5.  Fields added in the form must be, First Name, Last Name, Email and Contact Number
6.  After adding a contact to the list, an email notification will be sent to the email of the contact user that says, “We added you in our contact list. Thank you.”
7.  Add pagination if more than 10 contacts
8.  Must be responsive (You can use Bootstrap)
9.  File/Codes should be pushed to the repository (Bitbucket/Github) and make it public. 
If finished please post it to skype group 

Notes: When done, please share us the Repository Link.


## Instructions

- Clone the repository
- Create the database
- Set up the .env file
- php artisan key:generate
- php artisan migrate

### DB configuration ###
* DB_CONNECTION=mysql (If necessary) * 
* DB_HOST=127.0.0.1 (If necessary) *
* DB_PORT=3306 (If necessary) *
* DB_DATABASE=contactslistsystem * 
* DB_USERNAME=root * 
* DB_PASSWORD= * 

### Email configuration ###
* MAIL_MAILER=smtp *
* MAIL_HOST=smtp.mailtrap.io *
* MAIL_PORT=2525 *
* MAIL_USERNAME=null *
* MAIL_PASSWORD=null *
* MAIL_ENCRYPTION=null *

## Observations ##

- If you want to test with dummy data run the command: ### php artisan migrate:fresh --seed ###

## Alexander Sánchez ##
### ajstalito@gmail.com ###



