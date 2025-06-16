# CUROTEC

<hr style="height: 1px"/>

## Project

<p style="font-size: 15px">This application corresponds to a technical test for a Software Engineer position.</p>

# Instalation

### Clone Repositories

1. Clone the repository and submodules

    - `git clone git@github.com:jcwirko/curotec.git`

2. Change the branches of the submodules
    - `cd curotec && git checkout main`

### Setup

1.  In path `/path/to/../curotec/`
2.  In **\_env** file fill in `USER_ID` and `GROUP_ID` with your user and group id. You can find them by running `id` in your terminal.
3.  Run `make build-app` to build the backend containers.
    -   In case something fails, such as a seeder, the `make clean` command is executed to reset the environment, followed by `make build-app` to rebuild it.
4.  Run `make up` to start the containers

### Ports

-   **Backend API**: http://localhost:7676/api
-   **UI** listens on port **7676**: http://localhost:7676.

### Postman

Within the project, you’ll find a _Postman_ folder containing a **_collection_** and an **_environment configuration file_** that I use to test the API. Import these files into Postman.
