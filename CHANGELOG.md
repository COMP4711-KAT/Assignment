#CHANGELOG
### v.1 (2016-03-02)
* Initial Commit

### v.1.1 (2016-03-02)
* Added the template setup and style

### v.1.2 (2016-09-02)
* Added the base model, fully featured fancy-dancy
* Added the Players model
* Display the Player names and Cash on the home page

## v.1.3 (2016-09-02)
* Added the Stocks model
* Displays each Stock's name and value with a placeholder for a link
    to the stock's history page.

### v.1.4 (2016-09-02)
* Added a new link in the menu for profiles
* Added Portfolios model
* Display transactions made by a single player
* Display a dropdown that when clicked goes to specified player
* Added routes for profiles

### v.1.5 (2016-10-02)
* Added a links to users in homepage
* Added Current holdings for each user and updates with transactions
* Reformatted the profile page to look cleaner
* Added another view to handle having it click to the profile link, and
  looking for another guy as it used the current directory

### v.1.6 (2016-11-02)
* Added a links to stocks in homepage
* Routed the pages so it doesn't use controller routing
* Got rid of using model values within controller
* Got recently active stock and use that to get its history and transactions
* Stocks history page implemented
* Got rid of a view that was not needed

## v.1.6 (2016-11-02)
* Added a link to login in the navbar
* Changed portfolio/index to default to the logged in user, if found
* Added a portfolio/login to allow users to login using a username
* Added a portfolio/logout to allow users to logout

## v.1.7 (2016-11-02)
* Minor fix on transactions model
