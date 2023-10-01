<center style='font-size:25px'>
    <b>Ad ApiGW</b>
</center>

### **🔭Scope:**
<p>
Ad apigw primary role is to act as a single entry point and standardized process for interactions between Microservice. The API gateway can also perform various other functions to support and manage API usage with authentication.
</p>



## **Install application:**
Make sure to have following dependencies installed <br>
	    - Docker (https://docs.docker.com/get-docker/) <br><br>



<b>Create docker external network to future connect if have already please avoid </b>

```bash
docker network create --subnet=10.10.10.0/24 --gateway=10.10.10.1 ad-common-network
```
<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-api-gw.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp src/.env.docker-installtion.example src/.env
 docker-compose build
 docker-compose up -d
```

<br><b>create a database using this following name</b>
### **🌱 Database credentials **
```env
Host: localhost
Port:33067
Username: root
Password: secret
```
### **🌱 Database name **
```bash
apigw
```


<br><b>Enter docker container </b>
```bash
 docker exec -it ad_apigw bash
```

<br><b>Run following command in docker container </b>
```bash
 composer install
 php artisan migrate
 php artisan db:seed --class=UsersTableSeeder
 exit
```


### **🌱 Application info:**
```env
App_URL: http://localhost:4002/
```

### **🌱 Default user name password to get token**
```env
username: rahibhasan689009@gmail.com
password: 12345678

```
