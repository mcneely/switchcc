# switchcc
Code Challenge for Switch

**Endpoint:**

```/api/calculateChange/{Total Cost}/{Ammount Provided}```

Called via a **GET** Request.

**Returns:**

A Json Result split out into denominations and counts. Ex:
```
{"change":
  {
    "$50 Bills":1,
    "$20 Bills":2,
    "$5 Bills":1,
    "$2 Bills":2,
    "Quarters":3,
    "Dimes":1,
    "Nickels":1
   }
}
```
