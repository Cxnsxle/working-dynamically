FROM ubuntu:20.04
MAINTAINER Cxnsxle systemfailure.net@gmail.com

EXPOSE 22

RUN apt update && apt install ssh -y 

ENTRYPOINT service ssh start && /bin/bash
