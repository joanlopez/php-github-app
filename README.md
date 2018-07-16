### PHP GitHub Application

This is a Symfony application that was thought to exploit the different features
of the public GitHub API (i. e. counting the words occurrences in a repository).

#### GitHub API

[Here](https://developer.github.com/v3/) you'll find more information about the GitHub API.
There are a lot of available features that will be exploited by this app.   

#### Set up

##### 0) (Only for Docker) Build the Docker image

Just run:

> make build

##### 1) Generate a personal access token

Follow [this](https://help.github.com/articles/creating-a-personal-access-token-for-the-command-line/) 
tutorial to get your GitHub personal access token needed to use the GitHub API. 
 
##### 2) Set up the environment configuration

Copy the `.env.dist` contents into a file named `.env` and the set the variable `GITHUB_AUTH_TOKEN` which
will be used to make the HTTP/S requests to the GitHub API. 

##### 3) Install the dependencies

Just run:

> composer install

To do it with Docker:

> make install

#### Instructions

##### Running as an HTTP service

Start the HTTP service running the following command:

> php bin/console server:run

Then the application is available at `localhost:8000`.

For example, to count the words occurrences of a repository, just do the following HTTP request:
 
> GET http://localhost:8000/repos/organization/repository/words
 
To do it with Docker:

> make deploy

##### Running as CLI

For example, to count the words occurrences of a repository, just run:

> php bin/console repos:words <organization> <repository>

For further information run:

> php bin/console repos:words --help

To do it with Docker:

> make run repos:words <organization> <repository>