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

# Data Example

2 compleated stopwatch sessions<br />
Even number of entries = clock is NOT running<br />
```json
[ 
   1575676690324,
   1575676691682,
   1575676692360,
   1575676693925
]
```
![WordPress Screenshot](https://raw.githubusercontent.com/JohnDeeBDD/stopwatch-block/master/stopwatch-data2.png)
---
1 compleate session + start time<br />
Odd number of entries = clock IS running<br />
```json
[ 
   1575676690324,
   1575676691682,
   1575676692360
]
```
---
Clock has not started yet / reset state<br />
```json
[]
```
# Javascript Hidden Variable
``postID`` is a hidden variable available on the frontend.

# RESPONSES
## Success

**Code** : `200 OK`

**Content** :

"Success!"
---
## Error

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
