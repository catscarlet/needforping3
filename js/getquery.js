var xmlHttp;

function GetCheckbox() {
  //value = new Array("23.252.100.110","104.224.133.143");
  //return value;
  checkbox = document.getElementsByName('q[]');
  var value = new Array();
  for (i = 0, j = 0 ; i < checkbox.length ; i++) {
    if (checkbox[i].checked) {
      //alert(checkbox[i].value);
      value[j] = checkbox[i].value;
      j++;
    }

    //value = server_selecter.selected_server.value

  }
  //alert(value);
  return value;

}

function getquery() {
  //value = new Array("23.252.100.110","104.224.133.143");
  var value = GetCheckbox();
  var url = 'query_db.php?';
  //alert(value);
  xmlHttp = GetXmlHttpObject();
  if (xmlHttp == null) {
    alert('Browser does not support HTTP Request');
    return;
  }

  //var query_server = value;
  GroupQueryUrl(url, value);

}

function GroupQueryUrl(url, value) {

  for (i = 0; i < value.length ; i++) {
    url = url + '&q[]=' + value[i];
  }
  //  url = url + = url + '?q=' + query_server + '&sid=' + Math.random();
  url = encodeURI(url + '&sid=' + Math.random());
  //alert(url);
  xmlHttp.onreadystatechange = stateChanged;
  xmlHttp.open('GET', url, true);
  xmlHttp.send(null);

}

function GetXmlHttpObject() {
  var xmlHttp = null;
  try {
    // Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  } catch (e) {
    //Internet Explorer
    try {
      xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (e) {
      xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
  }
  return xmlHttp;
}

function stateChanged() {
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == 'complete') {
    window.obj = eval('(' + xmlHttp.responseText + ')');
    draw_LOSS();
    draw_LATENCY();
  }
}
