function initMap() {
  const directionsRenderer = new google.maps.DirectionsRenderer();
  const directionsService = new google.maps.DirectionsService();
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: { lat: 48.833, lng: 2.333 },
    disableDefaultUI: true,
  });

  directionsRenderer.setMap(map);
  directionsRenderer.setPanel(document.getElementById("sidebar"));

  const control = document.getElementById("floating-panel");

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);

  const onChangeHandler = function () {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
  };

  document
    .getElementById("start")
    .addEventListener("change", onChangeHandler);
  document
    .getElementById("end")
    .addEventListener("change", onChangeHandler);
  /*document
    .getElementById("mode")
    .addEventListener("change", onChangeHandler);*/
}

function calculateAndDisplayRoute(directionsService, directionsRenderer) {
  const start = document.getElementById("start").value;
  const end = document.getElementById("end").value;
  //const selectedMode = document.getElementById("mode").value;

  directionsService
    .route({
      origin: start,
      destination: end,
      travelMode: "DRIVING",
      //travelMode: google.maps.TravelMode[selectedMode],
    })
    .then((response) => {
      directionsRenderer.setDirections(response);
    })
    .catch((e) =>
      window.alert("Directions request failed due to " + status)
    );
}

window.initMap = initMap;
