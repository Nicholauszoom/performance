+---------------------------------------------------------------------------------------------------------+
Author:Tazar Chriss
Summary:
These are some of the necessary instructions to follow in order to update the system
+---------------------------------------------------------------------------------------------------------+
First Run this command for newly created migrations
cmd: php artisan migrate 
----------------------------------------------------------------------------------------------------------
For leaves table run this command to create the updated table_columns

cmd: php artisan migrate:refresh --path=/database/migrations/2022_11_22_140243_create_leaves_table.php
-----------------------------------------------------------------------------------------------------------
For Dashboard visibility control
=>allow 'view-dashboard' at settings/roles... role to allow the user to view dashboard stats and disallow to hide them.
--------------------------------------------------------------------------------------------------------------
For Leave approvals
=>upload the 'leave_approvals.sql' file in your database
------------------------------------------------------------------------------------------------------------- 