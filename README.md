# Esercizio: travel-app

## Back-end

### Struttura file (database.json)

```json
{
    "12345": [
        {
            "name": "Trip-1",
            "days": [
                {
                    "title": "Day-1",
                    "day": "YYYY-MM-DD",
                    "stops": [
                        {
                            "title": "Stop-1",
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
- profileID
    - tripID
        - name (string: default "Trip-x")
        - days
            - title (string: default "Day-x")
            - day (string)
            - stops
                - title (string: default "Stop-x")
                - description (string: o null)
                - rating (number: da 0 a 5 o null)
                - images (array: nome immagini o null)
                - coordinates (array: latitudine, longitudine)

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