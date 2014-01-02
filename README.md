wp-flexi-vote
=============

Wordpress Plugin allowing for up/down or like voting geared to be flexible enough for any use.

There are lots of "vote" "like" "up/down" WordPress plugins out there, however it seems that every project that I come across needs a feature or two from one, and a feature or two from another.  This plugin was created with the hopes of being all inclusive.

Feature Goals :
Have all setting specified via default, shortcode, or based on an ID generated through admin panel

Choose what type of "vote" style :
	"Like"->Ability to mark an item positively only.
	"up/down"->Ability to mark an item positively or negatively
	"Rate"->The ability to mark an item on a scale (e.g. 1-10,1-5,1-4 etc).
		Should have the ability to represent the scale graphically, (eg, 1-10 could be 5 stars with the ability to rate in 1/2 star increments)

Force unique votes
	Per username
	Per IP
	Per Session

Allow anonymous (not logged in) voting

Upload custom vote buttons/graphics

Add multiple buttons per page
	If no ID is specified, button tracking will be unique to the page it's hosted on.
	If ID is specified, button tracking will be based on said ID

Have votes cast via AJAX, with POST/GET fallback

Ability to view/analyze voting statistics
	Per ID
	Per Page
	Per User
	Per Date/Date Range
