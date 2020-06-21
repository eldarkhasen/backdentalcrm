### Make an appointment
#### WARNING!
```
Request:
Method: POST
URI: asdasdasd
{
    Asd:asd
}

RESPONSE:

```

<hr>

### Make an appointment
#### WARNING!
```
Request:
Method: POST
URI: /api/v1/appointments
{
	"title": "test title",
	"starts_at": "22.06.2020",
	"ends_at": "23.06.2020",
	"price": 12000,
	"patient": {
		"id": 1,
		"surname": "test",
		"name": "test",
		"patronymic": "test",
		"phone": "test"
	},
	"employee": {
		"id": 2,
		"color": "#fff"
	},
	"treatment_course": { //if new course - null
		"id": 1
	},
	"is_first_visit": true
}

RESPONSE:
{
    "status": "pending",
    "starts_at": "2020-06-22T00:00:00.000000Z",
    "ends_at": "2020-06-23T00:00:00.000000Z",
    "employee_id": 2,
    "patient_id": 1,
    "color": "#fff",
    "is_first_visit": true,
    "title": "test test test, test",
    "treatment_course_id": 1,
    "updated_at": "2020-06-21T08:27:22.000000Z",
    "created_at": "2020-06-21T08:27:22.000000Z",
    "id": 4
}
```

<hr>

### update appointment
#### 
```
Request:
Method: PUT
URI: /api/v1/appointments/{id}
{
	"title": "test title",
	"starts_at": "22.06.2020",
	"ends_at": "23.06.2020",
	"price": 12000,
	"patient": {
		"id": 1,
		"surname": "test",
		"name": "test",
		"patronymic": "test",
		"phone": "test"
	},
	"employee": {
		"id": 2,
		"color": "#fff"
	},
	"treatment_course": {
		"id": 1
	},
	"is_first_visit": true,
	"status": "success"
}

RESPONSE:
{
    "id": 4,
    "title": "test title",
    "starts_at": "2020-06-22T00:00:00.000000Z",
    "ends_at": "2020-06-23T00:00:00.000000Z",
    "price": 0,
    "status": "success",
    "color": "#fff",
    "employee_id": 2,
    "patient_id": 1,
    "treatment_course_id": 1,
    "is_first_visit": true,
    "deleted_at": null,
    "created_at": "2020-06-21T08:27:22.000000Z",
    "updated_at": "2020-06-21T08:32:44.000000Z"
}
```


<hr>

### get appointment by id
```
Request: 
Method: GET
uri: /api/v1/appointments/{id}

Respoonse:
{
    "id": 4,
    "title": "test title",
    "starts_at": "21.06.2020 08:38",
    "ends_at": "21.06.2020 08:38",
    "price": 0,
    "status": "success",
    "color": "#fff",
    "employee": {
        "id": 2,
        "account_id": 2,
        "name": "ilyas",
        "surname": "akbergen",
        "patronymic": "zhan",
        "phone": "1234",
        "birth_date": "03.04.1998",
        "gender": "1",
        "color": "green",
        "created_at": null,
        "updated_at": null,
        "organization_id": 2
    },
    "patient": {
        "id": 1,
        "name": "test ",
        "surname": "test",
        "patronymic": "test",
        "phone": "123",
        "birth_date": "03.04.1998",
        "gender": "1",
        "id_card": "123",
        "id_number": "980403350149",
        "city": "1",
        "address": "",
        "workplace": null,
        "position": null,
        "discount": 0,
        "photoname": null,
        "mime": null,
        "original_photoname": null,
        "special_conditions": null,
        "anamnesis_vitae": null,
        "created_at": null,
        "updated_at": null
    },
    "treatment_course": {
        "id": 1,
        "name": "test test test, test",
        "is_finished": 0,
        "deleted_at": null,
        "created_at": "2020-06-21T08:27:22.000000Z",
        "updated_at": "2020-06-21T08:27:22.000000Z"
    },
    "is_first_visit": true
}
```

<hr>

