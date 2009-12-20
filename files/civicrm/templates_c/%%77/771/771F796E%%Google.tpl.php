<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:45:19
         compiled from CRM/Contact/Form/Task/Map/Google.tpl */ ?>
 <head>
  <script src="http://maps.google.com/maps?file=api&v=1&key=<?php echo $this->_tpl_vars['mapKey']; ?>
" type="text/javascript"></script>
  <?php echo '
  <script type="text/javascript">
    function onLoad() {

      //<![CDATA[
      var map    = new GMap(document.getElementById("map"));
      var spec   = map.spec;
      var span   = new GSize(';  echo $this->_tpl_vars['span']['lng']; ?>
,<?php echo $this->_tpl_vars['span']['lat'];  echo ');
      var center = new GPoint(';  echo $this->_tpl_vars['center']['lng']; ?>
,<?php echo $this->_tpl_vars['center']['lat'];  echo ');
      var zoom   = spec.getLowestZoomLevel(center, span, map.viewSize);
      
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.centerAndZoom(center, zoom);
      
      // Creates a marker whose info window displays the given number
      function createMarker(point, data) {
        var marker = new GMarker(point);

        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(data);
        });

        return marker;
      }

      '; ?>

      <?php $_from = $this->_tpl_vars['locations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['location']):
?>
      <?php echo ' 
         var point = new GPoint(';  echo $this->_tpl_vars['location']['lng']; ?>
,<?php echo $this->_tpl_vars['location']['lat'];  echo ');

	 var data = "'; ?>
<a href=<?php echo $this->_tpl_vars['location']['url']; ?>
><?php echo $this->_tpl_vars['location']['displayName']; ?>
</a><br /><?php echo $this->_tpl_vars['location']['location_type']; ?>
<br /><?php echo $this->_tpl_vars['location']['address'];  echo '";
         
         var marker = createMarker(point, data);
         map.addOverlay(marker);

      '; ?>
 
      <?php endforeach; endif; unset($_from); ?>
      <?php echo '

     //]]>  
   }
  </script>

'; ?>

  </head>
  <body onload="onLoad()"; >
    <div id="map" style="width: 600px; height: 400px"></div>
  </body>