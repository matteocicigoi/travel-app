# Esercizio: travel-app

## Introduzione

`travel-app` è un'applicazione di gestione viaggi che consente agli utenti di creare profili, pianificare viaggi, aggiungere giorni e tappe, e gestire dettagli come immagini e valutazioni.


## Back-end

### Struttura file (database.json)

```json
{
    "12345": [
        {
            "name": "Viaggio-1",
            "days": [
                {
                    "title": "Giorno-1",
                    "day": "YYYY-MM-DD",
                    "stops": [
                        {
                            "title": "Tappa-1",
                            "description": null,
                            "rating": null,
                            "images": [
                                "image.png",
                                "image2.png"
                            ],
                            "coordinates": [
                                "x",
                                "y"
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
```
- `profileID`: Identificatore per il profilo utente
    - `tripID`: Identificatore per il viaggio
        - `name`: (stringa) Nome del viaggio (default "Viaggio-x")
        - `days`:  Array di giorni del viaggio
            - `title`: (stringa) Titolo del giorno (default "Giorno-x")
            - `day`: (stringa) Data del giorno
            - `stops`: Array di fermate per il giorno
                - `title`: (stringa) Titolo della fermata (default "Fermata-x")
                - `description`: (stringa o null) Descrizione della fermata
                - `rating`: (numero: da 0 a 5 o null) Valutazione della fermata
                - `images`:  (array di stringhe o null) Array di nomi delle immagini)
                - `coordinates`: (array di due numeri: latitudine e longitudine)

---

### Chiamate API


| Metodo             | Parametri                                                                                                                                                                          | Restituisce     |
|--------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------|
| **createProfile**  | null                                                                                                                                                                               | `profileID`     |
| **createTrip**     | `profileID`,															                                                                                                              | `tripID`        |
| **createDay**      | `profileID`, `tripID`, `day` (string)							                                                                                                                  | `day`, `dayID`  |
| **createStop**     | `profileID`, `tripID`, `dayID`, `title`																												                 		      | `stopID`        |
| **renameTripTitle**| `profileID`, `tripID`, `newName` (string)                                                                                                                                          | `info`          |
| **renameDayTitle** | `profileID`, `tripID`, `dayID`, `newTitle` (string)                                                                                                                                | `info`          |
| **changeDay**      | `profileID`, `tripID`, `dayID`, `newDay` (string)                                                                                                                                  | `info`          |
| **changeStopInfo** | `profileID`, `tripID`, `dayID`, `stopID`, `newTitle` (opzionale, string), `newDescription` (opzionale, string), `newRating` (opzionale, number), `newCoordinates` (opzionale)      | `info`          |
| **addStopImage**   | `profileID`, `tripID`, `dayID`, `stopID`, `image` (dal form)                                                                                                                       | `imageID`       |
| **removeStopImage**| `profileID`, `tripID`, `dayID`, `stopID`, `imageID`                                                                                                                                | `info`          |
| **deleteStop**     | `profileID`, `tripID`, `dayID`, `stopID`                                                                                                                                           | `info`          |
| **deleteDay**      | `profileID`, `tripID`, `dayID`                                                                                                                                                     | `info`          |
| **deleteTrip**     | `profileID`, `tripID`                                                                                                                                                              | `info`          |
| **deleteProfile**  | `profileID`                                                                                                                                                                        | `info`          |
| **getProfile**     | `profileID`                                                                                                                                                                        | `profile`       |


## Front-end

Il front-end dell'applicazione è sviluppato con `Vue.js` e gestisce l'interfaccia utente per interagire con il back-end.

### Componenti

`Main.vue`: Il componente principale che gestisce la visualizzazione dell'interfaccia utente, inclusi i componenti per la mappa, le informazioni sui viaggi, e i dettagli delle tappe. Gestisce anche le interazioni tra i vari componenti.

`Api.vue`: Gestisce le chiamate API. I metodi API sono invocati da altri componenti per eseguire operazioni come la creazione, modifica e eliminazione di dati.

`Map.vue`: Mostra una mappa utilizzando la libreria Leaflet. Permette di aggiungere e rimuovere tappe, e aggiorna le coordinate delle fermate nel back-end.

`Start.vue`: Visualizza un pulsante per creare un nuovo profilo e viaggio. Interagisce con il componente `Api.vue` per avviare il processo di creazione.

`StopInfo.vue`: Mostra e gestisce le informazioni di una tappa selezionata. Permette di modificare dettagli come il titolo, la descrizione, e la valutazione, e di eliminarla.

`TripInfo.vue`: Visualizza e gestisce le informazioni sul viaggio corrente. Consente di rinominare il viaggio, aggiungere giorni, e modificare o eliminare giorni e viaggi.