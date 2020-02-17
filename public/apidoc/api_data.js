define({ "api": [
  {
    "type": "post",
    "url": "/api/send-otp",
    "title": "Send OTP",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSendOtp",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>User unique mobile number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type*. (Creator =&gt; 2, User =&gt; 3).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>language. (English =&gt; 1, Hindi =&gt; 2).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>OTP sent successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"OTP sent successfully.\",\n      \"data\": {}\n  }",
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
            "field": "MobileNumberMissing",
            "description": "<p>The mobile number is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User type is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Mobile number missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/token-update",
    "title": "Token Update",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostTokenUpdate",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token key.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Updated..</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Token Updated.\",\n      \"data\": {}\n  }",
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
            "field": "Useridmissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Usernotfound",
            "description": "<p>User not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Tokenismissing",
            "description": "<p>Token Is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User Id missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User not found\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Token Is missing\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/verify-otp",
    "title": "Verify OTP",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostVerifyOtp",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>User unique mobile number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type*. (User =&gt; 3).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "otp",
            "description": "<p>OTP*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>OTP verified successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"OTP verified successfully.\",\n      \"data\": {\n          \"user_detail\": {\n              \"id\": 2,\n              \"name\": \"Hariom\",\n              \"email\": \"hariom@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"1991-02-04\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.Com\",\n              \"about\": \"Lorem ipsum\",\n              \"experience\": \"2 Year\",\n              \"into_line\": null,\n              \"lang\": 1,\n              \"user_type_id\": 2,\n              \"otp\": \"12345\",\n              \"profile_pic\": \"http://127.0.0.1:8000/storage/profile_pic/1hbKjNG9nhvNTtJtWMn2t7hlsSE6GLsuKqtp3scX.jpeg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": \"2020-01-13 06:57:03\",\n              \"updated_at\": \"2020-01-13 06:57:03\",\n              \"deleted_at\": null\n          },\n          \"user\": {\n              \"following\": 10,\n              \"follower\": 50,\n              \"post\": 35\n          }\n      }\n  }",
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
            "field": "MobileNumberMissing",
            "description": "<p>The mobile number is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User type is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "OTPMissing",
            "description": "<p>The OTP is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Mobile number missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"OTP missing.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "get",
    "url": "/api/bookmark-list",
    "title": "Bookmark List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetBookmarkList",
    "group": "Bookmark",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Bookmark List.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n     \"status\": true,\n     \"status_code\": 200,\n     \"message\": \"Bookmark List.\",\n     \"data\": {\n       \"Bookmark_list\": [\n         {\n           \"id\": 2,\n           \"test_series_id\": 1,\n           \"created_at\": null,\n           \"subject_id\": 3,\n           \"name\": \"Lorem Ipsum is simply dummy text of the printing\",\n           \"total_question\": 556,\n           \"lang\": 1,\n           \"subject_name\": \"ssc\"\n          }\n        ]\n     }\n   }",
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
            "field": "UserIdismissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Usernotfound",
            "description": "<p>User not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/BookmarkController.php",
    "groupTitle": "Bookmark"
  },
  {
    "type": "post",
    "url": "/api/add-bookmark",
    "title": "Bookmark",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostBookmark",
    "group": "Bookmark",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User user_id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Flag type.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>test series bookmarked successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Test Series bookmarked successfully.\",\n      \"data\": {\n           \"favorite\": true,\n           \"count\": 1\n        }\n  }",
          "type": "json"
        },
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"test_series bookmarked Removed.\",\n      \"data\": {\n           \"favorite\": false,\n           \"count\": 1\n        }\n  }",
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
            "field": "UserIdmissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "test_seriesIdmissing",
            "description": "<p>test_series Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "test_seriesnotfound",
            "description": "<p>test_series not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"test_series Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"test_series not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/BookmarkController.php",
    "groupTitle": "Bookmark"
  },
  {
    "type": "get",
    "url": "/api/contact-us",
    "title": "Contact Us",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetContactUs",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Contact Us.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n     \"status\":true,\n     \"status_code\":200,\n     \"message\":\"Contact Us\",\n     \"data\":\n         {\n             \"number\":\"+911234567890\",\n             \"email\":\"info@quizz.com\"\n         }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/feedback",
    "title": "Feedback",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetFeedback",
    "group": "CMS",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "context",
            "description": "<p>message.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>about us found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Feedback Sent.\",\n   \"data\": {}\n}",
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
            "field": "Useridmissing",
            "description": "<p>User Id missing</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Contextmissing",
            "description": "<p>Context missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Context missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/privacy-policy",
    "title": "Privacy Policy",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetPrivacyPolicy",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Privacy Policy.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n     \"status\":true,\n     \"status_code\":200,\n     \"message\":\"Privacy Policy\",\n     \"data\":\n         {\n             \"content\":\"<ol>\\n   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <\\/ol>\"\n         }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "get",
    "url": "/api/terms-conditions",
    "title": "Terms Conditions",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetTermsConditions",
    "group": "CMS",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Terms Conditions.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n     \"status\":true,\n     \"status_code\":200,\n     \"message\":\"Terms Conditions\",\n     \"data\":\n         {\n             \"title\":\"I UNDERSTAND THAT HOPE WILL NOT USE MY PERSONAL DATA IN ANY WAY.\",\n             \"content\":\"<ol>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<\\/li>\\n        <\\/ol>\"\n         }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CmsController.php",
    "groupTitle": "CMS"
  },
  {
    "type": "post",
    "url": "/api/creator-user-profile",
    "title": "Creator User Profile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCreatorUserProfile",
    "group": "Creator",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>1=&gt;testseries, 2=&gt;usertest series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"TestSeries List\",\n   \"data\":{\n     \"user_profile\":{\n     \"id\": 1,\n     \"name\": \"quiz\",\n     \"email\": \"admin@mail.com\",\n     \"mobile_number\": null,\n     \"dob\": \"2020-01-08\",\n     \"designation\": null,\n     \"about\": null,\n     \"experience\": null,\n     \"qualification\": null,\n     \"lang\": 1,\n     \"user_type_id\": 2,\n     \"otp\": null,\n     \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n     \"device_token\": null,\n     \"latitude\": null,\n     \"longitude\": null,\n     \"is_active\": 1,\n     \"email_verified_at\": null,\n     \"created_by\": \"0\",\n     \"updated_by\": \"0\",\n     \"created_at\": null,\n     \"updated_at\": null,\n     \"deleted_at\": null\n     },\n     \"user\":{\n             \"following\": 10,\n             \"follower\": 50,\n             \"post\": 2,\n             \"Test_series\":[\n             {\n                    \"id\": 1,\n                     \"name\": \"grhfghrt\",\n                     \"created_at\": null,\n                     \"flag\": 1,\n                     \"total_ques_no\": 12\n             },\n             {\n                     \"id\": 2,\n                     \"name\": \"grhfgh\",\n                     \"created_at\": null,\n                     \"flag\": 1,\n                     \"total_ques_no\": 12\n             }\n         ]\n     }\n   }\n  }\n}",
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
            "field": "UserIdMissing",
            "description": "<p>User Id missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id Missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "Creator"
  },
  {
    "type": "get",
    "url": "/api/exam-list",
    "title": "Exam List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetExamList",
    "group": "Exam",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of Exams.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"List of Exams\",\n      \"data\": [\n          {\n              \"id\": 1,\n              \"name\": \"SSC\",\n              \"created_at\": null,\n              \"updated_at\": null,\n              \"deleted_at\": null,\n          },\n          {\n              \"id\": 2,\n              \"name\": \"RBI\",\n              \"created_at\": null,\n              \"updated_at\": null,\n              \"deleted_at\": null,\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ExamController.php",
    "groupTitle": "Exam"
  },
  {
    "type": "get",
    "url": "/api/invite-status",
    "title": "Invite Status",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetInviteStatus",
    "group": "Invite",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User user_id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Flag(1=&gt; testSeries, 2=&gt; User test series).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Invite",
            "description": "<p>.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Accepted\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Rejected\",\n      \"data\": {}\n  }",
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
            "field": "UserIdmissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TestSeriesIdmissing",
            "description": "<p>Test Series Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TestSeriesnotfound",
            "description": "<p>Test Series not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Test Series Id Missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Test Series not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/InviteController.php",
    "groupTitle": "Invite"
  },
  {
    "type": "post",
    "url": "/api/invite",
    "title": "Invite",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostInvite",
    "group": "Invite",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User user_id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series Id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Invite",
            "description": "<p>.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Invite successfully\",\n      \"data\": {\n             test_series\": \"dgregr\",\n             user_detail\": \"gggggu\"\n             }\n  }",
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
            "field": "UserIdmissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TestSeriesIdmissing",
            "description": "<p>Test Series Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Test Series Id Missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/InviteController.php",
    "groupTitle": "Invite"
  },
  {
    "type": "get",
    "url": "/api/notification",
    "title": "Notification",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetNotification",
    "group": "Notification",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>notification.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Notification List\",\n   \"data\": {\n       \"notification_list\": [\n       {\n           \"id\": 1,\n           \"user_id\": 1,\n           \"message\": \"notification\",\n           \"is_read\": 1,\n       }\n     ]\n  }\n}",
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
            "field": "Useridmissing",
            "description": "<p>User Id missing</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/NotificationController.php",
    "groupTitle": "Notification"
  },
  {
    "type": "get",
    "url": "/api/year-list",
    "title": "Year List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetYearList",
    "group": "Question",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of Years.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"List of Years\",\n      \"data\": [\n          {\n              \"year\": 2013\n          },\n          {\n              \"year\": 2019\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question"
  },
  {
    "type": "get",
    "url": "/api/comment-list",
    "title": "Comment List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetCommentList",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "question_id",
            "description": "<p>Question ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>comment list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n         \"status\":true,\n         \"status_code\":200,\n         \"message\":\"List of Comments\",\n         \"data\":[\n                {\n                 \"id\":3,\n                 \"user_id\":2,\n                 \"question_id\":5,\n                 \"description\":\"htrh\",\n                 \"created_at\":\"2020-01-07 10:26:42\",\n                 \"updated_at\":\"2020-01-07 10:26:42\"\n                 },\n                 {\n                     \"id\":4,\n                     \"user_id\":2,\n                     \"question_id\":5,\n                     \"description\":\"nice\",\n                     \"created_at\":\"2020-01-07 10:27:18\",\n                     \"updated_at\":\"2020-01-07 10:27:18\"\n         }\n     ]\n }",
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
            "field": "QuestionNotFound",
            "description": "<p>Question Not Found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Question not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionCommentController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "get",
    "url": "/api/question-detail",
    "title": "Question Detail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetQuestionDetail",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ques_id",
            "description": "<p>Question ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Question Detail.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question Detail.\",\n      \"data\": {\n         \"questions\": {\n              \"id\": 8,\n              \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n              \"ques_image\": \" \",\n              \"ques_time\": 20,\n              \"is_like\" : true,\n               \"user\": {\n                  \"id\": 2,\n                  \"name\": \"manish\",\n                  \"profile_pic\": \"\"\n               },\n              \"answers\": [\n                  {\n                      \"id\": 29,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 30,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 31,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 32,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 1,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  }\n              ]\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "get",
    "url": "/api/question-list",
    "title": "Question list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetQuestionlist",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "page",
            "description": "<p>Page No.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Flag*.(1=&gt;Random question, 2=&gt; Filtered Question)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "exam_id",
            "description": "<p>Exam Id in array format*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject_id",
            "description": "<p>Subject Id in array format*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "total_questions",
            "description": "<p>Total no. of questions*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "year",
            "description": "<p>year(optional)*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>Language(English=&gt;1,Hindi=&gt;2)*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Question list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question list.\",\n      \"data\": [\n         \"question_time\":50,\n         \"test_series_id\":2,\n         \"questions\": {\n              \"id\": 8,\n              \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n              \"ques_image\": \" \",\n              \"ques_time\": 20,\n              \"is_like\" : true,\n               \"user\": {\n                  \"id\": 2,\n                  \"name\": \"manish\",\n                  \"profile_pic\": \"\"\n               },\n              \"answers\": [\n                  {\n                      \"id\": 29,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 30,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 31,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 32,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 1,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  }\n              ]\n          },\n          {\n              \"id\": 20,\n              \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n              \"ques_image\": \" \",\n              \"ques_time\": 20,\n              \"is_like\" : true,\n               \"user\": {\n                  \"id\": 2,\n                  \"name\": \"manish\",\n                  \"profile_pic\": \"\"\n               },\n              \"answers\": [\n                  {\n                      \"id\": 77,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 78,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 79,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 80,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 1,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  }\n              ]\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "post",
    "url": "/api/comment",
    "title": "Comment",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostComment",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "question_id",
            "description": "<p>Question ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<p>Comment.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>comment.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Comment\",\n      \"data\": []\n  }",
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
            "field": "UserIdMissing",
            "description": "<p>user id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "QuestionIdMissing",
            "description": "<p>Question Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "CommentMissing",
            "description": "<p>Comment missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>User Not Found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "QuestionNotFound",
            "description": "<p>Question Not Found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user id missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Question ID missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Comment missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Question not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionCommentController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "post",
    "url": "/api/create-single-question",
    "title": "Create Single Question",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCreateSingleQuestion",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "exam_id",
            "description": "<p>Exam.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject_id",
            "description": "<p>Subject.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>language(1 =&gt; English,2 =&gt; Hindi) .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ques_time",
            "description": "<p>Question Time.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ques_pic",
            "description": "<p>Question Image*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ans1",
            "description": "<p>First Answer.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ans2",
            "description": "<p>Second Answer.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ans3",
            "description": "<p>Third Answer.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ans4",
            "description": "<p>Fourth Answer.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "correct_ans",
            "description": "<p>Correct Answer (ans1,ans2,ans3,an4).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Create test series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question added successfully\",\n      \"data\": {}\n  }",
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
            "field": "descriptionMissing",
            "description": "<p>The Description missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "questionTimeMissing",
            "description": "<p>The Question Time missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "testSeriesIdMissing",
            "description": "<p>The Test Series Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "subjectIdmissing",
            "description": "<p>The SubjectId missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "QuestionPicNot",
            "description": "<p>validtype Question pic not valid file type.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"description missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Question Time missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Test Series Id missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Subject Id missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Question pic not valid file type.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "post",
    "url": "/api/like-question",
    "title": "Question Like",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostQuestionLike",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "question_id",
            "description": "<p>Question ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Question",
            "description": "<p>Liked.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question Liked.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "post",
    "url": "/api/submit-answer",
    "title": "Submit Answer",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSubmitAnswer",
    "group": "Question_Answer",
    "examples": [
      {
        "title": "Example usage:",
        "content": "body:\n  {\n          \"user_id\":1,\n          \"quiz_id\":2,\n          \"name\" : \"SSC_1\",\n          \"exam_id\":1,\n          \"subject_id\":1,\n          \"lang\":1,\n          \"questions\":[\n                  {\n                          \"question_id\":1,\n                          \"answer_id\":4,\n                          \"is_correct\":1\n                  },\n                  {\n                          \"question_id\":2,\n                          \"answer_id\":6,\n                          \"is_correct\":0\n                  }\n          ]\n  }",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Answer",
            "description": "<p>'s submitted succeffully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Answer's submitted succeffully.\",\n      \"data\": {\n          \"test_series\": {\n              \"name\": \"SSC_1\",\n              \"your_score\": 1,\n              \"total_score\": 2,\n              \"your_rank\": \"2300\",\n              \"total_rank\": \"5000\",\n              \"questions\": [\n                  {\n                      \"question\": {\n                          \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\",\n                          \"ques_image\": \" \"\n                      },\n                      \"your_answer_id\": 4,\n                      \"answers\": [\n                          {\n                              \"id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 2,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 3,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 4,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 1\n                          }\n                      ]\n                  },\n                  {\n                      \"question\": {\n                          \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n                          \"ques_image\": \" \"\n                      },\n                      \"your_answer_id\": 6,\n                      \"answers\": [\n                          {\n                              \"id\": 5,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 6,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 7,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0\n                          },\n                          {\n                              \"id\": 8,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 1\n                          }\n                      ]\n                  }\n              ]\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "post",
    "url": "/api/submit-random-answer",
    "title": "Submit Random Answer",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSubmitRandomAnswer",
    "group": "Question_Answer",
    "examples": [
      {
        "title": "Example usage:",
        "content": "body:\n  {\n          \"user_id\":1,\n          \"questions\":[\n                  {\n                          \"question_id\":1,\n                          \"answer_id\":4,\n                          \"is_correct\":1\n                  },\n                  {\n                          \"question_id\":2,\n                          \"answer_id\":6,\n                          \"is_correct\":0\n                  }\n          ]\n  }",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Answer",
            "description": "<p>'s submitted succeffully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Answer's submitted succeffully.\",\n      \"data\": {}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuestionController.php",
    "groupTitle": "Question_Answer"
  },
  {
    "type": "get",
    "url": "/api/quiz-detail",
    "title": "Quiz Detail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetQuizDetail",
    "group": "Quiz",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Daily Quiz Found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Daily Quiz Found\",\n      \"data\": {\n          \"quiz\": {\n              \"id\": 1,\n              \"name\": \"ABC\",\n              \"total_question\": 10,\n              \"lang\": \"English\",\n              \"start_date_time\": \"2020-01-23 16:00:00\",\n              \"end_date_time\": \"2020-01-23 17:00:00\",\n              \"question_time\": 5345\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuizController.php",
    "groupTitle": "Quiz"
  },
  {
    "type": "get",
    "url": "/api/start-quiz",
    "title": "Start Quiz",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetQuizQuestion",
    "group": "Quiz",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Daily Quiz Found.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Daily Quiz Found.\",\n      \"data\": {\n          \"quiz\": {\n              \"id\": 1,\n              \"name\": \"ABC\",\n              \"total_question\": 10,\n              \"lang\": \"English\",\n              \"start_date_time\": \"2020-01-23 16:00:00\",\n              \"end_date_time\": \"2020-01-23 17:00:00\",\n              \"questions\": [\n                  {\n                      \"id\": 1,\n                      \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\",\n                      \"ques_image\": \"http://127.0.0.1:8000/storage/ques_image/ \",\n                      \"answers\": [\n                          {\n                              \"id\": 1,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 2,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 3,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 4,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 1,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          }\n                      ]\n                  }\n              ]\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuizController.php",
    "groupTitle": "Quiz"
  },
  {
    "type": "post",
    "url": "/api/submit-quiz",
    "title": "Submit Quiz",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostSubmitQuiz",
    "group": "Quiz",
    "examples": [
      {
        "title": "Example usage:",
        "content": "body:\n  {\n          \"user_id\":1,\n          \"quiz_id\":1,\n          \"questions\":[\n          {\n            \"question_id\":1,\n            \"answer_id\":4,\n            \"is_correct\":1\n          },\n          {\n            \"question_id\":2,\n            \"answer_id\":6,\n            \"is_correct\":0\n          }\n      ]\n  }",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Daily Quiz Submitted.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Daily Quiz Submitted.\",\n      \"data\": {\n\n       }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/QuizController.php",
    "groupTitle": "Quiz"
  },
  {
    "type": "get",
    "url": "/api/leadership",
    "title": "Leadership",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetLeadership",
    "group": "Rank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Leadership List.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Leadership list\",\n      \"data\":[\n             {\n              \"user_id\":2,\n              \"name\":\"Ankit_creator\",\n              \"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/img\\/no-image.jpg\",\n               \"points\":3\n              },\n              {\n              \"user_id\":5,\n              \"name\":\"shantanu\",\n              \"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/img\\/no-image.jpg\",\n              \"points\":0\n              },\n              {\n              \"user_id\":7,\n             \"name\":\"Sonali\",\n              \"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/profile_pic\\/P4dx2wtCWVdOSL3j34DOZCiu6Kvn9uSy2dKsFpMw.jpeg\",\n              \"points\":0\n              },\n              {\n              \"user_id\":9,\n              \"name\":\"sonali\",\n              \"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/img\\/no-image.jpg\",\n              \"points\":0\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RankingController.php",
    "groupTitle": "Rank"
  },
  {
    "type": "get",
    "url": "/api/user-ranking",
    "title": "User Raking",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetUserRanking",
    "group": "Rank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Rank List.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Ranking list\",\n      \"data\": {\n          \"users_ranking\": [\n              {\n                  \"user_id\": 2,\n                  \"name\": \"Ankit_creator\",\n                  \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n                  \"total_correct_answer\": \"6\"\n              },\n              {\n                  \"user_id\": 3,\n                  \"name\": \"Ankit_user\",\n                  \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n                  \"total_correct_answer\": \"4\"\n              }\n          ],\n          \"user\": {\n              \"id\": 3,\n              \"name\": \"Ankit_user\",\n              \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n              \"total_correct_answer\": \"4\",\n              \"rank_number\": 2\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RankingController.php",
    "groupTitle": "Rank"
  },
  {
    "type": "get",
    "url": "/api/quiz-ranking",
    "title": "Quiz Ranking",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "Getquizranking",
    "group": "Rank",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Quiz Ranking  list.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\":true,\n  \"status_code\":200,\n  \"message\":\"Quiz Ranking list\",\n  \"data\":{\n         \"users_leadership\":[\n         {\n\"user_id\":16,\n\"name\":\"Sonali\",\n\"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/storage\\/profile_pic\\/2gaeu9QoWVryb5WavH5mi1NJPRs12To9jKrXU3OA.jpeg\",\n\"points\":9\n},\n{\n\"user_id\":24,\n\"name\":\"11114\",\n\"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/img\\/no-image.jpg\",\n\"points\":9\n}\n],\n\"user\":{\n\"id\":24,\n\"name\":\"11114\",\n\"profile_pic\":\"http:\\/\\/127.0.0.1:8000\\/img\\/no-image.jpg\",\n\"points\":9,\n\"rank_number\":2\n}\n}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RankingController.php",
    "groupTitle": "Rank"
  },
  {
    "type": "get",
    "url": "/api/search",
    "title": "search",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetSearch",
    "group": "Search",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Search Results.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Search Results\",\n   \"data\": {\n       \"search_list\": [\n       {\n           \"id\": 1,\n           \"name\": \"fdgfdg\",\n           \"created_at\": null,\n           \"flag\": 1,\n           \"total_ques_no\": 12\n       }\n     ]\n  }\n}",
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
            "field": "InputMissing",
            "description": "<p>Input missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Input Missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "Search"
  },
  {
    "type": "get",
    "url": "/api/subject-list",
    "title": "Subject List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetSubjectList",
    "group": "Subject",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>List of Subjects.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>Array.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"List of Subjects\",\n      \"data\": [\n          {\n              \"id\": 1,\n              \"name\": \"English\",\n              \"created_at\": null,\n              \"updated_at\": null,\n              \"deleted_at\": null,\n          },\n          {\n              \"id\": 2,\n              \"name\": \"Hindi\",\n              \"created_at\": null,\n              \"updated_at\": null,\n              \"deleted_at\": null,\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubjectController.php",
    "groupTitle": "Subject"
  },
  {
    "type": "get",
    "url": "/api/my-test-series",
    "title": "My Test Series List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetMyTestSeriesList",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>TestSeries List.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"TestSeries List\",\n      \"data\": {\n          \"my_testseries\": [\n              {\n                  \"id\": 2,\n                  \"name\": \"gggggu\",\n                  \"created_at\": \"2020-01-20T11:47:20.000000Z\",\n                  \"flag\": 1,\n                  \"date\": \"23-Jan-2020\",\n                  \"is_bookmark\":TRUE,\n                  \"total_ques_no\": 10\n              },\n              {\n                  \"id\": 3,\n                  \"name\": \"gggggu\",\n                  \"created_at\": \"2020-01-20T11:47:31.000000Z\",\n                  \"flag\": 1,\n                  \"date\": \"23-Jan-2020\",\n                  \"is_bookmark\":TRUE,\n                  \"total_ques_no\": 10\n              },\n              {\n                  \"id\": 4,\n                  \"name\": \"rbi assistant computer\",\n                  \"created_at\": \"2020-01-22T09:47:16.000000Z\",\n                  \"flag\": 1,\n                  \"date\": \"23-Jan-2020\",\n                  \"is_bookmark\":TRUE,\n                  \"total_ques_no\": 10\n              }\n          ]\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "get",
    "url": "/api/search-history",
    "title": "Search History",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetSearchHistory",
    "group": "TestSeries",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>test series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Search History\",\n      \"data\": {\n          \"trend_search\": [\n              {\n                  \"id\": 3,\n                  \"name\": \"SSC\"\n              },\n              {\n                  \"id\": 4,\n                  \"name\": \"Math\"\n              }\n          ],\n          \"recent_search\": [\n              {\n                  \"id\": 4,\n                  \"name\": \"Math\"\n              },\n              {\n                  \"id\": 3,\n                  \"name\": \"SSC\"\n              }\n          ]\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "get",
    "url": "/api/test-series",
    "title": "Test Series",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetTestSeries",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>Flag*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>test series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Test Series.\",\n      \"data\": {\n          \"test_series\": {\n              \"id\": 3,\n              \"name\": \"SSC\",\n              \"total_question\": 1,\n              \"lang\": \"English\",\n              \"question_time\": 45,\n              \"questions\": [\n                  {\n                      \"id\": 1,\n                      \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\",\n                      \"ques_image\": \"http://127.0.0.1:8000/storage/ques_image/ \",\n                      \"ques_time\": 20,\n                      \"answers\": [\n                          {\n                              \"id\": 1,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 2,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 3,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 0,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          },\n                          {\n                              \"id\": 4,\n                              \"question_id\": 1,\n                              \"description\": \"Lorem Ipsum.\",\n                              \"is_answer\": 1,\n                              \"created_at\": null,\n                              \"updated_at\": null,\n                              \"deleted_at\": null\n                          }\n                      ]\n                  }\n              ]\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "get",
    "url": "/api/test-series-details",
    "title": "Test Series Details",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetTestSeriesDetails",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>FLag Key.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>TestSeries Details.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Test Series Details.\",\n      \"data\": {\n                 \"name\": \"Demo\",\n                 \"total_question\": 54,\n                 \"total_time\": 45\n              }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "get",
    "url": "/api/test-series-list",
    "title": "Test Series List",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetTestSeriesList",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>1=&gt;testseries, 2=&gt;usertest series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"TestSeries List\",\n   \"data\": {\n       \"TestSeries_list\": [\n       {\n           \"id\": 1,\n           \"name\": \"fdgfdg\",\n           \"created_at\": null,\n           \"flag\": 1,\n           \"total_ques_no\": 12,\n           \"is_attempted\": 0,\n       }\n     ]\n  }\n}",
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
            "field": "InputMissing",
            "description": "<p>Input missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Input Missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "post",
    "url": "/api/create-test-series",
    "title": "Create Test Series",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostCreateTestSeries",
    "group": "TestSeries",
    "examples": [
      {
        "title": "Example usage:",
        "content": "body:\n  {\n          \"user_id\":1,\n          \"series_name\" : \"SSC_1\",\n          \"exam_id\":1,\n          \"subject_id\":1,\n          \"question_count\":10,\n          \"lang\":1,\n          \"questions\":[\n                  {\n                          \"question_discription\":\"Detail of question\",\n                          \"ans_1\":\"detail ans 1\",\n                          \"ans_2\":\"detail ans 2\",\n                          \"ans_3\":\"detail ans 3\",\n                          \"ans_4\":\"detail ans 4\",\n                          \"correct_ans\":1,\n                          \"time_per_question\":1\n                  }\n          ]\n  }",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Test Series Created successfully\",\n      \"data\": {\n              \"id\": 1,\n              \"subject_id\": 2,\n              \"subject_name\": \"ssc\"\n         }\n  }",
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
            "field": "userIDMissing",
            "description": "<p>The user id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "testSeriesnameMissing",
            "description": "<p>The Test series name missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "totalnomissing",
            "description": "<p>The total no of question missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "langmissing",
            "description": "<p>The language missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "subjectidmissing",
            "description": "<p>The Subject Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "subjectnotfound",
            "description": "<p>The Subject not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User id missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Test Series Name missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Total no missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"lang missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"subject ID missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Subject not found.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "post",
    "url": "/api/delete-test-series",
    "title": "Delete Test Series",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostDeleteTestSeries",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "flag",
            "description": "<p>FLag Key.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Delete TestSeries List.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"test_series Removed.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "post",
    "url": "/api/publish-test-series",
    "title": "Publish Test Series",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostPublishTestSeries",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test Series ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>1=&gt;testseries, 2=&gt;usertest series.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"status\": true,\n   \"status_code\": 200,\n   \"message\": \"Publish Successfully\",\n   \"data\": {}\n}",
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
            "field": "userIDMissing",
            "description": "<p>The user id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "testSeriesidMissing",
            "description": "<p>The Test series id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "TestSeriesNotFound",
            "description": "<p>Test Series Not Found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>User Not Found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User id missing.\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Test Series Id missing\",\n    \"data\": {}\n }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Test Series not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "post",
    "url": "/api/upload-test-series-images",
    "title": "Upload Test Series Images",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostUploadTestseriesImages",
    "group": "TestSeries",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_images",
            "description": "<p>Images in Array Format.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "test_series_id",
            "description": "<p>Test series ID.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>TestSeries Images uploaded successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>response.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Image uploaded succefully.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TestSeriesController.php",
    "groupTitle": "TestSeries"
  },
  {
    "type": "get",
    "url": "/api/follow",
    "title": "Follow",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetFollow",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User user_id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "follow_user_id",
            "description": "<p>Follow User Id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Following.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Following\",\n      \"data\": {\n           \"follow\": true,\n           \"count\": 1\n        }\n  }",
          "type": "json"
        },
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Unfollow\",\n      \"data\": {\n           \"follow\": false,\n           \"count\": 1\n        }\n  }",
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
            "field": "UserIdmissing",
            "description": "<p>User Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ProductIdmissing",
            "description": "<p>Product Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Productnotfound",
            "description": "<p>Product not found.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "usernotfound",
            "description": "<p>user not found.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Follow User Id Missing\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Follow User not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"user not found.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FollowController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/api/user-profile",
    "title": "User Profile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "GetUserProfile",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User Profile.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"user Profile.\",\n      \"data\": {\n          \"user_profile\": {\n              \"id\": 2,\n              \"name\": \"Hariom\",\n              \"email\": \"hariom@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"1991-02-04\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.Com\",\n              \"into_line\": null,\n              \"about\": null,\n              \"experience\": null,\n              \"lang\": 1,\n              \"user_type_id\": 2,\n              \"otp\": \"12345\",\n              \"profile_pic\": \"http://127.0.0.1:8000/storage/profile_pic/1hbKjNG9nhvNTtJtWMn2t7hlsSE6GLsuKqtp3scX.jpeg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": \"2020-01-13 06:57:03\",\n              \"updated_at\": \"2020-01-13 06:57:03\",\n              \"deleted_at\": null\n          },\n          \"user\": {\n              \"following\": 10,\n              \"follower\": 50,\n              \"post\": 35\n          }\n      }\n  }",
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
            "field": "UserIDMissing",
            "description": "<p>The user ID is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User ID missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/register",
    "title": "Register User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostRegisterUser",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>User name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email_id",
            "description": "<p>User email id*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile_number",
            "description": "<p>User mobile number*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dob",
            "description": "<p>User Date of Birth*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "designation",
            "description": "<p>User designation*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "qualification",
            "description": "<p>User qualification*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>User language*. (English =&gt; 1, Hindi =&gt; 2)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User type*. (Creator =&gt; 2, User =&gt; 3)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "profile_pic",
            "description": "<p>User Profile pic.(File Type)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "into_line",
            "description": "<p>About Me</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "experience",
            "description": "<p>Experience</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User registered successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"User registered successfully.\",\n      \"data\": {}\n  }",
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
            "field": "MobileNumberMissing",
            "description": "<p>The mobile number is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserTypeMissing",
            "description": "<p>The User type is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Mobile number missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"User type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/update-exam-selection",
    "title": "Update Exam Selection",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostUpdateExamSelection",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "exam_id",
            "description": "<p>Exam ID's in array format*.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Exam's updated successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Exam's updated successfully.\",\n      \"data\": {}\n  }",
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
            "field": "UserIdMissing",
            "description": "<p>The user ID is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "ExamIdMissing",
            "description": "<p>The Exam ID is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User ID missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Exam ID's missing.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/update-language",
    "title": "Update Language",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostUpdateLanguage",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>User language*. (English =&gt; 1, Hindi =&gt; 2)</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Language Changed Successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Language Changed Successfully.\",\n      \"data\": {\n          \"user_detail\": {\n              \"id\": 1,\n              \"name\": \"Ankit\",\n              \"email\": \"ankit@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"2020-01-13\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.A.\",\n              \"lang\": \"2\",\n              \"user_type_id\": 1,\n              \"otp\": null,\n              \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": null,\n              \"updated_at\": \"2020-01-13 06:19:55\",\n              \"deleted_at\": null\n          }\n      }\n  }",
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
            "field": "UserIdMissing",
            "description": "<p>The user ID is missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "LangMissing",
            "description": "<p>The Lang is missing.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"User ID missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n {\n    \"status\": false,\n    \"status_code\": 404,\n    \"message\": \"Language type missing.\",\n    \"data\": {}\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/user-update",
    "title": "User Update",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Users unique access-token.</p>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Accept",
            "description": "<p>application/json.</p>"
          }
        ]
      }
    },
    "name": "PostUserUpdate",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>user name*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>email.*</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "profile_pic",
            "description": "<p>picture file.*</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dob",
            "description": "<p>Date Of Birth(2020-01-08)*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "designation",
            "description": "<p>Designation*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "into_line",
            "description": "<p>About Me*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "experience",
            "description": "<p>Experience</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "qualification",
            "description": "<p>Qualification</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lang",
            "description": "<p>Language (1=&gt;English, 2=&gt;Hindi).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_type",
            "description": "<p>User Type (2=&gt;Creator, 3=&gt;User).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "about",
            "description": "<p>About</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status_code",
            "description": "<p>(200 =&gt; success, 404 =&gt; Not found or failed).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Profile Updated..</p>"
          },
          {
            "group": "Success 200",
            "type": "JSON",
            "optional": false,
            "field": "data",
            "description": "<p>blank object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Profile Updated.\",\n      \"data\": {\n         \"user\": {\n              \"id\": 1,\n              \"name\": \"Ankit\",\n              \"email\": \"ankit@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"2020-01-13\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.A.\",\n              \"lang\": \"2\",\n              \"user_type_id\": 1,\n              \"otp\": null,\n              \"profile_pic\": \"http://127.0.0.1:8000/img/no-image.jpg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": null,\n              \"updated_at\": \"2020-01-13 06:19:55\",\n              \"deleted_at\": null\n         }\n     }\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User"
  }
] });
