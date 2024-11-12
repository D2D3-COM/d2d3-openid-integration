<h2>Idea</h2>

<pre>
* I will call the Login system OpenID System (OID)
* Dependent projects that want to use login from OID are Relying Party (RP)

1. OID:
- Provide login and registration forms for applications (App).
- Manage RPs, where each RP needs to register with OID the following information:
     + client_id: application identification.
     + client_secret: secret key to authenticate RP with OID.
     + redirect_uri: the path OID will send response after authentication is complete.

- After registration, each RP receives 3 links:
     + GET Login link: RP will redirect users to this path to log in.
     + POST API to get user information: RP sends AUTH_CODE to get user information.
     + POST API migrate user: RP can transfer user information to OID.
- OID will return the env variables that need to be added to RP's .env

2. RP login:
- When the user enters the RP's login page, RP will redirect to the login link from OID.
- The user logs in with username/password, then OID will return the AUTH_CODE via redirect_uri.
- redirect_uri will receive the AUTH_CODE and send it to the /userInfo endpoint with {client_secret} 
to get user information
- RP will create a new user if there is no user corresponding to this email in the RP system
</pre>

<h2>We need 7 steps for integration OpenId in your app</h2>

<b>Step 1: Register app in OpenId </b>
<br>
<b>Redirect URI </b></b>
This URL is used to get the <b>authorization_code</b> from OpenId. Normally, I would use the login URL to handle that too.
![image](https://github.com/user-attachments/assets/5bd06551-bd34-473b-8086-7c36c2ea63ac)
<br>

<b>Step 2: Copy all <u>Environment Variables</u> and paste to your .env </b>
![image](https://github.com/user-attachments/assets/b013815d-cb31-4ab3-a72e-61fb3ee45368)
<br>

<b>Step 3: In your App install <u>d2d3/openid-integration pakage</u>  </b>
<pre>composer require d2d3/openid-integration</pre>
<br>

<b>Step 4: Create one route api loginWithAuthCode </b>
![image](https://github.com/user-attachments/assets/60b35d22-488e-429f-aa01-10b7158d975c)
<br>

<b>Step 5: LoginWithAuthCode </b>
- Use D2d3\OpenidIntegration\Http\Services\OauthService::loginWithAuthCode for get Userdata
![image](https://github.com/user-attachments/assets/a53a260e-1562-4a71-9f2f-9f9c1258cfd2)

- Determine if the user already exists by Email. If the user does not exist, create a new one. If it exists, update based on information received from OpenId.
  
![image](https://github.com/user-attachments/assets/da4c5928-0d67-4cbe-8552-f6fdade5bcd1)


- Finally, retrieve the user information needed to login and return it to the client.
![image](https://github.com/user-attachments/assets/e01acbd3-1a3b-479a-9265-4fb94878d144)
<br>

<b>Step 6: On the user interface side: Create one link redirect to env.VUE_APP_D2D3_OID_LOGIN_URL </b>
![image](https://github.com/user-attachments/assets/524ee47d-8d35-4f08-b4f0-9119072ed117)
<br>

<b>Step 7: At the RedirectUri route that you provide for OpenID. Handle AUTH_CODE received from the param on the url to login</b>
![image](https://github.com/user-attachments/assets/b89222ac-43cf-494d-b354-e10ba83d67d7)

- Send AUTH_CODE to api LoginWithAuthCode and received user info to login
![image](https://github.com/user-attachments/assets/44b3f14c-f8fc-4ecb-b37d-c3a23bd1a179)
<br>

<h2>You can sync user from your app to OpenId with one command</h2>
<pre>php artisan openid:sync-user</pre>
This command will get <b>'email', 'email_verified_at', 'first_name', 'last_name', 'phone', 'password'</b> of your app and sync to OpenId

<h2>In case you want to sync user to OpenId when updating and creating new user, use </h2>
<pre>SyncDataService::syncUser($email)</pre>

