window.addEventListener('load', function () {
    const btnRegisterDay = document.querySelectorAll('.btn-register-day');
    btnRegisterDay.forEach(btn => {
       btn.addEventListener('click', evt => {
          evt.preventDefault();
          registerDayWork(btn.dataset.type, btn.dataset.description)
       });
    });
});

function setStatusId(id) {
    document.querySelector('input[name=status_id]').value = id;
}
function registerDayWork(nameDateValue, description) {

    const data = {
        "user_id": document.querySelector('input[name=user_id]').value,
        "date": document.querySelector('input[name=date]').value,
        "hour": document.querySelector('input[name=time]').value,
        "status_id": document.querySelector('input[name=status_id]').value,
        "description": description,
    }

    switch (nameDateValue) {
        case "startWork":
            data.startWork = true;
            break;
        case "exitWork":
            data.exitWork = true;
            break;
    }

    console.log(JSON.stringify(data));
    fetch('/api/event', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (response.status !== 200) throw Error("error response code");
            else return response.json();
        })
        .then(json => {
            console.info("Succes");
            setStatusId(json.status_id);
        })
        .catch(error => {
            console.log(error);
        })
}

