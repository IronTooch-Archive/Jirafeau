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
docker run -d -p 8080:80 mojo42/jirafeau
```
and then connect on [locahost:8080](http://localhost:8080/) and proceed to installation.

## Security

Jirafeau is run without privilidges with user id 2009. To make it able to open privilidged ports you can pass the capability, just stay with 8080 and use a reverse proxy or map the port 80:8080.
```
docker run -d -p 80:80 --sysctl net.ipv4.ip_unprivileged_port_start=80 mojo42/jirafeau
docker run -d -p 8080:80 mojo42/jirafeau
docker run -d -p 80:80 mojo42/jirafeau
```

Note that Jirafeau image does not provide any SSL/TLS. You may be interrested in using [docker compose](https://docs.docker.com/compose/) combined with [Let's Encrypt](https://letsencrypt.org/).

## Options

Jirafeau docker image accept some options through environment variables to ease its configuration.
More details about options in `lib/config.original.php`.

Available options:
- `FILE_HASH`: can be set to `md5` (default), `partial_md5` or `random`.

## Few notes

- `var-...` folder where lives all uploaded data is protected from direct access
- Image has been made using [Alpine Linux](https://alpinelinux.org/) with [lighttpd](https://www.lighttpd.net/) which makes the container very light and start very quickly
