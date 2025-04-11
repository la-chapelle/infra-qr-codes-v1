#!/bin/bash

HC_PING_URL=""

# If there are error, we are going to put send them to healthcheck.io
handle_error() {
    local error_code=$?
    curl https://hc-ping.com/${HC_PING_URL}/$error_code
    exit 1
}

curl https://hc-ping.com/${HC_PING_URL}/start

trap handle_error ERR

echo "Starting - Backup Docker for qr.lachapelle.me prod"

project_path=/var/www
VOLUME=

MYSQL_CONTAINER_NAME=

DB_NAME=qrcode

cd ${project_path}
docker exec ${MYSQL_CONTAINER_NAME} /usr/bin/mysqldump -u root --password="" ${DB_NAME} > backup_lachapelle_qr_prod_`date +"%Y-%m-%d"`.sql
docker run --rm -v $VOLUME:/$VOLUME alpine tar -cz --to-stdout -C /$VOLUME . >  lachapelle_qr_volume_backup_`date +"%Y-%m-%d"`.tar.gz

# Put
/usr/bin/rclone copy ./lachapelle_qr_volume_backup_`date +"%Y-%m-%d"`.tar.gz SharedDrive-ServicesTI:backup_lachapelle_qr_v1/data/
/usr/bin/rclone copy ./backup_lachapelle_qr_prod_`date +"%Y-%m-%d"`.sql SharedDrive-ServicesTI:backup_lachapelle_qr_v1/db/

rm lachapelle_qr_volume_backup_`date +"%Y-%m-%d"`.tar.gz
rm backup_lachapelle_qr_prod_`date +"%Y-%m-%d"`.sql

echo "End - Backup Docker for qr.lachapelle.me prod"

curl https://hc-ping.com/${HC_PING_URL}
