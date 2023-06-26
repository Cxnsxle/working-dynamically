#!/bin/bash

function ctrl_c() {
	echo -e "\n\n[!] Exiting...\n"
	tput cnorm && exit 1
}

# ctrl+c
trap ctrl_c SIGINT

function checkPort() {
	(exec 3<> /dev/tcp/$1/$2) 2>/dev/null
	if [ $? -eq 0 ]; then
		echo -e "[+] Host $1 - port $2 (OPEN)"
	fi

	exec 3<&-
	exec 3>&-
}

tput civis			# hide cursor

declare -a ports=($(seq 1 65535))

if [ $1 ]; then
	for port in ${ports[@]}; do
		checkPort $1 $port &
	done; wait
else
	echo -e "\n[!] How to use: $0 <IP-address>\n"
fi

tput cnorm			# unhide cursor
