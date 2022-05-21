# Informative website + Admin page

This project contains 2 webpages, One is the main website for the users who read it's content and get updated for any news.
The second page is ment for editing that webpages content and creating updates to be seen by the clients.

## Features - admin page

- Login system
- RichText editor
- uploading page sections to the editor
- uploading edited content to the main webpage
- saving drafts
- uploading drafts to the editor
- creating updates and storing them to the database
- viewing all update messages, the expiration date and status
- freeze and delete update messages
- change expiration date for an update messages
- change password and email

### undone functionality

- send emails with tokens
- reset password with tokens
- users and status functionality

## Testing

Open 'mainWebsite/index.php' in your browser, this will be the main webpage.

### Setup a database and a user

- Setup a local host
- In the 'DB' folder change the 'credentials.php' file and setup connectin to your phpMyAdmin or leave as is for default localhost credentials.
- Create a databse : open 'DB/createDB.php' in your browser, this will create 3 tables in your DB: users , messages and tokens. you may change the DataBase name in 'DB/credentials.php'.
- Create Admin user : open 'DB/createAdminUser.php' in your browser. if user is created you will see a success message and a link to login.
- Login page path: 'adminPages/Login.php' .
