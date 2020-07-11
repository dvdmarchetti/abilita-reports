## Installation
Clone the repository:
```
> git clone https://github.com/dvdmarchetti/abilita-reports.git
> cd abilita-reports
> cp .env.example .env
```

Edit `.env` file with the database settings and migrate the database schema and hook up a PHP server:
```
> php artisan migrate
> php artisan serve
```

You can with the dashboard with the integrated php server at http://localhost:8000/dashboard.

## Data Ingestion
To import data first put the excel files in the `storage/app/input` folder. Then open up the dashboard and click the refresh button.

Any import validation error for the parsed files will be reported in the dashboard.

## Query Results
After the import phase is complete, you can query query results at http://localhost:8000/queries
