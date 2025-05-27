# JSON REQUEST
### v 1.0
## Query a simple standard JSON file (from One table MySQL export)

**Usage**

```php
require_once('JsonRequest.php');
$datas = new JsonRequest('users.json');
echo $datas->showDatas();
```

![screenshot](./screen.png)

**Methods**

```php

✔️ getColumns(): array
✔️ getDatas() : array
✔️ reset(): object

✔️ filter(String $field, Mixed $value, String $comparator = '==', Bool $case_sensitive = false): object
✔️ sort(String $field, String $direction = 'ASC'): object

✔️ showDatas(array $onlycolumns = array(), Bool $reset = false): String
```
*Supported comparators*
>+ == *(default)*
>+ LIKE
>+ \>
>+ \>=
>+ <
>+ <=
>+ BETWEEN (value must be an array [min,max] , inclusive)

**Output html table with class "jsonrequest" to stylize in css**

*Sample:*

```css
.jsonrequest{
    border-collapse: collapse;
    width:100%;
    font-family: serif;
}

.jsonrequest td, .jsonrequest th {
    border:1px solid #bbb;
    padding:8px;
}
```
**You can find a complete sample in sample directory**