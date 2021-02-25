# rent-a-car
Rent a car application

PHP 7.3 used

## How to use ##
1. Download with zip, or even better is to clone it (I use Git bash).
2. Create Database and open application/Lib/config.php and add your credentials.
3. Ready to go

## About ##
This application is practical example based on MVC pattern written in pure PHP. CSS is used for frontend side.

## Structure ##
- Admin can: (must be logged in order to) add new car, update car, delete car, manage users(can see all users, and delete user)
- User can: rent a car, set pickup location along with date&time, set return location along with date&time, check information about rented car. 
Also user can update his information in account and update his password.
**But** before doing anything, user must be registered and logged-in.
- Rent(Pickup&Return Locations): 1.) Zagreb-Centar, 2.) Zagreb-zračna luka, 3.) Split-Centar, 4.) Split-zračna luka, 5.) Rijeka-Centar, 6.) Rijeka-zračna luka, 7.) Osijek-Centar, 8.) Osijek-zračna luka

Note: **Not for production!**
