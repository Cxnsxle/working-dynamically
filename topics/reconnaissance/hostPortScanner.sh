#!/bin/bash

function ctrl_c() {
	echo -e "\n\n[!] Exiting...\n"
	tput cnorm && exit 1
}

# ctrl+c
trap ctrl_c SIGINT


tput civis			# hide cursor

for i in $(seq 1 254); do
	if timeout 1 bash -c "ping -c 1 192.168.200.$i" &>/dev/null && echo -e "[+] Host 192.168.200.$i - (ACTIVE)"; then
		for port in 21 22 23 25 53 80 139 443 445 8080; do
			timeout 1 bash -c "echo '' > /dev/tcp/192.168.200.$i/$port" &>/dev/null && echo -e "\tIP 192.168.200.$i Port $port - (OPEN)" &
		done; wait
	fi &
done; wait

tput cnorm			# unhide cursor
