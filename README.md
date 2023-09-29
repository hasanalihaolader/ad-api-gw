<center style='font-size:25px'>
    <b>Ad ApiGW</b>
</center>

### **🔭Scope:**
<p>
Ad apigw primary role is to act as a single entry point and standardized process for interactions between Microservice. The API gateway can also perform various other functions to support and manage API usage with authentication.
</p>



## **Install application using docker:**
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
```

<br><b>Enter docker container </b>
```bash
 docker exec -u www-data -it ad_apigw bash
```
<br><b>please create a database (database name : apigw) using  database info below</b>
<br><b>Run following command in docker container </b>
```bash
 php artisan migrate
 php artisan db:seed --class=UsersTableSeeder
 exit
```
<br><b>Get back project root folder and run</b>
```bash
 docker-compose up -d
```
<br><b>Check application info below</b>


### **Manual installation:**
Make sure to have following dependencies installed <br>
	- PHP >- 7.4 <br>
 	- MYSQL <br>
  	- composer 2<br>

<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-api-gw.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp src/.env.example src/.env
```

<br><b>please create a database (database name : apigw) using  database info below</b>
<br><b>Modify .env to connect database following information</b>
```env
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=apigw
DB_USERNAME=root
DB_PASSWORD=secret
```
<br><b>Run following command to run application</b>
```env
php artisan migrate
php artisan db:seed --class=UsersTableSeeder
php -S localhost:4002 -t ./public
```
### **🌱 Application info:**
```env
App_URL: https://localhost:4002/
```

### **🌱 Database info when you use docker installation**
```env
Host: localhost
Port:33067
Username: root
Password: secret

```

### **🌱 Default user name password to get token**
```env
username: rahibhasan689009@gmail.com
password: 12345678

```
