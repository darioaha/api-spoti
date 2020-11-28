## .env file

### API Config

`ENVIRONMENT`

Could be:
* "dev" - show errors
* "staging"
* "production" - not show errors.

`PROJECT_NAME`
PROJECT_NAME="apispoti"

`LOG_LEVEL`

Could be:
* debug
* error
* info
* warning

#### Spotify Variables
`API_CLIENT_SPOTIFY`
Client ID from spotify app

`API_SECRET_SPOTIFY`
Client Secret from Spotify app
Something like this:
`API_SECRET_SPOTIFY=1d055378c13b4e10b6755cbd9facd488`

`API_QUERY_LIMIT_SPOTIFY`

Maximum number of results requested to spotify API (Maximum: 50)

Example
`API_QUERY_LIMIT_SPOTIFY=5`

`ARAI_DOCS_URL`
