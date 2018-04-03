# MySQL Snapshot Manager

This is a handy little utility to help in the creation and restoration of mysql snapshots.

## Installation
* Clone the repository into someplace your server can find eg. /var/www/htdocs/snapshots
* Configure the settings in settings.php so it behaves the way you want.
* You may need to set up a group policy on your server/dev machine to allow both the apache (or other server) user to access files created by your shell user and vsv
* Create a symlink to the cli.php `ln -s /var/www/htdocs/snapshots/cli.php /usr/local/sbin/msnap`
* Add the auto-complete to your .bashrc `source /var/www/htdocs/snapshots/autocomplete.sh`
* You will need to update autocomplete.sh if you want the shell command to be something other than `msnap`. Replace msnap on line 10 with whatever command you used when creating the symlink
