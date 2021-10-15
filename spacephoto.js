const getAPI = async (url, callback) => {
    dataa = await fetch(url)
    .then(response => response.json())
    .then(data => {
        createImg(data)
    }).catch(error => {
        console.log(error)
    })
    return dataa
}

function createImg(imgData) {
    console.log(imgData)
    document.getElementById("imgTitle").innerHTML = imgData.title
    document.getElementById("imgDate").innerHTML = imgData.date
    document.getElementById("spaceImg").src = imgData.url
    document.getElementById("imgDesciption").innerHTML = imgData.explanation
    document.getElementById("imgCredit").innerHTML = "Credit: " + imgData.copyright
}

getAPI("https://api.nasa.gov/planetary/apod?api_key=xU6Owr2hoN4V4zjFliyAnbgra8McvgRbntJlbNUH")

