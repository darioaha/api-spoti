
### GET /api/v1/albums

#### REQUEST

Param Query List

|        Name         |  Type  | Description                                                  |
| :-------------------: | :----: | :----------------------------------------------------------- |
|         q          | string | Name of the band                                                    |
|      page      | int  | Number of the page (Default 0)    |

* example
```bash
curl <server-name>/api/v1/albums?q=the%20beatles&page=0
}
```

#### RESPONSE

* Body: Array with albums
```json
[
    {
        "name": "Abbey Road (Super Deluxe Edition)",
        "tracks": 40,
        "released": "2019-09-27",
        "cover": {
            "height": 640,
            "url": "https://i.scdn.co/image/ab67616d0000b273c94603dcb78ec39322cebb5b",
            "width": 640
        }
    }
]
```

* Headers: Info about pagination. key=_metadata_pagination
```json
{
  "total":36,
  "limit":5,
  "offset":0,
  "total_pages":7,
  "page":0
}
```
* key=_metadata_pagination
|    Name    |  Tipo  | Description                                                  |
| :----------: | :----: | :----------------------------------------------------------- |
|     total     | int | Total items                       |
|     limit     | int | Actual limit to spotify Api                       |
|     offset     | int | Actual offset                       |
|     total_pages     | int | Total pages                       |
|     page     | int | Actual page                       |


### GET /api/v1/artists

#### REQUEST

Param Query List

|        Name         |  Type  | Description                                                  |
| :-------------------: | :----: | :----------------------------------------------------------- |
|         q          | string | Name of the band                                                    |
|      page      | int  | Number of the page (Default 0)    |

* example
```bash
curl <server-name>/api/v1/artists?q=the%20beatles&page=0
}
```

##### RESPONSE

* Body: Array with names of the artists from query request
```json
[
    {"name":"The Beatles"},
    {"name":"The Beatles Complete On Ukulele"}
]
```
