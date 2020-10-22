# Immersailles

Research project carried by the **Centre de Recherche du Château de Versailles** (GIP-CRCV), the University Gustave Eiffel (computer science department of the IUT of Marne-la-Vallée) and the University of Rennes 2.

The "Immersailles" project aims to make available online the **historico-spatialized identification of Ancien Régime characters on period plans of the Château of Versailles**. Each character will also be provided with a descriptive sheet in order to allow users to learn more about these former tenants.

Developed in an **open source** evolutionary logic and with the integration of data from the opendata, this openscience project - at the meeting of history and digital humanities - is seen as a tool for cultural and scientific mediation. Ultimately, it will allow users to learn more about the different families who lived at court during the reigns of Louis XIV, Louis XV and Louis XVI, their environment, their activities, etc...

This project will allow:
-  from the analysis of several sources (plans and censuses) provided by the CRCV to identify the former tenants of the Palace at different times ;
-  to georeference on a cartographic application these tenants and the names of the apartments on period plans ;
-  to link these georeferences to biographical records for interoperability with other existing tools (Wikipedia, Ancien Régime thesaurus, GIP-CRCV biographical database, etc.).


The project (in french): [projet immersailles](http://chateauversailles-recherche.fr/francais/recherche/projets-scientifiques-et-recherche-appliquee/projet-fressin-2019-2022 "Google's Homepage")

------------------------------------------------------------------------------------
## A l'attention des développeurs - Documentation
------------------------------------------------------------------------------------


Les classes php sont importées dans le mysql.php car la plus part du temps elles requièrent la base de données.


## Front



## Back


   ### Modification du mot de passe

Token


   ### Session




## Project tree

```Bash
|
├── admin
│   ├── contributeur.php
│   ├── create_user.php
│   ├── includes
│   │   ├── checkperms.php
│   │   ├── functions.php
│   │   └── navbar.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── manage_users.php
│   └── recovery.php
├── class
│   ├── bdd.php
│   └── user.php
├── img
│   ├...
│
├── includes
│   ├── footer.php
│   ├── mysql.php
│   └── navbar.php
├── index.php
├── scripts
│   └── js
│       └── timeline.js
└── style
    ├── style.css
    └── timeline.css
```
