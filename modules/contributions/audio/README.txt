README
------
This is a simple module that allows a user to create a new audio node type. An
audio node lets you upload, stream, and download audio files, and uses the
getID3 library to read and write ID3 tag information from the audio file.

This module comes with a handy flash player that can be embeded in your site.
It should be easy to change the player type and style by over riding the
function 'theme_audio_mp3_player($params)' in your theme level.

Comments? Ask away at: colin@bryght.com


Requirements
------------
This module requires Drupal 4.7.


Installation
------------
See INSTALL.txt


Contributors
------------
Colin Brumelle <colin@bryght.com>
    wrote the original 4.6 version (with assistance from the fabulously
    talented Adrian Rossouw <adrian@bryght.com>).
Andrew Morton <drewish@katherinehouse.com>
    rewrote the module for 4.7
Curtis Weyant http://drupal.org/user/65636
    provided PostgreSQL table translations
Steve Simms http://drupal.org/user/16822
    provided PostgreSQL table translations


$Id: README.txt,v 1.3.2.3 2006/08/15 16:47:33 drewish Exp $