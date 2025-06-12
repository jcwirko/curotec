# CUROTEC

<p margin-top: 20px; margin-bottom: 20px; font-size: 16px"> Technilal assestment</p>

Esta aplicacion corresponda a una prueba tecnica para un puesto de software engineer

<hr style="height: 1px"/>

## Project

<p style="font-size: 15px">Final draw is a repository that it contains two folders:</p>

```
Nadal: backend of the application built using Laravel API.
```

```
Federer: frontend of the application built using Next.js.
```

# Instalation

### Prerequisites

- Node v22.14.0
- Yarn v1.22.22

### Clone Repositories

1. Clone the repository and submodules

   - `git clone --recurse-submodules git@gitlab.com:juanblariza/finaldraw.git && cd finaldraw`

2. Change the branches of the submodules
   - `cd nadal && git checkout main && cd .. && cd federer && git checkout main`

### Setup Federer

1.  Go to Federer Path `/path/to/../finaldraw/federer/`
2.  Run `nvm use` to switch to Node.js version v22.14.0.
    • If the version is not installed, run `nvm install 22.14.0` to install it.
3.  Run `yarn install & yarn run dev`

### Setup Nadal

1.  In Nadal Path `/path/to/../finaldraw/nadal/`
2.  In **_env.development_** file fill in `USER_ID` and `GROUP_ID` with your user and group id. You can find them by running `id` in your terminal.
3.  Run `make build-fd` to build the backend containers.
    - In case something fails, such as a seeder, the `make clean` command is executed to reset the environment, followed by `make build-fd` to rebuild it.
4.  Run `make up` to start the containers

### Ports

- **Backend** listens on port **7676**: http://localhost:7676.
- **UI** listens on port **3000**: http://localhost:3000.
- **Backend API**: `http://localhost:7676/api`
- **Minio API**: `http://localhost:9001`
- **Minio UI**: http://localhost:9002
- **Mailhog**: http://localhost:8025
- **Horizon** http://localhost:7676/horizon/dashboard

### Setup Minio

1. Go to [Minio UI](http://localhost:9002) and login with credentials:
   - **Username**: minio
   - **Password**: 12345678
2. Upload the `surfaces` and `tournaments` folders into the finaldraw bucket. (Ask for the folders)

### Postman

Within the Nadal project, you’ll find a _Postman_ folder containing a **_collection_** and an **_environment configuration file_**. Import these files into Postman.
