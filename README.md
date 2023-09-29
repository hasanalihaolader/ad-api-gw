<center style='font-size:25px'>
    <b>IP MANAGMENT SOLUATION</b>
</center>

### **🔭Scope:**
<p>
IP management solution could be storing IP information (ex: 202.92.249.111 is the ‘BFBC2` server ) and updating existing IP records. IP management solution tracks every IP stored and updated data history.
</p>



## **Install application using docker:**
Make sure to have following dependencies installed <br>
	    - Docker (https://docs.docker.com/get-docker/) <br><br>



<b>Create docker external network to future connected</b>

```bash
docker network create --subnet=10.10.10.0/24 --gateway=10.10.10.1 ad-common-network
```
<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-ip-managment.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp src/.env.example src/.env
 docker-compose build
```

<br><b>Enter docker container </b>
```bash
 docker exec -u www-data -it ad_ip_managment bash
```

<br><b>Run following command in docker container </b>
```bash
 php artisan migrate
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
  	- composer <br>

<br><b>Git Clone / Download code</b>
```bash
git clone https://github.com/hasanalihaolader/ad-ip-managment.git
```
<br><b>Go to downloaded folder and run following command into this folder</b>
```bash
 cp .env.example .env
 cp .env.example .env
```
<br><b>Modify .env to connect database following information</b>
```env
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=ad_ip_managment
DB_USERNAME=ad_user
DB_PASSWORD=secret
```
<br><b>Run following command to run application</b>
```env
php artisan migrate
php artisan serve --port  4001
```
### **🌱 Application info:**
```env
App_URL: https://localhost:4001/
```

### **🌱 Database info when you use docker installtion**
```env
Host: localhost
Port:33067
Username: ad_user
Password: secret

```
