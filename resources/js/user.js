
function acceptedStatus(tokenApi, idStatus) {
    const apiUrl = `/api/status/${idStatus}`;

    const data = {
        'accepted': 1,
        'token_api': tokenApi
    }

    fetch(apiUrl, {
            method: "PUT",
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.status !== 200) throw new Error('Not accepted response code');
            else return response.json();
        })
        .then(json => {
            console.log(json)
            document.querySelector(`div[data-id="${json.id}"]`).remove();
        })
        .catch(error => {
            console.error(error);
        })
}

window.addEventListener('load',  () => {
    const btnBodyActive = document.querySelectorAll('.button-active-body');
    btnBodyActive.forEach(btn => {
       btn.addEventListener('click', (e) => {
          e.preventDefault();
          document.querySelector('div[data-body].active').classList.add('d-none');
          document.querySelector('div[data-body].active').classList.remove('active');
          document.querySelector(`div[data-body="${btn.dataset.body}"]`).classList.remove('d-none');
          document.querySelector(`div[data-body="${btn.dataset.body}"]`).classList.add('active');
       });
    });

    const btnAccepted = document.querySelectorAll('.button-accepted');
    btnAccepted.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            let tokenApi = document.querySelector('input[name="userTokenAuth"]').value;
            let idStatus = btn.dataset.id;
            let result = acceptedStatus(tokenApi, idStatus);
            console.log(result);
            /*if (acceptedStatus(tokenApi, idStatus)) {
            } else {
                alert("aktualizacja się nie udała");
            }*/
        })
    });
});