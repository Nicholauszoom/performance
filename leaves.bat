@echo off
cd /d %~dp0
php artisan leaves:escalation-task
php artisan leaves:annual_remaining_brought_foward
php artisan leaves:leave_revok_escalation
