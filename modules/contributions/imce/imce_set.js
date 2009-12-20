// $Id: imce_set.js,v 1.3.2.1 2006/11/13 19:51:20 ufku Exp $
if (isJsEnabled()) {
  addLoadEvent(imceInitiate);
}
function imceInitiate() {
  if ("undefined" != typeof(window.tinyMCE)) {
    for (var i=0; i<tinyMCE.configs.length; i++) {
      if (!tinyMCE.configs[i]['file_browser_callback']) {
        tinyMCE.configs[i]['file_browser_callback'] = 'imceImageBrowser';
      }
    }
  }
}
var imceRefererWin, imceRefererField, imceRefererType, imceRefererURL;
function imceImageBrowser(field_name, url, type, win) {
  //if (type!='image') return;//work for only images
  var imcePopup = window.open(imceBrowserURL, '', 'width=560, height=440, resize=0');
  imcePopup.focus();
  imceRefererWin = win;
  imceRefererField = win.document.forms[0].elements[field_name];
  imceRefererType = type;
  imceRefererURL = url;
}
