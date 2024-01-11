async function postJson(route, data, _token) {
    let response = await fetch(route, {
        method: "POST",
        headers: {
            "Content-type": "application/json;charset=utf-8",
        },
        body: JSON.stringify({
            data,
            _token,
        }),
    });
    return await response.json();
}
