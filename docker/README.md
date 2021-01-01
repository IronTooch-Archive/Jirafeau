# Run Jirafeau through a pre-made Docker image

Jirafeau is a small PHP application so running it inside a docker is pretty straightforward.

```
docker pull mojo42/jirafeau:latest
docker run -d -p 8080:80 mojo42/jirafeau:latest
```

Then connect on [locahost:8080](http://localhost:8080/).
The admin console is located on `/admin.php`, check console output to get auto-generated admin password.

# Build your own Jirafeau docker image

```
git clone https://gitlab.com/mojo42/Jirafeau.git
cd Jirafeau
docker build -t your/jirafeau:latest .
```

# Security

You may be interested to run Jirafeau on port 80:
```
docker run -d -p 80:80 --sysctl net.ipv4.ip_unprivileged_port_start=80 mojo42/jirafeau
```

Note that Jirafeau image does not provide any SSL/TLS. You may be interrested in using [docker compose](https://docs.docker.com/compose/) combined with [Let's Encrypt](https://letsencrypt.org/).

# Options

Jirafeau docker image accept some options through environment variables to ease its configuration.
More details about options in `lib/config.original.php`.

Available options:
- `ADMIN_PASSWORD`: setup a specific admin password. If not set, a random password will be generated.
- `WEB_ROOT`: setup a specific domain to point at when generating links (e.g. 'jirafeau.mydomain.com/').
- `VAR_ROOT`: setup a specific path where to place files. default: '/data'.
- `FILE_HASH`: can be set to `md5` (default), `partial_md5` or `random`.

## Few notes

- `var-...` folder where lives all uploaded data is protected from direct access
- Image has been made using [Alpine Linux](https://alpinelinux.org/) with [lighttpd](https://www.lighttpd.net/) which makes the container very light and start very quickly
