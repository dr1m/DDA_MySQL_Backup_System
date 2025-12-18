# DDA MySQL Backup System v1.020

🌟 PORTABLE SYSTEM - ALL-IN-ONE FILE 🌟
The system is a completely self-contained solution in the form of a single PHP file, providing maximum mobility and ease of deployment.

🚀 Advantages of the portable implementation:
1. ✅ MOBILITY - One file, can be quickly copied to any server
2. ✅ QUICK DEPLOYMENT - Requires no installation, just upload the file
3. ✅ SIMPLE BACKUP - Copy one file to back up the entire system
4. ✅ EASY MIGRATION - Move the system between servers in seconds
5. ✅ MINIMAL REQUIREMENTS - Works anywhere PHP and MySQL are available
6. ✅ SELF-SUFFICIENCY - All data and settings are stored in one place

📋 SYSTEM DESCRIPTION
- MySQL Backup System is a comprehensive solution for automatically creating MySQL database backups with management capabilities via a web interface and API.

✨ Core Features:
- Automatic backup creation for all databases or selected ones
- Flexible schedule configuration via Cron
- Management via web interface and API
- Token system for secure API access
- Multilingual interface (Russian, English, Chinese)
- Configurable backup retention periods
- Monitoring and statistics with pagination

🚀 QUICK START GUIDE
⏱️ DEPLOYMENT PROCESS (60 SECONDS)
- Upload the file to your server (10 seconds)
- bash
- wget https://raw.githubusercontent.com/dr1m/DDA_MySQL_Backup_System/main/DDA_MySQL_Backup_System.php
# or copy the single file to the server
- Set access permissions (5 seconds):
- bash 
- chmod 755 DDA_MySQL_Backup_System.php
- Run from console for initialization (10 seconds):
- bash
- php DDA_MySQL_Backup_System.php
- Open the web interface and configure (30 seconds)
- Open in browser: http://your-server/DDA_MySQL_Backup_System.php

  Add to Cron for automation (5 seconds)
TOTAL: 60 seconds for full deployment!

💻 CONSOLE USAGE
- Backup all databases:
- bash
- php DDA_MySQL_Backup_System.php
- Backup a specific database:
- bash
- php DDA_MySQL_Backup_System.php --database=database_name
# or
- php DDA_MySQL_Backup_System.php -d database_name
- Add to Cron for automatic execution:
- bash
# Daily at 2:00 AM
- 0 2 * * * php /path/to/DDA_MySQL_Backup_System.php

# Every hour
- 0 * * * * php /path/to/DDA_MySQL_Backup_System.php

🌐 WEB INTERFACE
- Available sections:
 -Dashboard - overall statistics and quick actions
- Backups - view and manage backup history with pagination
- Tokens - manage API tokens
- API - API documentation and testing
- Settings - system configuration

🔐 API ACCESS
API is only available if active tokens exist.

Main methods:
Method	Endpoint	Description
- GET	/?api=1&action=test_connection&token=TOKEN	Test MySQL connection
- POST	/?api=1&action=create_backup&token=TOKEN	Create backup
- GET	/?api=1&action=list_backups&token=TOKEN&page=1&per_page=20	List backups with pagination
- DELETE	/?api=1&action=delete_backup&name=DATE&token=TOKEN	Delete backup by date
- GET	/?api=1&action=system_info&token=TOKEN	System information
Complete documentation is available in the web interface under the "API" tab

📋 SYSTEM REQUIREMENTS
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Access to mysql and mysqldump commands
- Access to gzip command
- Write permissions to the backup directory
- Permissions to execute PHP scripts

⚙️ CONFIGURATION MANAGEMENT
- All settings are stored in JSON format and can be:
- Modified via the web interface
- Exported for backup
- Imported when migrating the system
- Manually edited (if necessary)
- Configuration files:
- DDA_MySQL_Backup_System_config.json - main system settings
- DDA_MySQL_Backup_System_tokens.json - API tokens and usage statistics

📊 LOGGING AND MONITORING
- Error logs: DDA_MySQL_Backup_System_error.log (if enabled)
- Execution logs: output to console or HTTP response
- Monitoring: web interface with detailed statistics
- Notifications: via API integrations
- Log format: CEF (Common Event Format) for SIEM system compatibility

🔒 SECURITY
- All settings are stored in JSON files
- API access via tokens with activity verification
- Web access with authorization (optional)
- File system permission checks
- Validation of all input data
- Protection against unauthorized API access

🐛 TROUBLESHOOTING
- Check permissions for the backup directory
- Verify MySQL connection settings are correct
- Enable error logging for diagnostics
- Check availability of mysql and mysqldump commands
- Ensure the MySQL user has necessary privileges
- Check for active tokens for API access

❓ FREQUENTLY ASKED QUESTIONS (FAQ)

Q: How much does the system weigh?
A: One PHP file ~200-300 KB

Q: Do I need to install additional packages?
A: No, the system uses only standard PHP and MySQL components

Q: Can I use it on shared hosting?
A: Yes, if the hosting supports PHP and MySQL access

Q: How do I back up the entire system?
A: Copy the single file DDA_MySQL_Backup_System.php

Q: Is PostgreSQL supported?
A: Only MySQL in the current version, but the architecture allows for adding support

📞 CONTACT AND SUPPORT
Author: Demidov Dmitry Anatolyevich (dr1m)
For questions and suggestions: info@dr1m.ru

GitHub: https://github.com/dr1m/DDA_MySQL_Backup_System

📄 LICENSE
MIT License

Copyright (c) 2025 Demidov Dmitry Anatolyevich (dr1m)

- Permission is granted for free use, copying, modification, merging, publishing, distribution, sublicensing, and/or selling copies of the Software.

⭐ Support the Project
If this project has been useful to you, please give it a star on GitHub!
