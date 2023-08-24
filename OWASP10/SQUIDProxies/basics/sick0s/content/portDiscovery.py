#!/usr/bin/python3

import sys
import signal
import requests

# function to manage CTRL+c
def def_handler(sig, frame):
    print("\n[!] Exiting...\n")
    sys.exit(1)

# function to find out every port behind a Proxy
def portDiscovery():
    common_tcp_ports = {20, 21, 22, 23, 25, 53, 80, 110, 115, 119, 135, 143, 161, 194, 443, 445, 465, 514, 993, 995, 1433, 1521, 1723, 3306, 3389, 5060, 5222, 5432, 5900, 6379, 6666, 8080, 8443, 9090, 9100, 9933, 10000, 12345, 14334, 16000, 16992, 20000, 21025, 22222, 27017, 30718, 32764, 32887, 49152, 49153, 50000}

    for port in common_tcp_ports:
        r = requests.get(main_url + ':' + str(port), proxies=squid_proxy)
        if (r.status_code != 503):
            print("Port:", port, "opened")

# CTRL+c
signal.signal(signal.SIGINT, def_handler)

# global variables
main_url = "http://127.0.0.1"
squid_proxy = {"http": "http://192.168.200.134:3128"}

if __name__ == "__main__":
    portDiscovery();