### get filtered appointments
#### 
```
Request:
Method: POST
URI: /api/v1/get-appointments
{
	"time_from": "21.06.2020",
	"time_to": "23.06.2020",
	"employee_ids": null,
	"patient_ids": null,
	"search_key": null
}

RESPONSE:

    {
        "id": 4,
        "title": "test title",
        "starts_at": "21.06.2020 08:36",
        "ends_at": "21.06.2020 08:36",
        "price": 0,
        "status": "success",
        "color": "#fff",
        "employee": {
            "id": 2,
            "account_id": 2,
            "name": "ilyas",
            "surname": "akbergen",
            "patronymic": "zhan",
            "phone": "1234",
            "birth_date": "03.04.1998",
            "gender": "1",
            "color": "green",
            "created_at": null,
            "updated_at": null,
            "organization_id": 2
        },
        "patient": {
            "id": 1,
            "name": "test ",
            "surname": "test",
            "patronymic": "test",
            "phone": "123",
            "birth_date": "03.04.1998",
            "gender": "1",
            "id_card": "123",
            "id_number": "980403350149",
            "city": "1",
            "address": "",
            "workplace": null,
            "position": null,
            "discount": 0,
            "photoname": null,
            "mime": null,
            "original_photoname": null,
            "special_conditions": null,
            "anamnesis_vitae": null,
            "created_at": null,
            "updated_at": null
        },
        "treatment_course": {
            "id": 1,
            "name": "test test test, test",
            "is_finished": 0,
            "deleted_at": null,
            "created_at": "2020-06-21T08:27:22.000000Z",
            "updated_at": "2020-06-21T08:27:22.000000Z"
        },
        "is_first_visit": true
    },
    {
        "id": 5,
        "title": "test test test, test",
        "starts_at": "21.06.2020 08:36",
        "ends_at": "21.06.2020 08:36",
        "price": 0,
        "status": "pending",
        "color": "#fff",
        "employee": {
            "id": 2,
            "account_id": 2,
            "name": "ilyas",
            "surname": "akbergen",
            "patronymic": "zhan",
            "phone": "1234",
            "birth_date": "03.04.1998",
            "gender": "1",
            "color": "green",
            "created_at": null,
            "updated_at": null,
            "organization_id": 2
        },
        "patient": {
            "id": 1,
            "name": "test ",
            "surname": "test",
            "patronymic": "test",
            "phone": "123",
            "birth_date": "03.04.1998",
            "gender": "1",
            "id_card": "123",
            "id_number": "980403350149",
            "city": "1",
            "address": "",
            "workplace": null,
            "position": null,
            "discount": 0,
            "photoname": null,
            "mime": null,
            "original_photoname": null,
            "special_conditions": null,
            "anamnesis_vitae": null,
            "created_at": null,
            "updated_at": null
        },
        "treatment_course": {
            "id": 1,
            "name": "test test test, test",
            "is_finished": 0,
            "deleted_at": null,
            "created_at": "2020-06-21T08:27:22.000000Z",
            "updated_at": "2020-06-21T08:27:22.000000Z"
        },
        "is_first_visit": true
    }

```

<hr>

### delete appointment by id
```
Request:
uri: /api/v1/appointments/{id}
Method: DELETE

Respoonse:
{
    "id": 4,
    "title": "test title",
    "starts_at": "21.06.2020 08:38",
    "ends_at": "21.06.2020 08:38",
    "price": 0,
    "status": "success",
    "color": "#fff",
    "employee": {
        "id": 2,
        "account_id": 2,
        "name": "ilyas",
        "surname": "akbergen",
        "patronymic": "zhan",
        "phone": "1234",
        "birth_date": "03.04.1998",
        "gender": "1",
        "color": "green",
        "created_at": null,
        "updated_at": null,
        "organization_id": 2
    },
    "patient": {
        "id": 1,
        "name": "test ",
        "surname": "test",
        "patronymic": "test",
        "phone": "123",
        "birth_date": "03.04.1998",
        "gender": "1",
        "id_card": "123",
        "id_number": "980403350149",
        "city": "1",
        "address": "",
        "workplace": null,
        "position": null,
        "discount": 0,
        "photoname": null,
        "mime": null,
        "original_photoname": null,
        "special_conditions": null,
        "anamnesis_vitae": null,
        "created_at": null,
        "updated_at": null
    },
    "treatment_course": {
        "id": 1,
        "name": "test test test, test",
        "is_finished": 0,
        "deleted_at": null,
        "created_at": "2020-06-21T08:27:22.000000Z",
        "updated_at": "2020-06-21T08:27:22.000000Z"
    },
    "is_first_visit": true
}

response: true/false
```
