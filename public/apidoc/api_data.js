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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"OTP verified successfully.\",\n      \"data\": {\n          \"user_detail\": {\n              \"id\": 2,\n              \"name\": \"Hariom\",\n              \"email\": \"hariom@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"1991-02-04\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.Com\",\n              \"into_line\": null,\n              \"lang\": 1,\n              \"user_type_id\": 2,\n              \"otp\": \"12345\",\n              \"profile_pic\": \"http://127.0.0.1:8000/storage/profile_pic/1hbKjNG9nhvNTtJtWMn2t7hlsSE6GLsuKqtp3scX.jpeg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": \"2020-01-13 06:57:03\",\n              \"updated_at\": \"2020-01-13 06:57:03\",\n              \"deleted_at\": null\n          },\n          \"user\": {\n              \"following\": 10,\n              \"follower\": 50,\n              \"post\": 35\n          }\n      }\n  }",
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
          "content": "HTTP/1.1 200 OK\n   {\n     \"status\": true,\n     \"status_code\": 200,\n     \"message\": \"Bookmark List.\",\n     \"data\": {\n       \"Bookmark_list\": [\n         {\n           \"id\": 2,\n           \"question_id\": 1,\n           \"question_id\": 3,\n           \"created_at\": null,\n           \"subject_id\": 3,\n           \"description\": \"Lorem Ipsum is simply dummy text of the printing\",\n           \"ques_image\": 556,\n           \"ques_time\": 10,\n           \"subject_detail\": \"ssc\"\n          }\n        ]\n     }\n   }",
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
            "field": "question_id",
            "description": "<p>Question_id.</p>"
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
            "description": "<p>Question bookmarked successfully.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question bookmarked successfully.\",\n      \"data\": {\n           \"favorite\": true,\n           \"count\": 1\n        }\n  }",
          "type": "json"
        },
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question bookmarked Removed.\",\n      \"data\": {\n           \"favorite\": false,\n           \"count\": 1\n        }\n  }",
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
            "field": "QuestionIdmissing",
            "description": "<p>Question Id missing.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Questionnotfound",
            "description": "<p>Question not found.</p>"
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
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Question Id missing.\",\n      \"data\": {}\n  }",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n  {\n      \"status\": false,\n      \"status_code\": 404,\n      \"message\": \"Question not found.\",\n      \"data\": {}\n  }",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Question list.\",\n      \"data\": [\n          {\n              \"id\": 8,\n              \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n              \"ques_image\": \" \",\n              \"ques_time\": 20,\n              \"is_like\" : true,\n               \"user\": {\n                  \"id\": 2,\n                  \"name\": \"manish\",\n                  \"profile_pic\": \"\"\n               },\n              \"answers\": [\n                  {\n                      \"id\": 29,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 30,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 31,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 32,\n                      \"question_id\": 8,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 1,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  }\n              ]\n          },\n          {\n              \"id\": 20,\n              \"description\": \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\n              \"ques_image\": \" \",\n              \"ques_time\": 20,\n              \"is_like\" : true,\n               \"user\": {\n                  \"id\": 2,\n                  \"name\": \"manish\",\n                  \"profile_pic\": \"\"\n               },\n              \"answers\": [\n                  {\n                      \"id\": 77,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 78,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 79,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 0,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  },\n                  {\n                      \"id\": 80,\n                      \"question_id\": 20,\n                      \"description\": \"Lorem Ipsum.\",\n                      \"is_answer\": 1,\n                      \"created_at\": null,\n                      \"updated_at\": null,\n                      \"deleted_at\": null\n                  }\n              ]\n          }\n      ]\n  }",
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
    "url": "/api/create-question",
    "title": "Create Question",
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
    "name": "PostCreateQuestion",
    "group": "Question_Answer",
    "parameter": {
      "fields": {
        "Parameter": [
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
            "field": "ques_image",
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
            "field": "Correct_ans",
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Test Series Created successfully\",\n      \"data\": {}\n  }",
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
            "field": "ques_image",
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
            "field": "Correct_ans",
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
        "content": "body:\n  {\n          \"user_id\":1,\n          \"name\" : \"SSC_1\",\n          \"exam_id\":1,\n          \"subject_id\":1,\n          \"lang\":1,\n          \"questions\":[\n                  {\n                          \"question_id\":1,\n                          \"answer_id\":4,\n                          \"is_correct\":1\n                  },\n                  {\n                          \"question_id\":2,\n                          \"answer_id\":6,\n                          \"is_correct\":0\n                  }\n          ]\n  }",
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
    "url": "/api/create-quiz",
    "title": "Create Quiz",
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
    "name": "PostCreateQuiz",
    "group": "Quiz",
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
            "field": "name",
            "description": "<p>Quiz Name*.</p>"
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
            "field": "start_date_time",
            "description": "<p>Start Date Time (YYYY-MM-DD H:i)*.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "end_date_time",
            "description": "<p>End Date Time (YYYY-MM-DD H:i)*.</p>"
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
            "description": "<p>Quiz Created.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"Quiz create successfully.\",\n      \"data\": {\n          \"user_id\": \"1\",\n          \"name\": \"SSC QUIZ\",\n          \"total_questions\": \"10\",\n          \"start_date_time\": \"2020-01-08 01:00\",\n          \"end_date_time\": \"2020-01-08 02:00\",\n          \"lang\": \"1\",\n          \"updated_at\": \"2020-01-08 06:56:01\",\n          \"created_at\": \"2020-01-08 06:56:01\",\n          \"id\": 1\n      }\n  }",
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
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id .</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "exam_id",
            "description": "<p>Exam Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "subject_id",
            "description": "<p>Subject Id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "series_name",
            "description": "<p>Test Series Name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "total_question",
            "description": "<p>Total no. of questions*.</p>"
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
          "content": "HTTP/1.1 200 OK\n  {\n      \"status\": true,\n      \"status_code\": 200,\n      \"message\": \"user Profile.\",\n      \"data\": {\n          \"user_profile\": {\n              \"id\": 2,\n              \"name\": \"Hariom\",\n              \"email\": \"hariom@mail.com\",\n              \"mobile_number\": \"8077575835\",\n              \"dob\": \"1991-02-04\",\n              \"designation\": \"Student\",\n              \"qualification\": \"M.Com\",\n              \"into_line\": null,\n              \"lang\": 1,\n              \"user_type_id\": 2,\n              \"otp\": \"12345\",\n              \"profile_pic\": \"http://127.0.0.1:8000/storage/profile_pic/1hbKjNG9nhvNTtJtWMn2t7hlsSE6GLsuKqtp3scX.jpeg\",\n              \"device_token\": null,\n              \"latitude\": null,\n              \"longitude\": null,\n              \"is_active\": 1,\n              \"email_verified_at\": null,\n              \"created_by\": \"0\",\n              \"updated_by\": \"0\",\n              \"created_at\": \"2020-01-13 06:57:03\",\n              \"updated_at\": \"2020-01-13 06:57:03\",\n              \"deleted_at\": null\n          },\n          \"user\": {\n              \"following\": 10,\n              \"follower\": 50,\n              \"post\": 35\n          }\n      }\n  }",
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
  }
] });
