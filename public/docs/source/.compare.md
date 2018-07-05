---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#Phone
<!-- START_ad21fcfd68df2c035e862ad38fdf077e -->
## Send confirm SMS code

> Example request:

```bash
curl -X POST "http://localhost/api/phone/confirm" \
-H "Accept: application/json" \
    -d "phone"="totam" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/phone/confirm",
    "method": "POST",
    "data": {
        "phone": "totam"
},
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/phone/confirm`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    phone | string |  required  | 

<!-- END_ad21fcfd68df2c035e862ad38fdf077e -->

