#!/bin/sh
# deploy.sh
set -e

sudo apt-get install -y lftp

# deployment via ftp upload. Using FTPS for that
lftp -c "set ftps:initial-prot ''; open ftp://$FTP_USER:$FTP_PASS@$FTP_HOST:21$FTP_PATH; mirror --verbose --reverse public .; quit;"
