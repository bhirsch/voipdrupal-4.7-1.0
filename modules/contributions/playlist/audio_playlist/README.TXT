This module is dependent on the audio.module and playlist.module.

INSTALLATION:
1) go to administer >> modules and turn on the playlist.module
2) go to administer >> modules and turn on the audio_playlist.module
3) go to administer >> access control and turn on permissions for: 
    Playlist.module: manage playlists
    Audio_Playlist.module: create audio playlist, edit audio playlist
4) go to create >> content >> audio playlist to create a new playlist.
5) go to 'browse audio' to view a searchable, sortable table of audio files to add to your playlist
6) go to 'my audio playlists' to view a list of audio playlists you made

Other useful URLS:
'playlist/'             will display all recent playlists
'playlist/feed'         will display an RSS feed of all recent playlists added
'playlist/##'           will display all the recent playlists created by user ##
'playlist/##/feed'      will display an RSS feed of recent playlists created by user ## 
'playlist/browse/audio' will display a searchable, sortable table of audio files
'node/##/xspf'          will output an xspf feed of your playlist
'node/##/podcast'       will output an iTunes friendly feed of your playlist
'node/##/m3u'           will output an m3u file of your playlist
'node/##/pls'           will output a pls file of your playlist.
'node/##/getplayer.js'  javascript code that you can include on other websites 
                        to display a flash player with your playlist.  
example: <script type="text/javascript"  src="http://example.com/node/3/getplayer.js"> </script>

-----------------------------------------------------------
CONFIGURATION:

Go to administer >> settings >> audio_playlist

Name Settings:
Here you can change the human readable name for the audio playlist.  You can change it to be audio album, podcast, or anything you choose.  The reasoning for this is because there are many different names for the same thing, and it should be easily configurable.  Similarly, you can change the help text that appears at create >> content.

Link Settings:
At the bottom of each audio playlist that is created is a set of links.  Here you can choose which links to turn on or off.  Note that the feeds will still be available through direct URL (i.e. node/##/podcast)

Number of Tracks to Display in the audio browser view:
You can change the number of tracks displayed per page on the playlist/browse/audio page. Beware a high number may crash some browsers because each audio file has to load a mini flash player.

---------------------------------------------------------------
BLOCK SETTINGS:
Go to administer >> blocks.
Turn on the XSPF block.  Click the 'configure' link. You can decide if you want the extended or slim version of the player, if you want the player to automatically begin playing, the width of the player, and even the title text used for the block.  You can even enter in no title for the block.
This block provides an xspf player with a dropdown select box with all the playlists on the site, sorted first by sticky posts and then by alphabetical.  This essentially becomes a jukebox for the different playlists/albums/podcasts on the site!  

----------------------------------------------------------------------
USAGE:
Go to create >> content >> audio playlist.
Enter required info, plus the extra playlist info, and submit. Your playlist is now created.
Click the "manage audio playlist" tab at the top to add some new songs.
You can upload a new audio file to your playlist (and to the site) or add an existing file to your playlist.
Once you've added some files, you can drag and order the files, or remove files you don't want.
After you are done adding and ordering files, click the "view" tab.
You should see your new playlist, with some links at the bottom.
The m3u, pls, podcast, xspf links provide different methods for people to listen to your new playlist.
Additionally you can click on the "launch popup player" and a flash XSPF player will start playing in a new window.











