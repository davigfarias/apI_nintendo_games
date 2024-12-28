# Nintendo-Only Games API

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
[![Created Badge](https://badges.pufler.dev/created/davigfarias/apI_nintendo_games)](https://badges.pufler.dev)
[![Updated Badge](https://badges.pufler.dev/updated/davigfarias/apI_nintendo_games)](https://badges.pufler.dev)
[![Visits Badge](https://badges.pufler.dev/visits/davigfarias/apI_nintendo_games)](https://badges.pufler.dev)


## Description:
A simple REST API with PHP that returns Nintendo-Only releases for their Consoles. This API is still under development while I'm learning and implementing more of the REST design. Also, this is the first time of implementation of another mini-framework side-project called "River"; 

## Database Credits:
Deeply appreciate the effort and work of Andrii Samoshyn for joining and create the database that I've used in this project. All the credits belongs to him. 

## How to use the API
1. Clone this repository using git clone https://github.com/davigfarias/apI_nintendo_games.git
2. Use either Insomnia or Postman to setup a GET request to the API.
3. You're done!

## Documentation
The API has four endpoints, as listed:

### "/"
This will show some information of the API, as well as the current version and status

Example:
```
"name:": "nintendo_titles",
"author:": "Dave G.Farias",
"version:": 1,
"description:": "Access a database of Nintendo-only titles from different consoles. Using Andrii Samoshyn's Kaggle database, updated 4 years ago.",
"status:": "operational",
"supported_methods:": "GET"
```

### "/titles"
This will list all the database filtered by "Game Name", "Year" and "Console"
```
{
"Game Title: ": "Super Mario 3D World + Bowser's Fury",
"Year: ": "Feb 12, 2021",
"Console: ": "Switch"
},
```

### "/titles/{console}"
If you need to filter either more by console, type in this endpoint the console you want to be displayed (the API is prepared for either all-lowercase or all-uppercase)
```
{
"Game Title: ": "Kirby's Extra Epic Yarn",
"Year: ": "Mar 8, 2019",
"Console: ": "3DS"
},
```

### "/consoles"
Wanted to know which consoles is currently being on the database? You can access this endpoint to show all the consoles that is currently listed on this database:
```
Switch, iOS, 3DS, WIIU, WII, DS, TG16), GBA, GC, N64, working title)
```

## Aknowlegements
Thanks for *Robson V. Leite* (coffeecode) for the implementation of a Simple Routing System that matched perfectly with this project;
Thanks for *Rafael Capoani*  for the video inspiration on how to build a API REST with PHP. 

## Licence
