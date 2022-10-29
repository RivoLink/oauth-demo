# oauth-demo

## Local testing with PHP built-in server

### Start PHP built-in server
```sh
php -S localhost:8930 -t web
```

### Setup local HTTPS protocol with Stunnel
- Download Stunnel from https://www.stunnel.org/downloads.html
- Install it
- Open configuration file `stunnel.conf` from `[installation path]\stunnel\config\` directory
- At the end of the file put the next part of the code:

```sh
[https]
accept  = localhost:9898
connect = localhost:8930
cert = stunnel.pem
```
- Save the configuration file and restart Stunnel
- Access the local website via: https://localhost:9898
