# oauth-demo

## Local testing with PHP built-in server

### Start PHP built-in server
```sh
php -S localhost:8930 -t web
```

### Local HTTPS protocol with Stunnel
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


## Facebook OAuth configurations

### Create a Facebook App
- Go to: https://developers.facebook.com/apps/create/
- Select "*Consumer*" for app type
- Add a name and finish creating your app

### Basic settings for Facebook App
- In the menu (Left Pannel), select *Settings* > *Basic*
- Fill in the fields: *"Display name"*, *"App domains"*, *"Privacy Policy URL"* and *'User data deletion
'*
- Save changes

### Facebook Login settings
- In the dashboard, add products *"Facebook Login"* to your app
- Comptele *"Site URL"* with `https://localhost`
- In the menu (Left Pannel), select *Facebook Login* > *Settings*
- Fill in *"Valid OAuth Redirect URIs"* with: `https://localhost:9898/sign-up` and `https://localhost:9898/sign-in`
- Set *"Login with the JavaScript SDK"* to `Yes`
- Fill in *"Allowed Domains for the JavaScript SDK"* with: `https://localhost:9898`
- Save changes

### Facebook App - Live Mode
- In the header menu, switch your app to *"App Mode: Live"*
- Copy `web\private\facebook-auth.json.dist` to `web\private\facebook-auth.json`
- Set `app_id` value to you *"Facebook App ID"*
- Set `app_version` value to you *"Facebook App Version"*, maybe `v14.0`

