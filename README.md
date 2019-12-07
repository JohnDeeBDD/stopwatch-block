This is a WordPress plugin that displays a frontend "stopwatch". 

# Usage

To activate the plugin, enter the WordPress shortcode ``[contractor-stopwatch]`` in the content of your post.
![Frontend](https://raw.githubusercontent.com/JohnDeeBDD/stopwatch-block/master/clock-face.png)

# API: Save Data

This endpoint collects the data for the stop watch.

**URL** : `/wp-json/contractor-stopwatch/v1/save-data`

**Method** : `POST`

**Auth required** : pending - ignore for now

**Data**

argument name| type | description| required
------------ | --------- | ------- | -------
postID | integer | the WordPress post ID | yes [or data will not be saved]
startStopArray | array | the stopwatch sessions | no

**Data Example**
2 compleated stopwatch sessions
Even number of entries = clock is NOT running
```json
[ 
   1575676690324,
   1575676691682,
   1575676692360,
   1575676693925
]
```

1 compleate session + start time
Odd number of entries = clock IS running
```json
[ 
   1575676690324,
   1575676691682,
   1575676692360
]
```

Clock has not started yet / reset state
```json
[]
```

![WordPress Screenshot](https://raw.githubusercontent.com/JohnDeeBDD/stopwatch-block/master/stopwatch-data2.png)

## Javascript Hidden Variable
``postID`` is a hidden variable available on the frontend.

## Success Response

**Code** : `200 OK`

**Content** :

"Success!"


## Error Response

**Condition** : typo or some other error

**Code** : `404 BAD REQUEST`

**Content** :

```json
{
    code: "rest_no_route",
    message: "No route was found matching the URL and request method",
    data: {
        status: 404
    }
}
```
