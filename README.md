# Festivities Api

### Clone repo
```
git clone https://github.com/odparraj/festivities-api.git
```
### Open Folder
```
cd festivities-api
```

###  Run docker and laravel sail commands
``` 
./run.sh
```

## Api Features
Method     | URI
-----------|-----------------------------
POST       | api/festivities             
GET - HEAD | api/festivities             
POST       | api/festivities/batch       
PATCH      | api/festivities/batch       
DELETE     | api/festivities/batch       
GET - HEAD | api/festivities/search (indexed search)      
POST       | api/festivities/search (database search)     
GET - HEAD | api/festivities/{festivity} 
PUT - PATCH| api/festivities/{festivity} 
DELETE     | api/festivities/{festivity} 


## Postman Collection

[Festivities Api](https://www.getpostman.com/collections/6c9539a06cfe998ea89f)



## How did it develop

- It starts from a pretty good code base, using [laravel orion library](https://tailflow.github.io/laravel-orion-docs).
- Migrations were generated for festivities table
- Validation request is added for store, update, batch store and update store operations
- Json resource is added for answers, masking id with a uuid, uuid field is instantiated in a Festivity Model observer, at this point a bug was found in laravel orion library when trying to use uuid as main key, so It is resolved forking github project and adding it as a repository to composer.json
- Indexed search is added integrating meilisearch library https://www.meilisearch.com/ for laravel,

- The initial import of festivities is solved with a command that is launched in docker deploy, data is validated and only correct records are inserted

- dockerization is added using Sail library from laravel