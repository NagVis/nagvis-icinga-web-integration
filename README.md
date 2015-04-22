# Icinga Web Cronk integration

These files are meant to support integration of NagVis wth Icinga Web. 

The idea is that you create a user in Nagvis with the appropriate rights
(eg icingaweb with password icingaweb) and then edit nagvis.ini.php to set

```
logonmodule="LogonMixedQuery"
logonenvcreateuser="0"
```

Then you call NagVis from the corresponding Icinga Web cronk appending 
```username=icingaweb&password=icingaweb``` (eg ```/nagvis/frontend/nagvis-js/index.php?username=icingaweb&password=icingaweb```).

This way users already authenticated in Icinga Web can see the maps,
but everyone else needs to authenticate.

By creating multiple users with different rights in Nagvis and creating
multiple cronks with different permissions in Icinga Web it is possible
to fine tune which maps are visible to which users/groups.

## Thanks

This code has been developed and contributed by Christos Tsirimokos.
Thanks for sharing and supporting NagVis!

## Disclaimer

We publish this code as is. May it be useful for anyone out there.
We, the NagVis developers, won't improve it or port it to newer
versions.
