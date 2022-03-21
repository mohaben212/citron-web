
let pingPong = true;

function start(e) {
    ping();
}

function status(id, str, state) {
    document.getElementById(id).classList.remove('error');
    document.getElementById(id).classList.remove('success');
    document.getElementById(id).classList.remove('warning');
    document.getElementById(id).classList.remove('info');
    document.getElementById(id).innerText = str;
    document.getElementById(id).classList.add(state);
}

function pingOk(p) {
    status('pinged', 'OK : '+p.toString()+'ms', 'success');
}

function pingFail() {
    status('pinged', 'FAILED', 'error');
}

function pingSlow(p) {
    status('pinged', 'Slow : '+p.toString()+'ms', 'warning');
}

function ping(slowMode) {
    if(!slowMode) { slowMode = false; }
    let d = Date.now();
    const h = new Headers();
    h.append('Content-Type', 'text/json');
    const o = {
        method: 'GET',
        headers: h,
        mode: 'cors'
    };
    const r = new Request('api.php?c=ping'+(slowMode? '&slow=1':''), o);
    fetch(r, o).then(res => res.json()).then((res) => {
        console.info('Successfully pinged API server');
        if(res.result.pong) {
            const diff = parseInt((1000 * res.result.pong) - d);
            if(diff > 100) {
                pingSlow(diff);
            } else {
                pingOk(diff);
            }
            pingPong = setTimeout(ping, 5000);
        } else if(pingPong) {
            clearTimeout(pingPong);
            pingPong = null;
            pingFail();
            alert('There is an error with API server (invalid result)');
            throw 'Error while pinging';
        }
    }).catch(() => {
        if(pingPong) {
            clearTimeout(pingPong);
            pingPong = null;
            pingFail();
            alert('There is an error with API server');
            throw 'Error while pinging';
        }
    });
}

window.addEventListener('load', start);
