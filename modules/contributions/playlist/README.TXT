

The playlist.module provides a set of common functions used for making playlists and other ordered lists.

Most playlists will need something like:

    1. A table to keep track of the relationships
    2. A set of functions to interact with the database
    3. A theme_sort function that allows for easy re-ordering of playlist items
    4. A way to define new XML feeds based on playlist data/metadata

The playlist.module provides everything to do the first 3, and the last is done by a custom node module (such as audio_playlist.module).



The audio_playlist.module makes use of the playlist API and also serves as an example for making new playlist modules.

An example workflow for creating a new playlist would be:

   1. Create a new playlist node (YOUR NODE MODULE)
   2. Define what node types can be added to this new playlist (YOUR NODE MODULE)
   3. A common management/sort system for re-ordering, deleting, adding items (PLAYLIST MODULE)
   4. Allow new, pluggable XML feed definitions (YOUR NODE MODULE)

So as you can see, the playlist.module serves to assist in making playlist modules, it doesn't do much by itself.


