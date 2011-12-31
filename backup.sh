#!/bin/sh

#Set the date and webroot for the backup files
date=`date '+%F'`
webroot='/mnt/stor3-wc2-dfw1/484627/www.soomopublishing.com/'

#Dump the mysql database
mysqldump -h mysql50-82.wc2.dfw1.stabletransit.com -u 484627_soomo -p'SecureSoomo1' DB_NAME > $webroot/backups/db_wp_backup.sql
mysqldump -h mysql50-83.wc2.dfw1.stabletransit.com -u 484627_soomowiki -p'SecureSoomo1' DB_NAME > $webroot/backups/db_wiki_backup.sql

 
#Backup Site
tar -czpvf $webroot/backups/sitebackup.tar.gz $webroot/web/content/
 
#Compress DB and Site backup into one file
tar --exclude 'sitebackup' --remove-files -czpvf $webroot/backups/backup.$date.tar.gz $webroot/backups/sitebackup.tar.gz $webroot/backups/db_wiki_backup.sql $webroot/backups/db_wp_backup.sql

#Upload your files to cloud files.
php $webroot/cloudfiles_backup.php 

#After your backup has been uploaded, remove the tar ball from the filesystem.
rm $webroot/backups/backup.$date.tar.gz
