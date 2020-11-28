# SpotiApi

## API
SpotiApi is an API written in PHP to get albums from a band name. 
The API exposes [two endpoints](services.md) /api/v1/albums and /api/v1/artists

### SpotiApi

### Prerequisites 

You need to install the next tools:

* Docker ([installation with docker](#docker))
* Docker-compose 1.27 (Only for docker-compose installation)
https://docs.docker.com/compose/install/

### Clone

```
git clone https://github.com/darioaha/api-spoti.git apispoti
```
#### Docker

1. Copy and modify env file
```
cd apispoti
cp .env.tmpl .env
```
See [configuration](configuration.md)
> The most important configurations are the ID and Secret for  Spotify 
> [Create App and Save ClientID and Secret](https://developer.spotify.com/dashboard/applications)

2. Build Docker Image
```
docker build -t apispoti -f Dockerfile .
```

3. Run docker image
```
docker run -d \
  -p 80:80 \
  -p 443:443 \
  --env-file .env \
  --hostname="apispoti" \
  --name="apispoti" \
  apispoti
```

4. Dev mode
```
docker run -d \
  -p 80:80 \
  -p 443:443 \
  --env-file .env \
  --restart=always \
  --name="apispoti" \
  -v $(pwd):/var/www/apispoti \
  apispoti
```

### Docker Compose

#### Deploy Compose
1. Copy and modify env file
```
cd apispoti
cp .env.tmpl .env
```
See [configuration](configuration.md)
> The most important configurations are the ID and Secret for  Spotify 
> [Create App and Save ClientID and Secret](https://developer.spotify.com/dashboard/applications)

1. Run docker-compose up
docker-compose definition include the following services
- 
: Docker container for the api

```bash

docker-compose up --build -d
```

#### Delete Compose
```bash
docker-compose down
```

### Postman examples

You can import the `SpotiApi.postman_collection.json` into postman app for test
