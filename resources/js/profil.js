window.addEventListener('load', function () {
    const btn = document.querySelectorAll('.change-body');
    btn.forEach( e => {
        e.addEventListener('click', (btn) => {
            document.querySelector('.change-body.text-warning').classList.remove('text-warning');
            document.querySelector(`span[data-body="${e.dataset.body}"]`).classList.add("text-warning");
            document.querySelector('div[data-body].d-flex').classList.add('d-none');
            document.querySelector('div[data-body].d-flex').classList.remove('d-flex');

            document.querySelector(`div[data-body="${e.dataset.body}"]`).classList.remove('d-none');
            document.querySelector(`div[data-body="${e.dataset.body}"]`).classList.add('d-flex');
        })
    });

    const btnAcceptedStatus = document.querySelectorAll('.acceptedStatus');
    btnAcceptedStatus.forEach( btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            acceptedStatus(btn.dataset.id);
        })
    })
})

const acceptedStatus = (id) => {
    fetch(`/api/status/${id}`, {
        method: "PUT",
        headers: {
            'Content-Type': "application/json",
        },
        body: JSON.stringify({
            "accepted": true
        })
    })
        .then( response => {
            if (response.status !== 200) throw Error('Error Status');
            else return response.json();
        })
        .then( json => {
            console.log(json)
        })
        .catch( err => {
            console.error(err)
        })
}
