An application to sit along side LMeve and augment its functionality.  This app
will consume data produced/pulled in by the lmeve poller and produce data into
the lmeve database tables when necessary.

--For now, some very brief documentation on setup
Copy/rename application/config/database.dist.php to application/config/database.php and set the parameters appropriately.
Copy/rename application/config/lmconfig.dist.php to application/config/lmconfig.php and set the following parameters appropriately:
    $LM_dbhost
    $LM_dbuser
    $LM_dbpass
    $LM_EVEDB