define({ "api": [
  {
    "type": "get",
    "url": "/contingents/all",
    "title": "Requesting all contingents",
    "name": "Get_All_Contingents",
    "group": "Contingent",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>jsonObject</p> ",
            "optional": false,
            "field": "Contingents",
            "description": "<p>JSONObject containing contingents info &amp; meta info. http://www.jsoneditoronline.org/?id=a1d0eb703336fa4f5eb93a72813c5a06</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./api/index.php",
    "groupTitle": "Contingent"
  },
  {
    "type": "get",
    "url": "/event/:id",
    "title": "Get Event information .",
    "name": "GetUser",
    "group": "Event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>Event unique ID.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>jsonObject</p> ",
            "optional": false,
            "field": "Events",
            "description": "<p>JSONObject containing event info &amp; meta info. http://www.jsoneditoronline.org/?id=ad9ceb16c8f68d2892b1abd60cf824d9</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EventNotFound",
            "description": "<p>Event with given ID not found http://www.jsoneditoronline.org/?id=ad9ceb16c8f68d2892b1abd60cb8dd0a</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "  {\n\"code\":204,\n\"error\":1,\n\"message\":\"Oops, Event by id 20 not found\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./api/index.php",
    "groupTitle": "Event"
  },
  {
    "type": "get",
    "url": "/events/all",
    "title": "Requesting all events",
    "name": "Get_All_Events",
    "group": "Event",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>jsonObject</p> ",
            "optional": false,
            "field": "Events",
            "description": "<p>JSONObject containing event info &amp; meta info. http://www.jsoneditoronline.org/?id=a1d0eb703336fa4f5eb93a72813c5a06</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./api/index.php",
    "groupTitle": "Event"
  },
  {
    "type": "get",
    "url": "/registrations/contingents/event/:event",
    "title": "Get Registrations of contingents for given event.",
    "name": "GetRegistrationsOfContingentForEvent",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "String",
            "description": "<p>Event name.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>jsonObject</p> ",
            "optional": false,
            "field": "registrations",
            "description": "<p>All registrations</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 No registrations for event\n{\"error\":0,\"message\":\"No contingent found for the event 1\",\"total_contingents\":0}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Event",
            "description": "<p>The event of with given name was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": " HTTP/1.1 200 Not Found\n\n{\n    \"error\":1,\n    \"error_message\":\"Event with name missionsql not found\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./api/index.php",
    "groupTitle": "Registration"
  }
] });