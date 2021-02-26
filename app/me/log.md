## 54. Full test: Not Ok
#### 2 test are failing

## 54.1 Full test: Not Ok
#### 1 test was fixed
(misstyping)
#### 1 test is still failing
    a_reply_requires_a_body
## 54.b Thread | Reply
    - a user can only reply once per minute. (Finally working)...
    - ...but with status code 201, however tutor perform with 200.
    - Full test: Not Ok (a_reply_requires_a_body)
## 55 a_reply_requires_a_body
 - a compared Jeffrey way repository with mine,(all models) and I'm still having this issue.
 - I tried.that's it. no more searchings.
 - perhap I'll fix it  next time I do this course.
### 55.b PostRequestForm (Refactoring)
    - from start you'll realize that your test is no doing well like the tutor video, however I had to go github laracast project repo and check what were in the commits, and it works. now is working like a charm
   ### 55.c Full test: Running Well Ok 
   - a_reply_requires_a_body is working
   - I don't know how, but suddendly for today full test is running well. maybe it had to do with something I did yesterday.
   #### Warning:
   - Call methods correctly please.
   - Type correctly also please.
   ## 56. Mention users
   ### 56.1 Mentioned user working now
   - you can mention a user when you are replying a thread.
   - so far, you have to type like this in reply box: @Alina some text. (working)
   - User Alina will get a notification (working)
   - next it will be implement autocomplition.
   ## 57
   #### Important:
   - sometimes the tutor change something in the code that it works for him but not for me. so obviusly I'm not going to change my code. that's what I have to report here.(I already done this, when I tray to list channels, but I dit not report.)
### 57.a Creating Events
 - I did it following the tutor steps.
## 58 
#### 58.1 (Error) I found an error in the notification message after replying a thread.
#### 58.2 Reply
- now cancel button is working properly
## 61 User name auto completion
 - install dependencies: npm install at.js --save
 - npm install jquery.caret --save
### 61.a username completion is working well but... 
- there is some issues when you are trying to mention a user. I mean this is the name of the user Alanis Morissette, now when I am tagging or mention her. I press @ala, appers the name I press enter, and the autocompletion works. but when I press the button submit to reply the thread, I can see my answer but the name is @Ala however the user name is Alanis. 
- why this happens? because you forget add a period (.), after naming some friend.
#### 61.b User don't receive a notification when they are mentioned.
- I don't know why this is happening.
#### 61.c Idea:
- when I'm taking some of this courses it would be a good idea if a the same course parallel. I mean for instance if today I taking and I completed the lesson 23. tomorrow in stead of take the lesson 24, I'll take the lesson 23 again.  why? first, for some practice. second, for check if in the current lesson I made mistakes or perhaps, they are project bugs (talking about error 61.a) 
### 63. Image Validation Error:
- there are some issues with 2 testing methods:
    - a_user_may_add_an_avatar_to_their_profile
    - a_valid_avatar_must_be_provided
- this both methods are complicated to figure it out, between both methods are sharing problems.
#### 63.a Image Validation (temp solution)
 - there is just one method which is not ok(a_valid_avatar_must_be_provided). Lets see what happens.
### 64. Profile user Image is not working.
- I have to save manually to public/avatars/ folder
- so far everything (javascript) is working but the aupload image is not working yet. you have to do manually. if you do works. 

#### 66.a Image Validation Working
- OK. now you can upload an image, and this user image can be display from user profile and thread page.
- FAIL. a_valid_avatar_must_be_provided is the unique method that's not working (in it test file)
### 66. Trending threads with redis (ok)
- Completed Successfully.
### 68. Thread Views Design 1 (ok)
- Completed Successfully.
### 70. Thread Views without Redis (ok)
- Completed Successfully.
- Using old School Tecniques.
### 72. Confirm their email address
- I was stucked minutes here. I thought I did n't make it. 