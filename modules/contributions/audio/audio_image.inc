<?php
// $Id: audio_image.inc,v 1.1.2.2 2006/08/09 22:57:59 drewish Exp $

/**
 * Audio Image Functions.
 */

/**
 * Returns an array of all the different image types with "clean" descriptions.
 */
function audio_image_type_clean_array($index = NULL) {
  $ret = array(
    0x00 => 'other',
    0x01 => 'file_icon',
    0x02 => 'other_file_icon',
    0x03 => 'cover_front',
    0x04 => 'cover_back',
    0x05 => 'leaflet',
    0x06 => 'media',
    0x07 => 'lead_artist',
    0x08 => 'artist',
    0x09 => 'conductor',
    0x0A => 'band_orch',
    0x0B => 'comp',
    0x0C => 'lyricist',
    0x0D => 'rec_loc',
    0x0E => 'recording',
    0x0F => 'performance',
    0x10 => 'screen_cap',
    0x11 => 'fish',
    0x12 => 'illust',
    0x13 => 'band_logo',
    0x14 => 'pub_logo'
  );
  return is_null($index) ? $ret : $ret[$index];
}

/**
 * Returns an array of all the different image types with "dirty" descriptions.
 */
function audio_image_type_dirty_array($index = NULL) {
  $ret = array(
    0x00 => 'Other',
    0x01 => '32x32 pixels \'file icon\' (PNG only)',
    0x02 => 'Other file icon',
    0x03 => 'Cover (front)',
    0x04 => 'Cover (back)',
    0x05 => 'Leaflet page',
    0x06 => 'Media (e.g. label side of CD)',
    0x07 => 'Lead artist/lead performer/soloist',
    0x08 => 'Artist/performer',
    0x09 => 'Conductor',
    0x0A => 'Band/Orchestra',
    0x0B => 'Composer',
    0x0C => 'Lyricist/text writer',
    0x0D => 'Recording Location',
    0x0E => 'During recording',
    0x0F => 'During performance',
    0x10 => 'Movie/video screen capture',
    0x11 => 'A bright coloured fish',
    0x12 => 'Illustration',
    0x13 => 'Band/artist logotype',
    0x14 => 'Publisher/Studio logotype'
  );
  return is_null($index) ? $ret : $ret[$index];
}

/**
 * Build an audio image array from a filepath and pic type.
 * @param $filepath
 * @param $pictype one of the pictype indexes from
 *   audio_image_type_clean_array() or audio_image_type_dirty_array().
 * @returns an array with image info
 */
function _audio_image_get_info($filepath, $pictype) {
  if ($info = getimagesize($filepath)) {
    $extensions = array('1' => 'gif', '2' => 'jpg', '3' => 'png');
    $extension = array_key_exists($info[2], $extensions) ? $extensions[$info[2]] : '';
    $out = array(
      'pictype'   => $pictype,
      'filepath'  => $filepath,
      'filemime'  => $info['mime'],
      'filesize'  => filesize($filepath),
      'extension' => $extension,
      'width'     => $info[0],
      'height'    => $info[1],
    );
    return $out;
  }
  return FALSE;
}

/**
 * Creates the image's filename in the form directory/prefix_imagetype.ext
 *
 * @param $prefix The prefix of the filename, probably should be the nid.
 * @param $mimetype the image's mime type. jpeg, png and gif are the only
 *   formats allowed.
 * @param $pictype
 * @param $in_tempdir Should this file be in the temp directory
 * @return full filepath or null in case of an error.
 */
function _audio_image_filename($prefix, $mimetype, $pictype = 0x03, $in_tempdir = FALSE) {
  $directory = audio_get_directory() . (($in_tempdir) ? '/temp' : '/images');
  file_check_directory($directory, TRUE);

  //get the clean image type
  $image_type = audio_image_type_clean_array($pictype);

  switch ($mimetype) {
    case 'image/jpeg':
      $ext = '.jpg';
      break;
    case 'image/png':
      $ext = '.png';
      break;
    case 'image/gif':
      $ext = '.gif';
      break;
    default:
      // don't return a filename for any other extensions
      return;
  }

  // combine the path and file extension from the mimetype
  return $directory .'/'. $prefix .'_'. $image_type . $ext;
}

/*
 * Crops (to square) and resizes to the image size setting. The image must have
 * already been saved to a file (who's path is stored in the path value).
 *
 * @param $audio_image array from _audio_image_get_info()
 * @return array with complete image info.
 */
function _audio_image_resize($image) {
  $width  = $image['width'];
  $height = $image['height'];

  // crop to a square
  if ($width == $height) {
    $size = $width;
  }
  else {
    $size = min($width, $height);
    image_crop($image['filepath'], $image['filepath'], 0, 0, $size, $size);
  }

  // resize down to the maximum dimention
  $maxsize = variable_get('audio_image_size', 170);
  if ($size > $maxsize) {
    image_resize($image['filepath'], $image['filepath'], $maxsize, $maxsize);
    $size = $maxsize;
  }

  // store the changes back in
  $image['height'] = $image['width'] = $size;

  return $image;
}

