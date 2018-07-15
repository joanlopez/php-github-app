### PHP GitHub Application

This is a Symfony application that was thought to exploit the different features
of the public GitHub API (i. e. counting the words appearances in a repository).

#### GitHub API

[Here](https://developer.github.com/v3/) you'll find more information about the GitHub API.
There are a lot of available features that will be exploited by this app.   

#### Set up

##### 0) Generate a personal access token

Follow [this](https://help.github.com/articles/creating-a-personal-access-token-for-the-command-line/) 
tutorial to get your GitHub personal access token needed to use the GitHub API. 
 
##### 1) Set up the environment configuration

Copy the `.env.dist` contents into a file named `.env` and the set the variable `GITHUB_AUTH_TOKEN` which
will be used to make the HTTP/S requests to the GitHub API. 

##### 2) Install the dependencies

Just run:

> composer install