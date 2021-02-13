## 54. after running phpunit
##### 2 test issues were found. 
### 54.1 a_reply_requires_a_body 
I am not able to compare code. I'll do it when is possible.

### 54.2 replies_that_contain_spam_may_not_be_created
I was able to compare codes but is not working as I excepted.

### Full Terminal Info

There were 2 failures:

1) Tests\Feature\ParticipatedInForumTest::a_reply_requires_a_body
Session is missing expected key [errors].
Failed asserting that false is true.

/home/babo/fg/forumtdd00/vendor/laravel/framework/src/Illuminate/Foundation/Testing/TestResponse.php:892
/home/babo/fg/forumtdd00/vendor/laravel/framework/src/Illuminate/Foundation/Testing/TestResponse.php:967
/home/babo/fg/forumtdd00/tests/Feature/ParticipatedInForumTest.php:44

2) Tests\Feature\ParticipatedInForumTest::replies_that_contain_spam_may_not_be_created
Expected status code 422 but received 201.
Failed asserting that false is true.

/home/babo/fg/forumtdd00/vendor/laravel/framework/src/Illuminate/Foundation/Testing/TestResponse.php:151
/home/babo/fg/forumtdd00/tests/Feature/ParticipatedInForumTest.php:112

FAILURES!

