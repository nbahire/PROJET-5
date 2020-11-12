const getFetch = (url, callback) => fetch(url)
    .then((response) => {
        if (response.ok) {
            return response.json()
        } else {
            console.error(request.status + " " + request.statusText + " " + url);
        }
    })
    .catch(function (error) {
        console.log('Il y a eu un problème avec l\'opération fetch: ' + error.message);
    });
