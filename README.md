# Meetup-Clone
A meetup.com clone for a databases project.

# Setup
See `meetupConfig.php` for the required database credentials.  Set up the MySQL database with the provided .sql file.  Run with your favorite web server, e.g. `php -S localhost:3307`.

# Files

  * create-event.php is the form submission page for creating a new event under a group.
  * event.php generates the page for viewing a single event.
  * events-by-date.php generates an index page for viewing events by date range.
  * group.php generates the page for viewing a single group.  It also provides an event index for events under that group.
  * groups-by-interest.php shows groups indexed by interest.
  * header.php generates the fragment of HTML common to all pages, including the title and navigation links.
  * index.php is the home page.
  * login.php is the login/registration page.  It submits to itself.
  * logout.php logs out the current user.  There's a known CSRF vulnerability here.
  * meetupConfig.php contains common database configuration stuff.
  * rsvp.php is the form submission page for RSVPing to an event.
  * user-home.php is the user homepage.
  * userIsAuthorized.php contains a helper function for checking if a user is an authorized member of a group.

# Additional features

  * Basic user registration
  * Viewing all events for a group
  * Viewing all groups for a user

# Credits

  * Peter Smondyrev
  * Max Marrone
  * Redwanul Mutee
 
 The SQL, HTML and PHP work was shared equally.
