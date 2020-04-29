# Jirafeau in Docker

Jirafeau is a small PHP application so running it inside a docker is pretty straightforward.

## Get Jirafeau's docker image

### Pull docker image from Docker Hub

`docker pull mojo42/jirafeau`

### Build your own docker image

```
git clone https://gitlab.com/mojo42/Jirafeau.git
cd Jirafeau
docker build -t mojo42/jirafeau:latest .
```

## Run Jirafeau image

Once you have your Jirafeau's image, you can run a quick & dirty Jirafeau using:
```
docker run -d -p 8080:8080 mojo42/jirafeau
```
and then connect on [locahost:8080](http://localhost:8080) and proceed to installation.

An other way to run Jirafeau (in a more controlled way) is to mount your Jirafeau's reprository in /www folder so your data are outside the container. This way, you will be able to easily make backups, upgrade Jirafeau, change configuration and develop Jirafeau.
```
docker run -d -p 8080:8080 -v$(pwd):/www mojo42/jirafeau
```

There are also other ways to manage your container (like docker's volumes) but this is out of the scope of this documentation.

## Security

Jirafeau is run without privilidges with user id 2009. To make it able to open privilidged ports you can pass the capability, just stay with 8080 and use a reverse proxy or map the port 80:8080.
```
docker run -d -p 80:80 --sysctl net.ipv4.ip_unprivileged_port_start=80 mojo42/jirafeau
docker run -d -p 8080:8080 mojo42/jirafeau
docker run -d -p 80:8080 mojo42/jirafeau
```

## Few notes

- SSL is currently not enabled in docker's image for the moment
- `var-...` folder where lives all uploaded data is protected from direct access
- Image has been made using [Alpine Linux](https://alpinelinux.org/) with [lighttpd](https://www.lighttpd.net/) which makes the container very light and start very quickly
