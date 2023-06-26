FROM ubuntu:latest

MAINTAINER Cxnsxle "systemfailure.net@gmail.com"

ENV DEBIAN_FRONTEND noninteractive

RUN apt update && apt install -y net-tools \
		iputils-ping \
		curl \
		git \
		nano \
		apache2 \
		php

COPY prueba.txt /var/www/html/

EXPOSE 80

ENTRYPOINT service apache2 start && /bin/bash
