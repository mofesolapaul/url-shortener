# Project: Url Shortener

## Setup instructions
The entire setup process has been distilled into a single file to make it easy for you to spin up the application and try it out. Run the following command in the project folder (p.s: docker must be installed on your machine):

 ```bash
 chmod u+x setup.sh && ./setup.sh
 ```
- Frontend app will be available at [localhost:8088](http://localhost:8088)
- Backend app will be available at [localhost:8089](http://localhost:8089)

## Implementation draft
API

- [POST] /shorten
    - Check for cache entry (return if present)
    - Check for db record (put it in cache and return if present)
    - Generate unique 7-char code
        - Code is case-sensitive
        - Alphanumerics
    - Save new code (and the URL it represents) in db and cache
    - Return shortened link
- [POST] /customize
    - Validate input for uniqueness
    - Update record if it’s unique, reject update otherwise

Frontend

- [Input] paste your link
- [button] Shorten Url
- Perform API call
- Display returned short link (clickable)
- If there’s enough time
    - Show extra option to user
    - [Input] “Customize link”
    - [Grouped input] [localhost:8888/[Input:custom](http://localhost:8888/[Input:custom)identifier]
    - Make API call and show result

Link resolution:

- Match url (ex: localhost:8888/{code})
- Check for code in cache
- Check for code in db, persist in cache if present
- ~~Send a 302 response to browser, forwarding to the original url~~
- No 302, browser cache would prevent features like statistics
    - Utilize  rabbitmq for async stats updates per requested link